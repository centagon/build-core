/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import WindowDispatch from './lib/WindowDispatch';
import AutoGrow from './lib/AutoGrow';
import Sidebar from './lib/Sidebar';

const autogrow = new AutoGrow('textarea');
const sidebar = new Sidebar;

global.build = {
    core: {
        WindowDispatch,
        autogrow,
        sidebar
    }
};