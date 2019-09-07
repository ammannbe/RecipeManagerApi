YieldAmountCalculator = {
    _baseMultiplier: null,
    _currentMultiplier: null,
};

YieldAmountCalculator.init = function () {
    if (!$('input[name=yield_amount]').length) {
        return;
    }

    YieldAmountCalculator._baseMultiplier = $('input[name=yield_amount]').val();

    $('input[name=yield_amount]').keyup(function (event) {
        YieldAmountCalculator._currentMultiplier = $(this).val()

        if (!YieldAmountCalculator.validateMultipliers()) {
            return;
        }

        $('span[data-amount]').each(function () {
            YieldAmountCalculator.calcAndSetAmount(this);
        });
    });
}

YieldAmountCalculator.validateMultipliers = function () {
    try {
        var multipliers = [];
        multipliers.push(YieldAmountCalculator._currentMultiplier);
        multipliers.push(YieldAmountCalculator._baseMultiplier);

        multipliers.forEach(multiplier => {
            if (!multiplier || multiplier <= 0) {
                throw false;
            }
        });
    } catch (error) {
        return false;
    }
    return true;
}

YieldAmountCalculator.calcAndSetAmount = function (el) {
    var amount = $(el).data('amount');
    var multiplied = (amount / YieldAmountCalculator._baseMultiplier * YieldAmountCalculator._currentMultiplier)
    multiplied = +(multiplied).toPrecision(2);

    if (amount) {
        var currentAmount = $(el).data('current-amount');
        $(el).text($(el).text().replace(currentAmount, multiplied));
        $(el).data('current-amount', multiplied);
    }
}
