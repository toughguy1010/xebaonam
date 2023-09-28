$('#prepaid').click(function () {
    $('#listpercent').toggle();
    $('body').toggleClass('fixscroll');
})

$('.infopopup .close').click(function () {
    $('#listpercent').hide();
    $('body').removeClass('fixscroll');
})

$('.gop').click(function () {
    $(this).remove();
    $('.infodetail').show();
})

$('.km').click(function () {
    $(this).parent().find('.boxShowKM').toggle(300);
})

$('.listmonths li').click(function () {
    $('.listmonths li').removeClass('actived');
    $(this).addClass('actived');
})

$('.infolist li.ac').click(function () {
    $('.table li .infodetail').addClass('hide');
    $('.infolist li').removeClass('actived');
    $(this).addClass('actived');
})

$('.bhkv').click(function () {
    $(this).attr('data-bh', ($(this).attr('data-bh') == 0) ? 1 : 0);
})

function ResetBoxCalculate() {
    $("#boxresult-" + $("#hdbankcode").val()).find("#div-result .alepay-item").html("");
    $("#boxresult-" + $("#hdbankcode").val()).hide();
    $(".infocard " + $("#hdbankcode").val()).hide()
}

function ChooseBankSetCardType(n) {
    if (n !== undefined) {
        $("#err-general").html("").hide();
        $("#listbank a").removeClass("acti");
        $("#cardtype a").removeClass("acti");
        ResetBoxCalculate();
        $("#hdcardtype").val("");
        $("#hdbankcode").val("");
        $("#alepay-err").html("");
        $("#hdmonth").val("");
        $("#btncomplete").hide();
        $(".note-tos").hide();
        $(n).addClass("acti");
        $('.step_2').show();
        $('#boxresult-bank').html('');
        $(".bankCode_").val($(n).data("code"));
        $("#hdbankname").val($(n).data("name"));
        var t = $(n).data("card");
        t !== undefined && t !== "" && (t.indexOf("VISA") > -1 ? $("#VISA").show() : $("#VISA").hide(), t.indexOf("MASTERCARD") > -1 ? $("#MASTERCARD").show() : $("#MASTERCARD").hide(), t.indexOf("JCB") > -1 ? $("#JCB").show() : $("#JCB").hide(), setTimeout(function () {
            $("#cardtype a:visible").length === 1 && ($("#step2").html("Bước 2: Chọn loại thẻ"))
        }, 1e3))
    }
}

function ChooseAlepayPackage(item) {
    var n = $(item).data('month');
    $('.month_').val(n);
    if ($("#alepay-err").show(), $("#boxresult-bank aside a").removeClass("choosed").html("Chọn mua"), typeof n === undefined || n === "" || n === "-1") $("#alepay-err").html("Quý khách vui lòng chọn số tháng trả góp");
    else {
        $('.info_fee.total').val($(item).data('total'));
        $('.info_fee.every_month').val($(item).data('feemonth'));
        $('.info_fee.difference').val($(item).data('difference'));
        $('.info_fee.fee').val($(item).data('fee'));
        $(".showtimeship_address").hide();
        $("#alepay-err").hide();
        $("#boxresult-bank aside a[data-month='" + n + "']").addClass("choosed").html("Đang chọn");
        $("#hdmonth").val(n);
        $(".rechoose-month").css("display", "inline").html("Chọn lại");
        $(".alepay-item").not($("#alepay-item-" + n)).addClass("none");
        $(".alepay-item#alepay-item-" + n).removeClass("none");
        setTimeout(function () {
            $('#alepay-item-' + n).addClass("onecol");
        }, 1e3);
        $(".prepaidcolor").show();
        $("#div-info").show();
        $(".note-tos").show();
    }
}

function ReChooseMonth() {
    $('.month_').val("");
    $(".alepay-item").removeClass("none");
    $(".rechoose-month").hide();
    $('.info_fee').val("");
    $(".cart-btt").removeClass("choosed").html("Chọn mua");
    $('.alepay-item').removeClass("onecol");
    $(".list-prepaid").slideUp()
}

$(".supermarket label").click(function () {
    var show = $(this).attr('data-show');
    $('.citydis select').val(0);
    if (show == 1) {
        $('.sieuthi .shop').html('<input type="hidden" value="" name="InstallmentOrder[shop_id]">');
        $('.address').val('N/A');
        $('.inshop').hide();
    } else {
        $('.address').val('');
        $('.inshop').show();
        $('.sieuthi .shop').html('<input type="hidden" value="N/A" name="InstallmentOrder[shop_id]">');
    }
});

function addCardInstallment() {
    var month = $('.month_').val();
    var bank = $('.list_bank_ a.acti').attr('data-code');
    var card = $('.listcard a.acti').attr('data-code');
    var name = $('#InstallmentOrder_username').val();
    var phone = $('#InstallmentOrder_phone').val();
    var province = $('#InstallmentOrder_province_id').val();
    var district = $('#InstallmentOrder_district_id').val();
    var address = $('#InstallmentOrder_address').val();
    var shop = $('.shop input').val();
    if (!month) {
        alert('Bạn phải chọn số tháng trả góp.');
        return false;
    }
    if (!bank) {
        alert('Bạn phải chọn ngân hàng trả góp.');
        return false;
    }
    if (!card) {
        alert('Bạn phải chọn loại thẻ.');
        return false;
    }
    if (!name) {
        alert('Bạn phải nhập tên.');
        return false;
    }
    if (!phone) {
        alert('Bạn phải nhập số điện thoại.');
        return false;
    }
    if (!province) {
        alert('Bạn phải chọn tỉnh/thành phố.');
        return false;
    }
    if (!district) {
        alert('Bạn phải chọn quận/huyện.');
        return false;
    }
    if (!address) {
        alert('Bạn phải nhập số nhà,tên đường.');
        return false;
    }
    if (!shop) {
        alert('Bạn cần chọn chi nhánh nhận hàng.');
        return false;
    }
    $('.formorder').submit();
    return false;
}
