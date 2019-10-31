Markdown = {
    _stackedit: new Stackedit(),
    $_editor: null,
    $_recipeInstructions: null,
};

Markdown.init = function () {
    Markdown.$_editor = $('textarea.markdown-editor');
    Markdown.$_recipeInstructions = $('section.content.recipe article.instructions p');
    Markdown.startEventListener();
    Markdown.convertToHtml();
}

Markdown.startEventListener = function () {
    // Listen to StackEdit events and apply the changes to the textarea or recipe instructions.
    Markdown._stackedit.on('fileChange', (file) => {
        if (Markdown.$_editor.length) {
            // Editing a recipe and show the plaintext
            Markdown.$_editor[0].value = file.content.text;
        } else if (Markdown.$_recipeInstructions.length) {
            // Show the HTML of the instructions
            Markdown.$_recipeInstructions.html(file.content.html);
        }
    });

    Markdown._stackedit.on('close', () => {
        $('html').removeClass('stackedit-no-overflow');
    })

    $(Markdown.$_editor[0]).focus(function (e) {
        Markdown.openEditor(Markdown.$_editor[0].value);
    });
}

Markdown.openEditor = function (content) {
    // Open the iframe
    $('html').addClass('stackedit-no-overflow');
    Markdown._stackedit.openFile({
        content: {
            text: content // the Markdown content.
        }
    });
}

Markdown.convertToHtml = function () {
    if (!Markdown.$_recipeInstructions.length) {
        return false;
    }
    var text = Markdown.$_recipeInstructions.text().trim();
    Markdown._stackedit.openFile({
        content: { text: text }
    }, true /* silent mode */);
}
