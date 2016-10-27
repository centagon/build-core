import _each from 'lodash/each';

export default class {

    /**
     * LazyLoad constructor.
     * @param   {string}  selector
     */
    constructor(selector = 'img[data-src]') {
        _each(document.querySelectorAll(selector), img => {
            img.setAttribute('src', img.getAttribute('data-src'));

            img.onload = () => img.removeAttribute('data-src');
        });
    }
}
