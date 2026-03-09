<?php

/*
 * This file is part of the Kimai plugin "Last weeks billable widget".
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\LastWeeksBillableWidgetBundle\Widget;

use App\Widget\Type\AbstractWidget;
use App\Widget\WidgetInterface;

final class LastWeeksBillableChartCanvas extends AbstractWidget
{
    public function getWidth(): int
    {
        return WidgetInterface::WIDTH_FULL;
    }

    public function getHeight(): int
    {
        return WidgetInterface::HEIGHT_LARGE;
    }

    public function getPermissions(): array
    {
        return ['view_own_timesheet'];
    }

    public function isInternal(): bool
    {
        return true;
    }

    public function getTitle(): string
    {
        return 'last_weeks_billable_widget.title';
    }

    public function getId(): string
    {
        return 'LastWeeksBillableChartCanvas';
    }

    public function getTemplateName(): string
    {
        return '@LastWeeksBillableWidget/widget/widget-lastweeksbillablechart-canvas.html.twig';
    }

    /**
     * @param array<string, string|bool|int|null|array<string, mixed>> $options
     */
    public function getData(array $options = []): mixed
    {
        return [
            'weeks' => $options['weeks'] ?? [],
            'series' => $options['series'] ?? [],
            'target' => $options['target'] ?? 0,
            'ratio' => $options['ratio'] ?? 0,
        ];
    }
}
