$(document).ready(function() {
    $('nav.top .dropdown a').click(function(e) {
        disableDefault(e);
        $('nav.right').toggle();
    });
});
