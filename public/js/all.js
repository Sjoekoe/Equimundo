(function () {
    function displayComment(data) {
        var commentHtml = createComment(data);
        var commentEl = $(commentHtml);
        commentEl.hide();
        var postsList = data.form.next();
        console.log(postsList);
        postsList.append(commentEl);
        commentEl.slideDown();
    }

    function createComment(data) {
        var html = '' +
            '<article class="comments__comment media status-media row">' +
            '<div class="pull-left">' +
            '</div>' +
            '<div class="media-body">' +
            '<h4 class="media-heading">' + data.username+ '</h4>' +
            data.body +
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
    });
})();
(function() {
    var submitAjaxRequest = function(e) {
        var form = $(this);
        var method = form.find('input[name=_method]').val() || 'POST';
        var icon = form.find('i');
        var favorited = icon.hasClass('fa-heart');

        if (favorited) {
            icon.removeClass('fa-heart').addClass('fa-heart-o');
        } else {
            icon.removeClass('fa-heart-o').addClass('fa-heart');
        }

        $.ajax({
            type: method,
            url: form.prop('action'),
            data: form.serialize()
        });

        e.preventDefault();
    }

    $('.like-button').on('submit', submitAjaxRequest);
})();