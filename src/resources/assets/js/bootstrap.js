import WindowDispatch from './lib/WindowDispatch';
import Selectable from './lib/Selectable';
import AutoGrow from './lib/AutoGrow';
import Sidebar from './lib/Sidebar';
import TabsDriver from './lib/Tabs/TabsDriver';

require('./lib/Modals/Driver');

window._ = require('lodash');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */
window.Vue = require('vue');
require('vue-resource');  

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */
Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', config.csrf_token);

    next();
});

// Register a global errorhandler
if (!Vue.config.errorHandler) {
     Vue.config.errorHandler = function (err, vm, info) {
         window.console.error(err);
     };
}

/**
 * Setup select2
 */
$('select').not('#vue-wrapper select').select2();

/**
 * Setup spectrum
 */
$('.color-picker').spectrum({
    showInput: true,
    showAlpha: true,
    preferredFormat: 'rgb',
});

/**
 * Here we'll register all required core components.
 */
const autogrow = new AutoGrow('textarea');
const sidebar = new Sidebar;
const selectable = (new Selectable('table.table--selectable')).registerEvents();

const tabsdriver = (new TabsDriver('.tabs')).registerEvents();

window.build = {
    core: {
        WindowDispatch,
        autogrow,
        sidebar
    }
};
