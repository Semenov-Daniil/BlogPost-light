$(() => {

    const selectResize = function() {
        Array.from($('#pjax-posts #postsearch-statuses_id').find('option')).forEach(element => {
            if (element.textContent.length > 35) {
                element.textContent = element.textContent.slice(0, 35) + '...';
            }
        })
    }

    $('#pjax-posts').on('change', '#postsearch-statuses_id', function(event) {
        let url = new URL(window.location);

        url.searchParams.set('PostSearch[statuses_id]', $(this).find('option:selected').val());

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