
// Прокрутка до блоков
$('a.header__link, a.smooth__link').on('click', function (event) {
    var $anchor = $(this);
    $('html, body').stop().animate({
        scrollTop: $($anchor.attr('href')).offset().top - 88
    }, {
        duration: 2000,
        specialEasing: {
            width: "linear",
            height: "easeInOutCubic"
        }
    });
    event.preventDefault();
});
// Прокрутка до блоков закончилась
