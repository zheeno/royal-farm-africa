$(document).ready(function () {

    // init animations
    new WOW().init();
    // init timeago
    $(".timeago").ready(function () {
        $("time.timeago").timeago();
        // timeago().render(document.querySelectorAll('.timeago'));
    });
    // init tooltip
    $('[data-toggle="tooltip"]').tooltip();

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

    // dropdown selector for ratings
    $("#ratingSelector .dropdown-item").on("click", function (evt) {
        evt.preventDefault();
        const rating = $(this).attr('data-value');
        $("#rating").val(rating);
        $("#ratingButton").html($(this).html());
    });

    // wallet payment initiator
    $('.wallet-pay-btn').on('click', function (evt) {
        evt.preventDefault();
        $('#confirmationModal').modal('show');
    });

    // hover effects on featured cards
    $('.featured-card').mouseenter(function () {
        $(this).addClass('grey lighten-3');
    });
    $('.featured-card').mouseleave(function () {
        $(this).removeClass('grey lighten-3');
    });
});


// flutter Rave
document.addEventListener("DOMContentLoaded", function (event) {
    document.getElementById("ravePay").addEventListener("click", function (e) {
        var PBFKey = "FLWPUBK_TEST-09433fc46747cb550ad9b6d7cc0f2c51-X";

        getpaidSetup({
            PBFPubKey: PBFKey,
            customer_email: "user@example.com",
            customer_firstname: "Temi",
            customer_lastname: "Adelewa",
            custom_description: "Pay Internet",
            custom_logo: "https://pbs.twimg.com/profile_images/915859962554929153/jnVxGxVj.jpg",
            custom_title: "Communique Global System",
            amount: 2000,
            customer_phone: "234099940409",
            country: "NG",
            currency: "NGN",
            txref: "rave-123456",
            integrity_hash: "964eb106b1af3bd952903e6b54857fff",
            onclose: function () { },
            callback: function (response) {
                var flw_ref = response.tx.flwRef; // collect flwRef returned and pass to a 					server page to complete status check.
                console.log("This is the response returned after a charge", response);
                if (
                    response.tx.chargeResponseCode == "00" ||
                    response.tx.chargeResponseCode == "0"
                ) {
                    // redirect to a success page
                } else {
                    // redirect to a failure page.
                }
            }
        });
    });

});


// toggle notifs collapse
$(".notifColTog").on('click', function (evt) {
    // evt.preventDefault();
    console.log('col')
    $(".notifColTog").addClass('blue-text').removeClass('disabled border p-2 blue white-text');
    $(this).removeClass('blue-text').addClass('disabled border p-2 blue white-text');
    $($(this).attr('data-pri-target')).collapse('show');
    $($(this).attr('data-sec-target')).collapse('hide');
});