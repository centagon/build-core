class AutoGrow {

    constructor(element) {
        $(element).each(function () {
            $(this).height($(this)[0].scrollHeight);
        });

        $(document).on('keyup', element, function () {
            $(this)
                .css('height', 10)
                .css('height', $(this)[0].scrollHeight + 20);
        });

        $(() => $(element).trigger('keyup'));
    }
}

export default AutoGrow;