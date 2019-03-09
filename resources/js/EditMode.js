var EditMode = {};

EditMode.init = function() {
    $.get(EditMode._uri, function (editMode) {
        if (editMode) {
            EditMode.enable();
        } else {
            EditMode.disable();
        }
    });
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
    EditMode.$_item.removeClass('hidden');
    $.get(`${EditMode._uri}/enable`);

}

EditMode.disable = function() {
    EditMode._enabled = false;
    EditMode.$_input.prop('checked', false);
    EditMode.$_item.addClass('hidden');
    $.get(`${EditMode._uri}/disable`);
}


$(document).ready(function () {
    EditMode.$_switch = $('.switch.edit-mode');
    if (EditMode.$_switch.length) {
        EditMode.$_item   = $('.edit-mode.item');
        EditMode.$_input  = $('.switch.edit-mode input[type=checkbox]');
        EditMode._enabled = false;
        EditMode._uri     = '/edit-mode';

        EditMode.init();

        EditMode.$_input.change(function() {
            EditMode.toggle();
        });
    }
});
