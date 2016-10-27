/* eslint-disable no-console */

export default class {

    /**
     * Primer constructor.
     */
    constructor() {
        this.debug = false;

        // Stash console for later use.
        this.console = global.console;
    }

    /**
     * Get the Primer version.
     *
     * @returns {string}
     */
    get version() {
        return '0.1.3';
    }

    /**
     * Boot Primer.
     *
     * @param {bool} debug
     *
     * @returns {object}
     */
    boot(debug = false) {
        this.debug = debug;

        // Suppress console loging when debugging is disabled.
        if (! debug) {
            this.disableConsole();
        } else {
            this.enableConsole();
        }

        return this;
    }

    /**
     * Disable console logging.
     */
    disableConsole() {
        global.console = {};

        console.log
            = console.info
            = console.warm
            = console.error = () => {};
    }

    /**
     * Enable/Restore console logging.
     */
    enableConsole() {
        global.console = this.console;

        global.console.warn(`Centagon Primer ${this.version} debug mode enabled!
Please disable logging on production by calling (new Primer).boot(false);`);
    }
}
