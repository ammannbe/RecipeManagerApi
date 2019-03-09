
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./NoScript.js');

require('./Toast.js');
require('./Dropdown.js');
require('./Delete.js');
require('./EditMode.js');


disableDefault = function(event) {
    event.preventDefault();
    event.stopPropagation();
}

$(document).ready(function () {
    $('article.recipes button.show-more').click(function(e) {
        disableDefault(e);

        $(this).siblings('ul').children('li').removeClass('forced hidden');
        $(this).remove();
    });
});
