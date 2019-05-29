Search = {};

Search.init = function() {
    if ($("#term").length && autocompleteData) {
        var array = [];
        $.each(autocompleteData, function (index, value) {
            $.each(value, function (i, v) {
                array.push(v);
            });
        });

        $("#term").autocomplete({
            source: array
        });
    }
}
