<script type="text/javascript">
    //<![CDATA[

    var iExtCount = 9;
    var iIntCount = 3;
    var expRoot = './images/autos/1';
    var colorRoot = './images/autos/1/360';
    var path_Ext = 'ngoai_that';
    var path_Int = 'noi_that';
    var arrExt = [{Code: '4/es_1.png', NameVN: 'Đen', NameEN: '4/ex_Phantom_Black.png'}, {Code: '5/es_0.png', NameVN: 'Đỏ tươi', NameEN: '5/ex_Veloster_Red.png'}, {Code: '6/es_0.png', NameVN: 'Cam', NameEN: '6/ex_Vitamin_C.png'}, {Code: '7/es_0.png', NameVN: 'Vàng', NameEN: '7/ex_Sunflower.png'}, {Code: '8/es_0.png', NameVN: 'Xanh cốm', NameEN: '8/ex_Green_Apple.png'}, {Code: '9/es_0.png', NameVN: 'Bạc xám', NameEN: '9/ex_Sonic_Silver.png'}, {Code: '10/es_0.png', NameVN: 'Trắng', NameEN: '10/ex_White_Crystal.png'}, {Code: '11/es_0.png', NameVN: 'Bạc', NameEN: '11/ex_Sleek_Silver.png'}, {Code: '12/es_0.png', NameVN: 'Xanh nước biển', NameEN: '12/ex_Blue_Ocean.png'}];
    var arrInt = [{Code: '1/is_119.jpg', NameVN: 'Đen', NameEN: '1/i1.gif'}, {Code: '2/is_119.jpg', NameVN: 'Ghi', NameEN: '2/i2.gif'}, {Code: '3/is_119.jpg', NameVN: 'Đỏ', NameEN: '3/i3.gif'}];

    //]]>
</script>
<script>
    var carColor = "";
    $(function () {
        $(".experience_category a").click(function () {
            if ($(this).attr("class") != "on") {
                $(".experience_category a").removeClass("on");
                $(this).addClass("on");
                if ($(this).parent().attr("class") == "exterior")
                    exteriorInit();
                else
                    interiorInit();
            }
            return false;
        })
        $(".experience_category a:first").click();
    });
    var iCount = iIntCount;
    function interiorInit() {
        $(".experience_option p").empty();
        $(".experience_option ul").empty();
        for (i = 0; i < iCount; i++) {
            $(".experience_option ul").append("<li class=\"" + arrInt[i]["Code"] + "\"><a href=\"#\"><img alt=\"\" src=\"" + colorRoot + "/" + path_Int + "/" + arrInt[i]["NameEN"] + "\"></a></li>");
        }
        optionInit();
        $(".experience_option li a").click(function () {
            $(".experience_option li a").removeClass("on");
            $(".experience_option li span").hide();
            $(this).addClass("on");
            if ($("span", $(this).parent()).length == 0)
                $("<span><img src=\"./stylehnk/images/cover_color.png\" /></span>").appendTo($(this).parent());
            else
                $("span", $(this).parent()).show();
            carColor = $(this).parent().attr("class");
            $(".experience_panoramabox").empty();
            $(".experience_panoramabox").append("<img class='panorama' width='640' height='289' src='" + colorRoot + "/" + path_Int + "/" + carColor + "' />");
            $(".experience_panoramabox img.panorama").one("load", function () {
                $(this).panorama({views_number: 120, views_columns: 20});
                $(".pano_loading_start img").attr("src", "./stylehnk/images/btn_start2.png")
            });
            return false;
        });
        $(".experience_option li a:first").click();
    }
    var eCount = iExtCount;
    function exteriorInit() {
        $(".experience_option ul").empty();
        for (i = 0; i < eCount; i++) {
//$(".experience_option ul").append("<li class=\"e" + i + "\"><a href=\"#\"><img alt=\"\" src=\"" + carRoot + "/experience/e" + i + ".png\"></a></li>");
            $(".experience_option ul").append("<li class=\"e" + i + "\"><a code='" + arrExt[i]["Code"] + "' href=\"#\" title='" + arrExt[i]["NameVN"] + "'><img alt=\"\" src=\"" + colorRoot + "/" + path_Ext + "/" + arrExt[i]["NameEN"] + "\"></a></li>");
        }
        optionInit();
        $(".experience_option li a").click(function () {
            $(".experience_option li a").removeClass("on");
            $(".experience_option li span").hide();
            $(this).addClass("on");
            if ($("span", $(this).parent()).length == 0)
                $("<span><img src=\"./stylehnk/images/cover_color.png\" /></span>").appendTo($(this).parent());
            else
                $("span", $(this).parent()).show();
            carColor = $(this).attr("code");
            $(".experience_panoramabox").empty();
            $(".experience_panoramabox").append("<img class='panorama' width='640' height='289' src='" + colorRoot + "/" + path_Ext + "/" + carColor + "' />");
            $(".experience_panoramabox img.panorama").one("load", function () {
                $(this).panorama({views_number: 36, views_columns: 36});
            });
//
            $(".experience_option p").html("<img src='" + $("img", $(this)).attr("src") + "'/>&nbsp;" + $(this).attr("title"));
            return false;
        });
        $(".experience_option li a:first").click();
    }
    function optionInit() {
        var i = $(".experience_option ul li").length;
        if (i < 7)
            $(".experience_option ul").width(52);
        else if (i < 13)
            $(".experience_option ul").width(92);
    }
    function showPanoramaLargeLayer() {
        if ($("#layer_experience_panorama").length == 0)
            $("#wrap").append('<div id="layer_experience_panorama" class="layer_experience_panorama"></div>');
        else
            $("#layer_experience_panorama").empty();
        $("#layer_experience_panorama").append('<div class="layer_panorama_close"><a href="javascript:closeLayer();"><img alt="close" src="./stylehnk/images/btn_layer_close.png"></a></div>');
        $("#layer_experience_panorama").append('<div class="normal"><div class="box"></div></div>');
        $("#layer_experience_panorama").append('<div class="experience_category"><ul><li><a class="on" href="#">Ngoại thất</a></li><li><a href="javascript:cubeExterienceCustomiz();">Nội thất</a></li></ul></div>');
        $("#layer_experience_panorama").append('<div class="experience_desc"><span>The image may differ from the actual product.</span></div>');
        $("#layer_experience_panorama").height($(document).height()).width($(window).width()).fadeIn();
        $("#layer_experience_panorama .box").append("<img class='panorama_large' src='" + carRoot + carColor + "/b_0.png" + "' width='1024' height='462'/>");
        $("#layer_experience_panorama img.panorama_large").panorama({views_number: 36, views_columns: 36});
    }
    function closeLayer() {
        $('#layer_experience_panorama').fadeOut();
    }
</script> 
