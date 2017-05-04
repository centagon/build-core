import Tabs from './Tabs';

export default class TabsDriver {

    constructor(e) {
        this.tabs = [];
        this.$elements = $(e);
    }

    registerEvents() {
        var _self = this;
        
        this.$elements.each( function() {
            _self.add(this);
        });
        
        return this;
    }
    
    add(target) {
        this.tabs.push( (new Tabs(target)).registerEvents() );
    }

}