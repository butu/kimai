<?php

/*
 * This file is part of the Kimai plugin "Billing report".
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\BillingReportBundle\Reporting;

use App\Entity\ProjectMeta;
use App\Repository\TimesheetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\Query\Expr\Join;

final class BillingReportService
{
    public function __construct(
        private TimesheetRepository $timesheetRepository,
        private UserRepository $userRepository
    )
    {
    }

    /**
     * @return BillingReportRow[]
     */
    public function getReport(BillingReportQuery $query): array
    {
        $month = $query->getMonth();
        if ($month === null) {
            return [];
        }

        $start = clone $month;
        $start->setTime(0, 0, 0);
        $end = clone $month;
        $end->modify('last day of this month');
        $end->setTime(23, 59, 59);

        $qb = $this->timesheetRepository->createQueryBuilder('t');
        $qb
            ->select([
                'IDENTITY(t.user) as user_id',
                'COALESCE(pm.value, :unknown) as billing_classification',
                'COALESCE(SUM(t.duration), 0) as duration',
            ])
            ->leftJoin(ProjectMeta::class, 'pm', Join::WITH, 'pm.project = t.project AND pm.name = :meta_name')
            ->andWhere('t.billable = :billable')
            ->andWhere('t.end IS NOT NULL')
            ->andWhere($qb->expr()->gte('t.begin', ':start'))
            ->andWhere($qb->expr()->lt('t.begin', ':end'))
            ->groupBy('user_id', 'billing_classification')
            ->setParameter('billable', true)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->setParameter('meta_name', 'billing_classification')
            ->setParameter('unknown', 'unknown')
        ;

        /** @var array<array{user_id: int, billing_classification: string, duration: int}> $results */
        $results = $qb->getQuery()->getArrayResult();

        // Group by user
        /** @var array<int, array{flat: int, atcost: int, unknown: int}> $userData */
        $userData = [];
        /** @var array<int, int> $userIds */
        $userIds = [];
        /** @var array<int, array{flat: int[], atcost: int[], unknown: int[]}> $projectIds */
        $projectIds = [];
        foreach ($results as $row) {
            $userId = (int) $row['user_id'];
            $classification = $row['billing_classification'];
            $duration = (int) $row['duration'];
            $userIds[$userId] = $userId;

            if (!isset($userData[$userId])) {
                $userData[$userId] = [
                    'flat' => 0,
                    'atcost' => 0,
                    'unknown' => 0,
                ];
            }

            $userData[$userId][$classification] += $duration;
        }

        // Fetch distinct project IDs per (user, classification) for the drill-down link
        $qbProjects = $this->timesheetRepository->createQueryBuilder('t2');
        $qbProjects
            ->select([
                'IDENTITY(t2.user) as user_id',
                'COALESCE(pm2.value, :unknown2) as billing_classification',
                'IDENTITY(t2.project) as project_id',
            ])
            ->leftJoin(ProjectMeta::class, 'pm2', Join::WITH, 'pm2.project = t2.project AND pm2.name = :meta_name2')
            ->andWhere('t2.billable = :billable2')
            ->andWhere('t2.end IS NOT NULL')
            ->andWhere($qbProjects->expr()->gte('t2.begin', ':start2'))
            ->andWhere($qbProjects->expr()->lt('t2.begin', ':end2'))
            ->groupBy('user_id', 'billing_classification', 'project_id')
            ->setParameter('billable2', true)
            ->setParameter('start2', $start)
            ->setParameter('end2', $end)
            ->setParameter('meta_name2', 'billing_classification')
            ->setParameter('unknown2', 'unknown')
        ;

        /** @var array<array{user_id: int, billing_classification: string, project_id: int}> $projectResults */
        $projectResults = $qbProjects->getQuery()->getArrayResult();
        foreach ($projectResults as $row) {
            $userId = (int) $row['user_id'];
            $classification = $row['billing_classification'];
            $projectId = (int) $row['project_id'];

            if (!isset($projectIds[$userId])) {
                $projectIds[$userId] = ['flat' => [], 'atcost' => [], 'unknown' => []];
            }

            $projectIds[$userId][$classification][] = $projectId;
        }

        // Load users that have data
        $users = [];
        if (\count($userIds) > 0) {
            $foundUsers = $this->userRepository->findBy(['id' => $userIds]);
            foreach ($foundUsers as $user) {
                $users[$user->getId()] = $user;
            }
        }

        // Get all active users (even those without bookings)
        $allActiveUsers = $this->userRepository->findBy(['enabled' => true]);

        $rows = [];

        // Helper to get Redmine user ID from a user
        $getRedmineId = function (User $u): ?int {
            $val = $u->getPreferenceValue('redmine_user_id');
            if ($val !== null && $val !== '') {
                return (int) $val;
            }

            return null;
        };

        // Add active users with data
        foreach ($allActiveUsers as $user) {
            $userId = $user->getId();
            $data = $userData[$userId] ?? ['flat' => 0, 'atcost' => 0, 'unknown' => 0];
            $pIds = $projectIds[$userId] ?? ['flat' => [], 'atcost' => [], 'unknown' => []];
            $rmId = $getRedmineId($user);

            if ($data['flat'] === 0 && $data['atcost'] === 0 && $data['unknown'] === 0) {
                $rows[] = new BillingReportRow($user, 0, 0, 0, [], [], [], $rmId);
            } else {
                $rows[] = new BillingReportRow($user, $data['flat'], $data['atcost'], $data['unknown'], $pIds['flat'], $pIds['atcost'], $pIds['unknown'], $rmId);
            }

            unset($userData[$userId]);
        }

        // Any remaining userData entries are disabled users with data - include them
        foreach ($userData as $userId => $data) {
            if (isset($users[$userId])) {
                $pIds = $projectIds[$userId] ?? ['flat' => [], 'atcost' => [], 'unknown' => []];
                $rmId = $getRedmineId($users[$userId]);
                $rows[] = new BillingReportRow($users[$userId], $data['flat'], $data['atcost'], $data['unknown'], $pIds['flat'], $pIds['atcost'], $pIds['unknown'], $rmId);
            }
        }

        // Sort alphabetically by user display name
        usort($rows, function (BillingReportRow $a, BillingReportRow $b) {
            return strcmp($a->getUserDisplayName(), $b->getUserDisplayName());
        });

        return $rows;
    }
}
