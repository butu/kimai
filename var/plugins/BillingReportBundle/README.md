# BillingReportBundle

Ein Kimai-Plugin, das einen Abrechnungsprüfungs-Report und eine Abrechnungsart pro Projekt hinzufügt.

## Funktionen

- **Abrechnungsart pro Projekt**: Projekte können als „Pauschal" oder „Nach Aufwand" klassifiziert werden.
- **Abrechnungsprüfungs-Report**: Monatsweise Aufstellung der abrechenbaren Stunden pro Benutzer, gruppiert nach Abrechnungsart.

## Installation

1. Dieses Bundle nach `var/plugins/BillingReportBundle/` kopieren.
2. Kimai neu laden:
   ```bash
   bin/console kimai:reload --no-interaction
   ```

## Verwendung

- Nach der Installation erscheint im Projekt-Formular das Feld „Abrechnungsart".
- Im Reporting-Bereich erscheint der Report „Abrechnungsprüfung" für Admins.
