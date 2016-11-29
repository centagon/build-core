/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require('./bootstrap');

import AssetWrapper from './components/asset/Wrapper.vue';
import Example from './components/Example.vue';

const app = new Vue({
    el: '#vue-wrapper',
    components: {
        AssetWrapper,
        Example
    }
});
