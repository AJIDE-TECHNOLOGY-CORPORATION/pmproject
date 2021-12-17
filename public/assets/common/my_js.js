$(document).on("click", ".delete-btn", function (event) {
    'use strict';
    event.preventDefault();
    var url = $(this).attr("href");
    swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        dangerMode: true,
        buttons: {
            confirm: {
                text: 'Yes, delete it!',
                value: true,
                visible: true,
                color: '#DD6B55',
                closeModal: true
            },
            cancel: {
                text: "No, cancel please!",
                value: false,
                visible: true,
                closeModal: true,
            }
        },
    })
        .then((isConfirm) => {
            if (isConfirm) {
                /* if the response is ok */
                window.location.href = url;
            } else {
                /* if the response is cancel */
                swal("Cancelled", "Your data is safe.", "error");
            }
        });
    return false;
});
$(document).on("click", ".delete-btn-restriction", function (event) {
    'use strict';
    event.preventDefault();
    var url = $(this).attr("href");
    swal({
        title: "Alert",
        text: "Delete is not allowded.Customer connected with Transaction! Please Use Inactive Option.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        dangerMode: true,
    });
    return false;
});