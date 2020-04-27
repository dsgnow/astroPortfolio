// animation to section when click menu //

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

// appear elements when scroll //
$(document).on('scroll', function () {

    const windowHeight = $(window).height();
    const scrollValue = $(window).scrollTop();

    // about section //
    const $wrapRocket = $('.wrapRocket');
    const $aboutParagraph = $('.about p');
    const $rocket = $('.rocket');
    const $rocketClouds = $('.rocket .greyClouds1, .rocket .greyClouds2, .rocket .greyClouds3, .rocket .greyClouds4');
    const rocketFromTop = $rocket.offset().top;
    const rocketHeight = $rocket.outerHeight();
    const $aboutBgcStars = $('.blackBgcStarsAbout');
    const $aboutBgcTwink = $('.blackBgcTwinkAbout');
    const $hiImPiotr = $('.imPiotr');


    if (scrollValue > rocketHeight + rocketFromTop - windowHeight - 200) {
        $wrapRocket.addClass("active");
        $rocketClouds.addClass("active");

        function rocketInSpace() {
            $aboutBgcStars.addClass("starsAll opacityBgc");
            $aboutBgcTwink.addClass("twinkling opacityBgc");
        }

        function rocketInSpaceTexts() {
            $hiImPiotr.attr("src", "img/imPiotrWhite.png");
            $aboutParagraph.addClass('white');
        }

        setTimeout(rocketInSpace, 4000);
        setTimeout(rocketInSpaceTexts, 4000);


    }

    //clean
    if (scrollValue < 100) {
        $('section.me *').removeClass('active');
        $aboutBgcStars.removeClass("starsAll opacityBgc");
        $aboutBgcTwink.removeClass("twinkling opacityBgc");
        $hiImPiotr.attr("src", "img/imPiotr.png");
        $aboutParagraph.removeClass('white');
    }
})