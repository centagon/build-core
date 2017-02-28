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
        let $link = $item.find('a[href^="#"]');
        
        if ($link.length === 0) {
            return undefined;
        }
        
        return $link.attr('href').replace('#','');
    }
    
    getPanel(id) {
        return this.$panels.filter('#'+id);
    }
    
    getItem(id) {
        return this.$items.find('a[href]').filter('[href="#'+id+'"]').parent('.tabs__item');
    }
    
    switchPanel(id) {
        if (!id) {
            return;
        }
        
        this.$panels.removeClass('tabs__panel--active');
        this.$items.removeClass('tabs__item--active');
        
        var $activePanel = this.getPanel(id);
        var $activeItem = this.getItem(id);
        
        $activePanel.addClass('tabs__panel--active');
        $activeItem.addClass('tabs__item--active');
    }

    registerEvents() {
        var self = this;
        
        this.$items.on('click',this.$items, function (e) {
            let id = self.getItemId($(this));
            
            if (!id) {
                return;
            }
            
            e.preventDefault();
            self.switchPanel(id);
        });
    }
    
}