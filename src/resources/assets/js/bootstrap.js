import WindowDispatch from './lib/WindowDispatch';
import Selectable from './lib/Selectable';
import AutoGrow from './lib/AutoGrow';
import Sidebar from './lib/Sidebar';

window._ = require('lodash');
window.$ = window.jQuery = require('jquery');

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
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);

    next();
});

const autogrow = new AutoGrow('textarea');
const sidebar = new Sidebar;
const selectable = (new Selectable('table.selectable')).registerEvents();

window.build = {
    core: {
        WindowDispatch,
        autogrow,
        sidebar
    }
};