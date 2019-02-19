# Change Log

## [0.8](https://github.com/kevinpapst/kimai2/tree/0.8) (2019-02-19)
[Full Changelog](https://github.com/kevinpapst/kimai2/compare/0.7...0.8)

**Implemented enhancements:**

- Export other users' timesheets using the API [\#562](https://github.com/kevinpapst/kimai2/issues/562)
- Some importer bugs/improvements [\#553](https://github.com/kevinpapst/kimai2/issues/553)
- Export timesheet only exports entries on the current page [\#534](https://github.com/kevinpapst/kimai2/issues/534)
- On the last activities dropdown show tha last ten DIFFERENT activities [\#533](https://github.com/kevinpapst/kimai2/issues/533)
- Better user expierence on "My Times" [\#526](https://github.com/kevinpapst/kimai2/issues/526)
- Highlight current day in datepickers and not only the selected day [\#522](https://github.com/kevinpapst/kimai2/issues/522)
- Configuration of first page after login [\#501](https://github.com/kevinpapst/kimai2/issues/501)
- Visual Grouping of entry from same day or same week with some stats of that group [\#495](https://github.com/kevinpapst/kimai2/issues/495)

**Fixed bugs:**

- Error 404 on 'My times' page 2+ if the time range is changed to something smaller [\#558](https://github.com/kevinpapst/kimai2/issues/558)
- Timezone is not working correctly [\#554](https://github.com/kevinpapst/kimai2/issues/554)
- New time picker not working on languages without updated translation [\#546](https://github.com/kevinpapst/kimai2/issues/546)
- Export timesheet only exports entries on the current page [\#534](https://github.com/kevinpapst/kimai2/issues/534)
- Kimai2 will not allow me to enter times in the future [\#531](https://github.com/kevinpapst/kimai2/issues/531)
- No projects in filter section [\#525](https://github.com/kevinpapst/kimai2/issues/525)
- This value should be greater than or equal to zero [\#511](https://github.com/kevinpapst/kimai2/issues/511)
- Wrong time after migration kimai v1 data [\#507](https://github.com/kevinpapst/kimai2/issues/507)
- SQL-Error for getRecentActivities\(\) caused by GROUP BY  [\#488](https://github.com/kevinpapst/kimai2/issues/488)

**Closed issues:**

- Feedback for improving installation setup [\#541](https://github.com/kevinpapst/kimai2/issues/541)
- template entry.end\_time shows empty field [\#535](https://github.com/kevinpapst/kimai2/issues/535)

**Merged pull requests:**

- handle deleted user during import from v1 [\#569](https://github.com/kevinpapst/kimai2/pull/569) ([kevinpapst](https://github.com/kevinpapst))
- fix pagination in combination with daterange picker [\#568](https://github.com/kevinpapst/kimai2/pull/568) ([kevinpapst](https://github.com/kevinpapst))
- allow to query other users timesheets via api [\#563](https://github.com/kevinpapst/kimai2/pull/563) ([kevinpapst](https://github.com/kevinpapst))
- Updated HTML invoice templates [\#560](https://github.com/kevinpapst/kimai2/pull/560) ([kevinpapst](https://github.com/kevinpapst))
- updated composer packages [\#559](https://github.com/kevinpapst/kimai2/pull/559) ([kevinpapst](https://github.com/kevinpapst))
- fix timezone problems in timesheet forms [\#555](https://github.com/kevinpapst/kimai2/pull/555) ([kevinpapst](https://github.com/kevinpapst))
- Daily stats in timesheet [\#552](https://github.com/kevinpapst/kimai2/pull/552) ([kevinpapst](https://github.com/kevinpapst))
- Added more php requirements to documentation [\#551](https://github.com/kevinpapst/kimai2/pull/551) ([infeeeee](https://github.com/infeeeee))
- improve recent activities [\#550](https://github.com/kevinpapst/kimai2/pull/550) ([kevinpapst](https://github.com/kevinpapst))
- scss fixes: year selector width, dropdown menu width, navbar refactoring [\#549](https://github.com/kevinpapst/kimai2/pull/549) ([infeeeee](https://github.com/infeeeee))
- improved installation docs [\#548](https://github.com/kevinpapst/kimai2/pull/548) ([kevinpapst](https://github.com/kevinpapst))
- fix daterange-picker for fr, hu and ar [\#547](https://github.com/kevinpapst/kimai2/pull/547) ([kevinpapst](https://github.com/kevinpapst))
- do not limit users timesheet export page size [\#545](https://github.com/kevinpapst/kimai2/pull/545) ([kevinpapst](https://github.com/kevinpapst))
- Use Symfony formatter for currency symbol placement [\#542](https://github.com/kevinpapst/kimai2/pull/542) ([sanjitlpatel](https://github.com/sanjitlpatel))
- Localized date-inputs and daterange-picker [\#540](https://github.com/kevinpapst/kimai2/pull/540) ([kevinpapst](https://github.com/kevinpapst))
- added export module [\#538](https://github.com/kevinpapst/kimai2/pull/538) ([kevinpapst](https://github.com/kevinpapst))
- updated documentation [\#536](https://github.com/kevinpapst/kimai2/pull/536) ([kevinpapst](https://github.com/kevinpapst))
- support remote data in beta-test selectpicker [\#529](https://github.com/kevinpapst/kimai2/pull/529) ([kevinpapst](https://github.com/kevinpapst))
- Improve allowed running records [\#528](https://github.com/kevinpapst/kimai2/pull/528) ([kevinpapst](https://github.com/kevinpapst))
- Improve daterangepicker [\#527](https://github.com/kevinpapst/kimai2/pull/527) ([kevinpapst](https://github.com/kevinpapst))
- added configurable view after login [\#523](https://github.com/kevinpapst/kimai2/pull/523) ([kevinpapst](https://github.com/kevinpapst))
- convert timesheets to UTC with support for user timezone [\#372](https://github.com/kevinpapst/kimai2/pull/372) ([kevinpapst](https://github.com/kevinpapst))

## [0.7](https://github.com/kevinpapst/kimai2/tree/0.7) (2019-01-28)
[Full Changelog](https://github.com/kevinpapst/kimai2/compare/0.6.1...0.7)

**Implemented enhancements:**

- Editing from calendar view will return to my times table instead of calendar [\#515](https://github.com/kevinpapst/kimai2/issues/515)
- Timesheet Export for Admins [\#503](https://github.com/kevinpapst/kimai2/issues/503)
- Customer List Not Alphabetic [\#499](https://github.com/kevinpapst/kimai2/issues/499)
- sorting of ${entry.X} values [\#487](https://github.com/kevinpapst/kimai2/issues/487)
- ${entry.description} needed in Word-Docx [\#485](https://github.com/kevinpapst/kimai2/issues/485)
- Automatic sort for activities, customers, etc. [\#477](https://github.com/kevinpapst/kimai2/issues/477)
- User title in the timesheet invoice [\#461](https://github.com/kevinpapst/kimai2/issues/461)
- global variables for reports/invoices [\#438](https://github.com/kevinpapst/kimai2/issues/438)
- Configuration option: Only one active record for each user [\#427](https://github.com/kevinpapst/kimai2/issues/427)
- User creating activity and projects [\#393](https://github.com/kevinpapst/kimai2/issues/393)
- Configuration option to disable fixed rate and hourly rate from "edit timesheet" [\#330](https://github.com/kevinpapst/kimai2/issues/330)
- Set other users hourly rate [\#303](https://github.com/kevinpapst/kimai2/issues/303)
- Feature request - Make "Rate" hideable [\#217](https://github.com/kevinpapst/kimai2/issues/217)
-  fixed null project for advanced invoice calculator [\#462](https://github.com/kevinpapst/kimai2/pull/462) ([kevinpapst](https://github.com/kevinpapst))

**Fixed bugs:**

- Timesheet Export for Admins [\#503](https://github.com/kevinpapst/kimai2/issues/503)
- admin activity: visibility "none" \(no filter\) causes sql-error [\#491](https://github.com/kevinpapst/kimai2/issues/491)
- login-screen optimizations [\#483](https://github.com/kevinpapst/kimai2/issues/483)
- Configuration of roles to add/edit customers, projects, activities... [\#479](https://github.com/kevinpapst/kimai2/issues/479)
- Line breaks for address and payment information fields [\#464](https://github.com/kevinpapst/kimai2/issues/464)
- Possible to use a decimal in hourly rate field? [\#458](https://github.com/kevinpapst/kimai2/issues/458)
- Invoice Number Generator possibly not compatible  [\#454](https://github.com/kevinpapst/kimai2/issues/454)
- users can change their role to system-admin [\#440](https://github.com/kevinpapst/kimai2/issues/440)
- fix wrong include filename in user registration [\#520](https://github.com/kevinpapst/kimai2/pull/520) ([kevinpapst](https://github.com/kevinpapst))
- fix segmentation fault - rollback composer dependencies [\#463](https://github.com/kevinpapst/kimai2/pull/463) ([kevinpapst](https://github.com/kevinpapst))
-  fixed null project for advanced invoice calculator [\#462](https://github.com/kevinpapst/kimai2/pull/462) ([kevinpapst](https://github.com/kevinpapst))
- fix the restart timesheet button [\#436](https://github.com/kevinpapst/kimai2/pull/436) ([kevinpapst](https://github.com/kevinpapst))

**Closed issues:**

- Redirecting when using Kimai on a subdirectory + reverse proxy [\#492](https://github.com/kevinpapst/kimai2/issues/492)
- Installation \(Cannot declare.... in use\) [\#455](https://github.com/kevinpapst/kimai2/issues/455)
- New Number Generator not recognized [\#453](https://github.com/kevinpapst/kimai2/issues/453)
- de/help/invoices returns 404 error [\#452](https://github.com/kevinpapst/kimai2/issues/452)
- Can you Add Brazilian Portuguese Translation? I can help it.. [\#444](https://github.com/kevinpapst/kimai2/issues/444)
- replace all selects with smart-selects and live-search [\#441](https://github.com/kevinpapst/kimai2/issues/441)
- use parsedown-extra for rendering markdown [\#388](https://github.com/kevinpapst/kimai2/issues/388)
- Think about a cooler name [\#133](https://github.com/kevinpapst/kimai2/issues/133)

**Merged pull requests:**

- pagination without reload while keeping filters applied [\#521](https://github.com/kevinpapst/kimai2/pull/521) ([kevinpapst](https://github.com/kevinpapst))
- go back to calendar after editing and creation of time-records [\#519](https://github.com/kevinpapst/kimai2/pull/519) ([kevinpapst](https://github.com/kevinpapst))
-  fetch toolbar results without page reload [\#518](https://github.com/kevinpapst/kimai2/pull/518) ([kevinpapst](https://github.com/kevinpapst))
- Form and theme improvements [\#513](https://github.com/kevinpapst/kimai2/pull/513) ([kevinpapst](https://github.com/kevinpapst))
- validation for future and negative times [\#512](https://github.com/kevinpapst/kimai2/pull/512) ([kevinpapst](https://github.com/kevinpapst))
- alphabetical order for selectboxes [\#510](https://github.com/kevinpapst/kimai2/pull/510) ([kevinpapst](https://github.com/kevinpapst))
- Export team timesheets [\#508](https://github.com/kevinpapst/kimai2/pull/508) ([kevinpapst](https://github.com/kevinpapst))
- fix broken sql in activity admin [\#506](https://github.com/kevinpapst/kimai2/pull/506) ([kevinpapst](https://github.com/kevinpapst))
- display invoice entries in ascending order [\#505](https://github.com/kevinpapst/kimai2/pull/505) ([kevinpapst](https://github.com/kevinpapst))
- Improve DOCX template row [\#504](https://github.com/kevinpapst/kimai2/pull/504) ([kevinpapst](https://github.com/kevinpapst))
- do not display admin menu if it has no children [\#500](https://github.com/kevinpapst/kimai2/pull/500) ([kevinpapst](https://github.com/kevinpapst))
- login-screen optimizations [\#493](https://github.com/kevinpapst/kimai2/pull/493) ([lduer](https://github.com/lduer))
- preg\_replace for md-file-extensions when rendering correct link… [\#482](https://github.com/kevinpapst/kimai2/pull/482) ([lduer](https://github.com/lduer))
- Better composer install in the docker [\#481](https://github.com/kevinpapst/kimai2/pull/481) ([tobybatch](https://github.com/tobybatch))
- Update dockerfile for https in composer installer [\#478](https://github.com/kevinpapst/kimai2/pull/478) ([scolson](https://github.com/scolson))
- support line breaks in docx [\#466](https://github.com/kevinpapst/kimai2/pull/466) ([kevinpapst](https://github.com/kevinpapst))
- updated README and docu [\#465](https://github.com/kevinpapst/kimai2/pull/465) ([kevinpapst](https://github.com/kevinpapst))
- allow decimals in users hourly rate [\#460](https://github.com/kevinpapst/kimai2/pull/460) ([kevinpapst](https://github.com/kevinpapst))
- updated all composer packages [\#459](https://github.com/kevinpapst/kimai2/pull/459) ([kevinpapst](https://github.com/kevinpapst))
- moved some packages to dev requirements [\#456](https://github.com/kevinpapst/kimai2/pull/456) ([kevinpapst](https://github.com/kevinpapst))
- Added portuguese translations [\#446](https://github.com/kevinpapst/kimai2/pull/446) ([marquesmatheus](https://github.com/marquesmatheus))
- Simplify timesheet edit form if only one customer is existing [\#443](https://github.com/kevinpapst/kimai2/pull/443) ([kevinpapst](https://github.com/kevinpapst))
- added project variables for invoice templates [\#439](https://github.com/kevinpapst/kimai2/pull/439) ([kevinpapst](https://github.com/kevinpapst))
- added configurable permission system [\#424](https://github.com/kevinpapst/kimai2/pull/424) ([kevinpapst](https://github.com/kevinpapst))
- Only one running timesheet: automatically stop others [\#386](https://github.com/kevinpapst/kimai2/pull/386) ([lduer](https://github.com/lduer))

## [0.6.1](https://github.com/kevinpapst/kimai2/tree/0.6.1) (2018-11-19)
[Full Changelog](https://github.com/kevinpapst/kimai2/compare/0.6...0.6.1)

**Fixed bugs:**

- Error importing v1 Database [\#428](https://github.com/kevinpapst/kimai2/issues/428)
- Redo button missing? [\#426](https://github.com/kevinpapst/kimai2/issues/426)

**Closed issues:**

-  Error importing v1 Database \(could not convert to string\) [\#431](https://github.com/kevinpapst/kimai2/issues/431)

**Merged pull requests:**

- fix migration for MySQL [\#430](https://github.com/kevinpapst/kimai2/pull/430) ([kevinpapst](https://github.com/kevinpapst))
- fix importer for MySQL [\#429](https://github.com/kevinpapst/kimai2/pull/429) ([kevinpapst](https://github.com/kevinpapst))

## [0.6](https://github.com/kevinpapst/kimai2/tree/0.6) (2018-11-18)
[Full Changelog](https://github.com/kevinpapst/kimai2/compare/0.5...0.6)

**Implemented enhancements:**

- Language setting does not work immediately [\#418](https://github.com/kevinpapst/kimai2/issues/418)
- Merge projects and/or activities [\#406](https://github.com/kevinpapst/kimai2/issues/406)
- Global activities support for Kimai 1 importer [\#400](https://github.com/kevinpapst/kimai2/issues/400)
- Invoice Grouped by Activity [\#379](https://github.com/kevinpapst/kimai2/issues/379)
- Set the order of columns \(in my times page\) [\#371](https://github.com/kevinpapst/kimai2/issues/371)
- Columns on small/narrow displays \(mobile\) on „my times“ page [\#370](https://github.com/kevinpapst/kimai2/issues/370)
- Make settings more accessible [\#365](https://github.com/kevinpapst/kimai2/issues/365)
- Data validation for register page username field. [\#360](https://github.com/kevinpapst/kimai2/issues/360)
- Option for setting default calendar view [\#359](https://github.com/kevinpapst/kimai2/issues/359)
- Activities just Duration [\#334](https://github.com/kevinpapst/kimai2/issues/334)
- API: Add filtering/sorting/limits [\#333](https://github.com/kevinpapst/kimai2/issues/333)
- API: Timesheets [\#315](https://github.com/kevinpapst/kimai2/issues/315)
- Feature request: Quick search box for activities when creating new timesheet [\#307](https://github.com/kevinpapst/kimai2/issues/307)
- Separate Customer / Project / Activity input when logging time [\#250](https://github.com/kevinpapst/kimai2/issues/250)
- Interactive help after fresh installation [\#94](https://github.com/kevinpapst/kimai2/issues/94)

**Fixed bugs:**

- Invoicing export - 500: Internal Server Error [\#390](https://github.com/kevinpapst/kimai2/issues/390)
- invalid CSRF-Token [\#344](https://github.com/kevinpapst/kimai2/issues/344)
- fix column visibility if unconfigured \(no cookie existing\) [\#423](https://github.com/kevinpapst/kimai2/pull/423) ([kevinpapst](https://github.com/kevinpapst))
- fix duration and rate for html invoices [\#414](https://github.com/kevinpapst/kimai2/pull/414) ([kevinpapst](https://github.com/kevinpapst))
- fixed broken toolbar form with empty date [\#391](https://github.com/kevinpapst/kimai2/pull/391) ([kevinpapst](https://github.com/kevinpapst))

**Closed issues:**

- After installation no graphic/background/icons shown [\#417](https://github.com/kevinpapst/kimai2/issues/417)
- Form fields should be always visible [\#408](https://github.com/kevinpapst/kimai2/issues/408)
- Active filter should stay open [\#405](https://github.com/kevinpapst/kimai2/issues/405)
- Make project field optional [\#401](https://github.com/kevinpapst/kimai2/issues/401)
- Unrecognized Options "renderer, number\_generator" under "kimai.invoice" [\#381](https://github.com/kevinpapst/kimai2/issues/381)
- 500: Internal Server Error after login \(new install\) [\#342](https://github.com/kevinpapst/kimai2/issues/342)
- Invoices export error [\#341](https://github.com/kevinpapst/kimai2/issues/341)
- add the same activity for multiple projects [\#325](https://github.com/kevinpapst/kimai2/issues/325)
- API: Endpoint for API docs needs session cookie [\#319](https://github.com/kevinpapst/kimai2/issues/319)
- docker image for kimai2 [\#284](https://github.com/kevinpapst/kimai2/issues/284)

**Merged pull requests:**

- redirect to user language after profile update [\#421](https://github.com/kevinpapst/kimai2/pull/421) ([kevinpapst](https://github.com/kevinpapst))
- added more timesheet related invoice fields [\#411](https://github.com/kevinpapst/kimai2/pull/411) ([kevinpapst](https://github.com/kevinpapst))
- toolbar improvements [\#410](https://github.com/kevinpapst/kimai2/pull/410) ([kevinpapst](https://github.com/kevinpapst))
- move entries from one entity to another upon deletion [\#409](https://github.com/kevinpapst/kimai2/pull/409) ([kevinpapst](https://github.com/kevinpapst))
- show toolbar filter if they were submitted [\#407](https://github.com/kevinpapst/kimai2/pull/407) ([kevinpapst](https://github.com/kevinpapst))
- full configurable data columns in all screen sizes [\#404](https://github.com/kevinpapst/kimai2/pull/404) ([kevinpapst](https://github.com/kevinpapst))
- added global activity support in importer [\#402](https://github.com/kevinpapst/kimai2/pull/402) ([kevinpapst](https://github.com/kevinpapst))
- added parsedown extension for header ids \(\#388\) [\#399](https://github.com/kevinpapst/kimai2/pull/399) ([lduer](https://github.com/lduer))
- Fix for \#397 [\#398](https://github.com/kevinpapst/kimai2/pull/398) ([tobybatch](https://github.com/tobybatch))
- Added links to docker hub and my docker repo [\#396](https://github.com/kevinpapst/kimai2/pull/396) ([tobybatch](https://github.com/tobybatch))
- fixed issues- & milestone links [\#395](https://github.com/kevinpapst/kimai2/pull/395) ([lduer](https://github.com/lduer))
- added links to further docker images by the community [\#394](https://github.com/kevinpapst/kimai2/pull/394) ([kevinpapst](https://github.com/kevinpapst))
- beta test: added quick search box for customers, projects and activities [\#392](https://github.com/kevinpapst/kimai2/pull/392) ([kevinpapst](https://github.com/kevinpapst))
- updated the documentation, reflecting the changes in \#306 [\#387](https://github.com/kevinpapst/kimai2/pull/387) ([lduer](https://github.com/lduer))
- Added Hungarian translation and fixed the path of kimai.yaml in translation documentation [\#385](https://github.com/kevinpapst/kimai2/pull/385) ([infeeeee](https://github.com/infeeeee))
- improved docs and cross-linked docker [\#383](https://github.com/kevinpapst/kimai2/pull/383) ([kevinpapst](https://github.com/kevinpapst))
- Doc update of install/update instructions re: username [\#382](https://github.com/kevinpapst/kimai2/pull/382) ([srdco](https://github.com/srdco))
- invoice calculator to group entries by activity [\#380](https://github.com/kevinpapst/kimai2/pull/380) ([kevinpapst](https://github.com/kevinpapst))
- basic about screen with server and debug infos [\#378](https://github.com/kevinpapst/kimai2/pull/378) ([kevinpapst](https://github.com/kevinpapst))
- Dev/demo dockerfile [\#377](https://github.com/kevinpapst/kimai2/pull/377) ([tobybatch](https://github.com/tobybatch))
- Sidebar - user-profile links and language settings [\#369](https://github.com/kevinpapst/kimai2/pull/369) ([kevinpapst](https://github.com/kevinpapst))
- added configurable initial calendar view [\#363](https://github.com/kevinpapst/kimai2/pull/363) ([kevinpapst](https://github.com/kevinpapst))
- decrease minimum username to 3 character [\#362](https://github.com/kevinpapst/kimai2/pull/362) ([kevinpapst](https://github.com/kevinpapst))
- Default country \(\#2\) [\#358](https://github.com/kevinpapst/kimai2/pull/358) ([tobybatch](https://github.com/tobybatch))
- composer: removed deprecated symfony/lt, updated others [\#354](https://github.com/kevinpapst/kimai2/pull/354) ([kevinpapst](https://github.com/kevinpapst))
- updated admin-lte theme bundle to 2.1.1 [\#350](https://github.com/kevinpapst/kimai2/pull/350) ([kevinpapst](https://github.com/kevinpapst))
- updated timesheet and email documentation [\#349](https://github.com/kevinpapst/kimai2/pull/349) ([kevinpapst](https://github.com/kevinpapst))
- updated required dependencies [\#346](https://github.com/kevinpapst/kimai2/pull/346) ([kevinpapst](https://github.com/kevinpapst))
- Fix password reset [\#345](https://github.com/kevinpapst/kimai2/pull/345) ([kevinpapst](https://github.com/kevinpapst))
- added arabic translations and locale support in datepicker [\#337](https://github.com/kevinpapst/kimai2/pull/337) ([kevinpapst](https://github.com/kevinpapst))
- API endpoint for Timesheet entries [\#332](https://github.com/kevinpapst/kimai2/pull/332) ([kevinpapst](https://github.com/kevinpapst))
- Support global activities [\#259](https://github.com/kevinpapst/kimai2/pull/259) ([kevinpapst](https://github.com/kevinpapst))

## [0.5](https://github.com/kevinpapst/kimai2/tree/0.5) (2018-09-27)
[Full Changelog](https://github.com/kevinpapst/kimai2/compare/0.4...0.5)

**Implemented enhancements:**

- API: Kimai metadata endpoint [\#320](https://github.com/kevinpapst/kimai2/issues/320)
- Support Markdown in timesheet description [\#295](https://github.com/kevinpapst/kimai2/issues/295)
- Add support for MS Office templates [\#283](https://github.com/kevinpapst/kimai2/issues/283)
- Adding rates to customers, projects and tasks [\#271](https://github.com/kevinpapst/kimai2/issues/271)
- Delete invoice templates [\#267](https://github.com/kevinpapst/kimai2/issues/267)
- Sum of hours in timesheet invoice [\#262](https://github.com/kevinpapst/kimai2/issues/262)
- Feature request - API [\#251](https://github.com/kevinpapst/kimai2/issues/251)
- Feature request - PDF Download for monthly report [\#244](https://github.com/kevinpapst/kimai2/issues/244)
- Add support for OpenOffice templates [\#223](https://github.com/kevinpapst/kimai2/issues/223)
- Feature Request - Excel Output of times [\#221](https://github.com/kevinpapst/kimai2/issues/221)
- Add hourly rate options [\#111](https://github.com/kevinpapst/kimai2/issues/111)

**Fixed bugs:**

- Excel Output not containing data [\#327](https://github.com/kevinpapst/kimai2/issues/327)

**Closed issues:**

- Creating database schema throws exceptions [\#322](https://github.com/kevinpapst/kimai2/issues/322)
- Add permission voter for invoices and templates [\#293](https://github.com/kevinpapst/kimai2/issues/293)

**Merged pull requests:**

- added copy invoice template action [\#331](https://github.com/kevinpapst/kimai2/pull/331) ([kevinpapst](https://github.com/kevinpapst))
- fix spreadsheet renderer for invoices with one entry [\#328](https://github.com/kevinpapst/kimai2/pull/328) ([kevinpapst](https://github.com/kevinpapst))
- invoice VAT as float and database key length [\#323](https://github.com/kevinpapst/kimai2/pull/323) ([kevinpapst](https://github.com/kevinpapst))
- added version command + api endpoint [\#321](https://github.com/kevinpapst/kimai2/pull/321) ([kevinpapst](https://github.com/kevinpapst))
- Timesheet export [\#317](https://github.com/kevinpapst/kimai2/pull/317) ([kevinpapst](https://github.com/kevinpapst))
- added invoice voter [\#316](https://github.com/kevinpapst/kimai2/pull/316) ([kevinpapst](https://github.com/kevinpapst))
- Refactored invoice system [\#306](https://github.com/kevinpapst/kimai2/pull/306) ([kevinpapst](https://github.com/kevinpapst))
- add stable controller tests [\#305](https://github.com/kevinpapst/kimai2/pull/305) ([kevinpapst](https://github.com/kevinpapst))
- Fixed rate and Hourly rates [\#304](https://github.com/kevinpapst/kimai2/pull/304) ([kevinpapst](https://github.com/kevinpapst))
- add hourly\_rate and fixed\_rate to timesheet entries [\#302](https://github.com/kevinpapst/kimai2/pull/302) ([kevinpapst](https://github.com/kevinpapst))
- allow to switch language on any page [\#299](https://github.com/kevinpapst/kimai2/pull/299) ([kevinpapst](https://github.com/kevinpapst))
-  Fix duration\_short format for french translation  [\#297](https://github.com/kevinpapst/kimai2/pull/297) ([jeau](https://github.com/jeau))
- allow markdown in timesheet descriptions [\#296](https://github.com/kevinpapst/kimai2/pull/296) ([kevinpapst](https://github.com/kevinpapst))
- added option to delete invoice template [\#294](https://github.com/kevinpapst/kimai2/pull/294) ([kevinpapst](https://github.com/kevinpapst))
- Improved invoice preview [\#254](https://github.com/kevinpapst/kimai2/pull/254) ([kevinpapst](https://github.com/kevinpapst))

## [0.4](https://github.com/kevinpapst/kimai2/tree/0.4) (2018-09-01)
[Full Changelog](https://github.com/kevinpapst/kimai2/compare/0.3...0.4)

**Implemented enhancements:**

- Delete user [\#225](https://github.com/kevinpapst/kimai2/issues/225)

**Fixed bugs:**

- Don't allow to stop an already stopped entry [\#282](https://github.com/kevinpapst/kimai2/issues/282)
- installed it, and then what??? [\#255](https://github.com/kevinpapst/kimai2/issues/255)
- fixed calendar for empty timesheet descriptions [\#265](https://github.com/kevinpapst/kimai2/pull/265) ([kevinpapst](https://github.com/kevinpapst))
- fixed .htaccess for apache users [\#260](https://github.com/kevinpapst/kimai2/pull/260) ([kevinpapst](https://github.com/kevinpapst))

**Closed issues:**

- Spanish Translation Contrib [\#248](https://github.com/kevinpapst/kimai2/issues/248)
- Administration of projects throws error if locale is "de" [\#247](https://github.com/kevinpapst/kimai2/issues/247)
- Web Installer Package for near-automated installs from browser [\#235](https://github.com/kevinpapst/kimai2/issues/235)
- Improve dashboard display [\#280](https://github.com/kevinpapst/kimai2/issues/280)
- Feature request - Monthly overview / report [\#207](https://github.com/kevinpapst/kimai2/issues/207)

**Merged pull requests:**

- fixed money display in dashboard widgets [\#291](https://github.com/kevinpapst/kimai2/pull/291) ([kevinpapst](https://github.com/kevinpapst))
- Symfony update 4.1.4 [\#290](https://github.com/kevinpapst/kimai2/pull/290) ([kevinpapst](https://github.com/kevinpapst))
- do not allow to stop already stopped timesheets [\#289](https://github.com/kevinpapst/kimai2/pull/289) ([kevinpapst](https://github.com/kevinpapst))
- added configurable formats for duration [\#287](https://github.com/kevinpapst/kimai2/pull/287) ([kevinpapst](https://github.com/kevinpapst))
- Updated russian translations [\#286](https://github.com/kevinpapst/kimai2/pull/286) ([kevinpapst](https://github.com/kevinpapst))
- Update french translation [\#279](https://github.com/kevinpapst/kimai2/pull/279) ([jeau](https://github.com/jeau))
- Fix standard date format in french [\#278](https://github.com/kevinpapst/kimai2/pull/278) ([jeau](https://github.com/jeau))
-  new translations: spanish, french and italian [\#276](https://github.com/kevinpapst/kimai2/pull/276) ([kevinpapst](https://github.com/kevinpapst))
- French translation for Kimai [\#275](https://github.com/kevinpapst/kimai2/pull/275) ([jeau](https://github.com/jeau))
- updated to AdminLTE 2.4.8 [\#274](https://github.com/kevinpapst/kimai2/pull/274) ([kevinpapst](https://github.com/kevinpapst))
- fixing migration\_v1.md url [\#270](https://github.com/kevinpapst/kimai2/pull/270) ([ltsavar](https://github.com/ltsavar))
- dashboard widgets are configurable via config [\#269](https://github.com/kevinpapst/kimai2/pull/269) ([kevinpapst](https://github.com/kevinpapst))
- Spanish translation for Kimai [\#266](https://github.com/kevinpapst/kimai2/pull/266) ([cobaltos](https://github.com/cobaltos))
- moved theme settings to dynamic compiler pass [\#264](https://github.com/kevinpapst/kimai2/pull/264) ([kevinpapst](https://github.com/kevinpapst))
- Added config setting to disable password-reset and user-registration [\#261](https://github.com/kevinpapst/kimai2/pull/261) ([kevinpapst](https://github.com/kevinpapst))
- Added basic API endpoints [\#258](https://github.com/kevinpapst/kimai2/pull/258) ([kevinpapst](https://github.com/kevinpapst))
- Hotfix for Symfony Flex incompatibility with latest composer changes [\#257](https://github.com/kevinpapst/kimai2/pull/257) ([kevinpapst](https://github.com/kevinpapst))
- added italian translation [\#253](https://github.com/kevinpapst/kimai2/pull/253) ([kevinpapst](https://github.com/kevinpapst))
- Delete user [\#249](https://github.com/kevinpapst/kimai2/pull/249) ([kevinpapst](https://github.com/kevinpapst))
- dashboard widgets from event [\#246](https://github.com/kevinpapst/kimai2/pull/246) ([kevinpapst](https://github.com/kevinpapst))
- Added timesheet-calendar view [\#236](https://github.com/kevinpapst/kimai2/pull/236) ([kevinpapst](https://github.com/kevinpapst))
- Improved data fixtures [\#234](https://github.com/kevinpapst/kimai2/pull/234) ([kevinpapst](https://github.com/kevinpapst))

## [0.3](https://github.com/kevinpapst/kimai2/tree/0.3) (2018-07-22)
[Full Changelog](https://github.com/kevinpapst/kimai2/compare/0.2...0.3)

**Implemented enhancements:**

- Install Kimai as WebApp [\#203](https://github.com/kevinpapst/kimai2/issues/203)
- Replace AvanzuAdminTheme with AdminLTE bundle [\#201](https://github.com/kevinpapst/kimai2/issues/201)
- Add dynamic column filter [\#174](https://github.com/kevinpapst/kimai2/issues/174)
- Add register user function [\#164](https://github.com/kevinpapst/kimai2/issues/164)
- Add forgot password function - login screen [\#163](https://github.com/kevinpapst/kimai2/issues/163)
- Integrate FOSUserBundle \(for registration, password-reset, etc.\) [\#144](https://github.com/kevinpapst/kimai2/issues/144)
- added dynamic column filter \#174 [\#184](https://github.com/kevinpapst/kimai2/pull/184) ([kevinpapst](https://github.com/kevinpapst))

**Fixed bugs:**

- Missing assets in fresh installation [\#213](https://github.com/kevinpapst/kimai2/issues/213)
- Cannot remove payment terms from invoice template [\#188](https://github.com/kevinpapst/kimai2/issues/188)
- Set PHP locale for date format and month names [\#110](https://github.com/kevinpapst/kimai2/issues/110)
- Show revenue only for Admin \(wrong currency shown\) [\#19](https://github.com/kevinpapst/kimai2/issues/19)

**Closed issues:**

- Installation Issue of version1.3.1 [\#208](https://github.com/kevinpapst/kimai2/issues/208)
- Error on bin/console doctrine:schema:create [\#191](https://github.com/kevinpapst/kimai2/issues/191)
- Verifying email configuration [\#226](https://github.com/kevinpapst/kimai2/issues/226)
- Add favicon [\#205](https://github.com/kevinpapst/kimai2/issues/205)
- Document DB requirements in install docu [\#196](https://github.com/kevinpapst/kimai2/issues/196)
- easier creation of tasks [\#195](https://github.com/kevinpapst/kimai2/issues/195)
- Integrate lock bot [\#183](https://github.com/kevinpapst/kimai2/issues/183)
- Upgrade to FontAwesome 5 [\#179](https://github.com/kevinpapst/kimai2/issues/179)

**Merged pull requests:**

- Easier creation of Tasks/Projects/User [\#230](https://github.com/kevinpapst/kimai2/pull/230) ([kevinpapst](https://github.com/kevinpapst))
- Added email configuration docs [\#228](https://github.com/kevinpapst/kimai2/pull/228) ([kevinpapst](https://github.com/kevinpapst))
- Show revenue only for ROLE\_ADMIN [\#227](https://github.com/kevinpapst/kimai2/pull/227) ([kevinpapst](https://github.com/kevinpapst))
- hotfix responsiveness [\#220](https://github.com/kevinpapst/kimai2/pull/220) ([kevinpapst](https://github.com/kevinpapst))
- Integrated FOSUserBundle [\#216](https://github.com/kevinpapst/kimai2/pull/216) ([kevinpapst](https://github.com/kevinpapst))
- added auto-script to install assets [\#214](https://github.com/kevinpapst/kimai2/pull/214) ([kevinpapst](https://github.com/kevinpapst))
- added yunohost installation link [\#212](https://github.com/kevinpapst/kimai2/pull/212) ([kevinpapst](https://github.com/kevinpapst))
- added favicons and web app metadata [\#211](https://github.com/kevinpapst/kimai2/pull/211) ([kevinpapst](https://github.com/kevinpapst))
- added FAQ and database requirement docu \#196 [\#210](https://github.com/kevinpapst/kimai2/pull/210) ([kevinpapst](https://github.com/kevinpapst))
- Updated to AdminLTEBundle 1.0 [\#206](https://github.com/kevinpapst/kimai2/pull/206) ([kevinpapst](https://github.com/kevinpapst))
- replaced AvanzuAdminTheme with AdminLTE bundle [\#202](https://github.com/kevinpapst/kimai2/pull/202) ([kevinpapst](https://github.com/kevinpapst))
- allow empty invoice template terms \#188 [\#189](https://github.com/kevinpapst/kimai2/pull/189) ([kevinpapst](https://github.com/kevinpapst))
- improved install docs and composer [\#187](https://github.com/kevinpapst/kimai2/pull/187) ([kevinpapst](https://github.com/kevinpapst))
- added lock-bot config \#183 [\#186](https://github.com/kevinpapst/kimai2/pull/186) ([kevinpapst](https://github.com/kevinpapst))
- Composer package name [\#185](https://github.com/kevinpapst/kimai2/pull/185) ([kevinpapst](https://github.com/kevinpapst))
- updated to font-awesome 5 \#179 [\#181](https://github.com/kevinpapst/kimai2/pull/181) ([kevinpapst](https://github.com/kevinpapst))
- language specific money and date display [\#180](https://github.com/kevinpapst/kimai2/pull/180) ([kevinpapst](https://github.com/kevinpapst))

## [0.2](https://github.com/kevinpapst/kimai2/tree/0.2) (2018-06-23)
[Full Changelog](https://github.com/kevinpapst/kimai2/compare/0.1...0.2)

**Implemented enhancements:**

- Add english translation [\#8](https://github.com/kevinpapst/kimai2/issues/8)
- Add configurable system configuration [\#6](https://github.com/kevinpapst/kimai2/issues/6)
- Hide notifications after some seconds [\#169](https://github.com/kevinpapst/kimai2/issues/169)
- Setup Scrutinizer to run code sniffer [\#158](https://github.com/kevinpapst/kimai2/issues/158)
- Local config to overwrite settings [\#153](https://github.com/kevinpapst/kimai2/issues/153)
- Improve mobile view [\#151](https://github.com/kevinpapst/kimai2/issues/151)
- Add help text to form elements [\#138](https://github.com/kevinpapst/kimai2/issues/138)
- Add duration-only mode [\#131](https://github.com/kevinpapst/kimai2/issues/131)
- Add help controller [\#129](https://github.com/kevinpapst/kimai2/issues/129)
- Secure create-user command [\#123](https://github.com/kevinpapst/kimai2/issues/123)
- Add command for building a production release [\#115](https://github.com/kevinpapst/kimai2/issues/115)
- Add webpack and webpack-encore for frontend assets [\#113](https://github.com/kevinpapst/kimai2/issues/113)
- Add time rounding option [\#112](https://github.com/kevinpapst/kimai2/issues/112)
- Add field order number in Projects [\#107](https://github.com/kevinpapst/kimai2/issues/107)
- Create docu for invoice templates [\#106](https://github.com/kevinpapst/kimai2/issues/106)
- Add invoice template: timesheet [\#104](https://github.com/kevinpapst/kimai2/issues/104)
- Add importer from Kimai v1 [\#102](https://github.com/kevinpapst/kimai2/issues/102)
- Setup error pages [\#100](https://github.com/kevinpapst/kimai2/issues/100)
- Add basic HTML invoice rendering [\#97](https://github.com/kevinpapst/kimai2/issues/97)
- Filter user in timesheet admin [\#93](https://github.com/kevinpapst/kimai2/issues/93)
- Support to switch theme settings [\#89](https://github.com/kevinpapst/kimai2/issues/89)
- Roles should become a real table [\#86](https://github.com/kevinpapst/kimai2/issues/86)
- Fix Doctrine extensions config loader [\#84](https://github.com/kevinpapst/kimai2/issues/84)
- Upgrade to Symfony 4 and Flex [\#74](https://github.com/kevinpapst/kimai2/issues/74)
- Add remember me login [\#53](https://github.com/kevinpapst/kimai2/issues/53)
- Add preferences sidebar [\#10](https://github.com/kevinpapst/kimai2/issues/10)
- Add user settings [\#9](https://github.com/kevinpapst/kimai2/issues/9)
- Mobile alignments and toolbar \#151 [\#157](https://github.com/kevinpapst/kimai2/pull/157) ([kevinpapst](https://github.com/kevinpapst))
- Local config \#153 [\#156](https://github.com/kevinpapst/kimai2/pull/156) ([kevinpapst](https://github.com/kevinpapst))
- Filter in hidden toolbar - improved mobile \#151 [\#155](https://github.com/kevinpapst/kimai2/pull/155) ([kevinpapst](https://github.com/kevinpapst))
- Improved mobile view \#151 [\#150](https://github.com/kevinpapst/kimai2/pull/150) ([kevinpapst](https://github.com/kevinpapst))

**Fixed bugs:**

- Change to users language after login [\#7](https://github.com/kevinpapst/kimai2/issues/7)
- Prevent end time before start time [\#152](https://github.com/kevinpapst/kimai2/issues/152)
- Importing old data fails [\#145](https://github.com/kevinpapst/kimai2/issues/145)
- Translate LanguageType choices  [\#83](https://github.com/kevinpapst/kimai2/issues/83)
- Mobile alignments and toolbar \\#151 [\#157](https://github.com/kevinpapst/kimai2/pull/157) ([kevinpapst](https://github.com/kevinpapst))
- Improved mobile view \\#151 [\#150](https://github.com/kevinpapst/kimai2/pull/150) ([kevinpapst](https://github.com/kevinpapst))

**Closed issues:**

- Add CHANGELOG.md [\#177](https://github.com/kevinpapst/kimai2/issues/177)
- Add preview blog message and info text on old website [\#162](https://github.com/kevinpapst/kimai2/issues/162)
- Upgrade to Symfony 4.1 [\#149](https://github.com/kevinpapst/kimai2/issues/149)
- Replace has\_role\(\) with is\_granted\(\) [\#148](https://github.com/kevinpapst/kimai2/issues/148)
- Duration mode: creating new timesheet records prefills duration with some seconds [\#137](https://github.com/kevinpapst/kimai2/issues/137)
- \[RFC\] Encore: configureFilenames with hash after filename instead of in the filename [\#125](https://github.com/kevinpapst/kimai2/issues/125)
- \[RFC\] Kimai license header [\#124](https://github.com/kevinpapst/kimai2/issues/124)
- Setup travis to run phpunit tests [\#120](https://github.com/kevinpapst/kimai2/issues/120)
- Add russian translation [\#95](https://github.com/kevinpapst/kimai2/issues/95)

**Merged pull requests:**

- \[WIP\] Translations [\#173](https://github.com/kevinpapst/kimai2/pull/173) ([simonschaufi](https://github.com/simonschaufi))
- various documentation updates [\#176](https://github.com/kevinpapst/kimai2/pull/176) ([kevinpapst](https://github.com/kevinpapst))
- code styles: header\_comment and ordered\_imports [\#175](https://github.com/kevinpapst/kimai2/pull/175) ([kevinpapst](https://github.com/kevinpapst))
- Code sniffer rules \#158 [\#172](https://github.com/kevinpapst/kimai2/pull/172) ([kevinpapst](https://github.com/kevinpapst))
- Set default locale for unit-tests [\#171](https://github.com/kevinpapst/kimai2/pull/171) ([kevinpapst](https://github.com/kevinpapst))
- Hide success notification after 5 seconds [\#170](https://github.com/kevinpapst/kimai2/pull/170) ([kevinpapst](https://github.com/kevinpapst))
- Added validation for end date before start date [\#167](https://github.com/kevinpapst/kimai2/pull/167) ([kevinpapst](https://github.com/kevinpapst))
- Security expression \#148 [\#166](https://github.com/kevinpapst/kimai2/pull/166) ([kevinpapst](https://github.com/kevinpapst))
- Composer install [\#165](https://github.com/kevinpapst/kimai2/pull/165) ([kevinpapst](https://github.com/kevinpapst))
- added scrutinizer config \#158 [\#161](https://github.com/kevinpapst/kimai2/pull/161) ([kevinpapst](https://github.com/kevinpapst))
- Update to Symfony 4.1 \#149 [\#160](https://github.com/kevinpapst/kimai2/pull/160) ([kevinpapst](https://github.com/kevinpapst))
- Updated README [\#159](https://github.com/kevinpapst/kimai2/pull/159) ([kevinpapst](https://github.com/kevinpapst))
- added russian translation \#95 [\#147](https://github.com/kevinpapst/kimai2/pull/147) ([kevinpapst](https://github.com/kevinpapst))
- Bugfix importer \(\#145\) [\#146](https://github.com/kevinpapst/kimai2/pull/146) ([kevinpapst](https://github.com/kevinpapst))
- help text and link for form labels \#138 [\#143](https://github.com/kevinpapst/kimai2/pull/143) ([kevinpapst](https://github.com/kevinpapst))
- bugfix for duration\_only mode \#137 [\#142](https://github.com/kevinpapst/kimai2/pull/142) ([kevinpapst](https://github.com/kevinpapst))
- Make the back link appear like a normal link instead of a button [\#139](https://github.com/kevinpapst/kimai2/pull/139) ([simonschaufi](https://github.com/simonschaufi))
- Use short array syntax [\#135](https://github.com/kevinpapst/kimai2/pull/135) ([simonschaufi](https://github.com/simonschaufi))
- Duration only mode \#131 [\#134](https://github.com/kevinpapst/kimai2/pull/134) ([kevinpapst](https://github.com/kevinpapst))
- added controller to render markdown documentation \#129 [\#132](https://github.com/kevinpapst/kimai2/pull/132) ([kevinpapst](https://github.com/kevinpapst))
- Rounding rules [\#128](https://github.com/kevinpapst/kimai2/pull/128) ([kevinpapst](https://github.com/kevinpapst))
- Secure create-user command [\#127](https://github.com/kevinpapst/kimai2/pull/127) ([simonschaufi](https://github.com/simonschaufi))
- ConfigureFilenames with hash after filename [\#126](https://github.com/kevinpapst/kimai2/pull/126) ([simonschaufi](https://github.com/simonschaufi))
- added webpack-encore for managing frontend assets \#113 [\#122](https://github.com/kevinpapst/kimai2/pull/122) ([kevinpapst](https://github.com/kevinpapst))
- Remove personal mentions in license header [\#119](https://github.com/kevinpapst/kimai2/pull/119) ([simonschaufi](https://github.com/simonschaufi))
- Add github issue and pull request template [\#118](https://github.com/kevinpapst/kimai2/pull/118) ([simonschaufi](https://github.com/simonschaufi))
- Improvements [\#114](https://github.com/kevinpapst/kimai2/pull/114) ([kevinpapst](https://github.com/kevinpapst))
- added first docu on extending kimai with bundles \#106 [\#109](https://github.com/kevinpapst/kimai2/pull/109) ([kevinpapst](https://github.com/kevinpapst))
- added order number to projects \#107 [\#108](https://github.com/kevinpapst/kimai2/pull/108) ([kevinpapst](https://github.com/kevinpapst))
- added short invoice calculator and timesheet invoice template \#104 [\#105](https://github.com/kevinpapst/kimai2/pull/105) ([kevinpapst](https://github.com/kevinpapst))
- added command to import data from kimai v1 \#102 [\#103](https://github.com/kevinpapst/kimai2/pull/103) ([kevinpapst](https://github.com/kevinpapst))
- Error pages \#100 [\#101](https://github.com/kevinpapst/kimai2/pull/101) ([kevinpapst](https://github.com/kevinpapst))
- added basic invoice rendering \#97 [\#99](https://github.com/kevinpapst/kimai2/pull/99) ([kevinpapst](https://github.com/kevinpapst))
- added remember me feature \#53 [\#98](https://github.com/kevinpapst/kimai2/pull/98) ([kevinpapst](https://github.com/kevinpapst))
- code-cleanup: removed unused classes, added role constants, phpcs fixes [\#96](https://github.com/kevinpapst/kimai2/pull/96) ([kevinpapst](https://github.com/kevinpapst))
- load doctrine extensions during kernel bootstrap \#84 [\#92](https://github.com/kevinpapst/kimai2/pull/92) ([kevinpapst](https://github.com/kevinpapst))
- support theme options via user preferences \#89 [\#91](https://github.com/kevinpapst/kimai2/pull/91) ([kevinpapst](https://github.com/kevinpapst))
- added dynamic user preferences \#7 \#9 [\#90](https://github.com/kevinpapst/kimai2/pull/90) ([kevinpapst](https://github.com/kevinpapst))
- added control sidebar \#10 [\#87](https://github.com/kevinpapst/kimai2/pull/87) ([kevinpapst](https://github.com/kevinpapst))
- added english translation \#8 [\#82](https://github.com/kevinpapst/kimai2/pull/82) ([kevinpapst](https://github.com/kevinpapst))
- upgraded to symfony 4 \#74 [\#81](https://github.com/kevinpapst/kimai2/pull/81) ([kevinpapst](https://github.com/kevinpapst))

## [0.1](https://github.com/kevinpapst/kimai2/tree/0.1) (2018-01-10)
**Implemented enhancements:**

- Hide inactive delete user button [\#78](https://github.com/kevinpapst/kimai2/issues/78)
- Delete activity [\#71](https://github.com/kevinpapst/kimai2/issues/71)
- Delete other users timesheet entries [\#70](https://github.com/kevinpapst/kimai2/issues/70)
- Delete Project [\#69](https://github.com/kevinpapst/kimai2/issues/69)
- Delete Customer [\#68](https://github.com/kevinpapst/kimai2/issues/68)
- Delete timesheet entries [\#67](https://github.com/kevinpapst/kimai2/issues/67)
- Add installation docu [\#64](https://github.com/kevinpapst/kimai2/issues/64)
- Disallow login for inactive user [\#57](https://github.com/kevinpapst/kimai2/issues/57)
- Add toolbar to filter user screen [\#56](https://github.com/kevinpapst/kimai2/issues/56)
- Upgrade to latest Avanzu version [\#55](https://github.com/kevinpapst/kimai2/issues/55)
- AdminLTE login screen [\#52](https://github.com/kevinpapst/kimai2/issues/52)
- Add edit Timesheet entry for Teamleads [\#45](https://github.com/kevinpapst/kimai2/issues/45)
- Add Timesheet Voter [\#44](https://github.com/kevinpapst/kimai2/issues/44)
- Developer improvements [\#42](https://github.com/kevinpapst/kimai2/issues/42)
- Base class for repository and query objects [\#40](https://github.com/kevinpapst/kimai2/issues/40)
- Add console command to create user [\#36](https://github.com/kevinpapst/kimai2/issues/36)
- Add basic security Voter [\#34](https://github.com/kevinpapst/kimai2/issues/34)
- Do not show hidden Activities [\#33](https://github.com/kevinpapst/kimai2/issues/33)
- Do not show hidden Projects [\#32](https://github.com/kevinpapst/kimai2/issues/32)
- Add "create timesheet record" form [\#31](https://github.com/kevinpapst/kimai2/issues/31)
- Add filter to Customer admin [\#28](https://github.com/kevinpapst/kimai2/issues/28)
- Do not show hidden Customer [\#27](https://github.com/kevinpapst/kimai2/issues/27)
- Rename Timesheet query class [\#25](https://github.com/kevinpapst/kimai2/issues/25)
- Add "create activity" functionality [\#24](https://github.com/kevinpapst/kimai2/issues/24)
- Add "create project" functionality [\#23](https://github.com/kevinpapst/kimai2/issues/23)
- Add "create customer" functionality [\#22](https://github.com/kevinpapst/kimai2/issues/22)
- Translate dashboard widgets [\#20](https://github.com/kevinpapst/kimai2/issues/20)
- Display user avatar in navbar [\#16](https://github.com/kevinpapst/kimai2/issues/16)
- Add role SUPER\_ADMIN [\#15](https://github.com/kevinpapst/kimai2/issues/15)
- Teamlead can see all user times [\#13](https://github.com/kevinpapst/kimai2/issues/13)
- Add filter to Timesheet \(user\) [\#11](https://github.com/kevinpapst/kimai2/issues/11)
- Add "create user" functionality [\#5](https://github.com/kevinpapst/kimai2/issues/5)
- Edit users role [\#4](https://github.com/kevinpapst/kimai2/issues/4)
- Add filter to Timesheet admin [\#3](https://github.com/kevinpapst/kimai2/issues/3)
- Add filter to Activity admin [\#2](https://github.com/kevinpapst/kimai2/issues/2)
- Add filter to Project admin [\#1](https://github.com/kevinpapst/kimai2/issues/1)

**Merged pull requests:**

- hide inactive delete user button \#78 [\#79](https://github.com/kevinpapst/kimai2/pull/79) ([kevinpapst](https://github.com/kevinpapst))
- added delete customer action \#68 [\#77](https://github.com/kevinpapst/kimai2/pull/77) ([kevinpapst](https://github.com/kevinpapst))
- added delete action for projects \#69 [\#76](https://github.com/kevinpapst/kimai2/pull/76) ([kevinpapst](https://github.com/kevinpapst))
- Delete actions \#71 [\#75](https://github.com/kevinpapst/kimai2/pull/75) ([kevinpapst](https://github.com/kevinpapst))
- added delete timesheet record for admins \#70 [\#73](https://github.com/kevinpapst/kimai2/pull/73) ([kevinpapst](https://github.com/kevinpapst))
- added delete timesheet records action for users \#67 [\#72](https://github.com/kevinpapst/kimai2/pull/72) ([kevinpapst](https://github.com/kevinpapst))
- added toolbar to user screen \#56 [\#66](https://github.com/kevinpapst/kimai2/pull/66) ([kevinpapst](https://github.com/kevinpapst))
- document installation options \#64 [\#65](https://github.com/kevinpapst/kimai2/pull/65) ([kevinpapst](https://github.com/kevinpapst))
- update avanzu admin bundle \#55 [\#63](https://github.com/kevinpapst/kimai2/pull/63) ([kevinpapst](https://github.com/kevinpapst))
- prevent inactive user from login \#57 [\#61](https://github.com/kevinpapst/kimai2/pull/61) ([kevinpapst](https://github.com/kevinpapst))
- handle hidden customer \#27 [\#60](https://github.com/kevinpapst/kimai2/pull/60) ([kevinpapst](https://github.com/kevinpapst))
- handle hidden projects \#32 [\#59](https://github.com/kevinpapst/kimai2/pull/59) ([kevinpapst](https://github.com/kevinpapst))
- Handle hidden activities \#33 [\#58](https://github.com/kevinpapst/kimai2/pull/58) ([kevinpapst](https://github.com/kevinpapst))
- using the AdminLTE login screen \#52 [\#54](https://github.com/kevinpapst/kimai2/pull/54) ([kevinpapst](https://github.com/kevinpapst))
- added toolbar for activity screen \#2 [\#51](https://github.com/kevinpapst/kimai2/pull/51) ([kevinpapst](https://github.com/kevinpapst))
- Added toolbar to project screen \#1 [\#50](https://github.com/kevinpapst/kimai2/pull/50) ([kevinpapst](https://github.com/kevinpapst))
- added toolbar to customer screen \#28 [\#49](https://github.com/kevinpapst/kimai2/pull/49) ([kevinpapst](https://github.com/kevinpapst))
- added form to edit timesheet entries for all user \#45 [\#48](https://github.com/kevinpapst/kimai2/pull/48) ([kevinpapst](https://github.com/kevinpapst))
- Create timesheet for User \#31 [\#47](https://github.com/kevinpapst/kimai2/pull/47) ([kevinpapst](https://github.com/kevinpapst))
- added timesheet voter \#44 [\#46](https://github.com/kevinpapst/kimai2/pull/46) ([kevinpapst](https://github.com/kevinpapst))
- Developer cleanup \#42 [\#43](https://github.com/kevinpapst/kimai2/pull/43) ([kevinpapst](https://github.com/kevinpapst))
- Repository cleanup [\#41](https://github.com/kevinpapst/kimai2/pull/41) ([kevinpapst](https://github.com/kevinpapst))
- Added voter for customer, project and activity  [\#39](https://github.com/kevinpapst/kimai2/pull/39) ([kevinpapst](https://github.com/kevinpapst))
- added create user console command [\#38](https://github.com/kevinpapst/kimai2/pull/38) ([kevinpapst](https://github.com/kevinpapst))
- added "create user" functionality [\#37](https://github.com/kevinpapst/kimai2/pull/37) ([kevinpapst](https://github.com/kevinpapst))
- Added "create activity" form [\#35](https://github.com/kevinpapst/kimai2/pull/35) ([kevinpapst](https://github.com/kevinpapst))
- Added create project functionality [\#30](https://github.com/kevinpapst/kimai2/pull/30) ([kevinpapst](https://github.com/kevinpapst))
- Rename TimesheetQuery class [\#29](https://github.com/kevinpapst/kimai2/pull/29) ([kevinpapst](https://github.com/kevinpapst))
- Add customer functionality [\#26](https://github.com/kevinpapst/kimai2/pull/26) ([kevinpapst](https://github.com/kevinpapst))
- Dashboard widgets [\#21](https://github.com/kevinpapst/kimai2/pull/21) ([kevinpapst](https://github.com/kevinpapst))
- Added form to edit user roles [\#18](https://github.com/kevinpapst/kimai2/pull/18) ([kevinpapst](https://github.com/kevinpapst))
- added role ROLE\_SUPER\_ADMIN [\#17](https://github.com/kevinpapst/kimai2/pull/17) ([kevinpapst](https://github.com/kevinpapst))
- allow TEAMLEAD to see user times [\#14](https://github.com/kevinpapst/kimai2/pull/14) ([kevinpapst](https://github.com/kevinpapst))
- Timesheet toolbar [\#12](https://github.com/kevinpapst/kimai2/pull/12) ([kevinpapst](https://github.com/kevinpapst))



\* *This Change Log was automatically generated by [github_changelog_generator](https://github.com/skywinder/Github-Changelog-Generator)*