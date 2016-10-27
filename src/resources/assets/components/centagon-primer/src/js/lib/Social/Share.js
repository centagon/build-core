import { Window } from '../Util';
import _each from 'lodash/each';

export default class Share {

    /**
     * Share Constructor.
     *
     * @param   {String}  selector
     */
    constructor(selector = 'data-social') {
        this.networks = {};
        this.selector = selector;
    }

    /**
     * Register a (or multiple) new network.
     *
     * @param   {String}  network
     * @param   {Object}  instance
     */
    register(network, instance) {
        if (typeof network === 'object') {
            return network.forEach((n, i) => this.register(n, i));
        }

        this.networks[network] = instance;

        return this;
    }

    /**
     * Boot the map of social media networks.
     */
    boot() {
        this.networks.forEach((network, Instance) => {
            this.networks[network] = new Instance(this);
        });

        this.registerEvents();
    }

    /**
     * Register the click event.
     */
    registerEvents() {
        const elements = document.querySelectorAll(`[${this.selector}]`);

        _each(elements, element => {
            element.addEventListener('click', () => this.onClick(element));
        });
    }

    /**
     * Open the sharing window.
     *
     * @param   {String}  element
     */
    onClick(element) {
        const network = this.networks[element.getAttribute(this.selector)];

        Window.open(network.url);
    }
}