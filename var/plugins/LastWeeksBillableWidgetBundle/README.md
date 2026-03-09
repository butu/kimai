# LastWeeksBillableWidgetBundle

A Kimai plugin that adds a dashboard Chart.js widget for billable hours in the selected month.

## Installation

1. Copy this bundle into `var/plugins/LastWeeksBillableWidgetBundle`.
2. Reload Kimai:

```bash
bin/console kimai:reload
```

## Notes

- The widget is available in dashboard edit mode under the widget list.
- It uses only billable timesheet entries.
- It shows the current month by default and supports month-by-month pagination.
- The chart includes a 25h weekly target line.
