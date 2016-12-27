/**
 * This file is part of the Centagon Build/Foundation package.
 *
 * (c) Centagon <build@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

'use strict';

class Container {

    /**
     * Construct a new Selectable Container instance.
     *
     * @param  {string}  element
     */
    constructor(element) {
        var query = this.query = $(element);

        // The name [data-name] of this selectable (This WILL be used when specified)
        this.name = query.data('name');
        
        this.element = element;
        this.selector = query.find('input[type=checkbox]:not([value])');
        this.selectables = query.find('input[type=checkbox][value]');
        
        this.buttons = this.queryButtons();
        this.idCollector = this.queryIdCollector();
    }
    
    /**
     * Return the buttons for this Selectable Container
     * 
     * @returns {jQuery|$|@pro;window@pro;$|Window.$|Element}
     */
    queryButtons() {
        
        if (this.name) {
            return $('[data-selectable-button][for='+this.name+']');
        }
        
        return $('[data-selectable-button]');
        
    }
    
    /**
     * Return the IdCollector instance
     * 
     * @returns {jQuery|$|@pro;window@pro;$|Window.$|Element}
     */
    queryIdCollector() {
        
        if (this.name) {
            return $('[data-id-collector][for='+this.name+']');
        }
        
        return $('[data-id-collector]');
    }

    /**
     * Register the selectable event handlers.
     */
    registerEvents() {
        const selectables = this.selectables;

        // Listen to selectable Toggler
        this.selector.change(function () {
            selectables.prop('checked', $(this).is(':checked')).trigger('change');
        });

        // Listen to selectable change triggers
        selectables.change( (e) => {

            var checked = $(e.target).is(':checked'),
                    row = $(e.target).closest('.selectable--row');

            // Enable/Disable the Action buttons
            if (checked) {
                this.buttons.removeAttr('disabled');
            } else {
                this.buttons.attr('disabled', 'disabled');
            }

            // id collection
            var ids = [];
            
            // Find the checked selectables
            this.selectables.filter(':checked').map((key, item) => ids.push(item.value));
            
            // Collect the ids
            this.idCollector.val(ids.join(','));

            // Change the Selectable row Style
            if (checked) {
                row.addClass('selected');
            } else {
                row.removeClass('selected');
            }
        });
        
        return this;
    }
}

export default Container;