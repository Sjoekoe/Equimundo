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