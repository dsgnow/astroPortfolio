/* popup overlay */
const overlay = document.querySelector('.overlay');
const popUp = document.querySelector('.popUp');
const popUpButton = document.querySelector('.popUpButton');
const popUpText = document.querySelector('.popUpText');
const popUpTextSmall = document.querySelector('.popUpTextSmall');

function showPopup() {
    popUp.classList.add("showPopup");
    popUp.classList.remove("hidePopup");
    overlay.classList.toggle("show");
}

popUpButton.addEventListener('mousedown', (e) => {
    e.preventDefault();
    popUp.classList.add("hidePopup");
    popUp.classList.remove("showPopup");
    overlay.classList.remove("show");
})

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

// clock time //

const endTime = new Date('2020-01-20 12:34:00').getTime();

const spanMo = document.querySelector('span.mo');
const spanD = document.querySelector('span.d');
const spanH = document.querySelector('span.h');
const spanM = document.querySelector('span.m');
const spanS = document.querySelector('span.s');

setInterval(() => {
    const nowTime = new Date().getTime();
    const time = nowTime - endTime;

    const months = Math.floor((nowTime / (1000 * 60 * 60 * 24 * 30.5)) - (endTime / (1000 * 60 * 60 * 24 * 30.5)));

    const days = Math.floor((nowTime / (1000 * 60 * 60 * 24) - endTime / (1000 * 60 * 60 * 24)) % 30.5);

    let hours = Math.floor((nowTime / (1000 * 60 * 60) - endTime / (1000 * 60 * 60)) % 24);
    hours = Math.abs(hours) < 10 ? `0${hours}` : hours;

    const minutes = Math.floor((nowTime / (1000 * 60) - endTime / (1000 * 60)) % 60);

    let secs = Math.floor((nowTime / 1000 - endTime / 1000) % 60);
    secs = Math.abs(secs) < 10 ? `0${secs}` : secs;

    spanMo.textContent = Math.abs(months) + ' ms.';
    spanD.textContent = Math.abs(days) + ' d.';
    spanH.textContent = Math.abs(hours) + ' h.';
    spanM.textContent = Math.abs(minutes) + ' m.';
    spanS.textContent = Math.abs(secs) + ' s.';
}, 1000)

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
    $(".clock").toggleClass('white');
    $(".clock").addClass('transitionText');
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
        $(".clock").removeClass('transitionText');
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
    const $skills = $('.skills');
    const skillsFromTop = $skills.offset().top;
    const skillsHeight = $skills.outerHeight();
    const skillsSpans = document.querySelectorAll('.skill');

    // project section //
    const $firstProject = $('.firstProject');
    const firstProjectFromTop = $firstProject.offset().top;
    const firstProjectHeight = $firstProject.outerHeight();

    const $secondProject = $('.secondProject');
    const secondProjectFromTop = $secondProject.offset().top;
    const secondProjectHeight = $secondProject.outerHeight();

    // contact section //
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

    if (scrollValue > skillsHeight + skillsFromTop - windowHeight) {

        skillsSpans.forEach(function (skill, index) {
            setTimeout(function () {
                skill.classList.add("opacityOn");
            }, index * 500)
        });

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


//send email

$(".btn-sendEmail").click(function (e) {
    e.preventDefault();

    let form_name = $(".form_name").val();
    form_name = DOMPurify.sanitize(form_name);

    let form_email = $(".form_email").val();
    form_email = DOMPurify.sanitize(form_email);

    let form_message = $(".form_message").val();
    form_message = DOMPurify.sanitize(form_message);



    if (!$(".form_name").val()) {
        showPopup();
        popUpText.textContent = "Name is empty.";
        popUpTextSmall.textContent = "Please complete the field.";
        $(".form_name").focus();
        return false;
    }

    if (!$(".form_email").val()) {
        showPopup();
        popUpText.textContent = "Email is empty.";
        popUpTextSmall.textContent = "Please complete the field.";
        $(".form_email").focus();
        return false;
    }

    if (!$(".form_message").val()) {
        showPopup();
        popUpText.textContent = "Message is empty.";
        popUpTextSmall.textContent = "Please complete the field.";
        $(".form_message").focus();
        return false;
    }

    function validateEmail(email) {
        let re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    const email = $(".form_email").val();
    if (validateEmail(email)) {
        console.log("correct format");
    } else {
        showPopup();
        popUpText.textContent = "Email is not correct.";
        popUpTextSmall.textContent = "Please correct the field.";
        $(".form_email").focus();
        return false;
    }


    $.ajax({
        type: "POST",
        contentType: "application/x-www-form-urlencoded; charset=iso-8859-1",
        url: "gmail.php",

        data: {
            form_email: form_email,
            form_name: form_name,
            form_message: form_message
        },

        success: function (result) {

            if (result.replace(/\s/g, '') == "ok") {
                $(".form_email").val("");
                $(".form_message").val("");
                $(".form_name").val("");
                showPopup();
                popUpText.textContent = "Success! Message send.";

            } else if (result.replace(/\s/g, '') !== "ok") {
                showPopup();
                popUpText.textContent = "Error. Unable to send message.";
            }

        }
    });

});