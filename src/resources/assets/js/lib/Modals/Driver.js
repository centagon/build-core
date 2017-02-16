import Modal from './Modal';

var jquery = window.$;

var modals = {};

window.$.fn.modal = function ( action ) {
    
    if (this.length > 1) {
        
        $(this).each( function (e) {
            $(e).modal(action);
        });
        
        return this;
    }
    
    if (!modals[this.id]) {
        modals[this.id] = new Modal(this);
    }
    
    var thisModal = modals[this.id];
    
    switch (action) {
        case 'show':
            thisModal.show();
            break;
        case 'hide':
            thisModal.hide();
            break;
    }
    
    return this;
    
};