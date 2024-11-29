$(() => {

    const selectResize = function() {
        Array.from($('#pjax-users select').find('option')).forEach(element => {
            if (element.textContent.length > 35) {
                element.textContent = element.textContent.slice(0, 35) + '...';
            }
        })
    }

    $('#pjax-users').on('input', '#usersearch-id', function(event) {
        let url = new URL(window.location);

        url.searchParams.set('UserSearch[id]', $(this).val());
        url.searchParams.set('UserSearch[login]', $('#usersearch-login').val());
        url.searchParams.set('UserSearch[is_block]', $('#usersearch-is_block').find('option:selected').val());

        $.pjax.reload({
            container: '#pjax-users',
            url: url,
            pushState: false,
            timeout: 5000,
        });

        $(this).focus();

        $('#pjax-users').on('pjax:complete', function(event) {
            let inputField = $('#usersearch-id');
            inputField.focus();
            let val = inputField.val();
            inputField[0].setSelectionRange(val.length, val.length);
            $('#pjax-users').off(event);
        })
    });

    $('#pjax-users').on('input', '#usersearch-login', function(event) {
        let url = new URL(window.location);

        url.searchParams.set('UserSearch[id]', $('#usersearch-id').val());
        url.searchParams.set('UserSearch[login]', $(this).val());
        url.searchParams.set('UserSearch[is_block]', $('#usersearch-is_block').find('option:selected').val());

        $.pjax.reload({
            container: '#pjax-users',
            url: url,
            pushState: false,
            timeout: 5000,
        });

        $(this).focus();

        $('#pjax-users').on('pjax:complete', function(event) {
            let inputField = $('#usersearch-login');
            inputField.focus();
            let val = inputField.val();
            inputField[0].setSelectionRange(val.length, val.length);
            $('#pjax-users').off(event);
        })
    });

    $('#pjax-users').on('change', '#usersearch-is_block', function(event) {
        let url = new URL(window.location);

        url.searchParams.set('UserSearch[id]', $('#usersearch-id').val());
        url.searchParams.set('UserSearch[login]', $('#usersearch-login').val());
        url.searchParams.set('UserSearch[is_block]', $(this).find('option:selected').val());

        $.pjax.reload({
            container: '#pjax-users',
            url: url,
            pushState: false,
            timeout: 5000,
        })
    });

    selectResize();

    $('#pjax-users').on('pjax:complete', function(event) {
        selectResize();
    })
});