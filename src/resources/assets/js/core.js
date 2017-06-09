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

import AssetContainer from './screens/asset/Container.vue';
import AssetPicker from './screens/asset/Picker.vue';
import InputAsset from './components/input/Asset.vue';
import TagSelect from './components/input/TagSelect.vue';


Vue.component('tag-select', TagSelect);
Vue.component('input-asset', InputAsset);
Vue.component('asset-container', AssetContainer);
Vue.component('asset-picker', AssetPicker);

window.vuedata = {
    build: window.build
};

$( window ).load( function () {
    
    const app = new Vue({
        el: '#vue-wrapper',
        data: {
            vuedata: window.vuedata
        }
    });
    
    window.app = app;
});