<?php if ($hotel) { ?>
    <div class="reservation-in">
        <div class="back-page">
            <a href="<?php echo Yii::app()->createUrl('tour/tourHotel/detail', array('id' => $hotel['id'], 'alias' => $hotel['alias'])) ?>">Trở về trang khách sạn vừa xem</a>
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
                            <?php
                            foreach ($rooms as $room) {
                                ?>
                                <input type='hidden' name='TourBooking[room][<?php echo $room['id'] ?>]' value="<?php echo $room['qty']; ?>" />
                                <?php
                            }
                            ?>
                            <input type="hidden" name="TourBooking[hotel_id]" value="<?php echo $hotel['id'] ?>" />
                            <input type="hidden" name="TourBooking[checking_in]" value="<?php echo $checking_in ?>" />
                            <input type="hidden" name="TourBooking[checking_out]" value="<?php echo $checking_out ?>" />
                            <input type="hidden" name="TourBooking[finish]" value="1" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="booking-information">
                        <div class="title-steps">
                            <h3>Thông tin đặt phòng</h3>
                            <div class="icon-steps">
                                <h4>2</h4>
                            </div>
                        </div>
                        <div class="cont-booking-information">
                            <div class="box-img-room">
                                <img src="<?php echo ClaHost::getImageHost(), $hotel['image_path'], 's415_415/', $hotel['image_name'] ?>" alt="#">
                            </div>
                            <div class="name-room">
                                <h4><?php echo $hotel['name'] ?></h4>
                            </div>
                            <div class="adress-hotel">
                                <p><span>Địa chỉ:</span> <?php echo implode(' - ', array($hotel['ward_name'], $hotel['district_name'], $hotel['province_name'])); ?></p>
                            </div>
                            <div class="date-room">
                                <p><span class="title-date">Ngày nhận: </span><span class="cont-date">  <?php echo $checking_in ?></span></p>
                                <p><span class="title-date">Ngày trả: </span><span class="cont-date">  <?php echo $checking_out ?></span></p>
                            </div>
                            <div class="booking_bill">
                                <h2>Thông tin thanh toán</h2>
                                <?php
                                $i = 0;
                                $totals_price = 0;
                                foreach ($rooms as $room) {
                                    $i++;
                                    $totals_price += $room['total_price'];
                                    ?>
                                    <p class="max-people"><?php echo $i ?>. <?php echo $room['name']; ?></p>
                                    <div class="wap_bill">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="w_60">
                                                        <span class="numberRooms"><?php echo $room['qty'] ?></span> phòng                                       
                                                    </td>
                                                    <td class="w_10">x</td>
                                                    <td class="w_80 ">
                                                        <span class="symbol_before"></span> 
                                                        <span data="460000" class="price_show"><?php echo number_format($room['price'], 0, '', '.'); ?></span> 
                                                        <span class="symbol_after">₫</span>
                                                    </td>
                                                    <td class="w_10">x</td>
                                                    <td class="w_50 numberNights"><?php echo $room['count_night']; ?> Đêm</td>
                                                    <td class="w_10">=</td>
                                                    <td align="right">
                                                        <span id="money_room_8078_0" class="priceRoomTotal">
                                                            <span class="symbol_before"></span>
                                                            <span class="price_show"><?php echo number_format($room['total_price'], 0, '', '.'); ?></span> 
                                                            <span class="symbol_after">₫</span>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                }
                                ?>
                                <p class="total_money">
                                    Tổng số tiền
                                    <b>
                                        <span class="symbol_before"></span> 
                                        <span class="price_show"><?php echo number_format($totals_price, 0, '', '.'); ?></span> 
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