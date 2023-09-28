<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/colorbox/jquery.colorbox-min.js');
?>
<form action="<?php echo Yii::app()->createUrl('tour/booking/bookingRoom'); ?>" id="form_booking_room" method="POST">
    <div class="product-detail clearfix">
        <div class="product-detail-box">
            <div class="product-detail-img clearfix">
                <div class="product-img-main"> 
                    <a class="product-img-small product-img-large cboxElement">
                        <img src="<?php echo ClaHost::getImageHost() . $hotel_room['image_path'] . 's330_330/' . $hotel_room['image_name']; ?>">
                    </a>
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
                <div class="product-img-item">
                    <ul>
                        <li>
                            <a class="product-img-small cboxElement" href="#">
                                <img src="css/img/anh_detail.jpg">
                            </a>
                        </li>
                        <li>
                            <a class="product-img-small cboxElement" href="#">
                                <img src="css/img/anh_detail.jpg">
                            </a>
                        </li>
                        <li>
                            <a class="product-img-small cboxElement" href="#">
                                <img src="css/img/anh_detail.jpg">
                            </a>
                        </li>
                        <li>
                            <a class="product-img-small cboxElement" href="#">
                                <img src="css/img/anh_detail.jpg">
                            </a>
                        </li>
                        <li>
                            <a class="product-img-small cboxElement" href="#">
                                <img src="css/img/anh_detail.jpg">
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="product-detail-info product-detail-detail" id="product-detail-info">
                <h3 class="list-content-title list-content-title-cri list-content-title-detail"> 
                    <a href="javascript:void(0)"><?php echo $hotel_room['name'] ?></a> 
                </h3>
                <div class="rating-box-comment">
                    <div class="rating" style="width:100%;"></div>
                </div>
                <?php if (isset($hotel_room['price']) && $hotel_room['price'] > 0) { ?>
                    <div class="price price-cri price-cri-detail">
                        <p>Giá: <span><?php echo number_format($hotel_room['price'], 0, '', '.'); ?> vnd</span></p>
                    </div>
                <?php } ?>
                <?php
                if (isset($hotel['single_bed']) || isset($hotel['double_bed']) || isset($hotel['single_bed_bonus']) || isset($hotel['double_bed_bonus'])) {
                    $total_per = $hotel['single_bed'] + ($hotel['double_bed'] * 2) + $hotel['single_bed_bonus'] + ($hotel['double_bed_bonus'] * 2);
                    ?>
                    <div class="maximum-people maximum-people-detail">
                        <p><span>S? ngu?i t?i da:</span> <?php echo $total_per; ?></p>
                    </div>
                <?php } ?>
                <div class="product-info-quantity product-info-quantity-detail number-room">
                    <label>S? pḥng:</label>
                    <span class="product-detail-quantity">
                        <input type="number" name="TourBooking[room][<?php echo $hotel_room['id'] ?>]" value="1" max-lenght="3" class="sc-quantity product_quantity" id="product_quantity" style="width: 40px;" min="1" step="1">
                    </span>
                </div>
                <input type="hidden" name="TourBooking[hotel_id]" value="<?php echo $hotel['id'] ?>" />
                <div class="attribute-hotel attribute-detail">
                    <ul>
                        <?php
                        foreach ($comforts as $comfort) {
                            if (in_array($comfort['id'], $comfort)) {
                                ?>
                                <li>
                                    <?php if ($comfort['image_path'] && $comfort['image_name']) { ?>
                                        <a href="javascript:void(0)" title="<?php echo $comfort['name'] ?>">
                                            <img alt="<?php echo $comfort['name'] ?>" src="<?php echo ClaHost::getImageHost(), $comfort['image_path'], $comfort['image_name']; ?>" />
                                        </a>
                                    <?php } ?>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>

                <div class="ProductAction ProductAction-in ProductAction-detail clearfix">
                    <div class="ProductActionAdd ProductActionAdd-in ProductActionAdd-detail"> 
                        <a onclick="submit_booking(this)" href="javascript:void(0)" title="Đ?t pḥng" class="a-btn-2">
                            <span class="a-btn-2-text">Đ?t pḥng</span> 
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-detail-more">
            <h4>Chi ti?t pḥng </h4>
            <div class="content-product-detail">
                <?php echo $hotel_room['description']; ?>
            </div>
        </div>
        <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK6)); ?>
    </div>
</form> 
<script type="text/javascript">
    $(".box-img-hotel-in .hotel-img-small").colorbox({rel: 'product-img-large', innerHeight: 600, innerWidth: 800});
    function submit_booking(thisTag) {
        var tag_number_room = $(thisTag).parents('#product-detail-info').find('.number-room #product_quantity');
        var number_room = tag_number_room.val();
        if (number_room == 0) {
            tag_number_room.val(1);
        }
//        alert(number_room)    ;
        $('#form_booking_room').submit();
    }
</script>
<script>
    $(function () {
        $(".convenient").click(function () {
            if ($(".convenient-cont").hasClass("close-in") == false) {
                $(".convenient-cont").addClass("close-in");

            } else {
                $(".convenient-cont").removeClass("close-in")
            }
        });
        $(".policy-in").click(function () {
            if ($(".policy-in-cont").hasClass("close-in") == false) {
                $(".policy-in-cont").addClass("close-in");
            } else {
                $(".policy-in-cont").removeClass("close-in")
            }
        });
        $(".introduce-in-in").click(function () {
            if ($(".introduce-in-in-cont").hasClass("close-in") == false) {
                $(".introduce-in-in-cont").addClass("close-in");
            } else {
                $(".introduce-in-in-cont").removeClass("close-in")
            }
        });
        $(".icon-view-menu").click(function () {
            if ($(".menu-abouts").hasClass("open") == false) {
                $(".menu-abouts").addClass("open");
            } else {
                $(".menu-abouts").removeClass("open")
            }
        });
    });
</script>