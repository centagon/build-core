class Network {

    /**
     * Get the current location.
     *
     * @returns {string}
     */
    get location() {
        return encodeURIComponent(window.location.href);
    }

    /**
     * Get the document title.
     *
     * @returns {string}
     */
    get title() {
        return encodeURI(document.title);
    }
}

class OpenGraphNetwork extends Network {

    /**
     * Construct the Open Graph title from the og:title meta property.
     *
     * @returns {string}
     */
    get title() {
        const element = document.querySelector('meta[property="og:title"]');

        return element
            ? encodeURIComponent(element.getAttribute('content'))
            : super.title;
    }
}

export class Twitter extends Network {

    /**
     * Construct the Twitter title from the twitter:description property.
     *
     * @returns {string}
     */
    get title() {
        const element = document.querySelector('meta[property="twitter:description"]');

        return element
            ? encodeURIComponent(element.getAttribute('content'))
            : super.title;
    }

    /**
     * Construct the Twitter social sharing url.
     *
     * @returns {*}
     */
    get url() {
        return `https://twitter.com/share?text=${this.title}&url=${this.location}`;
    }
}

export class Facebook extends OpenGraphNetwork {

    /**
     * Construct the Facebook social sharing url.
     *
     * @returns {*}
     */
    get url() {
        return `https://www.facebook.com/sharer/sharer.php?u=${this.location}`;
    }
}

export class LinkedIn extends OpenGraphNetwork {

    /**
     * Construct the LinkedIn social sharing url.
     *
     * @returns {*}
     */
    get url() {
        return `http://www.linkedin.com/shareArticle?mini=true&url=${this.location}`;
    }
}

export class Xing extends OpenGraphNetwork {

    /**
     * Construct the Xing social sharing url.
     * @returns {*}
     */
    get url() {
        return `https://www.xing.com/spi/shares/new?url=${this.location}`;
    }
}
