<?php $themUrl = Yii::app()->theme->baseUrl; ?>
<script type="text/javascript" src="<?= $themUrl ?>/js/jssor.js"></script>
<script type="text/javascript" src="<?= $themUrl ?>/js/jssor.slider.js"></script>
<div class="top-detail">
    <div class="header-top-detail">
        <div class="list-content-body">
            <h3 class="list-content-title"><a href="javascript:void(0)"
                                              title="<?php echo $tour['name'] ?>"><?php echo $tour['name'] ?> </a></h3>
            <div class="adress-hotel">
                <div class="share-social">
                    <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_SOCIAL)); ?>
                </div>
            </div>
        </div>
        <div class="cont-top-detail">
            <div class="box-img-hotel">
                <?php
                $images = $tour->getImages();
                ?>
                <?php if ($images && count($images)) { ?>
                    <div id="slider2_container"
                         style="position: relative; width: 790px; height: 444px; overflow: hidden;">
                        <!-- Slides Container -->
                        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 790px; height: 444px;
                             overflow: hidden;">
                            <?php foreach ($images as $img) { ?>
                                <div>
                                    <img u="image"
                                         src="<?php echo ClaHost::getImageHost() . $img['path'] . $img['name']; ?>">
                                    <img u="thumb"
                                         src="<?php echo ClaHost::getImageHost() . $img['path'] . 's100_100/' . $img['name']; ?>">
                                </div>
                            <?php } ?>
                        </div>
                        <div u="thumbnavigator" class="jssort07"
                             style="width: 790px; height: 100px; left: 0px; bottom: 0px;">
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
        <div class="box-detail-hotel clearfix" style="padding: 10px 0px;">
            <div class="col-xs-8">
                <div>
                    <div>
                        <label>Tour ID:</label> <span><?php echo $tour['id'] ?></span>
                    </div>

                    <?php if ($tour['departure_date']) { ?>
                        <div>
                            <label>Ngày khởi hành:</label> <span><?php echo $tour['departure_date'] ?></span>
                        </div>
                    <?php } ?>
                    <?php if ($tour['time']) { ?>
                        <div>
                            <label>Thời gian:</label> <span><?php echo $tour['time'] ?></span>
                        </div>
                    <?php } ?>
                    <?php if ($tour['departure_at']) { ?>
                        <div>
                            <label>Điểm khởi hành:</label> <span><?php echo $tour['departure_at'] ?></span>
                        </div>
                    <?php } ?>
                    <?php if ($tour['destination']) { ?>
                        <div>
                            <label>Điểm đến:</label> <span><?php echo $tour['destination'] ?></span>
                        </div>
                    <?php } ?>
                    <?php if ($tour['transport']) { ?>
                        <div>
                            <label>Phương tiện:</label> <span><?php echo $tour['transport'] ?></span>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="price-tour">
                    <?php if ($tour['price'] > 0) { ?>
                        <div class="price">
                            <label>Giá Tour:</label> <span><?php echo number_format($tour['price'], 0, '', '.'); ?>
                                đ</span>
                        </div>
                    <?php } ?>
                    <?php if ($tour['price_market'] > 0) { ?>
                        <div class="price-market">
                            <label>Giá chưa khuyến mại:</label>
                            <span><?php echo number_format($tour['price_market'], 0, '', '.'); ?> đ</span>
                        </div>
                    <?php } ?>
                </div>
                <form action="<?php echo Yii::app()->createUrl('tour/booking/bookingTour'); ?>" id="form_booking_tour"
                      method="POST">
                    <input type="hidden" name="TourBooking[tour_id]" value="<?php echo $tour['id']; ?>"/>
                    <input type="hidden" name="TourBooking[qty]" value="1"/>
                    <div class="clearfix">
                        <div class="ProductActionAdd">
                            <a onclick="submit_booking();" href="javascript:void(0)" class="a-btn-2">
                                <span class="a-btn-2-text">Đặt tour ngay</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function submit_booking() {
        $('#form_booking_tour').submit();
    }
</script>
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

<div class="detail-hotel">
    <?php if (isset($tour->price_include) && $tour->price_include) { ?>
        <div class="box-detail-hotel">
            <div class="title-hotel-detail introduce-in-in">
                <p><?php echo Yii::t('tour', 'price_include'); ?></p>
            </div>
            <div class="cont introduce-in-in-cont">
                <?php echo $tour->price_include ?>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($tour->schedule) && $tour->schedule) { ?>
        <div class="box-detail-hotel">
            <div class="title-hotel-detail introduce-in-in">
                <p><?php echo Yii::t('tour', 'tour_schedule'); ?></p>
            </div>
            <div class="cont introduce-in-in-cont">
                <?php echo $tour->schedule ?>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($tour->policy) && $tour->policy) { ?>
        <div class="box-detail-hotel">
            <div class="title-hotel-detail policy-in">
                <p><?php echo Yii::t('tour', 'tour_policy'); ?></p>
            </div>
            <div class="cont policy-in-cont">
                <?php echo $tour->policy ?>
            </div>
        </div>
    <?php } ?>
</div> 