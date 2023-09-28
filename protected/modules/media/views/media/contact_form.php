<div class="wrap_print_picture">
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="info">
            <p class="bg-success"><?php echo Yii::app()->user->getFlash('success'); ?></p>
        </div>
    <?php endif; ?>
    
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'print-picture-form',
        'action' => Yii::app()->createUrl('media/media/siteContactForm', array('id' => $form_id)),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'form-horizontal w3f-form', 'role' => 'form', 'enctype' => 'multipart/form-data'),
    ));
    ?>
    
    <div class="title">
        <h3><?php echo Yii::t('contact', 'contact_info') ?></h3>
    </div>
    <div class="form-group w3-form-group">
        <?php echo $form->label($model, 'name', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
        <div class="col-xs-10 w3-form-field">
            <?php echo $form->textField($model, 'name', array('class' => 'form-control w3-form-input input-text', 'placeholder' => 'Họ và tên')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>
    </div>
    <div class="form-group w3-form-group">
        <?php echo $form->label($model, 'email', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
        <div class="col-xs-10 w3-form-field">
            <?php echo $form->textField($model, 'email', array('class' => 'form-control w3-form-input input-text', 'placeholder' => 'Email')); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>
    </div>
    <div class="form-group w3-form-group">
        <?php echo $form->label($model, 'phone', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
        <div class="col-xs-10 w3-form-field">
            <?php echo $form->textField($model, 'phone', array('class' => 'form-control w3-form-input input-text', 'placeholder' => 'Điện thoại')); ?>
            <?php echo $form->error($model, 'phone'); ?>
        </div>
    </div>
    <div class="form-group w3-form-group">
        <?php echo $form->label($model, 'address', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
        <div class="col-xs-10 w3-form-field">
            <?php echo $form->textField($model, 'address', array('class' => 'form-control w3-form-input input-text', 'placeholder' => 'Địa chỉ')); ?>
            <?php echo $form->error($model, 'address'); ?>
        </div>
    </div>

    <div class="title">
        <h3><?php echo Yii::t('file', 'select_image') ?></h3>
    </div>
    <div class="form-group w3-form-group">
        <?php echo CHtml::label(Yii::t('file', 'select_image'), '', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="col-xs-10 w3-form-field">
            <?php echo $form->hiddenField($model, 'image_src', array('class' => 'span12 col-sm-12')); ?>
            <div class="row" style="margin: 10px 0px;">
                <?php echo CHtml::fileField('image_src', ''); ?>
            </div>
            <?php echo $form->error($model, 'image_src'); ?>
        </div>
    </div>
    <div class="form-group w3-form-group">
        <?php echo $form->label($model, 'note', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
        <div class="col-xs-10 w3-form-field">
            <?php echo $form->textArea($model, 'note', array('class' => 'form-control w3-form-input input-textarea', 'placeholder' => 'Lời nhắn của bạn')); ?>
            <?php echo $form->error($model, 'note'); ?>
        </div>
    </div>

    <div class="title">
        <h3><?php echo Yii::t('shoppingcart', 'billing-text') ?></h3>
    </div>
    <div class="form-group w3-form-group">
        <?php echo $form->labelEx($model, 'payment_method', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
        <div class="col-xs-10 w3-form-field">
            <?php echo $form->dropDownList($model, 'payment_method', ActiveRecord::statusPaymentMethod(), array('class' => 'form-control w3-form-input')); ?>
            <?php echo $form->error($model, 'payment_method'); ?>
        </div>
    </div>
    <div class="form-group w3-form-group">
        <?php echo $form->labelEx($model, 'transport_method', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="col-xs-10 w3-form-field">
            <?php echo $form->dropDownList($model, 'transport_method', ActiveRecord::transportMethod(), array('class' => 'form-control w3-form-input')); ?>
            <?php echo $form->error($model, 'transport_method'); ?>
        </div>
    </div>

    <div class="w3-form-group form-group">
        <div class=" col-xs-12 w3-form-button">
            <div class="registered-action">
                <button type="button" class="btn btn-primary" onclick="submit_print_picture_form();"><span>Đặt hàng</span></button>
            </div>
        </div>
    </div>

    <?php
    $this->endWidget();
    ?>

    <script>
        function submit_print_picture_form() {
            document.getElementById("print-picture-form").submit();
            return false;
        }
    </script>
</div>
