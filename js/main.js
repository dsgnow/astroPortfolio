// animation to section when click menu //

$('nav a').on('click', function () {
    const goToSection = "[data-section=" + $(this).attr('class') + "]";
    $('body, html').animate({
        scrollTop: $(goToSection).offset().top
    }, 500)
})

$('.hambPopup a').on('click', function () {
    hambPop.classList.remove('show');
    hambButtonI.classList.toggle('fa-times');
    const goToSection = "[data-section=" + $(this).attr('class') + "]";
    $('body, html').animate({
        scrollTop: $(goToSection).offset().top
    }, 500)
})



// change nav visiblity when scroll //
const $hamburger = $('.hamburger');
const $nav = $('.nav');
let popHambUse = false;

var lastScrollTop = 0;
$(window).scroll(function (event) {
    var st = $(this).scrollTop();
    if (st > lastScrollTop) {
        if (popHambUse === false) {
            $(".hamburger").addClass('opacityNone');
        }
        $(".nav").addClass('opacityNone');
    } else {
        if (popHambUse === false) {
            $(".hamburger").removeClass('opacityNone');
        }
        $(".nav").removeClass('opacityNone');
    }
    lastScrollTop = st;
});

// hamburger popup //

const hambButton = document.querySelector('.hamburger');
const hambButtonI = document.querySelector('.hamburger i');
const hambPop = document.querySelector('.hambPopup');

hambButton.addEventListener('click', () => {
    popHambUse = !popHambUse;
    hambPop.classList.toggle('show');
    hambButtonI.classList.toggle('fa-times');
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

    const $firstProject = $('.firstProject');
    const firstProjectFromTop = $firstProject.offset().top;
    const firstProjectHeight = $firstProject.outerHeight();

    const $secondProject = $('.secondProject');
    const secondProjectFromTop = $secondProject.offset().top;
    const secondProjectHeight = $secondProject.outerHeight();

    const $contactAstro = $('.shoe');
    const contactAstroFromTop = $contactAstro.offset().top;
    const contactAstroHeight = $contactAstro.outerHeight();


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

        //setTimeout(rocketInSpace, 3000);
        //setTimeout(rocketInSpaceTexts, 3000);
    }

    if (scrollValue > firstProjectHeight + firstProjectFromTop - windowHeight - 200) {
        $firstProject.addClass("projectOddShow");
    }

    if (scrollValue > secondProjectHeight + secondProjectFromTop - windowHeight - 200) {
        $secondProject.addClass("projectEvenShow");
    }

    if (scrollValue > contactAstroHeight + contactAstroFromTop - windowHeight - 200) {
        $contactAstro.addClass("opacityOn");
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