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
                            <?php echo $form->labelEx($model, 'places_to_visit', array('class' => 'width-td')); ?>
                            <div class=" w3-form-field width-r">
                                <?php echo $form->dropDownList($model, 'places_to_visit', $listprovince, array('class' => 'form-control width-r')); ?>
                                <?php echo $form->error($model, 'places_to_visit'); ?>
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
                            <?php echo $form->labelEx($model, 'adults', array('class' => 'width-td')); ?>
                            <div class=" w3-form-field width-ip ">
                                <?php echo $form->textField($model, 'adults', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'address'))); ?>
                                <?php echo $form->error($model, 'adults'); ?>
                            </div>
                        </div>
                        <div class="form-group w3-form-group pop-ng ">
                            <?php echo $form->labelEx($model, 'children', array('class' => 'width-td')); ?>
                            <div class=" w3-form-field width-ip ">
                                <?php echo $form->textField($model, 'children', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'address'))); ?>
                                <?php echo $form->error($model, 'children'); ?>
                            </div>
                        </div>
                        <div class="form-group w3-form-group pop-ng ">
                            <?php echo $form->labelEx($model, 'length', array('class' => 'width-td')); ?>
                            <div class=" w3-form-field width-ip ">
                                <?php echo $form->textField($model, 'length', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'address'))); ?>
                                <?php echo $form->error($model, 'length'); ?>
                            </div>
                        </div>
                        <div class="form-group w3-form-group pop-ng  ">
                            <?php echo $form->labelEx($model, 'tour_style', array('class' => 'width-td')); ?>
                            <div class=" w3-form-field width-r">
                                <?php echo $form->dropDownList($model, 'tour_style', TourStyle::getOptionsStyles(), array('class' => 'form-control width-r')); ?>
                                <?php echo $form->error($model, 'tour_style'); ?>
                            </div>
                        </div>
                        <div class="form-group w3-form-group pop-ng ">
                            <?php echo $form->labelEx($model, 'passport', array('class' => 'width-td')); ?>
                            <div class=" w3-form-field width-ip ">
                                <?php echo $form->textField($model, 'passport', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'address'))); ?>
                                <?php echo $form->error($model, 'passport'); ?>
                            </div>
                        </div>
                        <div class="form-group w3-form-group pop-ng ">
                            <?php echo $form->labelEx($model, 'flight_number', array('class' => 'width-td')); ?>
                            <div class=" w3-form-field width-ip ">
                                <?php echo $form->textField($model, 'flight_number', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'address'))); ?>
                                <?php echo $form->error($model, 'flight_number'); ?>
                            </div>
                        </div>
                        <div class="form-group w3-form-group pop-ng  ">
                            <?php echo $form->labelEx($model, 'star_rating', array('class' => 'width-td')); ?>
                            <div class=" w3-form-field width-r">
                                <?php echo $form->dropDownList($model, 'star_rating', $liststar, array('class' => 'form-control width-r')); ?>
                                <?php echo $form->error($model, 'star_rating'); ?>
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
                        <input type="hidden" name="TourBooking[tour_id]" value="" />
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
                                <button type="submit">Gửi</button>
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
