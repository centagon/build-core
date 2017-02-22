import Tabs from './Tabs';

export default class TabsDriver {

    constructor(e) {
        this.$elements = $(e);
    }

    registerEvents() {
        this.$elements.each(function () {
            (new Tabs(this)).registerEvents();
        });
    }

}