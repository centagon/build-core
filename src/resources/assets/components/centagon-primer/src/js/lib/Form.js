import _each from 'lodash/each';

export default class {

    /**
     * Register the swap state event handlers.
     *
     * @param  {string}  selector
     */
    static registerSwapHandler(selector = 'data-state-event') {
        $(document).on('state-toggle', (_, data) => {
            const elements = document.querySelectorAll(`[${selector}="${data.event}"]`);

            _each(elements, el => el.classList.toggle('state-inversed'));
        });
    }
}