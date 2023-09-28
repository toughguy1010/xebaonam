<div class="detail-top">
    <div id="demo">
        <div class="container">
            <div id="sync1" class="owl-carousel">

                <!--ITEM 1 DỰ TOÁN CHI PHÍ-->
                <div class="item">
                    <div>
                        <div style="margin: 10px; overflow: hidden;">
                            <div class="row">
                                <div class="col-xs-5" style="padding-top:80px; text-align: right">
                                    <div class="carname modernHBold "><?php echo $car['name'] ?></div>
                                    <div class="slogan modernHEcoLight "><?php echo $car['slogan'] ?></div>
                                    <div class="summary"><?php echo $car['sortdesc']; ?></div>
                                    <div class="item-productprice">
                                        <a href="<?php echo Yii::app()->createUrl('car/buycar/calculateCost', array('cid' => $car['id'])); ?>" class="btn btn-detail-product">
                                            Dự toán chi phí
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xs-7" style="padding-top:80px">
                                    <img class="htccar img-responsive" src="<?php echo ClaHost::getImageHost(), $car['avatar_path'], 's700_0/', $car['avatar_name']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--END ITEM 1 DỰ TOÁN CHI PHÍ-->

                <!--ITEM 2 CẢM NHẬN 360-->
                <?php if (count($options_exterior) || count($options_interior)) { ?>
                    <div class="item">
                        <div>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $("img.advancedPanorama").panorama({views_number: 36, views_columns: 20});
                                });
                            </script>
                            <style>
                                .experience_panoramabox{
                                    margin-top:50px;
                                    width: 640px;
                                    float: left;
                                }
                                .experience_option{
                                    float: left;
                                    margin: 50px 0 0 50px;
                                }
                            </style>	
                            <div style="margin: 10px; overflow: hidden; ">
                                <div class="bs-example bs-example-tabs xoay360" data-example-id="togglable-tabs">
                                    <ul id="panoramaTabs" class="nav nav-tabs" role="tablist">
                                        <?php if (count($options_exterior)) { ?>
                                            <li role="presentation" class="active"><a href="#ngoai-that-360" id="ngoai-that-360-tab" role="tab" data-toggle="tab" aria-controls="ngoai-that-360" aria-expanded="true" class="exterior"><?php echo Yii::t('car', 'exterior'); ?></a></li>
                                        <?php } ?>
                                        <?php if (count($options_interior)) { ?>
                                            <li role="presentation"><a href="#noi-that-360" role="tab" id="noi-that-360-tab" data-toggle="tab" aria-controls="noi-that-360" class="interior"><?php echo Yii::t('car', 'interior'); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                    <div id="myTabContentPanorama" class="tab-content">
                                        <?php if (count($options_exterior)) { ?>
                                            <div role="tabpanel" class="tab-pane fade in active" id="ngoai-that-360" aria-labelledby="ngoai-that-360-tab">
                                                <div class="experience_panoramabox">
                                                    <img src="<?php echo $options_exterior[0]['default']['path'] ?>" class="panorama" width="640" height="289"  />	
                                                </div>
                                                <div class="experience_option">
                                                    <p class="color_view">
                                                        <img src="<?php echo $options_exterior[0]['path'] ?>">&nbsp;<?php echo $options_exterior[0]['name'] ?>
                                                    </p>
                                                    <ul style="width: 92px;">
                                                        <?php foreach ($options_exterior as $option_exterior) { ?>
                                                            <li class="option_color">
                                                                <a code="<?php echo $option_exterior['default']['path'] ?>" href="javascript:void(0)" title="<?php echo $option_exterior['name'] ?>" class="">
                                                                    <img alt="<?php echo $option_exterior['name'] ?>" src="<?php echo $option_exterior['path'] ?>">
                                                                </a>
                                                                <span style="display: none;">
                                                                    <img src="<?php echo Yii::app()->theme->baseUrl ?>/css/img/cover_color.png">
                                                                </span>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if (count($options_interior)) { ?>
                                            <div role="tabpanel" class="tab-pane fade" id="noi-that-360" aria-labelledby="noi-that-360-tab">
                                                <div class="experience_panoramabox">
                                                    <img src="<?php echo $options_interior[0]['default']['path'] ?>" class="panorama" width="640" height="289" />	
                                                </div>
                                                <div class="experience_option">
                                                    <p class="color_view">
                                                        <img src="<?php echo $options_interior[0]['path'] ?>">&nbsp;<?php echo $options_interior[0]['name'] ?>
                                                    </p>
                                                    <ul style="width: 92px;">
                                                        <?php foreach ($options_interior as $option_interior) { ?>
                                                            <li class="option_color">
                                                                <a code="<?php echo $option_interior['default']['path'] ?>" href="javascript:void(0)" title="<?php echo $option_interior['name'] ?>" class="">
                                                                    <img alt="<?php echo $option_interior['name'] ?>" src="<?php echo $option_interior['path'] ?>">
                                                                </a>
                                                                <span style="display: none;">
                                                                    <img src="<?php echo Yii::app()->theme->baseUrl ?>/css/img/cover_color.png">
                                                                </span>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript">

                        $(function () {
                            $("#panoramaTabs a").click(function () {
                                if ($(this).attr("class") == '<?php echo ActiveRecord::OPTION_EXTERIOR ?>') {
                                    exteriorInit();
                                } else {
                                    interiorInit();
                                }
                            });
                            $("#panoramaTabs a:first").click();
                            //                        $("#ngoai-that-360 .experience_panoramabox img.panorama").one("load", function () {
                            $("#ngoai-that-360 .experience_panoramabox img.panorama").panorama({views_number: 36, views_columns: 36});
                            //                        });
                            //                        $("#noi-that-360 .experience_panoramabox img.panorama").one("load", function () {
                            $("#noi-that-360 .experience_panoramabox img.panorama").panorama({views_number: 120, views_columns: 20});
                            $("#noi-that-360 .pano_loading_start img").attr("src", "./css/images/btn_start2.png")
                            //                        });
                        });

                        function exteriorInit() {
                            $("#ngoai-that-360 .experience_option li a").click(function () {
                                $("#ngoai-that-360 .experience_option p").empty();
                                $("#ngoai-that-360 .experience_option li a").removeClass("on");
                                $("#ngoai-that-360 .experience_option li span").hide();
                                // 360 PANORAMA
                                $("#ngoai-that-360 .experience_panoramabox").empty();

                                var src = $(this).attr('code');

                                $("#ngoai-that-360 .experience_panoramabox").append("<img class='panorama' width='640' height='289' src='" + src + "' />");

                                $("#ngoai-that-360 .experience_panoramabox img.panorama").one("load", function () {
                                    $(this).panorama({views_number: 36, views_columns: 36});
                                });
                                $("#ngoai-that-360 .experience_option p").html("<img src='" + $("img", $(this)).attr("src") + "'/>&nbsp;" + $(this).attr("title"));
                            });
                        }

                        function interiorInit() {
                            $("#noi-that-360 .experience_option li a").click(function () {
                                $("#noi-that-360 .experience_option p").empty();
                                $("#noi-that-360 .experience_option li a").removeClass("on");
                                $("#noi-that-360 .experience_option li span").hide();
                                // 360 PANORAMA
                                $("#noi-that-360 .experience_panoramabox").empty();

                                var src = $(this).attr('code');

                                $("#noi-that-360 .experience_panoramabox").append("<img class='panorama' width='640' height='289' src='" + src + "' />");

                                $("#noi-that-360 .experience_panoramabox img.panorama").one("load", function () {
                                    $(this).panorama({views_number: 120, views_columns: 20});
                                    $("#noi-that-360 .pano_loading_start img").attr("src", "./css/images/btn_start2.png")
                                });
                                $("#noi-that-360 .experience_option p").html("<img src='" + $("img", $(this)).attr("src") + "'/>&nbsp;" + $(this).attr("title"));
                            });
                        }
                    </script>
                <?php } ?>
                <!--END ITEM 2 CẢM NHẬN 360-->

                <!--ITEM 3 HÌNH ẢNH-->
                <div class="item">
                    <div>
                        <div style="margin: 10px; overflow: hidden; ">
                            <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
                                <ul id="myTabs" class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#tong-quan" role="tab" id="tong-quan-tab" data-toggle="tab" aria-controls="tong-quan" aria-expanded="true"><?php echo Yii::t('car', 'overview') ?></a></li>
                                    <li role="presentation" class=""><a href="#noi-that" id="noi-that-tab" role="tab" data-toggle="tab" aria-controls="noi-that" aria-expanded="false"><?php echo Yii::t('car', 'interior') ?></a></li>
                                    <li role="presentation" class=""><a href="#ngoai-that" id="ngoai-that-tab" role="tab" data-toggle="tab" aria-controls="ngoai-that" aria-expanded="false"><?php echo Yii::t('car', 'exterior') ?></a></li>
                                    <li role="presentation" class=""><a href="#an-toan-van-hanh" id="an-toan-van-hanh-tab" role="tab" data-toggle="tab" aria-controls="an-toan-van-hanh" aria-expanded="false"><?php echo Yii::t('car', 'car_image_safety') ?></a></li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <?php
                                    $images = $model->getImages();
                                    if (count($images)) {
                                        ?>
                                        <div role="tabpanel" class="tab-pane fade active in" id="tong-quan" aria-labelledby="tong-quan-tab">
                                            <div class="row">
                                                <?php
                                                $tq = 0;
                                                foreach ($images as $image) {
                                                    if ($image['type'] == 1) {
                                                        $tq++;
                                                        ?>
                                                        <div style="display: <?php echo ($tq <= 7) ? 'block' : 'none' ?>" class="wrap-item-img col-xs-6 col-sm-3" index="<?php echo $tq ?>">
                                                            <div class="box-img">
                                                                <a href="#" title="#">
                                                                    <img src="<?php echo Images::getAbsoluteLink($image); ?>" alt="#" title="#">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <?php
                                                if ($tq > 7) {
                                                    $page_size = 7;
                                                    $pagestq = ceil($tq / $page_size);
                                                    ?>
                                                    <div class="pagging col-xs-6 col-sm-3">
                                                        <?php for ($i = 1; $i <= $pagestq; $i++) { ?>
                                                            <a class="btn btn-primary" href="javascript:cubeGalleryCustomiz('<?php echo $i ?>','#tong-quan')"><?php echo $i ?></a>
                                                        <?php } ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="noi-that" aria-labelledby="noi-that-tab">
                                            <div class="row">
                                                <?php
                                                $nt = 0;
                                                foreach ($images as $image) {
                                                    if ($image['type'] == 2) {
                                                        $nt++;
                                                        ?>
                                                        <div style="display: <?php echo ($nt <= 7) ? 'block' : 'none' ?>" class="wrap-item-img col-xs-6 col-sm-3" index="<?php echo $nt ?>">
                                                            <div class="box-img">
                                                                <a href="#" title="#">
                                                                    <img src="<?php echo Images::getAbsoluteLink($image); ?>" alt="#" title="#">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <?php
                                                if ($nt > 7) {
                                                    $page_size = 7;
                                                    $pagesnt = ceil($nt / $page_size);
                                                    ?>
                                                    <div class="pagging col-xs-6 col-sm-3">
                                                        <?php for ($i = 1; $i <= $pagesnt; $i++) { ?>
                                                            <a class="btn btn-primary" href="javascript:cubeGalleryCustomiz('<?php echo $i ?>','#noi-that')"><?php echo $i ?></a>
                                                        <?php } ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="ngoai-that" aria-labelledby="ngoai-that-tab">
                                            <div class="row">
                                                <?php
                                                $ngt = 0;
                                                foreach ($images as $image) {
                                                    if ($image['type'] == 3) {
                                                        $ngt++;
                                                        ?>
                                                        <div style="display: <?php echo ($ngt <= 7) ? 'block' : 'none' ?>" class="wrap-item-img col-xs-6 col-sm-3" index="<?php echo $ngt ?>">
                                                            <div class="box-img">
                                                                <a href="#" title="#">
                                                                    <img src="<?php echo Images::getAbsoluteLink($image); ?>" alt="#" title="#">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <?php
                                                if ($ngt > 7) {
                                                    $page_size = 7;
                                                    $pagesngt = ceil($ngt / $page_size);
                                                    ?>
                                                    <div class="pagging col-xs-6 col-sm-3">
                                                        <?php for ($i = 1; $i <= $pagesngt; $i++) { ?>
                                                            <a class="btn btn-primary" href="javascript:cubeGalleryCustomiz('<?php echo $i ?>','#ngoai-that')"><?php echo $i ?></a>
                                                        <?php } ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="an-toan-van-hanh" aria-labelledby="an-toan-van-hanh-tab">
                                            <div class="row">
                                                <?php
                                                $atvh = 0;
                                                foreach ($images as $image) {
                                                    if ($image['type'] == 4) {
                                                        $atvh++;
                                                        ?>
                                                        <div style="display: <?php echo ($atvh <= 7) ? 'block' : 'none' ?>" class="wrap-item-img col-xs-6 col-sm-3" index="<?php echo $atvh ?>">
                                                            <div class="box-img">
                                                                <a href="#" title="#">
                                                                    <img src="<?php echo Images::getAbsoluteLink($image); ?>" alt="#" title="#">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <?php
                                                if ($atvh > 7) {
                                                    $page_size = 7;
                                                    $pagesatvh = ceil($atvh / $page_size);
                                                    ?>
                                                    <div class="pagging col-xs-6 col-sm-3">
                                                        <?php for ($i = 1; $i <= $pagesatvh; $i++) { ?>
                                                            <a class="btn btn-primary" href="javascript:cubeGalleryCustomiz('<?php echo $i ?>','#an-toan-van-hanh')"><?php echo $i ?></a>
                                                        <?php } ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--END ITEM 3 HÌNH ẢNH-->

                <!--ITEM 4 THÔNG SỐ XE-->
                <div class="item">
                    <div>
                        <div style="margin: 10px; overflow: hidden;  ">
                            <div id="divSpecification" class="item item-slide active" style="">
                                <div class="row" style="margin:0 0 70px 0; max-width:11140px; ">
                                    <div class="col-lg-12">
                                        <div class="specification">
                                            <p><style type="text/css">
                                                .auto-style1
                                                {
                                                    height: 24px;
                                                }
                                            </style></p>
                                            <div class="spec_table" style="border-top:1px solid #ccc;">
                                                <?php echo $model->attribute ?>
                                            </div>
                                            <p>&nbsp;</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--END ITEM 4 THÔNG SỐ XE-->

                <!--ITEM 5 VIDEO-->
                <div class="item">
                    <div class="video" style="margin:68px auto 0;width:700px"><iframe width="700" height="389" src="<?php echo $car['video_link'] ?>" frameborder="0" allowfullscreen=""></iframe></div>
                </div>
                <!--END ITEM 5 VIDEO-->

                <!--ITEM 6 DANH GIA XE-->
                <!--                <div class="item">
                                    <div>
                                        <div style="margin: 10px; overflow: hidden;  ">
                                            <div class="judge">
                                                <ul>
                                                    <li>
                                                        <div class="registered-action">
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm-dg1">
                                                                <div class="box-info">
                                                                    <div class="box-title">
                                                                        <h4>Hyundai Tucson 2010: Không nên bỏ qua khi tìm xe có mức giá 950 triệu</h4>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="registered-action">
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm-dg2">
                                                                <div class="box-info">
                                                                    <div class="box-title">
                                                                        <h4>Hyundai Tucson 2010: Không nên bỏ qua khi tìm xe có mức giá 950 triệu</h4>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="registered-action">
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm-dg3">
                
                
                                                                <div class="box-info">
                                                                    <div class="box-title">
                                                                        <h4>Hyundai Tucson 2010: Không nên bỏ qua khi tìm xe có mức giá 950 triệu</h4>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                <!--END ITEM 6 DANH GIA XE-->
            </div>
            <div id="sync2" class="owl-carousel">
                <div class="item"><img src="<?php echo Yii::app()->theme->baseUrl ?>/css/img/dutinh.png"><br><span>Dự toán chi phí</span></div>
                <?php if (count($options_exterior) || count($options_interior)) { ?>
                    <div class="item"><img src="<?php echo Yii::app()->theme->baseUrl ?>/css/img/360.png"><br><span>Cảm nhận 360</span></div>
                <?php } ?>
                <div class="item"><img src="<?php echo Yii::app()->theme->baseUrl ?>/css/img/affix-gallery.png"><br><span>Hình ảnh</span></div>
                <div class="item"><img src="<?php echo Yii::app()->theme->baseUrl ?>/css/img/affix-spec.png"><br><span>Thông số xe</span></div>
                <div class="item"><img src="<?php echo Yii::app()->theme->baseUrl ?>/css/img/affix-video.png"><br><span>Phim 30s</span></div>
                <!--<div class="item"><img src="<?php echo Yii::app()->theme->baseUrl ?>/css/img/affix-review.png"><br><span>Đánh giá xe</span></div>-->
            </div>
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="detail-cont">
    <div class="nav-detail-cont">
        <div class="container">
            <ul class="clearfix">
                <li><a href="<?php echo Yii::app()->request->requestUri ?>#slide_content01">Nổi bật</a></li>
                <li><a href="<?php echo Yii::app()->request->requestUri ?>#slide_content02">Ngoại thất</a></li>
                <li><a href="<?php echo Yii::app()->request->requestUri ?>#slide_content03">Nội thất</a></li>
                <li><a href="<?php echo Yii::app()->request->requestUri ?>#slide_content04">Vận hành</a></li>
                <li><a href="<?php echo Yii::app()->request->requestUri ?>#slide_content05">An toàn</a></li>
                <li><a href="<?php echo Yii::app()->request->requestUri ?>#slide_content06">Tiện nghi</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row no-margin properties-content">
            <div class="col-lg-12 no-padding">
                <?php
                echo $model->description;
                ?> 
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var offset = $('.detail-cont').offset();
        var height_doc = offset.top + 540;
        $(window).scroll(function () {
            var scroll_top = $(document).scrollTop();
            if (scroll_top > height_doc) {
                $('.detail-cont .nav-detail-cont').css('position', 'fixed');
                $('.detail-cont .nav-detail-cont').css('top', '0px');
                $('.detail-cont .nav-detail-cont').css('margin', '0px');
                $('.detail-cont .nav-detail-cont').css('z-index', '99');
                $('.detail-cont .nav-detail-cont').css('width', '100%');
            } else {
                $('.detail-cont .nav-detail-cont').css('position', 'static');
            }
        });
    });
</script>
<script type="text/javascript">
    var page_size = 7;
    function cubeGalleryCustomiz(page_index, group_cat) {
        var start_flag_hide = (page_index - 1) * page_size;
        var end_flag_hide = page_index * page_size;
        $(group_cat).find('.row .wrap-item-img').each(function (index, value) {
            if ($(this).attr('index') > start_flag_hide && $(this).attr('index') <= end_flag_hide) {
                $(this).css('display', 'block');
            } else {
                $(this).css('display', 'none');
            }
        });
    }
</script>
<script>
    $(document).ready(function () {

        var sync1 = $("#sync1");
        var sync2 = $("#sync2");

        sync1.owlCarousel({
            singleItem: true,
            slideSpeed: 1000,
            navigation: true,
            pagination: false,
            afterAction: syncPosition,
            responsiveRefreshRate: 200,
        });

        sync2.owlCarousel({
            items: 15,
            itemsDesktop: [1199, 10],
            itemsDesktopSmall: [979, 10],
            itemsTablet: [768, 8],
            itemsMobile: [479, 4],
            pagination: false,
            responsiveRefreshRate: 100,
            afterInit: function (el) {
                el.find(".owl-item").eq(0).addClass("synced");
            }
        });

        function syncPosition(el) {
            var current = this.currentItem;
            $("#sync2")
                    .find(".owl-item")
                    .removeClass("synced")
                    .eq(current)
                    .addClass("synced")
            if ($("#sync2").data("owlCarousel") !== undefined) {
                center(current)
            }

        }

        $("#sync2").on("click", ".owl-item", function (e) {
            e.preventDefault();
            var number = $(this).data("owlItem");
            sync1.trigger("owl.goTo", number);
        });

        function center(number) {
            var sync2visible = sync2.data("owlCarousel").owl.visibleItems;

            var num = number;
            var found = false;
            for (var i in sync2visible) {
                if (num === sync2visible[i]) {
                    var found = true;
                }
            }

            if (found === false) {
                if (num > sync2visible[sync2visible.length - 1]) {
                    sync2.trigger("owl.goTo", num - sync2visible.length + 2)
                } else {
                    if (num - 1 === -1) {
                        num = 0;
                    }
                    sync2.trigger("owl.goTo", num);
                }
            } else if (num === sync2visible[sync2visible.length - 1]) {
                sync2.trigger("owl.goTo", sync2visible[1])
            } else if (num === sync2visible[0]) {
                sync2.trigger("owl.goTo", num - 1)
            }
        }

    });
</script>