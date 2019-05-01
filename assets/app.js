// ------------------- INLINED ADMIN-LTE DEFINITIONS -------------------
// this was done to save around 300kb by:
// - removing moment locales which are not used
// - removing fullcalendar locales which are not used
// - removing icheck which is not used

//require('../vendor/kevinpapst/adminlte-bundle/Resources/assets/admin-lte');

const $ = require('jquery');
global.$ = global.jQuery = $;

require('jquery-ui');
require('bootstrap-sass');
require('jquery-slimscroll');
require('bootstrap-select');

const Moment = require('moment');
global.moment = Moment;
require('moment/locale/de');
require('moment/locale/it');
require('moment/locale/fr');
require('moment/locale/es');
require('moment/locale/ru');
require('moment/locale/ar');
require('moment/locale/hu');
require('moment/locale/pt-br');
require('moment/locale/sv');

require('daterangepicker');

// ------ AdminLTE framework ------
require('../vendor/kevinpapst/adminlte-bundle/Resources/assets/admin-lte.scss');
require('admin-lte/dist/css/AdminLTE.min.css');
require('admin-lte/dist/css/skins/_all-skins.css');
require('../vendor/kevinpapst/adminlte-bundle/Resources/assets/admin-lte-extensions.scss');

global.$.AdminLTE = {};
global.$.AdminLTE.options = {};
require('admin-lte/dist/js/adminlte.min');

require('../vendor/kevinpapst/adminlte-bundle/Resources/assets/default_avatar.png');

// ------------------- INLINED ADMIN-LTE DEFINITIONS -------------------
// ---------------------------------------------------------------------

require('./sass/app.scss');

require('fullcalendar');
require('fullcalendar/dist/gcal.min');
require('fullcalendar/dist/locale/de');
require('fullcalendar/dist/locale/it');
require('fullcalendar/dist/locale/fr');
require('fullcalendar/dist/locale/es');
require('fullcalendar/dist/locale/ru');
require('fullcalendar/dist/locale/ar');
require('fullcalendar/dist/locale/hu');
require('fullcalendar/dist/locale/pt-br');
require('fullcalendar/dist/locale/sv');
require('fullcalendar/dist/fullcalendar.min.css');

// ------ for charts ------
require('chart.js/dist/Chart.min');

// ------ Kimai itself ------
require('./js/kimai.js');
require('./js/datatable.js');
require('./js/toolbar.js');
require('./images/default_avatar.png');
require('./images/signature.png');
