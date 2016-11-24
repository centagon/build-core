/**
 * This file is part of the Centagon Build/Foundation package.
 *
 * (c) Centagon <build@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

'use strict';

class Selectable {

    /**
     * Construct a new Selectable instance.
     *
     * @param  {string}  element
     */
    constructor(element) {
        var query = $(element);

        this.element     = element;
        this.selector    = query.find('input[type=checkbox]:not([value])');
        this.selectables = query.find('input[type=checkbox][value]');
    }

    /**
     * Register the selectable event handlers.
     */
    registerEvents() {
        const selectables = this.selectables;

        this.selector.change(function () {
            selectables.prop('checked', $(this).is(':checked')).trigger('change');
        });

        selectables.change(function () {
            var checked = $(this).is(':checked'),
                row     = $(this).closest('.selectable-row');

            if (checked) {
                $('[data-selectable-button]').removeAttr('disabled');
            } else {
                $('[data-selectable-button]').attr('disabled', 'disabled');
            }

            // id collection
            var ids = [];
            $('.row-id:checked').map((key, item) => ids.push(item.value));
            $('[data-id-collector]').val(ids.join(','));

            if (checked) {
                row.addClass('selected');
            } else {
                row.removeClass('selected');
            }
        });
    }
}

export default Selectable;