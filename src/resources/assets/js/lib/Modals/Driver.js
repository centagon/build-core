import Modal from './Modal';

var jquery = window.$;

var modals = {};
var openmodals = 0;
var eventsBound = false;

window.$.fn.modal = function ( action ) {
    
    if (!eventsBound) {
        eventsBound = true;
        
        window.$(document).on('modal.opened', () => {
            openmodals++;
        });
        
        window.$(document).on('modal.closed', () => {
            if (openmodals>0) { 
                openmodals--; 
            };
        });
        
    }
    if (this.length > 1) {
        
        $(this).each( function (e) {
            $(e).modal(action);
        });
        
        return this;
    }
    
    var id = this.attr('id');
    
    if (!id) {
        console.warn('modal does not have an id');
        return this;
    }
    
    if (!modals[id]) {
        modals[id] = new Modal(this);
    }
    
    var thisModal = modals[id];
    
    switch (action) {
        case 'show':
            thisModal.show(openmodals);
            break;
        case 'hide':
            thisModal.hide();
            break;
    }
    
    return this;
    
};

