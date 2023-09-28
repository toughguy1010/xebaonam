<style type="text/css">
    @media (min-width: 1px){
        .modal-dialog { width: 600px; margin: 30px auto;} .modal-content { -webkit-box-shadow: 0 5px 15px rgba(0,0,0,.5); box-shadow: 0 5px 15px rgba(0,0,0,.5);}
    }
    @media (min-width: 1px){
        .modal-sm { width: 300px;}
    }
    .close {float: right;font-size: 35px;font-weight: 700;line-height: 1;color: #0095e6;text-shadow: 0 1px 0 #fff;filter: alpha(opacity=20);opacity: 1;}
    .close:focus, .close:hover {color: #f6931f;text-decoration: none;cursor: pointer;filter: alpha(opacity=50);opacity: .8}
    button.close {-webkit-appearance: none;padding: 0;cursor: pointer;background: 0 0;border: 0;padding:7px;    right: -30px; top: -30px; position:absolute;}
    .modal-open {overflow: hidden}
    .modal {position: fixed;top: 0;right: 0;bottom: 0;left: 0;z-index: 99999;display: none;overflow: hidden;-webkit-overflow-scrolling: touch;outline: 0; padding:10px;}
    .modal.fade .modal-dialog {-webkit-transition: -webkit-transform .3s ease-out;-o-transition: -o-transform .3s ease-out;transition: transform .3s ease-out;-webkit-transform: translate(0, -25%);-ms-transform: translate(0, -25%);-o-transform: translate(0, -25%);transform: translate(0, -25%)}
    .modal.in .modal-dialog {-webkit-transform: translate(0, 0);-ms-transform: translate(0, 0);-o-transform: translate(0, 0);transform: translate(0, 0)}
    .modal-open .modal {overflow-x: hidden;overflow-y: auto}
    .modal-dialog {position: relative;width: auto;margin: 10px}
    .modal-content {position: relative;background-color: #fff;-webkit-background-clip: padding-box;background-clip: padding-box;outline: 0;-webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5);box-shadow: 0 3px 9px rgba(0,0,0,.5)}
    .modal-backdrop {position: fixed;top: 0;right: 0;bottom: 0;left: 0;z-index: 1040;background-color: #000}
    .modal-backdrop.fade {filter: alpha(opacity=0);opacity: 0}
    .modal-backdrop.in {filter: alpha(opacity=50);opacity: .5}
    .modal-header {min-height: 16.43px;padding: 15px;border-bottom: 1px solid #e5e5e5}
    .modal-header .close {margin-top: -2px}
    .modal-title {margin: 0;line-height: 1.42857143}
    .modal-body {position: relative;padding: 15px}
    .modal-footer {padding: 15px;text-align: right;border-top: 1px solid #e5e5e5}
    .modal-footer .btn+.btn {margin-bottom: 0;margin-left: 5px}
    .modal-footer .btn-group .btn+.btn {margin-left: -1px}
    .modal-footer .btn-block+.btn-block {margin-left: 0}
    .modal-scrollbar-measure {position: absolute;top: -9999px;width: 50px;height: 50px;overflow: scroll}
    .modal-dialog.modal-sm-dat-phong {width:950px; margin:20px  auto;}
    .modal-dialog.modal-sm-dat-phong .modal-content{ padding:15px;}
</style>
<div class="checkout datphong">
    <h2 class="title-page-dp">Đặt phòng</h2>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'book-room-form',
        'htmlOptions' => array('class' => 'form-horizontal'),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ));
    ?>
    <div class="box-form">
        <h3 class="title-box-form">THÔNG TIN ĐẶT PHÒNG</h3>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'checking_in', array('class' => 'title-item')); ?>
                </div>
                <div class="col-sm-9">
                    <?php
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'TourBooking[checking_in]', //attribute name
                        'mode' => 'date', //use "time","date" or "datetime" (default)
                        'value' => ((int) $model->checking_in > 0 ) ? date('d-m-Y', (int) $model->checking_in) : '',
                        'language' => 'vi',
                        'options' => array(
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
                            'class' => 'form-control cont-item',
                            'placeholder' => 'Ngày đến'
                        ),
                    ));
                    ?>
                    <?php echo $form->error($model, 'checking_in') ?>
                </div>
            </div>
        </div>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'checking_out', array('class' => 'title-item')); ?>
                </div>
                <div class="col-sm-9">
                    <?php
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'TourBooking[checking_out]', //attribute name
                        'mode' => 'date', //use "time","date" or "datetime" (default)
                        'value' => ((int) $model->checking_out > 0 ) ? date('d-m-Y', (int) $model->checking_out) : '',
                        'language' => 'vi',
                        'options' => array(
                            'showSecond' => true,
                            'dateFormat' => 'dd-mm-yy',
                            'timeFormat' => 'HH:mm:ss',
                            'controlType' => 'select',
                            'stepHour' => 1,
                            'stepMinute' => 1,
                            'stepSecond' => 1,
                            //'showOn' => 'button',
                            'showSecond' => true,
                            'changeMonth' => true,
                            'changeYear' => false,
                            'tabularLevel' => null,
                        //'addSliderAccess' => true,
                        //'sliderAccessArgs' => array('touchonly' => false),
                        ), // jquery plugin options
                        'htmlOptions' => array(
                            'class' => 'form-control cont-item',
                            'placeholder' => 'Ngày đi'
                        )
                    ));
                    ?>
                    <?php echo $form->error($model, 'checking_out') ?>
                </div>
            </div>
        </div>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($room, 'room_id', array('class' => 'title-item')) ?>
                </div>
                <div class="col-sm-9">
                    <?php
                    $rooms = TourHotelRoom::getRoomBySiteid();

                    $options = array('' => 'Chọn phòng');
                    foreach ($rooms as $ro) {
                        $options[$ro['id']] = $ro['name'] . ' - ' . number_format($ro['price'], 0, ',', '.') . ' VNĐ';
                    }
                    ?>
                    <?php echo $form->dropDownList($room, 'room_id', $options, array('class' => 'form-control cont-item', 'placeholder' => 'Loại phòng')) ?>
                    <?php echo $form->error($room, 'room_id') ?>
                </div>
            </div>
        </div>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($room, 'room_qty', array('class' => 'title-item')); ?>
                </div>
                <div class="col-sm-9">
                    <?php echo $form->textField($room, 'room_qty', array('class' => 'form-control cont-item', 'placeholder' => 'Số lượng phòng')) ?>
                    <?php echo $form->error($room, 'room_qty') ?>
                </div>
            </div>
        </div>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'adults', array('class' => 'title-item')); ?>
                </div>
                <div class="col-sm-9">
                    <?php echo $form->textField($model, 'adults', array('class' => 'form-control cont-item', 'placeholder' => 'Số lượng người lớn')) ?>
                    <?php echo $form->error($model, 'adults') ?>
                </div>
            </div>
        </div>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'children', array('class' => 'title-item')); ?>
                </div>
                <div class="col-sm-9">
                    <?php echo $form->textField($model, 'children', array('class' => 'form-control cont-item', 'placeholder' => 'Số lượng trẻ em')) ?>
                    <?php echo $form->error($model, 'children') ?>
                </div>
            </div>
        </div>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'age_children', array('class' => 'title-item')); ?>
                </div>
                <div class="col-sm-9">
                    <?php echo $form->textField($model, 'age_children', array('class' => 'form-control cont-item', 'placeholder' => 'Tuổi trẻ em')) ?>
                    <?php echo $form->error($model, 'age_children') ?>
                </div>
            </div>
        </div>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'bed_type', array('class' => 'title-item')) ?>
                </div>
                <div class="col-sm-9">
                    <div class="">
                        <label class="radio-inline">
                            <?php echo $form->radioButton($model, 'bed_type', array('value' => TourBookingRoom::TWIN_BEDS)) . ' Gường đôi' ?>
                        </label>
                        <label class="radio-inline">
                            <?php echo $form->radioButton($model, 'bed_type', array('value' => TourBookingRoom::SINGLE_BED)) . ' Gường đơn' ?>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'extra_bed', array('class' => 'title-item')) ?>
                </div>
                <div class="col-sm-9">
                    <div class=""> 
                        <label class="radio-inline">
                            <?php echo $form->radioButton($model, 'extra_bed', array('value' => 1)) . 'Có' ?>
                        </label>
                        <label class="radio-inline">
                            <?php echo $form->radioButton($model, 'extra_bed', array('value' => 0)) . 'Không' ?>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-form">
        <h3 class="title-box-form">THÔNG TIN VỀ KHÁCH HÀNG</h3>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'sex', array('class' => 'title-item')) ?>
                </div>
                <div class="col-sm-9">
                    <?php echo $form->dropDownList($model, 'sex', TourBookingRoom::arrSex(), array('class' => 'form-control')) ?>
                    <?php echo $form->error($model, 'sex'); ?>
                </div>
            </div>
        </div>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'name', array('class' => 'title-item')); ?>
                </div>
                <div class="col-sm-9">
                    <?php echo $form->textField($model, 'name', array('class' => 'form-control cont-item', 'placeholder' => 'Họ tên')) ?>
                    <?php echo $form->error($model, 'name') ?>
                </div>
            </div>
        </div>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'company', array('class' => 'title-item')); ?>
                </div>
                <div class="col-sm-9">
                    <?php echo $form->textField($model, 'company', array('class' => 'form-control cont-item', 'placeholder' => 'Công ty')) ?>
                    <?php echo $form->error($model, 'company') ?>
                </div>
            </div>
        </div>

        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'address', array('class' => 'title-item')); ?>
                </div>
                <div class="col-sm-9">
                    <?php echo $form->textField($model, 'address', array('class' => 'form-control cont-item', 'placeholder' => 'Địa chỉ')) ?>
                    <?php echo $form->error($model, 'address') ?>
                </div>
            </div>
        </div>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'province_id', array('class' => 'title-item')) ?>
                </div>
                <div class="col-sm-9">
                    <?php $listprivince = LibProvinces::getListProvinceArr(); ?>
                    <?php echo $form->dropDownList($model, 'province_id', $listprivince, array('class' => 'form-control cont-item', 'placeholder' => 'Thành phố')) ?>
                    <?php echo $form->error($model, 'province_id') ?>
                </div>
            </div>
        </div>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'phone', array('class' => 'title-item')); ?>
                </div>
                <div class="col-sm-9">
                    <?php echo $form->textField($model, 'phone', array('class' => 'form-control cont-item', 'placeholder' => 'Điện thoại')) ?>
                    <?php echo $form->error($model, 'phone') ?>
                </div>
            </div>
        </div>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'email', array('class' => 'title-item')); ?>
                </div>
                <div class="col-sm-9">
                    <?php echo $form->textField($model, 'email', array('class' => 'form-control cont-item', 'placeholder' => 'Email')) ?>
                    <?php echo $form->error($model, 'email') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="box-form">
        <h3 class="title-box-form">THÔNG TIN DỊCH VỤ ĐÓN TIỄN</h3>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'transfer_request', array('class' => 'title-item')) ?>
                </div>
                <div class="col-sm-9">
                    <div class="">
                        <label class="radio-inline">
                            <?php echo $form->radioButton($model, 'transfer_request', array('value' => 1)) . 'Có' ?>
                        </label>
                        <label class="radio-inline">
                            <?php echo $form->radioButton($model, 'transfer_request', array('value' => 0)) . 'Không' ?>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'arrival_time', array('class' => 'title-item')) ?>
                </div>
                <div class="col-sm-9">
                    <?php
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'BookRoom[arrival_time]', //attribute name
                        'mode' => 'datetime', //use "time","date" or "datetime" (default)
                        'value' => ((int) $model->arrival_time > 0 ) ? date('d-m-Y H:i:s', (int) $model->arrival_time) : '',
                        'language' => 'vi',
                        'options' => array(
                            'showSecond' => true,
                            'dateFormat' => 'dd-mm-yy',
                            'timeFormat' => 'HH:mm:ss',
                            'controlType' => 'select',
                            'stepHour' => 1,
                            'stepMinute' => 1,
                            'stepSecond' => 1,
                            //'showOn' => 'button',
                            'showSecond' => true,
                            'changeMonth' => true,
                            'changeYear' => false,
                            'tabularLevel' => null,
                        //'addSliderAccess' => true,
                        //'sliderAccessArgs' => array('touchonly' => false),
                        ), // jquery plugin options
                        'htmlOptions' => array(
                            'class' => 'form-control cont-item',
                            'placeholder' => 'Thời gian đón đi'
                        )
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'travel_time', array('class' => 'title-item')) ?>
                </div>
                <div class="col-sm-9">
                    <?php
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'BookRoom[travel_time]', //attribute name
                        'mode' => 'datetime', //use "time","date" or "datetime" (default)
                        'value' => ((int) $model->travel_time > 0 ) ? date('d-m-Y H:i:s', (int) $model->travel_time) : '',
                        'language' => 'vi',
                        'options' => array(
                            'showSecond' => true,
                            'dateFormat' => 'dd-mm-yy',
                            'timeFormat' => 'HH:mm:ss',
                            'controlType' => 'select',
                            'stepHour' => 1,
                            'stepMinute' => 1,
                            'stepSecond' => 1,
                            //'showOn' => 'button',
                            'showSecond' => true,
                            'changeMonth' => true,
                            'changeYear' => false,
                            'tabularLevel' => null,
                        //'addSliderAccess' => true,
                        //'sliderAccessArgs' => array('touchonly' => false),
                        ), // jquery plugin options
                        'htmlOptions' => array(
                            'class' => 'form-control cont-item',
                            'placeholder' => 'Thời gian đưa về'
                        )
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="box-form">
        <h3 class="title-box-form">THÔNG TIN KHÁC</h3>
        <div class="item-form">
            <div class="row">
                <div class="col-sm-3">
                    <?php echo $form->labelEx($model, 'note', array('class' => 'title-item')) ?>
                </div>
                <div class="col-sm-9">
                    <?php echo $form->textArea($model, 'note', array('class' => 'form-control mes-dp', 'rows' => 3)) ?>
                    <?php echo $form->error($model, 'note') ?>
                </div>
            </div>
        </div>
        <?php $this->renderPartial('partial/payment_nganluong', array('model' => $model)); ?>
    </div>
    <div class="box-form">
        <h3 class="title-box-form">NẾU BẠN MUỐN ĐẶT TRỌN GÓI HOẶC THEO THỎA THUẬN RIÊNG, VUI LÒNG LIÊN HỆ VỚI CHÚNG TÔI THEO SỐ ĐƯỜNG DÂY NÓNG : 01252727979</h3>
    </div>
    <div class="box-submit clear">
        <a onclick="confirmBooking()" class="btn btn-info submit-datphong" href="#" title="#" data-toggle="modal" data-target=".bs-example-modal-sm-dat-phong">Đặt phòng</a>
    </div>
    <div class="modal fade bs-example-modal-sm-dat-phong" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm-dat-phong">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <div class="cont">
                    Xác nhận đặt phòng khách sạn
                    <?php
                    if (isset($_POST['TourBookingRoom']['room_id'])) {
                        $room_id = $_POST['TourBookingRoom']['room_id'];
                        $room_p = TourHotelRoom::model()->findByPk($room_id);
                        $name_room = $room_p->name;
                        $price_room = number_format($room_p->price, 0, ',', '.');
                    }
                    ?>
                    <div>
                        <label>Tên phòng:</label>
                        <span class="confirm-name-room"><?php echo (isset($name_room) && $name_room) ? $name_room : '' ?></span>
                    </div>
                    <div>
                        <label>Giá phòng:</label>
                        <span class="confirm-price-room"><?php echo (isset($price_room) && $price_room) ? $price_room . ' VNĐ' : '' ?></span>
                    </div>
                    <div>
                        <label>Ngày nhận phòng:</label>
                        <span class="confirm-checking-in"></span>
                    </div>
                    <div>
                        <label>Ngày Trả phòng:</label>
                        <span class="confirm-checking-out"></span>
                    </div>
                    <div>
                        <label>Số đêm:</label>
                        <span class="confirm-total-day"></span>
                    </div>
                    <div>
                        <label>Số phòng:</label>
                        <span class="confirm-total-room"></span>
                    </div>
                    <div style="display: none">
                        <label>Tổng số tiền:</label>
                        <span class="confirm-total-amount"></span>
                    </div>
                    <input type="submit" class="btn btn-info" value="Xác nhận" />
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="data-price-process" value="0" />
    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    function confirmBooking() {
        var checking_in = $('#TourBooking_checking_in').val();
        var checking_out = $('#TourBooking_checking_out').val();
        $('.confirm-checking-in').text(checking_in);
        $('.confirm-checking-out').text(checking_out);
        // process checking in
        var cki = checking_in.split("-");
        var cki_str = cki[2] + '/' + cki[1] + '/' + cki[0];
        var timestamp_cki = (new Date(cki_str).getTime() / 1000);
        // process checking out
        var cko = checking_out.split("-");
        var cko_str = cko[2] + '/' + cko[1] + '/' + cko[0];
        var timestamp_sko = (new Date(cko_str).getTime() / 1000);
        // process to total day
        var time = timestamp_sko - timestamp_cki;
        var total_day = time / 86400;
        $('.confirm-total-day').text(total_day + ' Đêm');
        //
        var total_room = $('#TourBookingRoom_room_qty').val();
        $('.confirm-total-room').text(total_room + ' Phòng');
        //
        // process total amount
        var price = $('#data-price-process').val();
        var total_price = price * total_room * total_day;
        $('.confirm-total-amount').text(total_price + ' VNĐ');
    }

    $(document).ready(function () {
        $('#TourBookingRoom_room_id').change(function () {
            var room_id = $(this).val();
            $.getJSON(
                    '<?php echo Yii::app()->createUrl('tour/bookRoom/getRoomInfo') ?>',
                    {room_id: room_id},
                    function (data) {
                        $('.confirm-name-room').text(data.data.name);
                        $('.confirm-price-room').text(data.data.price_format);
                        $('#data-price-process').val(data.data.price);
                    }
            );
        });
    });
</script>

