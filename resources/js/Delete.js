var Delete = {};

Delete.confirm = function(event) {
    if (! confirm('Bist du sicher?')) {
        disableDefault(event);
    }
}

$(document).ready(function () {
    Delete.$_confirm = $('.delete.confirm');

    Delete.$_confirm.on('click', function (event) {
        Delete.confirm(event);
    });
});
