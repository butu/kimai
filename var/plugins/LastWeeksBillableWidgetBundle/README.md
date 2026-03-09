# LastWeeksBillableWidgetBundle

A Kimai plugin that adds a dashboard Chart.js widget for billable hours in the current week and the previous 25 weeks (about six months).

## Installation

1. Copy this bundle into `var/plugins/LastWeeksBillableWidgetBundle`.
2. Reload Kimai:

```bash
bin/console kimai:reload
```

## Notes

- The widget is available in dashboard edit mode under the widget list.
- It uses only billable timesheet entries.
- The chart includes a 25h weekly target line.
