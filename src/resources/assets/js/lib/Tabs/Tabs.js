export default class Tabs {

    constructor(e) {
        this.$element = $(e);
        this.init();
    }
    
    init() {
        this.tab_id = this.$element.attr('id');
        
        this.$content = $('[data-tabs__content='+this.tab_id+']');
        this.$panels = this.$content.find('.tabs__panel');
        this.$items = this.$element.find('.tabs__item');
    }
    
    getItemId($item) {
        return $item.find('a[href]').attr('href').replace('#','');
    }
    
    getPanel(id) {
        return this.$panels.filter('#'+id);
    }
    
    getItem(id) {
        return this.$items.find('a[href]').filter('[href="#'+id+'"]').parent('.tabs__item');
    }
    
    switchPanel(id) {
        this.$panels.removeClass('tabs__panel--active');
        this.$items.removeClass('tabs__item--active');
        var $activePanel = this.getPanel(id);
        var $activeItem = this.getItem(id);
        
        $activePanel.addClass('tabs__panel--active');
        $activeItem.addClass('tabs__item--active');
    }

    registerEvents() {
        var self = this;
        
        this.$items.on('click',this.$items, function () {
            self.switchPanel(self.getItemId($(this)));
        });
    }
    
}