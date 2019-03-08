var Toast = {};

Toast.remove = function($element) {
    $element.parent().fadeOut('slow');
}

$(document).ready(function () {
    $('.toast .alert button').click(function () {
        Toast.remove($(this));
    });
});
