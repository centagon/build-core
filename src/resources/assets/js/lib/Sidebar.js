class Sidebar {

    setHeaders(xhr) {
        
        xhr.setRequestHeader('X-CSRF-TOKEN', config.csrf_token);
        
    }
    
    constructor() {
        const self = this;
        const doc = $(document);

        doc.on('click', 'a[href][data-open-sidebar]', function (e) {
            e.preventDefault();

            var sidebar = $('#' + $(this).data('open-sidebar')),
                href    = $(this).attr('href');

            self.load(sidebar, href);
        });

        doc.on('click', '.sidebar .cancel-button', function () {
            self.close($(this).closest('.sidebar'));
        });

        return this;
    }
    
    trigger(event, params) {
        $(document).trigger(`sidebar:${event}`, params);
    }

    load(sidebar, url, params = null) {
        const data = params;
        
        sidebar.addClass('sidebar--open');

        return $.ajax({
                    url: url,
                    data: data
                })
                .done(response => {
                    sidebar.find('.content').html(response);
            
                    this.trigger('opened', sidebar);
                    
                })
                .fail(response => {

                    // It's possible that laravel forgot the site we were logged into.
                    // So when the 'springboard' route returns a 401 unauthorized
                    // status code, then we'll redirect to the site selector.
                    if (response.status === 401) {
                        window.location.href = config.base_url;
                    }
                });
    }

    close(sidebar) {
        sidebar 
                .off('click','.button--secondary')
                .off('submit','form')
                .removeClass('sidebar--open')
                .find('.content').html('');
        
        this.trigger('closed', sidebar);
    }
    
    resource(sidebar, url, params) {
        const $sidebar = $(sidebar);
        
        this.close( $sidebar );
        
        var P = $.Deferred();
        
        this.load( $sidebar, url, params).then( () => {
            
            // Actors (buttons) will not be serialized ; so we make sure we do it ourselves
            var $actors = $(sidebar).find('form input[type=submit], form button');
            var currentActor = null;
                    
            $actors.on('click', (e) => {
                currentActor = e.target;
            });
            
            $(sidebar)
                .on('submit', 'form', (e) => {
                    e.preventDefault();
            
                    const $form = $(e.target);
                    
                    // Clear old errors
                    $form.find('.error[for]').removeClass('error');
                    
                    var obj = $(e.target).serializeArray();
                    var arr = {};
                    
                    const action = $form.attr('action');
                    var method = $form.attr('method');
                    
                    // Put the actor's value in the serialized array
                    if (currentActor) {
                        let name = $(currentActor).attr('name');
                        
                        if (name) {
                            arr[name] = $(currentActor).attr('value');
                        }
                    }
                    
                    _.each(obj, (o) => {
                        arr[o.name] = o.value;
                    });
                    
                    $.ajax({
                        url: action,
                        beforeSend: this.setHeaders,
                        type: method,
                        data: arr,
                        dataType: 'json'
                    }).then( (response) => {
                        P.resolve(response);
                        this.close($sidebar);
                    }).fail( (response) => {
                        
                        if (!response.responseJSON) {
                            P.reject(response);
                            this.close($sidebar);
                            return;
                        }
                        
                        _.each( response.responseJSON , (elem, i) => {
                            const $row = $form.find(`.row[for=${i}]`);
                            $row.addClass('error');
                            $row.find(`.form-error[for=${i}]`).html(elem[0]);
                        });
                        
                    });

                })
                .on('click', '.button--secondary', (e) => {
                    P.reject();
            
                    e.preventDefault();

                    this.close($sidebar);
                });

        });
        
        return P;

    }
    
}

export default Sidebar;