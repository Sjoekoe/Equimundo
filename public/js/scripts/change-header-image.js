function hideButtons() {
    $('.confirmation-buttons').hide();
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var coverPanel = $('.panel-bg-cover');
        var bg = $(coverPanel).css('background-image');
        var originalImage = bg.replace('url(','').replace(')','');

        reader.onload = function (e) {
            coverPanel.css(
                'background-image', 'url("' + e.target.result + '")'
            );
            $('.confirmation-buttons').show();
        }

        reader.readAsDataURL(input.files[0]);

        $('#heading-cancel-button').on('click', function() {
           coverPanel.css(
               'background-image', 'url("' + originalImage + '")'
           );
            hideButtons();
        });
    }
}

$("#header_picture").change(function(){
    readURL(this);
});


