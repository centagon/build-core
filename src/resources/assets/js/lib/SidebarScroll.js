const element = $('.panel.panel__sidebar').eq(0);
// const offset = element.offset().top;

$(window).scroll(function (e) {
    let scrollTop = $(window).scrollTop();

    // if (scrollTop >= offset) {
    //     element.addClass('sticky');
    // } else {
    //     element.removeClass('sticky');
    // }
});