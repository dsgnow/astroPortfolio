// animation when scroll //

$('nav a').on('click', function () {
    const goToSection = "[data-section=" + $(this).attr('class') + "]";
    $('body, html').animate({
        scrollTop: $(goToSection).offset().top
    }, 500)
})

// changes when click ship/cosmos //

$(".buttonBig").click(function () {
    $(".journey").toggleClass('white');
    $(".front").toggleClass('white');
    $(".blackBgcStars").toggleClass('starsAll');
    $(".blackBgcTwink").toggleClass('twinkling');
    $(".circle").toggleClass('animationCircleOut');
    $(".buttonBig").toggleClass('white');
    $(".buttonBig").toggleClass('bgcTrans');
    $(".buttonBig span").toggleClass('off');
    $(".slideDown i").toggleClass('white');
});