
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

window.$ = window.jQuery = require('jquery');
import 'jquery-ui/ui/widgets/autocomplete.js';
import 'jquery-ui/themes/base/all.css';

window.Cookies = require('js-cookie');
window.Stackedit = require('stackedit-js');
require('./3rd-party/select2-4.0.1.min.js');
require('./Toast.js');
require('./Dropdown.js');
require('./EditMode.js');
require('./Markdown');
require('./Modal.js');
require('./Search.js');
require('./YieldAmountCalculator');
require('./ShareWidget.js');

import Delete from './Delete'
window.Delete = Delete;

$(document).ready(function () {
    const confirm = new Delete();
    confirm.register();

    EditMode.init();
    Markdown.init();
    Dropdown.init();
    Search.init();
    YieldAmountCalculator.init();
    ShareWidget.init();

    $('article.recipes button.show-more').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $(this).siblings('ul').children('li').removeClass('forced hidden');
        $(this).remove();
    });
});
