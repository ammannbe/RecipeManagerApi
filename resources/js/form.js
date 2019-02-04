$(document).ready(function () {
    var cssFormPath = 'html body section.content.recipe.form form';

    //TODO: remove this block
    $(cssFormPath + ' .info-text').click(function() {
        if (! $(cssFormPath + ' .info-text a i.reload').length) {
            $(this).append('<a href="#" onclick="location.reload()">Liste neu laden<i class="reload"></i></a>');
        }
    });

    $(window).click(function() {
        $(cssFormPath + ' .list-input').hide();
    });

    $(cssFormPath + ' ul.list-input li').click(function(event) {
        event.stopPropagation(); // Prevent hide on $(window).click
    });

    $(cssFormPath + ' .text-input').on('keyup', function() {
        var $listInput = $(this).siblings('.list-input');

        if (!$.trim($(this).val())) {
            $listInput.hide();
        } else {
            $listInput.show();
            var value = $(this).val().toLowerCase();
            $listInput.children('li').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        }
    });

    $(cssFormPath + ' ul.list-input li').click(function() {
        var $listInput = $(this).parent();
        var $textInput = $listInput.siblings('.text-input');

        $textInput.val($(this).text());
        $listInput.hide();
    });

    $(cssFormPath + ' i.arrow-down').click(function(event) {
        event.stopPropagation(); // Prevent hide on $(window).click
        var $listInput = $(this).siblings('ul.list-input');
        $listInput.toggle();
        $listInput.children('li').show();
    });

});
