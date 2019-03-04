var Delete = {};

Delete.confirm = function(event) {
    if (! confirm('Bist du sicher?')) {
        event.stopPropagation();
        event.preventDefault();
    }
}

$(document).ready(function () {
    $('.delete.confirm').on('click', function (event) {
        Delete.confirm(event);
    });
});
