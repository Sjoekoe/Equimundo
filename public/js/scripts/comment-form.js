(function () {
    /*function displayComment(data) {
        var commentHtml = createComment(data);
        var commentEl = $(commentHtml);
        commentEl.hide();
        var postsList = data.form.prev();
        postsList.append(commentEl);
        commentEl.slideDown();
    }

    function createComment(data) {
        var html = '' +
            '<article class="comments__comment media status-media row">' +
            '<div class="media-body clearfix">' +
            '<h5 class="media-heading pull-left">' + data.username + '</h5>' +
            '<p>' + data.body  + '</p>' +
            '</div>' +
            '</article>';

        return html;
    }

    $('.comments__create-form').on('keydown', function (e) {
        if (e.keyCode == 13 && $.trim($(this).find('textarea').val().length !== "")) {
            e.preventDefault();

            var form = $(this);
            var method = form.find('input[name=_method]').val() || 'POST';
            var data = {
                "body": form.find('textarea[name=body]').val(),
                "status_id": form.find('input[name=status_id]').val(),
                "username": form.find('input[name=username]').val(),
                "form": $(this)
            }

            $.ajax({
                method: method,
                url: form.prop('action'),
                data: form.serialize(),
                success: function () {
                    displayComment(data);
                }
            });
        }
    });*/
})();
