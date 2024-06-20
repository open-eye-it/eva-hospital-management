function timeoutID(id, time){
    setTimeout(() => {
        $('#'+id).text('');
    }, time);
}

function scrollTop(id){
    $('html, body').animate({
        scrollTop: $("#"+id).offset().top-200
    }, 1000);
}

function sweetAlertSuccess(message, time=3000, route=''){
    Swal.fire({
        title: message,
        icon: "success",
        showCancelButton: false,
        showConfirmButton: false,
        timer: time
    }).then(function(){
        if(route != ''){
            window.location.href = route;
        }
    });
}

function sweetAlertError(message, time){
    Swal.fire({
        title: message,
        icon: "error",
        showCancelButton: false,
        showConfirmButton: false,
        timer: time
    }); 
}