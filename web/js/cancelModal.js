$(() => {

    $("#pjax-posts").on('click', '.btn-cancel-modal', function(event) {
        event.preventDefault();

        $('#cancel-modal').modal('show');
    })

})