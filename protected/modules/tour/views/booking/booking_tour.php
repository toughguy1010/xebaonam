<?php if ($tour) { ?>
    <div class="reservation-in">
        <div class="back-page">
            <a href="<?php echo Yii::app()->createUrl('tour/tour/detail', array('id' => $tour['id'], 'alias' => $tour['alias'])) ?>">Trở về trang tour vừa xem</a>
        </div>
        <div class="cont">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'booking-room-form',
                'htmlOptions' => array('class' => 'form-horizontal'),
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
            ));
            ?>
            <div class="row">
                <div class="col-sm-4">
                    <div class="contact-info-in">
                        <div class="title-steps">
                            <h3>Thông tin liên hệ</h3>
                            <div class="icon-steps">
                                <h4>1</h4>
                            </div>
                        </div>
                        <div class="cont-form">
                            <div class="form-group w3-form-group pop-ng ">
                                <?php echo $form->labelEx($model, 'name', array('class' => 'width-td')); ?>
                                <div class=" w3-form-field width-ip ">
                                    <?php echo $form->textField($model, 'name', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('tour_booking', 'name'))); ?>
                                    <?php echo $form->error($model, 'name'); ?>
                                </div>
                            </div>
                            <div class="form-group w3-form-group pop-ng  ">
                                <?php echo $form->labelEx($model, 'province_id', array('class' => 'width-td')); ?>
                                <div class=" w3-form-field width-r">
                                    <?php echo $form->dropDownList($model, 'province_id', $listprovince, array('class' => 'form-control width-r')); ?>
                                    <?php echo $form->error($model, 'province_id'); ?>
                                </div>
                            </div>
                            <div class="form-group w3-form-group pop-ng ">
                                <?php echo $form->labelEx($model, 'address', array('class' => 'width-td')); ?>
                                <div class=" w3-form-field width-ip ">
                                    <?php echo $form->textField($model, 'address', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'address'))); ?>
                                    <?php echo $form->error($model, 'address'); ?>
                                </div>
                            </div>
                            <div class="form-group w3-form-group pop-ng ">
                                <?php echo $form->labelEx($model, 'phone', array('class' => 'width-td')); ?>
                                <div class=" w3-form-field width-ip ">
                                    <?php echo $form->textField($model, 'phone', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'phone'))); ?>
                                    <?php echo $form->error($model, 'phone'); ?>
                                </div>
                            </div>
                            <div class="form-group w3-form-group pop-ng ">
                                <?php echo $form->labelEx($model, 'email', array('class' => 'width-td')); ?>
                                <div class=" w3-form-field width-ip ">
                                    <?php echo $form->textField($model, 'email', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('email', 'email'))); ?>
                                    <?php echo $form->error($model, 'email'); ?>
                                </div>
                            </div>
                            <input type="hidden" name="TourBooking[tour_id]" value="<?php echo $tour['id'] ?>" />
                            <input type="hidden" name="TourBooking[finish]" value="1" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="booking-information">
                        <div class="title-steps">
                            <h3>Thông tin đặt tour</h3>
                            <div class="icon-steps">
                                <h4>2</h4>
                            </div>
                        </div>
                        <div class="cont-booking-information">
                            <div class="box-img-room">
                                <img src="<?php echo ClaHost::getImageHost(), $tour['avatar_path'], 's415_415/', $tour['avatar_name'] ?>" alt="#">
                            </div>
                            <div class="name-room">
                                <h4><?php echo $tour['name'] ?></h4>
                            </div>
                            <div class="adress-hotel">
                                <p><span>Danh mục:</span> <?php echo $category->cat_name; ?></p>
                            </div>
                            <div class="date-room">
                                <p>
                                    <span class="title-date">Ngày khởi hành: </span>
                                    <span class="cont-date">
                                        <?php
                                        $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                                            'model' => $model, //Model object
                                            'name' => 'TourBooking[departure_date]', //attribute name
                                            'mode' => 'date', //use "time","date" or "datetime" (default)
                                            'value' => ((int) $model->departure_date > 0 ) ? date('d-m-Y', (int) $model->departure_date) : date('d-m-Y'),
                                            'language' => 'vi',
                                            'options' => array(
                                                'showSecond' => true,
                                                'dateFormat' => 'dd-mm-yy',
                                                'controlType' => 'select',
                                                'stepHour' => 1,
                                                'stepMinute' => 1,
                                                'stepSecond' => 1,
                                                //'showOn' => 'button',
                                                'showSecond' => false,
                                                'changeMonth' => true,
                                                'changeYear' => false,
                                                'tabularLevel' => null,
                                            ), // jquery plugin options
                                            'htmlOptions' => array(
                                                'class' => 'departure_date',
                                            )
                                        ));
                                        ?>
                                    </span>
                                </p>
                                <p>
                                    <span class="title-date">Số phiếu: </span>
                                    <span class="cont-date"> <input id="TourBooking_qty" type="text" name="TourBooking[qty]" value="1" /></span>
                                </p>
                            </div>
                            <div class="booking_bill">
                                <h2>Thông tin thanh toán</h2>
                                <p class="max-people">1. <?php echo $tour['name']; ?></p>
                                <div class="wap_bill">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="w_60">
                                                    <span class="number_ticket"><?php echo $qty ?></span> phiếu                                       
                                                </td>
                                                <td class="w_10">x</td>
                                                <td class="w_80 ">
                                                    <span class="symbol_before"></span> 
                                                    <span data="460000" class="price_show"><?php echo number_format($tour['price'], 0, '', '.'); ?></span> 
                                                    <span class="symbol_after">₫</span>
                                                </td>
                                                <?php
                                                $total_price = $qty * $tour['price'];
                                                ?>
                                                <td align="right">
                                                    <span id="money_room_8078_0" class="priceRoomTotal">
                                                        <span class="symbol_before"></span>
                                                        <span class="price_show"><?php echo number_format($total_price, 0, '', '.'); ?></span> 
                                                        <span class="symbol_after">₫</span>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="total_money">
                                    Tổng số tiền
                                    <b>
                                        <span class="symbol_before"></span> 
                                        <span class="price_show"><?php echo number_format($total_price, 0, '', '.'); ?></span> 
                                        <span class="symbol_after">₫</span>  
                                    </b>
                                </p>
                                <p class="vat">(Giá đã bao gồm Thuế và Phí dịch vụ)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="submit-booking">
                        <div class="title-steps">
                            <h3>Gửi yêu cầu đặt phòng</h3>
                            <div class="icon-steps">
                                <h4>3</h4>
                            </div>
                        </div>
                        <div class="cont">
                            <div class="ProductAction clearfix">
                                <div class="ProductActionAdd"> 
                                    <a onclick="submit_booking()" href="javascript:void(0)" class="a-btn-2">
                                        <span class="a-btn-2-text">Hoàn thành</span> 
                                    </a>
                                </div>
                            </div>
                            <div class="content-note">
                                <ul>
                                    <li>
                                        <?php
                                        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK8));
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <script type='text/javascript'>
        function addCommas(nStr)
        {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            return x1 + x2;
        }

        $(document).ready(function () {
            $('#TourBooking_qty').blur(function () {
                var qty = $(this).val();
                var price = parseInt(<?php echo $tour['price']; ?>);
                var total_price = qty * price;
                $('.number_ticket').html(qty);
                $('.price_show').html(addCommas(total_price));
            });
        });

        function submit_booking() {
            var name = $('#TourBooking_name').val();
            if (name == '') {
                alert('Bạn phải điền tên');
                $('#TourBooking_name').focus();
                return false;
            }
            var phone = $('#TourBooking_phone').val();
            if (phone == '') {
                alert('Bạn phải điền số điện thoại');
                $('#TourBooking_phone').focus();
                return false;
            }
            var email = $('#TourBooking_email').val();
            if (phone == '') {
                alert('Bạn phải điền email');
                $('#TourBooking_email').focus();
                return false;
            }

            $('#booking-room-form').submit();
        }
    </script>
<?php } else { ?>
    <div class="reservation-in">
        <?php if (Yii::app()->user->hasFlash('success')) { ?>
            <div class="info">
                <p class="bg-success"><?php echo Yii::app()->user->getFlash('success'); ?></p>
            </div>
        <?php } ?>
        <div class="back-page">
            <a href="<?php echo Yii::app()->getBaseUrl(true); ?>">Trở về trang chủ</a>
        </div>
    </div>
<?php } ?>