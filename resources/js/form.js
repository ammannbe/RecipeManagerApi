var Form = {};

Form.switch = function($switch) {
    $input = $switch.children('input');

    if($input.is(":checked")) {
        if ($switch.hasClass('edit-mode')) {
            Form.enableEditMode();
        }
    } else {
        if ($switch.hasClass('edit-mode')) {
            Form.disableEditMode();
        }
    }
}

Form.enableEditMode = function() {
    $('.edit-mode.item').removeClass('hidden');
}

Form.disableEditMode = function() {
    $('.edit-mode.item').addClass('hidden');
}

Form.dropdown = function(event, $element) {
    event.preventDefault();
    event.stopPropagation(); // Prevent hide on $(window).click

    var $listInput = $element.siblings('ul.js-dropdown');
    if ($listInput.is(':visible')) {
        $listInput.removeClass('show');
        $listInput.addClass('hidden');
    } else {
        $listInput.removeClass('hidden');
        $listInput.addClass('show');
    }
    $listInput.children('li').show();
}

$(document).ready(function () {
    var cssFormPath = '.form form';

    $(window).click(function() {
        $(cssFormPath + ' .js-dropdown').removeClass('show');
        $(cssFormPath + ' .js-dropdown').addClass('hidden');
    });

    Form.switch($('.switch'));
    $('.switch input[type=checkbox]').change(function() {
        Form.switch($(this).parent());
    });

    $(cssFormPath + ' .js-dropdown li').click(function(event) {
        event.stopPropagation(); // Prevent hide on $(window).click
    });

    $(cssFormPath + ' .text-input').on('keyup', function() {
        var $listInput = $(this).siblings('.js-dropdown');

        if (!$.trim($(this).val())) {
            $listInput.addClass('hidden');
            $listInput.removeClass('show');
        } else {
            $listInput.removeClass('hidden');
            $listInput.addClass('show');

            var value = $(this).val().toLowerCase();
            $listInput.children('li').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        }
    });

    $(cssFormPath + ' .js-dropdown li').click(function() {
        var $listInput = $(this).parent();
        var $textInput = $listInput.siblings('.text-input');

        $textInput.val($(this).text());
        $listInput.removeClass('show');
        $listInput.addClass('hidden');
    });

    $(cssFormPath + ' button.arrow-down').click(function(event) {
        Form.dropdown(event, $(this));
    });
});
