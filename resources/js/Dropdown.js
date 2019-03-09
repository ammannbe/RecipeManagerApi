var Dropdown = {};

Dropdown.toggle = function() {
    if (Dropdown.$_visible) {
        Dropdown.hide();
    } else {
        Dropdown.show();
    }
}

Dropdown.show = function() {
    Dropdown.$_currentItem.removeClass('hidden');
    Dropdown.$_currentItem.addClass('show');
    Dropdown.$_currentItem.children('li').show();
    Dropdown.$_visible = true;
}

Dropdown.hide = function() {
    Dropdown.$_items.removeClass('show');
    Dropdown.$_items.addClass('hidden');
    Dropdown.$_visible = false;
    Dropdown.$_currentItem = null;
}

$(document).ready(function () {
    Dropdown._cssPath  = '.form form';
    Dropdown.$_visible = false;
    Dropdown.$_items   = $(`${Dropdown._cssPath} .js-dropdown`);
    Dropdown.$_button  = $(`${Dropdown._cssPath} button.arrow-down`);
    Dropdown.$_input   = $(`${Dropdown._cssPath} .text-input`);

    $(window).click(function() {
        Dropdown.hide();
    });

    Dropdown.$_items.children('li').click(function(e) {
        disableDefault(e);
    });

    Dropdown.$_button.click(function(e) {
        disableDefault(e)

        Dropdown.$_currentItem = $(this).siblings('.js-dropdown');
        Dropdown.toggle();
    });

    Dropdown.$_input.on('keyup', function() {
        Dropdown.$_currentItem = $(this).siblings('.js-dropdown');

        var value = $(this).val().toLowerCase();
        if (value) {
            Dropdown.show();
            Dropdown.$_currentItem.children('li').filter(function() {
                $(this).toggle(
                    $(this).text()
                        .toLowerCase()
                        .indexOf(value) > -1
                )
            });
        } else {
            Dropdown.hide();
        }
    });

    Dropdown.$_items.children('li').click(function() {
        $(this).parent()
            .siblings('.text-input')
            .val($(this).text());
        Dropdown.hide();
    });
});
