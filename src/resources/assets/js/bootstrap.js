import {WindowDispatch} from 'centagon-build-core-js';
import {Selectable} from 'centagon-build-core-js';
import {AutoGrow} from 'centagon-build-core-js';
import {Sidebar} from 'centagon-build-core-js';

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

/**
 * Setup select2
 */
$('select').select2();

/**
 * Setup spectrum
 */
$('input[type=color]').spectrum({
    showInput:       true,
    showAlpha:       true,
    preferredFormat: 'rgb'
});

/**
 * Here we'll register all required core components.
 */
const autogrow = new AutoGrow('textarea');
const sidebar = new Sidebar;
const selectable = (new Selectable('table.table--selectable')).registerEvents();

window.build = {
    core: {
        WindowDispatch,
        autogrow,
        sidebar
    }
};
