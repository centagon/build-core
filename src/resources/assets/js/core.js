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

$( window ).load( function () {
    
    const app = new Vue({
        el: '#vue-wrapper',
        components: {
            AssetContainer,
            AssetPicker,
            InputAsset
        }
    });

    window.app = app;
    
    /**
     * Setup select2
     */
    $('select').select2();

});