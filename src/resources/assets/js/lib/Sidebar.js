class Sidebar {

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

    load(sidebar, url) {
        sidebar.addClass('sidebar--open');

        return $.ajax(url)
            .done(response => sidebar.find('.content').html(response))
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
        sidebar.removeClass('sidebar--open').find('.content').html('');
    }
}

export default Sidebar;