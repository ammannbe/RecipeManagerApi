$(document).ready(function () {
    $('a#add').click(function() { 
        $('nav.top.second').toggle('slow', function() {
            var display = $(this).css('display');
            if (display == 'none') {
                $('a#add').html('<i class="plus-sign"></i> Hinzufügen');
            } else {
                $('a#add').html('<i class="minus-sign"></i> Hinzufügen');
            }
        });
    });
});