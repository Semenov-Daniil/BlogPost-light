$(() => {

    const selectResize = function() {
        Array.from($('#pjax-posts #postsearch-themes_id').find('option')).forEach(element => {
            if (element.textContent.length > 35) {
                element.textContent = element.textContent.slice(0, 35) + '...';
            }
        })
    }

    $('#pjax-posts').on('input', '#postsearch-title', function(event) {
        let url = new URL(window.location);

        url.searchParams.set('PostSearch[title]', $(this).val());
        url.searchParams.set('PostSearch[themes_id]', $('#postsearch-themes_id').find('option:selected').val());

        $.pjax.reload({
            container: '#pjax-posts',
            url: url,
            pushState: false,
            timeout: 5000,
        });

        $(this).focus();

        $('#pjax-posts').on('pjax:complete', function(event) {
            let inputField = $('#postsearch-title');
            inputField.focus();
            let val = inputField.val();
            inputField[0].setSelectionRange(val.length, val.length);
        })
    });

    $('#pjax-posts').on('change', '#postsearch-themes_id', function(event) {
        let url = new URL(window.location);

        url.searchParams.set('PostSearch[title]', $('#postsearch-title').val());
        url.searchParams.set('PostSearch[themes_id]', $(this).find('option:selected').val());

        $.pjax.reload({
            container: '#pjax-posts',
            url: url,
            pushState: false,
            timeout: 5000,
        })
    });

    selectResize();

    $('#pjax-posts').on('pjax:complete', function(event) {
        selectResize();
    })
});