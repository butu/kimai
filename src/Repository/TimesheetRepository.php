<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Activity;
use App\Entity\Timesheet;
use App\Entity\User;
use App\Model\Statistic\Month;
use App\Model\Statistic\Year;
use App\Model\TimesheetGlobalStatistic;
use App\Model\TimesheetStatistic;
use App\Repository\Query\TimesheetQuery;
use DateTime;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Pagerfanta;

/**
 * Class TimesheetRepository
 */
class TimesheetRepository extends AbstractRepository
{
    /**
     * @param Timesheet $entry
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function stopRecording(Timesheet $entry)
    {
        // seems to be necessary so Doctrine will recognize a changed timestamp
        $entry->setBegin(clone $entry->getBegin());
        $entry->setEnd(new DateTime());
        $entityManager = $this->getEntityManager();
        $entityManager->persist($entry);
        $entityManager->flush();

        return true;
    }

    /**
     * @param User $user
     * @param Activity $activity
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function startRecording(User $user, Activity $activity)
    {
        $entry = new Timesheet();
        $entry
            ->setBegin(new DateTime())
            ->setUser($user)
            ->setActivity($activity);

        $entityManager = $this->getEntityManager();
        $entityManager->persist($entry);
        $entityManager->flush();

        return true;
    }

    /**
     * @param $select
     * @param User|null $user
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function queryThisMonth($select, User $user = null)
    {
        $end = new DateTime('last day of this month');
        $end->setTime(23, 59, 59);
        $begin = new DateTime('first day of this month');
        $begin->setTime(0, 0, 0);

        return $this->queryTimeRange($select, $begin, $end, $user);
    }

    /**
     * @param $select
     * @param DateTime $begin
     * @param DateTime $end
     * @param User|null $user
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function queryTimeRange($select, DateTime $begin, DateTime $end, User $user = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select($select)
            ->from(Timesheet::class, 't')
            ->where($qb->expr()->gt('t.begin', ':from'))
            ->andWhere($qb->expr()->lt('t.end', ':to'))
            ->setParameter('from', $begin, Type::DATETIME)
            ->setParameter('to', $end, Type::DATETIME);

        if (null !== $user) {
            $qb->andWhere('t.user = :user')
                ->setParameter('user', $user);
        }

        return $qb;
    }

    /**
     * Fetch statistic data for one user.
     *
     * @param User $user
     * @return TimesheetStatistic
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserStatistics(User $user)
    {
        $durationTotal = $this->getEntityManager()
            ->createQuery('SELECT SUM(t.duration) FROM ' . Timesheet::class . ' t WHERE t.user = :user')
            ->setParameter('user', $user)
            ->getSingleScalarResult();
        $recordsTotal = $this->getEntityManager()
            ->createQuery('SELECT COUNT(t.id) FROM ' . Timesheet::class . ' t WHERE t.user = :user')
            ->setParameter('user', $user)
            ->getSingleScalarResult();
        $rateTotal = $this->getEntityManager()
            ->createQuery('SELECT SUM(t.rate) FROM ' . Timesheet::class . ' t WHERE t.user = :user')
            ->setParameter('user', $user)
            ->getSingleScalarResult();
        $amountMonth = $this->queryThisMonth('SUM(t.rate)', $user)
            ->getQuery()
            ->getSingleScalarResult();
        $durationMonth = $this->queryThisMonth('SUM(t.duration)', $user)
            ->getQuery()
            ->getSingleScalarResult();
        $firstEntry = $this->getEntityManager()
            ->createQuery('SELECT MIN(t.begin) FROM ' . Timesheet::class . ' t WHERE t.user = :user')
            ->setParameter('user', $user)
            ->getSingleScalarResult();

        $stats = new TimesheetStatistic();
        $stats->setAmountTotal($rateTotal);
        $stats->setDurationTotal($durationTotal);
        $stats->setAmountThisMonth($amountMonth);
        $stats->setDurationThisMonth($durationMonth);
        $stats->setFirstEntry(new DateTime($firstEntry));
        $stats->setRecordsTotal($recordsTotal);

        return $stats;
    }

    /**
     * Returns an array of Year statistics.
     *
     * @param User|null $user
     * @return Year[]
     */
    public function getMonthlyStats(User $user = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('SUM(t.rate) as rate, SUM(t.duration) as duration, MONTH(t.begin) as month, YEAR(t.begin) as year')
            ->from(Timesheet::class, 't')
            ->where($qb->expr()->gt('t.begin', '0'))
            ->andWhere($qb->expr()->isNotNull('t.end'))
            ->orderBy('year', 'DESC')
            ->addOrderBy('month', 'ASC')
            ->groupBy('year')
            ->addGroupBy('month');

        if (null !== $user) {
            $qb->where('t.user = :user')
                ->setParameter('user', $user);
        }

        $years = [];
        foreach ($qb->getQuery()->execute() as $statRow) {
            $curYear = $statRow['year'];

            if (!isset($years[$curYear])) {
                $year = new Year($curYear);
                for ($i = 1; $i < 13; $i++) {
                    $month = $i < 10 ? '0' . $i : (string) $i;
                    $year->setMonth(new Month($month));
                }
                $years[$curYear] = $year;
            }

            $month = new Month($statRow['month']);
            $month->setTotalDuration($statRow['duration'])
                ->setTotalRate($statRow['rate']);
            $years[$curYear]->setMonth($month);
        }

        return $years;
    }

