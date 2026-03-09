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
    private const WEEK_COUNT = 26;
    private const TARGET_SECONDS = 90000;

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

        $currentWeekStart = $dateTimeFactory->getStartOfWeek();
        $weekStarts = [];
        for ($i = 0; $i < self::WEEK_COUNT; $i++) {
            $weekStarts[] = (clone $currentWeekStart)->modify('-' . $i . ' week');
        }
        $weekStarts = array_reverse($weekStarts);

        $weeks = [];
        $weekIndexByKey = [];
        foreach ($weekStarts as $index => $weekStart) {
            $weekKey = $weekStart->format('Ymd');
            $weekIndexByKey[$weekKey] = $index;
            $weeks[$index] = [
                'start' => clone $weekStart,
                'week' => (int) $weekStart->format('W'),
                'year' => (int) $weekStart->format('o'),
                'total' => 0,
                'delta' => 0,
            ];
        }

        $firstWeekStart = $weekStarts[0];
        $lastWeekEnd = $dateTimeFactory->getEndOfWeek($weekStarts[
            self::WEEK_COUNT - 1
        ]);

        $qb = $this->repository->createQueryBuilder('t');
        $qb
            ->select('t, p, a, c')
            ->andWhere($qb->expr()->gte('t.begin', ':begin'))
            ->andWhere($qb->expr()->lte('t.end', ':end'))
            ->andWhere($qb->expr()->eq('t.user', ':user'))
            ->andWhere($qb->expr()->eq('t.billable', ':billable'))
            ->andWhere($qb->expr()->isNotNull('t.end'))
            ->setParameter('begin', $firstWeekStart)
            ->setParameter('end', $lastWeekEnd)
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
                    'values' => array_fill(0, self::WEEK_COUNT, 0),
                ];
            }

            $series[$seriesKey]['values'][$weekIndex] += $duration;
        }

        foreach ($weeks as $index => $week) {
            $weeks[$index]['delta'] = $week['total'] - self::TARGET_SECONDS;
            $delta = $weeks[$index]['delta'];
            $weeks[$index]['deltaSign'] = $delta >= 0 ? '+' : '-';
        }

        uasort(
            $series,
            static fn (array $a, array $b): int => strcasecmp($a['activity'] . '|' . $a['project'], $b['activity'] . '|' . $b['project'])
        );

        return [
            'weeks' => array_values($weeks),
            'series' => array_values($series),
            'target' => self::TARGET_SECONDS,
        ];
    }
}
