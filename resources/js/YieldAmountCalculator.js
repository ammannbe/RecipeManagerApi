YieldAmountCalculator = {};

YieldAmountCalculator.init = function() {
    $('input[name=yield_amount]').keyup(function(event) {
        var multiplier = $(this).val();

        if (! multiplier || multiplier <= 0) {
            return;
        }

        $('span[data-amount]').each(function() {
            var amount = $(this).data('amount');
            var multiplied = Math.round(amount * multiplier);
            if (amount) {
                var currentAmount = $(this).data('current-amount');
                $(this).text($(this).text().replace(currentAmount, multiplied));
                $(this).data('current-amount', multiplied);
            }
        });
    });
}
