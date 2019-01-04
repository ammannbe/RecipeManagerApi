$(document).ready(function () {
    $('.confirmation').on('click', function (event) {
        if (confirm('Bist du sicher?')) {
            return true;
        } else {
            event.stopPropagation();
            event.preventDefault();
        }
    });
});
