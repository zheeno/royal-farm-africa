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

// toggle notifs collapse
$(".notifColTog").on('click', function (evt) {
    // evt.preventDefault();
    console.log('col')
    $(".notifColTog").addClass('blue-text').removeClass('disabled border p-2 blue white-text');
    $(this).removeClass('blue-text').addClass('disabled border p-2 blue white-text');
    $($(this).attr('data-pri-target')).collapse('show');
    $($(this).attr('data-sec-target')).collapse('hide');
});

// toggle dom elements using url queries
if (document.getElementById("url-element-tog")) {
    // check if auto toggle is on
    var autoTog = $('#url-element-tog').attr("data-auto-toggle");
    if (autoTog.toLowerCase() == "true") {
        var target = $('#url-element-tog').attr("data-target");
        var togMode = $('#url-element-tog').attr("data-toggle-mode");
        switch (togMode.toLowerCase()) {
            case "modal":
                $('#' + target).modal('show');
                break;

            default:
                break;
        }
    }
};


// initialize tinyMice
tinymce.init({
    selector: 'textarea.tinyMiceEditor',
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | ' +
        ' bold italic backcolor | alignleft aligncenter ' +
        ' alignright alignjustify | bullist numlist outdent indent |' +
        ' removeformat | help',
    toolbar_drawer: 'floating',
});


// form validation
$('form').on('submit', function (evt) {
    var form_id = $(this).attr("id");
    var invalid = "", valid = 0, required = 0;
    console.log('validating...' + form_id);
    // loop through all input fields
    $("#" + form_id + " input," + form_id + " textarea").each(function (index) {
        // check if it is a required field
        if ($(this).attr("require") != null) {
            required++;
            // check if required field has a content
            if ($(this).val().length == 0) {
                var text = $(this).prev().text();
                if (text.length > 0) {
                    invalid += `<li><strong>` + text + `</strong></li>`;
                }
            } else {
                valid++;
            }
        }
    });
    if (required > valid) {
        evt.preventDefault();
        $("#errorAlertModal").modal("show");
        $("#errorAlertModal .alert-danger").html(`
        <h5 class='h5-responsive bold'>These fields are required</h5>
        <ol class="pl-3">`+ invalid + `</ol>
        <small>Kindly provide appropraite values for these fields to proceed.</small>`
        );
    }
});

// status toggler
$(".spon-state-tog").on("click", function (e) {
    e.preventDefault();
    const id = $(this).attr("id");
    const state = $(this).attr("data-state");
    switch (id) {
        case 'is_active_tog':
            if (Number(state) == 1) {
                // active state is true therefore,
                // make it false,
                // and make in_progress true
                $(this).attr("data-state", 0);
                $("#is_active_val").val(0);
                $("#" + id + " .fa").removeClass("fa-toggle-on green-ic").addClass("fa-toggle-off red-ic");
            } else {
                // active state is false therefore,
                // make it true, and make is_completed false,
                $(this).attr("data-state", 1);
                $("#is_active_val").val(1);
                $("#is_active_val").val(1);
                $("#" + id + " .fa").addClass("fa-toggle-on green-ic").removeClass("fa-toggle-off red-ic");
                $("#is_completed_tog").attr("data-state", 0);
                $("#is_completed_val").val(0);
                $("#is_completed_tog .fa").removeClass("fa-toggle-on green-ic").addClass("fa-toggle-off red-ic");
                $("#in_progress_tog").attr("data-state", 0);
                $("#in_progress_val").val(0);
                $("#in_progress_tog .fa").removeClass("fa-toggle-on green-ic").addClass("fa-toggle-off red-ic");

            }
            break;
        case 'in_progress_tog':
            if (Number(state) == 1) {
                // in progress state is true therefore,
                // make it false,
                $(this).attr("data-state", 0);
                $("#in_progress_val").val(0);
                $("#" + id + " .fa").removeClass("fa-toggle-on green-ic").addClass("fa-toggle-off red-ic");
            } else {
                // in progress is false, therefore,
                // make it true, make is_active false
                // and make is_completed false
                $(this).attr("data-state", 1);
                $("#in_progress_val").val(1);
                $("#" + id + " .fa").addClass("fa-toggle-on green-ic").removeClass("fa-toggle-off red-ic");
                $("#is_completed_tog").attr("data-state", 0);
                $("#is_completed_val").val(0);
                $("#is_completed_tog .fa").removeClass("fa-toggle-on green-ic").addClass("fa-toggle-off red-ic");
                $("#is_active_tog").attr("data-state", 0);
                $("#is_active_val").val(0);
                $("#is_active_tog .fa").removeClass("fa-toggle-on green-ic").addClass("fa-toggle-off red-ic");
            }
            break;
        case "is_completed_tog":
            // check if state is true
            if (Number(state) == 1) {
                // completed state is true therefore,
                // make it false
                $(this).attr("data-state", 0);
                $("#is_completed_val").val(0);
                $("#" + id + " .fa").removeClass("fa-toggle-on green-ic").addClass("fa-toggle-off red-ic");
            } else {
                // completed state is false therefore,
                // make it true, and set in progress to false,
                // and is active to false
                $(this).attr("data-state", 1);
                $("#is_completed_val").val(1);
                $("#" + id + " .fa").addClass("fa-toggle-on green-ic").removeClass("fa-toggle-off red-ic");
                // #########################
                $("#in_progress_tog").attr("data-state", 0);
                $("#in_progress_val").val(0);
                $("#in_progress_tog .fa").removeClass("fa-toggle-on green-ic").addClass("fa-toggle-off red-ic");
                $("#is_active_tog").attr("data-state", 0);
                $("#is_active_val").val(0);
                $("#is_active_tog .fa").removeClass("fa-toggle-on green-ic").addClass("fa-toggle-off red-ic");
            }
            break;

        default:
            break;
    }
});