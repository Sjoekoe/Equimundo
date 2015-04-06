(function() {
    $('.comments__create-form').on('keydown', function(e) {
        if (e.keyCode == 13 && $.trim($(this).find('textarea').val()) !== "" ) {
            e.preventDefault();
            $(this).submit();
        }
    });
})();