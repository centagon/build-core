/* global $ */
/* global jQuery */

import _merge from 'lodash/merge';

export default class Scroll {

    /**
     * OnScroll constructor.
     *
     * @param  {object}  options
     */
    constructor(options) {
        this.settings = _merge({
            threshold: window.innerHeight / 2,
            onBeforeThreshold: () => {},
            onAfterThreshold: () => {}
        }, options);

        window.addEventListener('scroll', () => this.onScrollCallback());
    }

    /**
     * The callback that gets executed on every scroll event.
     */
    onScrollCallback() {
        if (this.scrolledPastThreshold()) {
            this.settings.onAfterThreshold();
        } else {
            this.settings.onBeforeThreshold();
        }
    }

    /**
     * Determine that we scrolled passed the given threshold.
     *
     * @returns {boolean}
     */
    scrolledPastThreshold() {
        const threshold = this.settings.threshold;

        return Scroll.getPosition() > threshold;
    }

    /**
     * Scroll to a certain position in the document.
     *
     * @param  {*}       offset
     * @param  {Number}  speed
     */
    static to(offset, speed = 250) {
        if (typeof offset === 'string') {
            // Did we pass in a selector string?
            offset = document.querySelector(offset).offsetTop;
        } else if (offset instanceof jQuery) {
            // Did we pass a jQuery object
            offset = offset.offset().top;
        }

        $('body, html').animate({ scrollTop: offset }, speed);
    }

    /**
     * Get the current scroll position.
     *
     * @returns {number}
     */
    static getPosition() {
        return document.body.scrollTop || document.documentElement.scrollTop;
    }
}
