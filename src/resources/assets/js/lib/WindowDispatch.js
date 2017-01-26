import {Util} from 'centagon-primer';

class WindowDispatch {

    /**
     * Set the new window reference.
     *
     * @param   {object}  reference
     *
     * @returns {WindowDispatch}
     */
    setReference(reference) {
        this.reference = reference;

        return this;
    }

    /**
     * Post a message to the reference window.
     *
     * @param  {string}  message
     */
    postMessage(message) {
        this.reference.postMessage(message, '*');
    }

    /**
     * Open a new window.
     *
     * @param   {string}  url
     * @param   {string}  title
     * @param   {int}     width
     * @param   {int}     height
     *
     * @returns {WindowDispatch}
     */
    static open(url, title = 'document', width = 500, height = 250) {
        const { top, left } = Util.Window.getCenter(width, height);
        const reference = window.open(url, title, this.parseArguments(width, height, top, left));

        reference.focus();

        return (new this).setReference(reference);
    }

    /**
     * Get/set the parent window reference.
     *
     * @returns {WindowDispatch}
     */
    static parent() {
        return (new this).setReference(window.opener);
    }

    /**
     * Listen to a message event.
     *
     * @param  {Function}  callback
     */
    static listen(callback) {
        window.addEventListener('message', e => callback(e), false);
    }

    /**
     * Parse the window arguments.
     *
     * @param  {int}  width
     * @param  {int}  height
     * @param  {int}  top
     * @param  {int}  left
     *
     * @returns {string}
     */
    static parseArguments(width, height, top, left) {
        return `scrollbars=yes, width=${width}, height=${height}, top=${top}, left=${left}`;
    }
}

export default WindowDispatch;