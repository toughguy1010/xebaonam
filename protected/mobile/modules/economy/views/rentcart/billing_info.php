<?php
$themUrl = Yii::app()->theme->baseUrl;
?>
<div class="page-taodonhang">
    <div class="container">
        <div class="wizard small row">
            <a href="<?= Yii::app()->createUrl('/economy/rentcart/order') ?>">
                Tạo Đơn Hàng
            </a>
            <a href="<?= Yii::app()->createUrl('/economy/rentcart/billingInfo') ?>" class="current">
                Thông Tin Cá Nhân
            </a>
            <a href="<?= Yii::app()->createUrl('/economy/rentcart/payment') ?>">
                Thanh Toán
            </a>
        </div>
        <div class="info-section">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'action' => Yii::app()->createUrl(''),
                'method' => 'POST',
                'id' => 'search_wifi',
                'htmlOptions' => array('class' => 'form-horizontal'),
            ));
            ?>
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                    <div class="title-wifi">
                        <h2><?php echo Yii::t('rent', 'user_infomation') ?></h2>
                    </div>
                    <div class="item-choice-infor">
                        <?php echo $form->labelEx($billing, 'name', array('class' => '')); ?>
                        <?php echo $form->textField($billing, 'name', array('class' => '', 'placeholder' => $model->getAttributeLabel('name'))); ?>
                        <?php echo $form->error($billing, 'name'); ?>
                    </div>
                    <div class="item-choice-infor">
                        <?php echo $form->labelEx($billing, 'email', array('class' => '')); ?>
                        <?php echo $form->textField($billing, 'email', array('class' => '', 'placeholder' => $model->getAttributeLabel('email'))); ?>
                        <?php echo $form->error($billing, 'email'); ?>
                    </div>
                    <div class="item-choice-infor">
                        <?php echo $form->labelEx($billing, 'phone', array('class' => '')); ?>
                        <?php echo $form->textField($billing, 'phone', array('class' => '', 'placeholder' => $model->getAttributeLabel('phone'))); ?>
                        <?php echo $form->error($billing, 'phone'); ?>
                    </div>
                    <div class="item-choice-infor">
                        <?php echo $form->labelEx($orderModel, 'note', array('class' => '')); ?>
                        <?php echo $form->textArea($orderModel, 'note', array('class' => '', 'cols' => 30, 'rows' => 10, 'placeholder' => $model->getAttributeLabel('note'))); ?>
                        <?php echo $form->error($orderModel, 'note'); ?>
                    </div>

                    <div class="title-wifi">
                        <h2><?php echo Yii::t('shoppingcart', 'billing-text') ?></h2>
                    </div>
                    <p style="font-size: 12px;text-align: justify">(*) Xin vui lòng cung cấp thông tin tài khoản của bạn cho mục đích chuyển khoản hoàn trả tiền cọc.
                        <br>
                        Quý khách vui lòng nhập thông tin giao dịch bằng tiếng Việt không dấu. Nội dung giao dịch có dấu sẽ được tự động lược bỏ khi ngân hàng xử lý giao dịch.</p>
                    <div class="item-choice-infor">
                        <?php echo $form->labelEx($orderModel, 'bank_no', array('class' => '')); ?>
                        <?php echo $form->textField($orderModel, 'bank_no', array('class' => '', 'placeholder' => $model->getAttributeLabel('bank_no'))); ?>
                        <?php echo $form->error($orderModel, 'bank_no'); ?>
                    </div>
                    <div class="item-choice-infor">
                        <?php echo $form->labelEx($orderModel, 'bank_name', array('class' => '')); ?>
                        <?php echo $form->textField($orderModel, 'bank_name', array('class' => '', 'placeholder' => $model->getAttributeLabel('bank_name'))); ?>
                        <?php echo $form->error($orderModel, 'bank_name'); ?>
                    </div>
                    <div class="item-choice-infor">
                        <?php echo $form->labelEx($orderModel, 'bank_note', array('class' => '')); ?>
                        <?php echo $form->textField($orderModel, 'bank_note', array('class' => '', 'placeholder' => $model->getAttributeLabel('bank_note'))); ?>
                        <?php echo $form->error($orderModel, 'bank_note'); ?>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                    <?= $rentCart ?>
                </div>
            </div>

            <div class="line-bot-order">
                <div class="back-cart">
                    <a href="<?= Yii::app()->createUrl('economy/rentcart/order') ?>"><i class="fa fa-arrow-left"></i>Quay
                        lại đặt hàng</a>
                </div>
                <div class="skip-process">
                    <button type="submit">
                        <a>Tiếp tục <i
                                    class="fa fa-arrow-right"></i></a>
                    </button>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
