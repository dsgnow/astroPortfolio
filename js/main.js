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
    $(".journey").addClass('transitionText');
    $(".front").addClass('transitionText');
    $(".blackBgcStars").toggleClass('starsAll');
    $(".blackBgcTwink").toggleClass('twinkling');
    $(".circle").toggleClass('animationCircleOut');
    $(".buttonBig").toggleClass('white');
    $(".buttonBig").toggleClass('bgcTrans');
    $(".buttonBig span").toggleClass('off');
    $(".slideDown i").toggleClass('white');

    function deleteTextTransition() {
        $(".journey").removeClass('transitionText');
        $(".front").removeClass('transitionText');
    }

    setTimeout(deleteTextTransition, 3000);
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
        $wrapRocket.removeClass("transformY0");

        function rocketInSpace() {
            $aboutBgcStars.addClass("starsAll opacityBgc");
            $aboutBgcTwink.addClass("twinkling opacityBgc");
        }

        function rocketInSpaceTexts() {
            $hiImPiotr.attr("src", "img/imPiotrWhite.svg");
            $aboutParagraph.addClass('white');
        }

        setTimeout(rocketInSpace, 3000);
        setTimeout(rocketInSpaceTexts, 3000);


    }

    //clean
    if (scrollValue < 100) {
        $('section.me *').removeClass('active');
        $aboutBgcStars.removeClass("starsAll opacityBgc");
        $aboutBgcTwink.removeClass("twinkling opacityBgc");
        $hiImPiotr.attr("src", "img/imPiotr.svg");
        $aboutParagraph.removeClass('white');

        $wrapRocket.addClass("transformY0");
    }
})