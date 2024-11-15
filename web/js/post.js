$(() => {

    $('#pjax-post-form').on('change', '#posts-check', function(event) {
        $('#posts-themes_id option:first').prop('selected', true);

        const select = $('#posts-themes_id');
        const theme = $('#posts-theme');

        select.removeClass('is-valid is-invalid');
        theme.removeClass('is-valid is-invalid');

        if ($(this).prop('checked')) {
            theme.prop('disabled', false);
            select.prop('disabled', true);
        } else {
            theme.prop('disabled', true);
            select.prop('disabled', false);
            theme.prop('value', '');
        }
    });

})