$(() => {

    $('#pjax-search-posts').on('input', '#postsearch-title', function(event) {
        const searchTitle = $(this);
        const searchThemes = $('#pjax-search-posts #postsearch-themes_id');
        const searchCreatedAt = $('#pjax-search-posts #search-created_at');
        const url = `/post/index?PostSearch[title]=${searchTitle.val()}&PostSearch[themes_id]=${searchThemes.find('option:selected').val()}&sort=${(searchCreatedAt.data('sort') == 'created_at' ? '-created_at' : 'created_at')}`;
        $.pjax.reload({
            container: '#pjax-posts',
            url: url,
        })
    });

    $('#pjax-search-posts').on('change', '#postsearch-themes_id', function(event) {
        const searchTitle = $('#pjax-search-posts #postsearch-title');
        const searchThemes = $(this);
        const searchCreatedAt = $('#pjax-search-posts #search-created_at');
        const url = `/post/index?PostSearch[title]=${searchTitle.val()}&PostSearch[themes_id]=${searchThemes.find('option:selected').val()}&sort=${(searchCreatedAt.data('sort') == 'created_at' ? '-created_at' : 'created_at')}`;
        $.pjax.reload({
            container: '#pjax-posts',
            url: url,
        })
    });

    $('#pjax-search-posts').on('click', '#search-created_at', function(event) {
        event.preventDefault();
        const searchTitle = $('#pjax-search-posts #postsearch-title');
        const searchThemes = $('#pjax-search-posts #postsearch-themes_id');
        const searchCreatedAt = $(this);
        const url = `/post/index?PostSearch[title]=${searchTitle.val()}&PostSearch[themes_id]=${searchThemes.find('option:selected').val()}&sort=${searchCreatedAt.data('sort')}`;

        $.pjax.reload({
            container: '#pjax-posts',
            url: url,
            pushState: false,
            replaceState: false,
            timeout: 5000,
        })

        $('#pjax-posts').on('pjax:complete', function(event) {
            $.pjax.reload({
                container: '#pjax-search-posts',
                url: url,
                pushState: false,
                replaceState: false,
                timeout: 5000,
            });

            $('#pjax-posts').off();
        });
    });

});