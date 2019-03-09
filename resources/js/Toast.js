var Toast = {};

Toast.remove = function() {
    Toast.$_button.parent().fadeOut('slow');
}

$(document).ready(function () {
    Toast.$_button = $('.toast .alert button');

    Toast.$_button.click(function () {
        Toast.remove();
    });
});
