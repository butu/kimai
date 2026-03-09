<?php

/*
 * This file is part of the Kimai plugin "Last weeks billable widget".
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\LastWeeksBillableWidgetBundle\Widget;

use App\Entity\Timesheet;
use App\Repository\TimesheetRepository;
use App\Timesheet\DateTimeFactory;
use App\Widget\WidgetInterface;
use App\Widget\Type\AbstractWidget;

final class LastWeeksBillableChart extends AbstractWidget
{
    private const TARGET_SECONDS = 90000;
    private const BILLABLE_RATIO = 0.65;

    public function __construct(private readonly TimesheetRepository $repository)
    {
    }

    public function getWidth(): int
    {
        return WidgetInterface::WIDTH_HALF;
    }

    public function getHeight(): int
    {
        return WidgetInterface::HEIGHT_LARGE;
    }

    public function getPermissions(): array
    {
        return ['view_own_timesheet'];
    }

    public function getTitle(): string
    {
        return 'last_weeks_billable_widget.title';
    }

    public function getId(): string
    {
        return 'LastWeeksBillableChart';
    }

    public function getTemplateName(): string
    {
        return '@LastWeeksBillableWidget/widget/widget-lastweeksbillablechart.html.twig';
    }

    /**
     * @param array<string, string|bool|int|null|array<string, mixed>> $options
     * @return array<string, string|bool|int|null|array<string, mixed>>
     */
    public function getOptions(array $options = []): array
    {
        return array_merge([
            'type' => 'bar',
            'id' => uniqid('LastWeeksBillableChart_'),
        ], parent::getOptions($options));
    }

    /**
     * @param array<string, string|bool|int|null|array<string, mixed>> $options
     */
    public function getData(array $options = []): mixed
    {
        $user = $this->getUser();
        $dateTimeFactory = DateTimeFactory::createByUser($user);
        $currentDate = $dateTimeFactory->createDateTime();

        $year = $options['year'] ?? null;
        if (\is_string($year)) {
            $year = (int) $year;
        }
        if (!\is_int($year) || $year < 1) {
            $year = (int) $currentDate->format('Y');
        }

        $month = $options['month'] ?? null;
        if (\is_string($month)) {
            $month = (int) $month;
        }
        if (!\is_int($month) || $month < 1 || $month > 12) {
            $month = (int) $currentDate->format('n');
        }

        $monthStart = $dateTimeFactory->createDateTime()->setDate($year, $month, 1)->setTime(0, 0, 0);
        $monthEnd = (clone $monthStart)->modify('last day of this month')->setTime(23, 59, 59);

        $weekStarts = [];
        $dayCursor = clone $monthStart;
        while ($dayCursor <= $monthEnd) {
            $weekStart = $dateTimeFactory->getStartOfWeek($dayCursor);
            $weekStarts[$weekStart->format('Ymd')] = clone $weekStart;
            $dayCursor->modify('+1 day');
        }
        $weekStarts = array_values($weekStarts);

        $previousMonth = (clone $monthStart)->modify('first day of previous month');
        $nextMonth = (clone $monthStart)->modify('first day of next month');

        $weeks = [];
        $weekIndexByKey = [];
        foreach ($weekStarts as $index => $weekStart) {
            $weekKey = $weekStart->format('Ymd');
            $weekIndexByKey[$weekKey] = $index;
            $weekEnd = $dateTimeFactory->getEndOfWeek($weekStart);
            $fixedTarget = self::TARGET_SECONDS;

            $weeks[$index] = [
                'start' => $weekStart < $monthStart ? clone $monthStart : clone $weekStart,
                'end' => $weekEnd > $monthEnd ? clone $monthEnd : $weekEnd,
                'week' => (int) $weekStart->format('W'),
                'year' => (int) $weekStart->format('o'),
                'total' => 0,
                'booked' => 0,
                'fixedTarget' => $fixedTarget,
                'fixedTargetHours' => round($fixedTarget / 3600, 2),
                'ratioTarget' => 0,
                'delta' => 0,
            ];
        }

        $qb = $this->repository->createQueryBuilder('t');
        $qb
            ->select('t, p, a, c')
            ->andWhere($qb->expr()->gte('t.begin', ':begin'))
            ->andWhere($qb->expr()->lte('t.end', ':end'))
            ->andWhere($qb->expr()->eq('t.user', ':user'))
            ->andWhere($qb->expr()->eq('t.billable', ':billable'))
            ->andWhere($qb->expr()->isNotNull('t.end'))
            ->setParameter('begin', $monthStart)
            ->setParameter('end', $monthEnd)
            ->setParameter('user', $user)
            ->setParameter('billable', true)
            ->leftJoin('t.activity', 'a')
            ->leftJoin('t.project', 'p')
            ->leftJoin('p.customer', 'c');

        $series = [];

        /** @var Timesheet $timesheet */
        foreach ($qb->getQuery()->getResult() as $timesheet) {
            $duration = $timesheet->getDuration() ?? 0;
            if ($duration <= 0) {
                continue;
            }

            $weekStart = $dateTimeFactory->getStartOfWeek($timesheet->getBegin());
            $weekKey = $weekStart->format('Ymd');
            if (!isset($weekIndexByKey[$weekKey])) {
                continue;
            }

            $weekIndex = $weekIndexByKey[$weekKey];
            $weeks[$weekIndex]['total'] += $duration;

            $project = $timesheet->getProject();
            $activity = $timesheet->getActivity();
            $customer = $project?->getCustomer();

            $seriesKey = ($project?->getId() ?? 0) . '_' . ($activity?->getId() ?? 0);
            if (!isset($series[$seriesKey])) {
                $series[$seriesKey] = [
                    'customer' => $customer?->getName() ?? '-',
                    'project' => $project?->getName() ?? '-',
                    'activity' => $activity?->getName() ?? '-',
                    'color' => $activity?->getColor() ?? $project?->getColor() ?? $customer?->getColor() ?? null,
                    'values' => array_fill(0, \count($weekStarts), 0),
                    'billable' => true,
                ];
            }

            $series[$seriesKey]['values'][$weekIndex] += $duration;
        }

        $qbAll = $this->repository->createQueryBuilder('t');
        $qbAll
            ->select('t')
            ->andWhere($qbAll->expr()->gte('t.begin', ':begin'))
            ->andWhere($qbAll->expr()->lte('t.end', ':end'))
            ->andWhere($qbAll->expr()->eq('t.user', ':user'))
            ->andWhere($qbAll->expr()->isNotNull('t.end'))
            ->setParameter('begin', $monthStart)
            ->setParameter('end', $monthEnd)
            ->setParameter('user', $user);

        /** @var Timesheet $timesheet */
        foreach ($qbAll->getQuery()->getResult() as $timesheet) {
            $duration = $timesheet->getDuration() ?? 0;
            if ($duration <= 0) {
                continue;
            }

            $weekStart = $dateTimeFactory->getStartOfWeek($timesheet->getBegin());
            $weekKey = $weekStart->format('Ymd');
            if (!isset($weekIndexByKey[$weekKey])) {
                continue;
            }

            $weekIndex = $weekIndexByKey[$weekKey];
            $weeks[$weekIndex]['booked'] += $duration;

            if ($timesheet->isBillable()) {
                continue;
            }

            $project = $timesheet->getProject();
            $activity = $timesheet->getActivity();
            $customer = $project?->getCustomer();

            $seriesKey = 'non_' . ($project?->getId() ?? 0) . '_' . ($activity?->getId() ?? 0);
            if (!isset($series[$seriesKey])) {
                $series[$seriesKey] = [
                    'customer' => $customer?->getName() ?? '-',
                    'project' => $project?->getName() ?? '-',
                    'activity' => $activity?->getName() ?? '-',
                    'color' => $activity?->getColor() ?? $project?->getColor() ?? $customer?->getColor() ?? null,
                    'values' => array_fill(0, \count($weekStarts), 0),
                    'billable' => false,
                ];
            }

            $series[$seriesKey]['values'][$weekIndex] += $duration;
        }

        foreach ($weeks as $index => $week) {
            $weeks[$index]['delta'] = $week['total'] - $week['fixedTarget'];
            $bookedHours = round($week['booked'] / 3600, 2);
            $ratioTargetHours = round($bookedHours * self::BILLABLE_RATIO, 2);
            $weeks[$index]['ratioTargetHours'] = $ratioTargetHours;
            $weeks[$index]['ratioTarget'] = (int) round($ratioTargetHours * 3600);
            $weeks[$index]['ratioDelta'] = $week['total'] - $weeks[$index]['ratioTarget'];
            $delta = $weeks[$index]['delta'];
            $weeks[$index]['deltaSign'] = $delta >= 0 ? '+' : '-';
            $ratioDelta = $weeks[$index]['ratioDelta'];
            $weeks[$index]['ratioDeltaSign'] = $ratioDelta >= 0 ? '+' : '-';
        }

        $periodBillable = 0;
        $periodBooked = 0;
        foreach ($weeks as $week) {
            $periodBillable += $week['total'];
            $periodBooked += $week['booked'];
        }

        $periodBillableHours = (int) round($periodBillable / 3600);
        $periodBillablePercent = 0;
        if ($periodBooked > 0) {
            $periodBillablePercent = (int) round(($periodBillable / $periodBooked) * 100);
        }

        uasort(
            $series,
            static function (array $a, array $b): int {
                $aBillable = $a['billable'] ?? true;
                $bBillable = $b['billable'] ?? true;

                if ($aBillable !== $bBillable) {
                    return $aBillable ? -1 : 1;
                }

                return strcasecmp($a['activity'] . '|' . $a['project'], $b['activity'] . '|' . $b['project']);
            }
        );

        return [
            'weeks' => array_values($weeks),
            'series' => array_values($series),
            'target' => self::TARGET_SECONDS,
            'ratio' => self::BILLABLE_RATIO,
            'period' => [
                'year' => (int) $monthStart->format('Y'),
                'month' => (int) $monthStart->format('n'),
                'date' => clone $monthStart,
                'billableHours' => $periodBillableHours,
                'billablePercent' => $periodBillablePercent,
            ],
            'previous' => [
                'year' => (int) $previousMonth->format('Y'),
                'month' => (int) $previousMonth->format('n'),
                'date' => clone $previousMonth,
            ],
            'next' => [
                'year' => (int) $nextMonth->format('Y'),
                'month' => (int) $nextMonth->format('n'),
                'date' => clone $nextMonth,
            ],
        ];
    }
}
