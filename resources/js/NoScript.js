var NoScript = {};

NoScript.remove = function() {
    NoScript.$_item.remove();
}

$(document).ready(function () {
    NoScript.$_item = $('.noscript');
    NoScript.remove();
});
