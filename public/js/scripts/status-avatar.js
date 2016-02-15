(function() {
    var changeAvatar = function(e) {
        var horseId = this.options[this.selectedIndex].value;
        var placeholder = $('#js-status-avatar');

        $.ajax({
            url: '/api/horses/data/' + horseId,
            success: function(data) {
                placeholder.attr('src', data);
            }
        });
    }

    $('#js-status-select').on('change', changeAvatar);
})();
