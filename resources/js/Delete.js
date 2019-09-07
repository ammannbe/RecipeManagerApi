Delete = {};
Delete.$_confirm;

Delete.confirm = function (event) {
    if (!confirm(Delete.$_confirm.data('confirm'))) {
        event.preventDefault();
        event.stopPropagation();
    }
}

$(document).ready(function () {
    Delete.$_confirm = $('.delete.confirm');

    Delete.$_confirm.on('click', function (event) {
        Delete.confirm(event);
    });
});
