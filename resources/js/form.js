$(document).ready(function () {
    $('form .info-text').click(function() {
        if (! $('form .info-text a i.reload').length) {
            $(this).append('<a href="#" onclick="location.reload()">Liste neu laden<i class="reload"></i></a>');
        }
    });
});
