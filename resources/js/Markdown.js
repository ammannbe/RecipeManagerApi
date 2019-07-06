Markdown = {
    _stackedit: new Stackedit(),
    $_editor: null,
};

Markdown.init = function() {
    Markdown.$_editor = $('textarea.markdown-editor')[0];
    Markdown.startEventListener();
}

Markdown.startEventListener = function() {
    // Listen to StackEdit events and apply the changes to the textarea.
    Markdown._stackedit.on('fileChange', (file) => {
        Markdown.$_editor.value = file.content.text;
    });

    Markdown._stackedit.on('close', () => {
        $('html').removeClass('stackedit-no-overflow');
    })

    $(Markdown.$_editor).focus(function(e) {
        Markdown.openEditor(Markdown.$_editor.value);
    });
}

Markdown.openEditor = function(content) {
    // Open the iframe
    $('html').addClass('stackedit-no-overflow');
    Markdown._stackedit.openFile({
      content: {
        text: content // the Markdown content.
      }
    });
}
