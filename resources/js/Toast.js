var Toast = {};

Toast.remove = function () {
    Toast.$_button.parent().fadeOut('slow');
}

$(document).ready(function () {
    Toast.$_button = $('.toast .alert button');

    setTimeout(() => {
        Toast.remove();
    }, 6000);

    Toast.$_button.click(function () {
        Toast.remove();
    });
});
