function timeoutID(id, time) {
    setTimeout(() => {
        $("#" + id).text("");
    }, time);
}

function scrollTop(id) {
    $("html, body").animate(
        {
            scrollTop: $("#" + id).offset().top - 200,
        },
        1000
    );
}

function modalScrollTop(modalId, fieldId) {
    $("#" + modalId + " .modal-body").animate(
        { scrollTop: $("#" + fieldId).offset().top + 500 },
        500
    );
    // $('#'+modalId+' .modal-body').animate({
    //     scrollTop: $("#"+fieldId).offset().top-500
    // }, 1000);
}

function sweetAlertSuccess(message, time = 3000, route = "") {
    Swal.fire({
        title: message,
        icon: "success",
        showCancelButton: false,
        showConfirmButton: false,
        timer: time,
    }).then(function () {
        if (route != "") {
            window.location.href = route;
        }
    });
}

function sweetAlertError(message, time) {
    Swal.fire({
        title: message,
        icon: "error",
        showCancelButton: false,
        showConfirmButton: false,
        timer: time,
    });
}

/* Start:: Appointment Create */
$("#ap_date").datepicker({
    todayHighlight: true,
    format: "yyyy-mm-dd",
});
/* End:: Appointment Create */
/* Start:: Follow Up OPD */
$("#ap_follow_up_date").datepicker({
    todayHighlight: true,
    format: "yyyy-mm-dd",
});
/* End:: Follow Up OPD */
/* Start:: Follow Up IPD */
$("#ipd_follow_up_date").datepicker({
    todayHighlight: true,
    format: "yyyy-mm-dd",
});
/* End:: Follow Up IPD */
