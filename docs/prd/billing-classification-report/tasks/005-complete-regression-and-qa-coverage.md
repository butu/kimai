---
title: Regression & Integrationsabdeckung abrunden
type: AFK
status: todo
---

## Parent

`docs/prd/billing-classification-report.md`

## What to build

Die fertige V1 wird gegen zentrale Regressionen abgesichert. Bestehende Reporting-, Formular- und Berechtigungstests werden angepasst, und die relevanten QA-Kommandos werden ausgeführt und dokumentiert.

## Acceptance criteria

- [ ] Bestehende Tests zur Reporting-Übersicht sind an den neuen Report angepasst.
- [ ] Berechtigungstests prüfen, dass Admins Zugriff haben und normale Benutzer nicht.
- [ ] Formularpflicht und Altdaten-Kompatibilität sind getestet.
- [ ] Report-Berechnung ist mit repräsentativen Testdaten für `flat`, `atcost`, `null`, nicht verrechenbar und laufend abgedeckt.
- [ ] Relevante gezielte PHPUnit-Tests laufen erfolgreich.
- [ ] Bei substantieller Implementierung laufen zusätzlich `composer codestyle`, `composer phpstan` und passende Integrationstests oder Abweichungen sind dokumentiert.
- [ ] Die finale Rückmeldung nennt exakt, welche Checks ausgeführt wurden und ob sie erfolgreich waren.

## Blocked by

- `docs/prd/billing-classification-report/tasks/001-store-project-billing-classification.md`
- `docs/prd/billing-classification-report/tasks/002-add-minimal-admin-billing-report.md`
- `docs/prd/billing-classification-report/tasks/003-calculate-user-billing-report-sums.md`
- `docs/prd/billing-classification-report/tasks/004-render-final-billing-report-table.md`
