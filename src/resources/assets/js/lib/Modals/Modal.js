export default class Modal {
        
        constructor(e) {
            this.element = $(e);
            
            this.register();
        }
        
        register() {
            $(document).trigger('modal.registering', this);
            
            $(this.element).on('click','[data-close],[data-dismiss="modal"]', () => {
                this.hide();
            });
            
            $(document).trigger('modal.registered', this);
        }
        
        hide() {
            $(document).trigger('modal.closing', this);
            this.element.removeClass('modal--visible');
            $(document).trigger('modal.closed', this);
        }
        
        show() {
            $(document).trigger('modal.opening', this);
            this.element.addClass('modal--visible');
            $(document).trigger('modal.opened', this);
        }
        
}