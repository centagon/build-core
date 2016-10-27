import { Element, String } from './Util';

export default class {

    /**
     * @param  {string}  selector
     */
    constructor(selector = '_primer-mq') {
        this.queries = [];

        this.createElement(selector);

        const element = document.getElementById(selector);

        this.parseStyles(String.toObject(Element.getStyle(element, 'font-family')));

        this.current = this.getCurrent();
    }

    /**
     * Create the primer meta tag.
     *
     * @param   {string}  id
     */
    createElement(id) {
        const tag = document.createElement('meta');

        tag.id = id;

        document.getElementsByTagName('head')[0].appendChild(tag);
    }

    /**
     * Parse the given style object.
     *
     * @param  {object}  parsedStyles
     */
    parseStyles(parsedStyles) {
        for (let key in parsedStyles) {
            if (! parsedStyles.hasOwnProperty(key)) {
                break;
            }

            this.queries.push({
                name: key,
                value: `only screen and (min-width: ${parsedStyles[key]})`
            });
        }
    }

    /**
     * Get the current media query.
     *
     * @returns {object}
     */
    getCurrent() {
        var matched;

        for (let i = 0; i < this.queries.length; i++) {
            let query = this.queries[i];

            if (window.matchMedia(query.value).matches) {
                matched = query;
            }
        }

        return matched;
    }

    /**
     * Get a specific media query.
     *
     * @param   {string}  size
     *
     * @returns {object}
     */
    get(size) {
        for (let i in this.queries) {
            let query = this.queries[i];

            if (size === query.name) {
                return query.value;
            }
        }

        return null;
    }
}