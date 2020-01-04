$(document).ready(function () {

    // init animations
    new WOW().init();
    // init timeago
    $(".timeago").ready(function () {
        $("time.timeago").timeago();
        // timeago().render(document.querySelectorAll('.timeago'));
    });

    $('.inc-unit').on('click', function (evt) {
        evt.preventDefault();
        var unit = Number($('#units').val());
        var max = Number($('#units').attr('data-max-val'));
        var inc = unit + 1;
        if (inc <= max) {
            $('#units').val(inc);
        }
    });

    $('.dec-unit').on('click', function (evt) {
        evt.preventDefault();
        var unit = Number($('#units').val());
        var dec = unit - 1;
        if (dec > 0) {
            $('#units').val(dec);
        }
    });

    if (document.getElementById("E404")) {
        var audio = new Audio('http://' + window.location.hostname + '/sounds/Crickets.mp3');
        audio.play();
        setTimeout(() => {
            audio.pause();
        }, 3000);
    }

    // number counter
    $(".counter").each(function (index) {
        var countTo = parseFloat($(this).attr("data-count-to"));
        console.log("Counter " + index, countTo);
        $(this).counter({
            autoStart: true, // true/false, default: true
            duration: 5000, // milliseconds, default: 1500
            countFrom: 0,// start counting at this number, default: 0
            countTo: countTo,// count to this number, default: 0
            runOnce: true,// only run the counter once, default: false
            placeholder: "**.**", // replace the number with this before counting,
            easing: "easeOutCubic", // easing effects
            onStart: function () { }, // callback on start of the counting
            onComplete: function () { }, // callback on completion of the counting
            numberFormatter: // function used to format the displayed numbers.
                function (number) {
                    return number;
                }
        });
    });

    // smooth scroll
    $('.smoothScroll').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1000); // The number here represents the speed of the scroll in milliseconds
                return false;
            }
        }
    });

});