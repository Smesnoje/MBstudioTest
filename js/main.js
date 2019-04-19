$(document).ready(function () {

    // document.addEventListener('contextmenu', event => event.preventDefault());

    // EASE SCROLL

    $(document).on('click', 'a[href^="#"]', function (event) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top
        }, 800);
    });
    // CUSTOM SCROLLBAR
    $(window).on("load", function () {
        $(".content").mCustomScrollbar({
            theme: "dark"
        });
    });
    (jQuery);
    // ANIMATION 

    function animation() {
        var windowHight = $(window).height();
        var scroll = $(window).scrollTop();
        $('.animation').each(function () {
            var position = $(this).offset().top;
            var animation = $(this).attr('data-animation');
            //var delay = $(this).attr('data-delay');
            if (position < scroll + windowHight - 60) {
                $(this).addClass(animation);
                //$(this).css('animation-delay', delay);
            }
        });
    }//end of animation function

    animation();
    $(window).scroll(function () {
        animation();
    });
    $('.controls').on('click', '.controls--next', function () {
        $('.image_active').css({ "background-image": "url('img/mbstudio-slider-img-2.jpg')" });
        $('.image_active').css({ "background-image": "url('img/mbstudio-slider-img-3.jpg')" });
    });
    if ($('.owl-carousel').length > 0) {
        $('.image').owlCarousel({
            items: 1,
            nav: true,
            loop: true,
            navText: ["<img src='img/arrow_slider_left-01.svg'>", "<img src='img/arrow_slider_right-01.svg'>"]
        });
        $('.process-services-photo').owlCarousel({
            items: 1,
            nav: true,
            dots: true,
            loop: true,
            navText: ["<img src='img/arrow_slider_left-01.svg'>", "<img src='img/arrow_slider_right-01.svg'>"]
        });
        $('.process-modal-gallery').owlCarousel({
            items: 1,
            nav: true,
            dots: true,
            loop: true,
            navText: ["<img src='img/arrow_slider_left-01.svg'>", "<img src='img/arrow_slider_right-01.svg'>"]
        });
        $('.single-work-gallery').owlCarousel({
            items: 1,
            nav: true,
            dots: true,
            loop: true,
            navText: ["<img src='img/arrow_slider_left-01.svg'>", "<img src='img/arrow_slider_right-01.svg'>"]
        });
    }

    if ($('#fullpage').length > 0) {
        $('#fullpage').fullpage({
            autoScrolling: false
        });
    }


    TweenMax.from(".featured-slider-title", 1, { opacity: 0, x: 300 });
    TweenMax.from(".featured-slider-info", 1, { opacity: 0, x: -300 });
    //    TweenMax.staggerFrom(".services-item", 0.5, {opacity: 0, y: 200}, 0.2);



    $(".filter-button").click(function () {
        var value = $(this).attr('data-filter');
        if (value == "all") {
            //$('.filter').removeClass('hidden');
            $('.filter').show('1000');
        } else {
            //            $('.filter[filter-item="'+value+'"]').removeClass('hidden');
            //            $(".filter").not('.filter[filter-item="'+value+'"]').addClass('hidden');
            $(".filter").not('.' + value).hide('3000');
            $('.filter').filter('.' + value).show('3000');
        }
    });


    $(function () {
        var controller = new ScrollMagic.Controller();

        var servicesTween = TweenMax.staggerFrom(".servicesScene", 0.5, { opacity: 0, y: 200 }, 0.2);
        var containerScene = new ScrollMagic.Scene({
            triggerElement: '#container',
            triggerHook: 'onEnter',
            offset: 203
        })
            .setTween(servicesTween)
            .addTo(controller);


        var servicesTween = TweenMax.from("#services-img", 2, { opacity: 0 });
        var servicesImgScene = new ScrollMagic.Scene({
            triggerElement: '#services-img',
            triggerHook: 'onEnter',
            offset: 203
        })
            .setTween(servicesTween)
            .addTo(controller);

        var socialTween = TweenMax.staggerFrom(".socialScene", 0.5, { opacity: 0, y: 200 }, 0.2);
        var SocialScene = new ScrollMagic.Scene({
            triggerElement: '.social',
            triggerHook: 'onEnter',
            offset: 203
        })
            .setTween(socialTween)
            .addTo(controller);


        var processTween = TweenMax.staggerFrom(".processScene", 0.5, { opacity: 0, y: 200 }, 0.2);
        var processScene = new ScrollMagic.Scene({
            triggerElement: '#process',
            triggerHook: 'onEnter',
            offset: 203
        })
            .setTween(processTween)
            .addTo(controller);

        var aboutTween = TweenMax.staggerFrom(".aboutScene", 0.5, { opacity: 0, y: 200 }, 0.2);
        var aboutScene = new ScrollMagic.Scene({
            triggerElement: '#aboutTween',
            triggerHook: 'onEnter',
            offset: 203
        })
            .setTween(aboutTween)
            .addTo(controller);
    });


    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus');
    });

    $('input').focus(function () {
        $(this).parents('.form-group').addClass('focused');
    });

    $('input').blur(function () {
        var inputValue = $(this).val();
        if (inputValue == "") {
            $(this).removeClass('filled');
            $(this).parents('.form-group').removeClass('focused');
        } else {
            $(this).addClass('filled');
        }
    })

}
);//end document.ready