    /**
     * Fetch statistic data for all user.
     *
     * @return TimesheetGlobalStatistic
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getGlobalStatistics()
    {
        $durationTotal = $this->getEntityManager()
            ->createQuery('SELECT SUM(t.duration) FROM ' . Timesheet::class . ' t')
            ->getSingleScalarResult();
        $recordsTotal = $this->getEntityManager()
            ->createQuery('SELECT COUNT(t.id) FROM ' . Timesheet::class . ' t')
            ->getSingleScalarResult();
        $rateTotal = $this->getEntityManager()
            ->createQuery('SELECT SUM(t.rate) FROM ' . Timesheet::class . ' t')
            ->getSingleScalarResult();
        $userTotal = $this->getEntityManager()
            ->createQuery('SELECT COUNT(DISTINCT(t.user)) FROM ' . Timesheet::class . ' t')
            ->getSingleScalarResult();
        $activeNow = $this->getActiveEntries();
        $amountMonth = $this->queryThisMonth('SUM(t.rate)')
            ->getQuery()
            ->getSingleScalarResult();
        $durationMonth = $this->queryThisMonth('SUM(t.duration)')
            ->getQuery()
            ->getSingleScalarResult();
        $activeMonth = $this->queryThisMonth('COUNT(DISTINCT(t.user))')
            ->getQuery()
            ->getSingleScalarResult();

        $stats = new TimesheetGlobalStatistic();
        $stats->setAmountTotal($rateTotal);
        $stats->setDurationTotal($durationTotal);
        $stats->setActiveTotal($userTotal);
        $stats->setActiveCurrently(count($activeNow));
        $stats->setActiveThisMonth($activeMonth);
        $stats->setAmountThisMonth($amountMonth);
        $stats->setDurationThisMonth($durationMonth);
        $stats->setRecordsTotal($recordsTotal);

        return $stats;
    }

    /**
     * TODO replace me by a findByQuery() call
     *
     * @param User $user
     * @return Timesheet[]|null
     */
    public function getActiveEntries(User $user = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('t', 'a', 'p', 'c')
            ->from(Timesheet::class, 't')
            ->join('t.activity', 'a')
            ->join('a.project', 'p')
            ->join('p.customer', 'c')
            ->where($qb->expr()->gt('t.begin', '0'))
            ->andWhere($qb->expr()->isNull('t.end'))
            ->orderBy('t.begin', 'DESC');

        $params = [];

        if (null !== $user) {
            $qb->andWhere('t.user = :user');
            $params['user'] = $user;
        }

        return $qb->getQuery()->execute($params);
    }

    /**
     * @param TimesheetQuery $query
     * @return QueryBuilder|Pagerfanta
     */
    public function findByQuery(TimesheetQuery $query)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('t', 'a', 'p', 'c', 'u')
            ->from(Timesheet::class, 't')
            ->join('t.activity', 'a')
            ->join('t.user', 'u')
            ->join('a.project', 'p')
            ->join('p.customer', 'c')
            ->orderBy('t.' . $query->getOrderBy(), $query->getOrder());

        if (null !== $query->getUser()) {
            $qb->andWhere('t.user = :user')
                ->setParameter('user', $query->getUser());
        }

        if (TimesheetQuery::STATE_RUNNING == $query->getState()) {
            $qb->andWhere($qb->expr()->isNull('t.end'));
        } elseif (TimesheetQuery::STATE_STOPPED == $query->getState()) {
            $qb->andWhere($qb->expr()->isNotNull('t.end'));
        }

        if (null !== $query->getBegin()) {
            $qb->andWhere('t.begin >= :begin')
                ->setParameter('begin', $query->getBegin());
        }
        if (null !== $query->getEnd()) {
            $qb->andWhere('t.end <= :end')
                ->setParameter('end', $query->getEnd());
        }

        if (null !== $query->getActivity()) {
            $qb->andWhere('t.activity = :activity')
                ->setParameter('activity', $query->getActivity());
        } elseif (null !== $query->getProject()) {
            $qb->andWhere('a.project = :project')
                ->setParameter('project', $query->getProject());
        } elseif (null !== $query->getCustomer()) {
            $qb->andWhere('p.customer = :customer')
                ->setParameter('customer', $query->getCustomer());
        }

        return $this->getBaseQueryResult($qb, $query);
    }
}
