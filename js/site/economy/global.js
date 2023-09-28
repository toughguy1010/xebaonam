/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
economy = {};
jQuery("#money_pay").keypress(function(e) {
        return economy.numberOnly(e);
    }).keyup(function(e) {
        var value = $(this).val();
        value = economy.ToNumber(value);
        $(this).val(economy.FormatNumber(value));
    });
economy.ToNumber = function(nStr) {
    if (nStr !== null && nStr !== NaN) {
        var rgx = /[đ₫\s,.]/;
        while (rgx.test(nStr)) {
            nStr = nStr.replace(rgx, '');
        }
        return eval(nStr) + 0;
    }
    return 0;

};
economy.FormatNumber = function(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    var value = x1 + x2;
    if (value === "NaN") {
        return 0;
    }
    return value;
};
economy.numberOnly = function(e){
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
}

