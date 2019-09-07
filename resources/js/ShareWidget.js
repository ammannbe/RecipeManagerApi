ShareWidget = {
    _widget: null,
    _hideButton: null,
};

ShareWidget.init = function () {
    ShareWidget.$_widget = $('.share-widget');
    ShareWidget.$_hideButton = ShareWidget.$_widget.children('.hide');

    if (sessionStorage.getItem('share-widget') !== 'hide') {
        ShareWidget.show();
    }

    ShareWidget.$_hideButton.click(function (event) {
        event.preventDefault();
        event.stopPropagation();
        ShareWidget.hide();
    });
}

ShareWidget.hide = function () {
    sessionStorage.setItem('share-widget', 'hide');
    ShareWidget.$_widget.hide();
}

ShareWidget.show = function () {
    sessionStorage.setItem('share-widget', 'show');
    ShareWidget.$_widget.show();
}
