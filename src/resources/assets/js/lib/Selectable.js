/**
 * This file is part of the Centagon Build/Foundation package.
 *
 * (c) Centagon <build@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

'use strict';

import Container from './Selectable/Container';

class Selectable {

    /**
     * Construct a new Global Selectable registrar.
     *
     * @param  {string}  element
     */
    constructor(element) {
        var query = $(element);
        
        this.containers = [];
        
        query.each( (i,e) => {
            this.containers.push(new Container(e));
        });
        
    }

    /**
     * Register the selectable event handlers.
     */
    registerEvents() {
        
        $.each(this.containers, (i,e) => {
            e.registerEvents();
        });
        
    }
}

export default Selectable;