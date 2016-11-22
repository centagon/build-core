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

        $.ajax(url).done((response) => {
            sidebar.find('.content').html(response);
        });
    }

    close(sidebar) {
        sidebar.removeClass('sidebar--open').find('.content').html('');
    }
}

export default Sidebar;