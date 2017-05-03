export default class Tabs {

    constructor(e) {
        this.$element = $(e);
        this.init();
    }
    
    init() {
        $(document).trigger('tabs:initializing', {tabs: this});
       
        this.tab_id = this.$element.attr('id');
        
        this.$content = $('[data-tabs__content='+this.tab_id+']');
        this.$panels = this.$content.find('.tabs__panel');
        this.$items = this.$element.find('.tabs__item');
        
        const $activePanel = this.$panels.filter('.tabs__panel--active');
        if ($activePanel.length) {
            this.activePanel = $activePanel.attr('id');
        }
        
        const $activeItem = this.$items.filter('.tabs_item--active');
        if ($activeItem.length) {
            this.activeItem = this.getItemId($activeItem);
        }
        
        this.$content.addClass('tabs__content--initialized')
        
        $(document).trigger('tabs:initialized', {tabs: this});
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
        
        const previous = this.activePanel;
        const next = id;
        
        $(document).trigger('tabs:switching', { 
            tabs: this,
            current: previous,
            next: next
        });
        
        this.activatePanel(next);
        this.activateItem(next);
        
        $(document).trigger('tabs:switched', { 
            tabs: this, 
            previous: previous,
            current: next
        });
    }
    
    activatePanel(id) {
        const $active = this.getPanel(id);
        
        this.$panels.not($active).removeClass('tabs__panel--active');
        $active.addClass('tabs__panel--active');
        
        this.activePanel = id;
    }

    activateItem(id) {
        const $active = this.getItem(id);
        
        this.$items.not($active).removeClass('tabs__item--active');
        $active.addClass('tabs__item--active');
        
        this.activeItem = id;
    }

    registerEvents() {
        var self = this;
        
        this.$items.on('click', function (e) {
            
            let id = self.getItemId($(this));
            
            if (!id) {
                return;
            }
            
            e.preventDefault();
            self.switchPanel(id);
        });
        
        return this;
        
    }
    
}