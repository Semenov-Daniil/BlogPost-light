$(() => {

    $('.reaction').on('click', '.btn-reaction', function(event) {
        event.preventDefault();

        const a  = $(this);

        $.ajax({
            url: a.attr('href'),
            success(data) {
                a.find('.count-reaction').html(data);
            },
        })

    })

});