/* global $ */

import { Visibility, Orientation } from './Util';
import MediaQuery from './MediaQuery';
import _each from 'lodash/each';

export default class Equalizer {

    /**
     * Equalizer constructor.
     *
     * @param  {string}  selector
     */
    constructor(selector = '.equalized') {
        this.selector = selector;
        this.mediaquery = new MediaQuery();
    }

    /**
     * Register the equalizer events.
     *
     * @returns {Equalizer}
     */
    register(element = window) {
        element.onload = () => this.equalize();

        $(element).on('changed.zf.mediaquery', (e, query) => {
            if (query !== 'small') this.equalize();
        });

        Orientation.onChange(() => {
            if (this.shouldEqualize()) {
                this.equalize();
            } else {
                this.reset();
            }
        });

        return this;
    }

    /**
     * Start equalizing the elements.
     */
    equalize() {
        const elements = this.getElements();
        const groups = {};
        const order = [];

        _each(elements, element => {
            const group = element.getAttribute('data-equalize') || 'global';

            // Check the visibility of the element. Invisible elements do
            // not consume any space in the document so we cannot
            // reliably calculate the height of this element.
            if (Visibility.isVisible(element) && this.shouldEqualize()) {
                if (!groups[group]) {
                    groups[group] = [];

                    // Append the group to the beginning of the ordering array.
                    // This enables us to walk through the groups and calculate
                    // the maximum heights from the inside out.
                    order.unshift(group);
                }

                groups[group].push(element);
            }
        });

        // Calculate the max height of the elements for each group.
        // Then apply that height to every element in the group.
        order.forEach(group => {
            const max = Math.max.apply(null, groups[group].map(element => element.offsetHeight));

            groups[group].forEach(element => {
                element.style.height = `${max}px`;
            });
        });

        $(document).trigger('primer.equalize.done');
    }

    /**
     * Resets the previously equalized elements.
     */
    reset() {
        const elements = this.getElements();

        for (let i = 0; i < elements.length; i++) {
            elements[i].style.height = null;
        }
    }

    getElements() {
        return document.querySelectorAll(this.selector);
    }

    /**
     * Determine if the element should be equalized.
     * @returns {boolean}
     */
    shouldEqualize() {
        return ! (this.mediaquery.getCurrent().name === 'small');
    }
}
