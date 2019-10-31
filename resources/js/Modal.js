Modal = {};
Modal.$_content;

$(document).ready(function () {
    Modal.$_container = $('#modal');
    Modal.$_content = $('#modal .content');
    Modal.$_title = $('#modal .title');
});

Modal.open = function (html, title = null) {
    Modal.$_content.html(html);
    Modal.$_container.show();
    if (title !== null) {
        Modal.$_title.text(title);
    }
}

Modal.close = function () {
    Modal.$_container.hide();
    Modal.$_content.html('');
}

Modal.photo = function (el) {
    var src = $(el).children('img').attr('src');
    var alt = $(el).children('img').attr('alt');
    var title = $('header h1').text().trim();
    Modal.open(`<div class="image"><img src="${src}" alt="${alt}" class="image"></div>`, title);
}
