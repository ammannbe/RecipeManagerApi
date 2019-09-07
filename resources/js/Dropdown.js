Dropdown = {
    _class: '.js-dropdown',
    _copy: '.copy-select2',
    _remove: '.remove-select2',
};

Dropdown.init = function () {
    $(Dropdown._class).select2();

    $(Dropdown._copy).click(function () {
        Dropdown.copy(this);
    });

    $(Dropdown._remove).click(function () {
        Dropdown.remove(this);
    });
}

Dropdown.copy = function (button) {
    var $el = $(button).siblings().last();

    $(Dropdown._class).select2('destroy');
    $el.after($el.clone());
    $(Dropdown._class).select2();
    $el.removeClass('hidden forced');
    $el.children('select').removeAttr('disabled');

    $(Dropdown._remove).unbind();
    $(Dropdown._remove).click(function () {
        Dropdown.remove(this);
    });
}

Dropdown.remove = function (button) {
    $(button).siblings().remove();
    $(button).remove();
}
