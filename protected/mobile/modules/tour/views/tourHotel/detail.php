<?php $themUrl = Yii::app()->theme->baseUrl; ?>
<script type="text/javascript" src="<?= $themUrl ?>/js/jssor.js"></script> 
<script type="text/javascript" src="<?= $themUrl ?>/js/jssor.slider.js"></script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/colorbox/jquery.colorbox-min.js');
?>
<div class="top-detail">
    <div class="header-top-detail">
        <div class="list-content-body">
            <h3 class="list-content-title"> <a href="javascript:void(0)" title="<?php echo $hotel['name'] ?>"><?php echo $hotel['name'] ?> </a> <span class="hotstar_large star_<?php echo $hotel['star'] ?>"></span></h3>
            <div class="adress-hotel">
                <p><span><?php echo Yii::t('common', 'address') ?>:</span> <?php echo implode(' - ', array($hotel['ward_name'], $hotel['district_name'], $hotel['province_name'])); ?></p>
                <!--<a href="#" title="#" class="search-map">Xem bản đồ</a></div>-->
                <div class="share-social">
                    <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_SOCIAL)); ?>
                </div>
            </div> 
        </div>
        <div class="cont-top-detail">
            <div class="box-img-hotel">
                <?php
                $images = $hotel->getImages();
                ?>
                <?php if ($images && count($images)) { ?>
                    <div id="slider2_container" style="position: relative; width: 790px; height: 444px; overflow: hidden;">
                        <!-- Slides Container -->
                        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 790px; height: 444px;
                             overflow: hidden;">
                             <?php foreach ($images as $img) { ?>
                                <div>
                                    <img u="image" src="<?php echo ClaHost::getImageHost() . $img['path'] . $img['name']; ?>">
                                    <img u="thumb" src="<?php echo ClaHost::getImageHost() . $img['path'] . 's100_100/' . $img['name']; ?>">
                                </div>
                            <?php } ?>
                        </div>
                        <div u="thumbnavigator" class="jssort07" style="width: 790px; height: 100px; left: 0px; bottom: 0px;">
                            <!-- Thumbnail Item Skin Begin -->
                            <div u="slides" style="cursor: default;">
                                <div u="prototype" class="p">
                                    <div u="thumbnailtemplate" class="i"></div>
                                    <div class="o"></div>
                                </div>
                            </div>
                            <span u="arrowleft" class="jssora11l" style="top: 123px; left: -15px;">
                            </span>
                            <!-- Arrow Right -->
                            <span u="arrowright" class="jssora11r" style="top: 123px; right: -15px;">
                            </span>
                            <!--#endregion Arrow Navigator Skin End -->
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function ($) {
        var options = {
            $AutoPlay: false, //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
            $AutoPlayInterval: 4000, //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
            $SlideDuration: 500, //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
            $DragOrientation: 3, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
            $UISearchMode: 0, //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).

            $ThumbnailNavigatorOptions: {
                $Class: $JssorThumbnailNavigator$, //[Required] Class to create thumbnail navigator instance
                $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always

                $Loop: 1, //[Optional] Enable loop(circular) of carousel or not, 0: stop, 1: loop, 2 rewind, default value is 1
                $SpacingX: 3, //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                $SpacingY: 3, //[Optional] Vertical space between each thumbnail in pixel, default value is 0
                $DisplayPieces: 7, //[Optional] Number of pieces to display, default value is 1
                $ParkingPosition: 253, //[Optional] The offset position to park thumbnail,

                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$, //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2, //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 6                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            }
        };

        var jssor_slider1 = new $JssorSlider$("slider2_container", options);

        //responsive code begin
        //you can remove responsive code if you don't want the slider scales while window resizes
        function ScaleSlider() {
            var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
            if (parentWidth)
                jssor_slider1.$ScaleWidth(Math.min(parentWidth, 790));
            else
                window.setTimeout(ScaleSlider, 30);
        }
        ScaleSlider();

        $(window).bind("load", ScaleSlider);
        $(window).bind("resize", ScaleSlider);
        $(window).bind("orientationchange", ScaleSlider);
        //responsive code end
    });
</script>
<form action="<?php echo Yii::app()->createUrl('tour/booking/bookingRoom'); ?>" id="form_booking_room" method="POST">
    <div class="detail-hotel clearfix">
        <div class="box-detail-hotel">
            <div class="title-hotel-detail policy-in">
                <p><?php echo Yii::t('tour_booking', 'choose_in_out_room') ?></p>
            </div>
            <div class="cont policy-in-cont clearfix">
                <div class="form-group col-xs-6"> 
                    <label for="exampleInputEmail1"><?php echo Yii::t('tour_booking', 'date_in') ?></label> 
                    <?php
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'TourBooking[checking_in]', //attribute name
                        'mode' => 'date', //use "time","date" or "datetime" (default)
                        'value' => ((int) $model->checking_in > 0 ) ? date('d-m-Y', (int) $model->checking_in) : date('d-m-Y'),
                        'language' => 'vi',
                        'options' => array(
                            'showSecond' => true,
                            'dateFormat' => 'dd-mm-yy',
//                            'timeFormat' => 'HH:mm:ss',
                            'controlType' => 'select',
                            'stepHour' => 1,
                            'stepMinute' => 1,
                            'stepSecond' => 1,
                            //'showOn' => 'button',
                            'showSecond' => false,
                            'changeMonth' => true,
                            'changeYear' => false,
                            'tabularLevel' => null,
                        //'addSliderAccess' => true,
                        //'sliderAccessArgs' => array('touchonly' => false),
                        ), // jquery plugin options
                        'htmlOptions' => array(
                            'class' => 'span12 col-sm-12',
                        )
                    ));
                    ?>
                </div>
                <div class="form-group col-xs-6"> 
                    <label for="exampleInputEmail1"><?php echo Yii::t('tour_booking', 'date_out') ?></label> 
                    <?php
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'TourBooking[checking_out]', //attribute name
                        'mode' => 'date', //use "time","date" or "datetime" (default)
                        'value' => ((int) $model->checking_out > 0 ) ? date('d-m-Y', (int) $model->checking_out) : date('d-m-Y', time() + 86400),
                        'language' => 'vi',
                        'options' => array(
                            'showSecond' => true,
                            'dateFormat' => 'dd-mm-yy',
//                            'timeFormat' => 'HH:mm:ss',
                            'controlType' => 'select',
                            'stepHour' => 1,
                            'stepMinute' => 1,
                            'stepSecond' => 1,
                            //'showOn' => 'button',
                            'showSecond' => false,
                            'changeMonth' => true,
                            'changeYear' => false,
                            'tabularLevel' => null,
                        //'addSliderAccess' => true,
                        //'sliderAccessArgs' => array('touchonly' => false),
                        ), // jquery plugin options
                        'htmlOptions' => array(
                            'class' => 'span12 col-sm-12',
                        )
                    ));
                    ?>
                </div>
            </div>
        </div>
        <input type="hidden" name="TourBooking[hotel_id]" value="<?php echo $hotel['id'] ?>" />
    </div>

    <?php if (isset($hotel_rooms) && count($hotel_rooms)) { ?>
        <div class="detail-room">
            <div class="grid">
                <?php
                foreach ($hotel_rooms as $room) {
                    $str_bed = TourHotelRoom::getNumberBedInRoom($room['single_bed'], $room['double_bed']);
                    $str_bed_bonus = TourHotelRoom::getNumberBedInRoom($room['single_bed_bonus'], $room['double_bed_bonus']);
                    ?>
                    <div class="list-item  ">
                        <div class="list-content clearfix">
                            <div class="list-content-box">
                                <div class="registered-action mua">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm-mua-<?php echo $room['id']; ?>">
                                        <div class="list-content-img">  
                                            <img alt="<?php echo $room['name'] ?>" src="<?php echo ClaHost::getImageHost(), $room['image_path'], 's200_200/', $room['image_name']; ?>"> 
                                        </div>
                                    </button>
                                    <div class="modal fade bs-example-modal-sm-mua-<?php echo $room['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                        <div class="modal-dialog modal-sm-mua">
                                            <div class="modal-content ">
                                                <div class="header-popup clearfix"> <i class="icon-popup"></i>
                                                    <div class="title-popup"><?php echo $room['name'] ?></div>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="cont">
                                                    <div class="top-cont">
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                <div class="box-img-hotel-in">
                                                                    <a class="hotel-img-small" href="<?php echo ClaHost::getImageHost() . $room['image_path'] . 's800_600/' . $room['image_name'] ?>">
                                                                        <img src="<?php echo ClaHost::getImageHost(), $room['image_path'], 's300_300/', $room['image_name']; ?>" alt="<?php echo $room['name']; ?>">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <div class="hotel-info">
                                                                    <?php if ($str_bed) { ?>
                                                                        • <b><?php echo Yii::t('tour', 'room_bed') ?>: </b><?php echo $str_bed; ?><br>
                                                                    <?php } ?>
                                                                    <?php if ($str_bed_bonus) { ?>
                                                                        • <b><?php echo Yii::t('tour', 'room_bed_bonus') ?>: </b><?php echo $str_bed_bonus; ?><br>
                                                                    <?php } ?>
                                                                    <?php if ($room['price'] && $room['price'] > 0) { ?>
                                                                        • <b><?php echo Yii::t('tour', 'room_price') ?>: </b><span class="symbol_before"></span> <span data="<?php echo $room['price'] ?>" class="price_show"><?php echo number_format($room['price'], 0, '', '.'); ?></span> <span class="symbol_after">₫</span><br>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bottom-cont">
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                <div class="title-bottom-cont">
                                                                    <h6>Tiện nghi phòng</h6>
                                                                </div>
                                                                <div class="cont-bottom-cont">
                                                                    <?php
                                                                    $comforted_room = array();
                                                                    if (isset($room['comforts_ids']) && $room['comforts_ids']) {
                                                                        $comforted_room = explode(',', $room['comforts_ids']);
                                                                    }
                                                                    if (count($comforted_room)) {
                                                                        ?>
                                                                        <ul>
                                                                            <?php
                                                                            foreach ($comforts_room as $comfort_room) {
                                                                                if (in_array($comfort_room['id'], $comforted_room)) {
                                                                                    ?>
                                                                                    <li>
                                                                                        <?php echo $comfort_room['name'] ?>
                                                                                    </li>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </ul>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <div class="title-bottom-cont">
                                                                    <h6>Chi tiết</h6>
                                                                </div>
                                                                <div class="cont-bottom-cont">
                                                                    <?php echo $room['description'] ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-content-body">
                                    <div class="registered-action">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm-mua-<?php echo $room['id'] ?>">
                                            <h4 class="list-content-title"> <?php echo $room['name'] ?> </h4>
                                        </button>
                                    </div>
                                    <div class="price">
                                        <?php if ($room['price'] && $room['price'] > 0) { ?>
                                            <p><span><?php echo Yii::t('tour', 'room_price') ?>: </span> <?php echo number_format($room['price'], 0, '', '.'); ?> đ</p> 
                                        <?php } ?>
                                        <?php if ($room['price'] && $room['price'] > 0) { ?>
                                            <div class="product-price-market"><?php echo Yii::t('tour', 'room_price_market') ?>: <span><?php echo number_format($room['price_market'], 0, '', '.'); ?> đ</span> </div>
                                        <?php } ?>
                                    </div>
                                    <?php
                                    if ($str_bed) {
                                        ?>
                                        <div class="maximum">
                                            <p><?php echo Yii::t('tour', 'room_bed') ?>: <span><?php echo $str_bed; ?></span></p>
                                        </div>
                                    <?php } ?>
                                    <div class="number-room clearfix">
                                        <span class="number-room-in"><?php echo Yii::t('tour_hotel', 'number_room') ?>: </span>
                                        <input name="TourBooking[room][<?php echo $room['id'] ?>]" type="number" class="form-control sc-quantity" max-lenght="3" value="0" min="0" step="0">
                                    </div>
                                    <div class="ProductAction clearfix">
                                        <div class="ProductActionAdd"> 
                                            <a onclick="submit_booking(this);" href="javascript:void(0)" class="a-btn-2">
                                                <span class="a-btn-2-text"><?php echo Yii::t('tour_booking', 'booking_now') ?></span> 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</form>
<script type="text/javascript">
    $(".box-img-hotel-in .hotel-img-small").colorbox({rel: 'product-img-large', innerHeight: 600, innerWidth: 800});
    function submit_booking(thisTag) {
        var tag_number_room = $(thisTag).parents('.list-content-body').find('.number-room .sc-quantity')
        var number_room = tag_number_room.val();
        if (number_room == 0) {
            tag_number_room.val(1);
        }
        $('#form_booking_room').submit();
    }
</script>
<div class="detail-hotel">
    <?php if ($hotel['comforts_ids']) { ?>
        <div class="box-detail-hotel">
            <div class="title-hotel-detail convenient">
                <p><?php echo Yii::t('tour_hotel', 'comfort') ?> <?php echo $hotel['name'] ?></p>
            </div>
            <div class="cont convenient-cont">
                <?php
                $comforted = array();
                if (isset($hotel['comforts_ids']) && $hotel['comforts_ids']) {
                    $comforted = explode(',', $hotel['comforts_ids']);
                }
                if (count($comforted)) {
                    ?>
                    <ul class="clearfix">
                        <?php
                        foreach ($comforts as $comfort) {
                            if (in_array($comfort['id'], $comforted)) {
                                ?>
                                <li>
                                    <?php if ($comfort['image_path'] != '' && $comfort['image_name'] != '') { ?>
                                        <img alt="<?php echo $comfort['name'] ?>" src="<?php echo ClaHost::getImageHost(), $comfort['image_path'], $comfort['image_name']; ?>" /> 
                                    <?php } ?>
                                    <?php echo $comfort['name'] ?>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($hotel->description) && $hotel->description) { ?>
        <div class="box-detail-hotel">
            <div class="title-hotel-detail introduce-in-in">
                <p><?php echo Yii::t('tour_hotel', 'introduce') ?> <?php echo $hotel['name'] ?></p>
            </div>
            <div class="cont introduce-in-in-cont">
                <?php echo $hotel->description ?>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($hotel->policy) && $hotel->policy) { ?>
        <div class="box-detail-hotel">
            <div class="title-hotel-detail policy-in">
                <p><?php echo Yii::t('tour_hotel', 'policy') ?> <?php echo $hotel['name'] ?></p>
            </div>
            <div class="cont policy-in-cont">
                <?php echo $hotel->policy ?>
            </div>
        </div>
    <?php } ?>
</div> 
<script>
    $(function () {
        $(".convenient").click(function () {
            if ($(".convenient-cont").hasClass("close-in") == false) {
                $(".convenient-cont").addClass("close-in");

            }
            else {
                $(".convenient-cont").removeClass("close-in")
            }
        });
        $(".policy-in").click(function () {
            if ($(".policy-in-cont").hasClass("close-in") == false) {
                $(".policy-in-cont").addClass("close-in");
            }
            else {
                $(".policy-in-cont").removeClass("close-in")
            }
        });
        $(".introduce-in-in").click(function () {
            if ($(".introduce-in-in-cont").hasClass("close-in") == false) {
                $(".introduce-in-in-cont").addClass("close-in");
            }
            else {
                $(".introduce-in-in-cont").removeClass("close-in")
            }
        });
        $(".icon-view-menu").click(function () {
            if ($(".menu-abouts").hasClass("open") == false) {
                $(".menu-abouts").addClass("open");
            }
            else {
                $(".menu-abouts").removeClass("open")
            }
        });
    });
</script>