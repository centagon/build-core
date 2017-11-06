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

        doc.on('sidebar:opened', function (e, sidebar) {
            $('.sidebar').resizable({
                handles: "w"
            });

            $('body').addClass('sidebar-open');
        });

        doc.on('click', '.sidebar .cancel-button', function () {
            self.close($(this).closest('.sidebar'));
            $('body').removeClass('sidebar-open');
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
                .off('click','.button--cancel')
                .off('submit','form')
                .removeClass('sidebar--open')
                .find('.content').html('');

        $('body').removeClass('sidebar-open');
        
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

                    var arr = $(e.target).serializeArray();
                    var obj = {};

                    // Create an object from the form data
                    _.each(arr, (o) => {
                        if (obj[o.name]) {
                            if (!obj[o.name].push) {
                                obj[o.name] = [obj[o.name]];
                            }
                            obj[o.name].push(o.value || '');
                        } else {
                            obj[o.name] = o.value || '';
                        }
                    });

                    const action = $form.attr('action');
                    var method = $form.attr('method');

                    // Put the actor's value in the serialized array
                    if (currentActor) {
                        let name = $(currentActor).attr('name');

                        if (name) {
                            obj[name] = $(currentActor).attr('value');
                        }
                    }

                    $.ajax({
                            url: action,
                            beforeSend: this.setHeaders,
                            type: method,
                            data: obj,
                            dataType: 'json'
                    }).then( (response) => {
                            P.resolve(response, obj);
                            this.close($sidebar);
                    }).fail( (response) => {
                        
                        if (!response.responseJSON) {
                            P.reject(response, arr);
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
                .on('click', '.button--cancel', (e) => {
                    P.reject();
            
                    e.preventDefault();

                    this.close($sidebar);
                });

        });
        
        return P;

    }
    
}

export default Sidebar;