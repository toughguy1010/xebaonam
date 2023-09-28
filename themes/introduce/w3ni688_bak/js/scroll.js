//hatv hatv1592@gmail.com
$(document).ready(function () {
    var banner_height = $('#header').height();
    var banner = $('#main .detail-title').height();
//    pos
    var pos_album = $("#album").position().top;
    var height_album = $("#album").height();
    var pos_slider = $("#slider").position().top;
    var height_slider = $("#slider").height();
    var pos_comment = $("#comment").position().top;
    var height_comment = $("#comment").height();
    $("#comment").position().top;
    $("#comment").position().top;
    var scroll = $(window).scrollTop();
    if (scroll >= (banner + banner_height)) {
        $('.product-detail-info1').css("position", 'fixed').css("top", '0');
    } else {
        $('.product-detail-info1').css("position", 'absolute').css('top', banner_height + banner);
    }

    $(window).scroll(function (event) {
        var scroll = $(window).scrollTop();

        if (scroll >= (banner + banner_height)) {
            $('.product-detail-info1').css("position", 'fixed').css("top", '0');
        } else {
            $('.product-detail-info1').css("position", 'absolute').css('top', banner_height + banner);
        }
        if (scroll >= (pos_slider - 50) && scroll < (pos_slider + height_slider - 50)) {
            $('.product-detail-info1 ul li').removeClass('active');
            $(".product-detail-info1 ul li a[data-target*='slider']").parent().addClass('active');

        } else if (scroll >= (pos_album - 50) && scroll < (pos_album + height_album - 50)) {
            $('.product-detail-info1 ul li').removeClass('active');
            $(".product-detail-info1 ul li a[data-target*='album']").parent().addClass('active');
        } else if (scroll >= (pos_album + height_album - 50)) {
            $('.product-detail-info1 ul li').removeClass('active');
            $(".product-detail-info1 ul li a[data-target*='comment']").parent().addClass('active');
        } else {
            $('.product-detail-info1 ul li').removeClass('active');
        }
    });

    $(document).on('click', '.searchbychar', function (event) {
        event.preventDefault();
        var target = "#" + this.getAttribute('data-target');
        $('html, body').animate({
            scrollTop: $(target).offset().top
        }, 800);
    });

});

  