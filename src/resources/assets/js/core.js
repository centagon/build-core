/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require('./bootstrap');
require('./lib/SidebarScroll');

require('../components/gridstack/src/gridstack.js');

import AssetContainer from './screens/asset/Container.vue';
import AssetPicker from './screens/asset/Picker.vue';
import InputAsset from './components/input/Asset.vue';
import TagSelect from './components/input/TagSelect.vue';
import vSelect from "vue-select";

Vue.component('tag-select', TagSelect);
Vue.component('input-asset', InputAsset);
Vue.component('v-select', vSelect);
Vue.component('asset-container', AssetContainer);
Vue.component('asset-picker', AssetPicker);

window.vuedata = window.vuedata || {};

$( window ).load( function () {
    
    const app = new Vue({
        el: '#vue-wrapper',
        data: {
            vuedata: window.vuedata
        }
    });
    
    window.app = app;
});