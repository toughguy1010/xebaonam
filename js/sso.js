(function ($) {
//    if (typeof brokerGetAttach === 'undefined' || !brokerGetAttach) {
//        var brokerGetAttach = "";
//    }
//    if (typeof currentUrl === 'undefined' || !currentUrl) {
//        var currentUrl = '';
//    }
    //
    jQuery.ajax({
        url: brokerGetAttach,
        type: 'POST',
        dataType: 'json',
        success: function (res) {
            switch (res.code) {
                case 200:
                    {
                        if (res.link) {
                            window.location.href = res.link;
                        }
                    }
                    break;
                default:
                    {
                    }
                    break;
            }
        },
        error: function () {
            alert('567');
        }
    });
})(jQuery);
