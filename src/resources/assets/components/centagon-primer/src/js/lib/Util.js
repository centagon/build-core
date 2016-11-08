export class Element {

    /**
     * Determine that the element is "in view".
     *
     * @param   {Element}  element
     *
     * @returns {boolean}
     */
    static inView(element) {
        const rect = element.getBoundingClientRect();

        return rect.top >= 0
            && rect.left >= 0
            && rect.bottom <= Window.height()
            && rect.right <= Window.width();
    }

    /**
     * Get a computed style property of an element.
     *
     * @param  {Element}  element
     * @param  {string}   property
     *
     * @returns {string}
     */
    static getStyle(element, property) {
        return Element.getStyles(element).getPropertyValue(property);
    }

    /**
     * Get the computed styles on an element.
     *
     * @param   {Element}  element
     *
     * @returns {CSSStyleDeclaration}
     */
    static getStyles(element) {
        return window.getComputedStyle(element, null);
    }
}

export class Orientation {

    /**
     * @callback Orientation~OnChange
     * @param    {Event}   event
     * @param    {string}  orientation
     */
    /**
     * Listen to an orientation change event and
     * execute the supplied callback.
     *
     * @param  {Orientation~OnChange}  callback
     */
    static onChange(callback) {
        const support = 'onorientationchange' in window;
        const event = support ? 'orientation' : 'resize';

        window.addEventListener(event, e => callback(e, Orientation.get()));
    }

    /**
     * Get the current device orientation.
     *
     * @returns {string}
     */
    static get() {
        return window.innerHeight > window.innerWidth ? 'portrait' : 'landscape';
    }
}

export class Visibility {

    /**
     * Find out if the given element is visibile.
     * Elements are considered visible if they consume space in the document.
     * Visible elements have a width or height that is greater than zero.
     *
     * @param   {object}  element
     * @returns {boolean}
     */
    static isVisible(element) {
        return element.offsetWidth > 0
            || element.offsetHeight > 0
            || element.getClientRects().length > 0;
    }

    /**
     * Determine that an element is not visible (or hidden).
     * This is calculated by the `Visibility.isVisible` method and returns the opposite.
     *
     * @param   {object}  element
     * @returns {boolean}
     */
    static isHidden(element) {
        return ! Visibility.isVisible(element);
    }
}

export class Window {

    /**
     * Open a new popup window.
     *
     * @param   {string}   url
     * @param   {int}      width
     * @param   {int}      height
     * @param   {boolean}  center
     */
    static open(url, width = 600, height = 450, center = true) {
        const top = center ? (screen.height / 2) - (height / 2) : 0;
        const left = center ? (screen.width / 2) - (width / 2) : 0;

        window.open(url, '', `width=${width},height=${height},top=${top},left=${left}`);
    }

    /**
     * @callback Window~OnResize
     * @param    {Event}   event
     */
    /**
     * Listen to an resize event and
     * execute the supplied callback.
     *
     * @param  {Window~OnResize}  callback
     */
    static onResize(callback) {
        window.onresize = (e) => callback(e)
    }

    /**
     * Get the width of the current window.
     *
     * @returns {Number|number}
     */
    static width() {
        return window.innerHeight || document.documentElement.clientHeight;
    }

    /**
     * Get the height of the current window.
     *
     * @returns {Number|number}
     */
    static height() {
        return window.innerWidth || document.documentElement.clientWidth;
    }

    /**
     * Get the center position of the window.
     *
     * @param   {number}  w
     * @param   {number}  h
     * 
     * @returns {{top: *, left: *}}
     */
    static getCenter(w, h) {
        const dualScreenLeft = window.screenLeft != 'undefined'
            ? window.screenLeft
            : screen.left;

        const dualScreenTop = window.screenTop != 'undefined'
            ? window.screenTop
            : screen.top;

        const left = ((Window.width() / 2) - (w / 2)) + dualScreenLeft;
        const top = ((Window.height() /  2) - (h / 2)) + dualScreenTop;

        return { top, left };
    }
}

export class String {

    /**
     * Decode a string into an object.
     *
     * @param  {string}  str
     *
     * @returns {*}
     */
    static toObject(str) {
        return str.split('&').reduce((ret, param) => {
            const parts = param.replace(/\+/g, ' ').split('=');
            let key = parts[0];
            let val = parts[1];

            key = decodeURIComponent(key);

            val = val === undefined ? null : decodeURIComponent(val);

            if (! ret.hasOwnProperty(key)) {
                ret[key] = val;
            } else if (Array.isArray(ret[key])) {
                ret[key].push(val);
            } else {
                ret[key] = [ret[key], val];
            }

            return ret;
        }, {});
    }
}