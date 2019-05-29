
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

window.$ = window.jQuery = require('jquery');
import 'jquery-ui/ui/widgets/autocomplete.js';
import 'jquery-ui/themes/base/all.css';

window.Cookies = require('js-cookie');
require('./3rd-party/select2-4.0.1.min.js');
require('./Toast.js');
require('./Dropdown.js');
require('./Delete.js');
require('./EditMode.js');
require('./Modal.js');
require('./Search.js');


function disableDefault(event) {
    event.preventDefault();
    event.stopPropagation();
}

$(document).ready(function () {
    EditMode.init();
    Dropdown.init();
    Search.init();

    $('article.recipes button.show-more').click(function(e) {
        disableDefault(e);

        $(this).siblings('ul').children('li').removeClass('forced hidden');
        $(this).remove();
    });
});
