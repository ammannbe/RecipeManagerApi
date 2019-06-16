EditMode = {
    $_switch: $('.switch.edit-mode'),
    $_item:   $('.edit-mode.item'),
    $_input:  $('.switch.edit-mode input[type=checkbox]'),

    _enabled: false
};

EditMode.init = function() {
    // Show switch only if JS is enabled
    EditMode.showSwitch();

    if (Cookies.get('edit-mode') === 'enabled') {
        EditMode.enable();
    } else {
        EditMode.disable();
    }

    EditMode.$_input.change(function() {
        EditMode.toggle();
    });
}

EditMode.showSwitch = function() {
    EditMode.$_switch.parent().removeClass('hidden forced');
}

EditMode.toggle = function() {
    if(EditMode._enabled) {
        EditMode.disable();
    } else {
        EditMode.enable();
    }
}

EditMode.enable = function() {
    EditMode._enabled = true;
    EditMode.$_input.prop('checked', true);
    EditMode.$_item.removeClass('hidden forced');
    Cookies.set('edit-mode', 'enabled');
    EditMode.$_switch.parent().parent().children().eq(1).hide(); // hide switch text

}

EditMode.disable = function() {
    EditMode._enabled = false;
    EditMode.$_input.prop('checked', false);
    EditMode.$_item.addClass('hidden forced');
    Cookies.set('edit-mode', 'disabled')
    EditMode.$_switch.parent().parent().children().eq(1).show(); // show switch text
}
