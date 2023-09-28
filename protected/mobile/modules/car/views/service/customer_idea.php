<div class="buycar registered-news clearfix">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'customer-idea-form',
        'action' => Yii::app()->createUrl('car/service/customerIdea', array('id' => $form_id)),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form'),
    ));
    ?>
    <div class="from-left">
        <div class="form-group w3-form-group pop-ng  ">
            <span class="width-td">HỌ TÊN</span>
            <div class=" w3-form-field width-r ">
                <?php echo $form->textField($model, 'user_name', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('car', 'user_name'))); ?>
                <?php echo $form->error($model, 'user_name'); ?>
            </div>
        </div>

        <div class="form-group w3-form-group pop-ng  ">
            <span class="width-td">EMAIL</span>
            <div class=" w3-form-field width-r ">
                <?php echo $form->textField($model, 'email', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'email'))); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>

        <div class="form-group w3-form-group pop-ng  ">
            <span class="width-td">SỐ ĐIỆN THOẠI</span>
            <div class=" w3-form-field width-r ">
                <?php echo $form->textField($model, 'phone', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'phone'))); ?>
                <?php echo $form->error($model, 'phone'); ?>
            </div>
        </div>
    </div>
    <div class="from-right">
        <div class="form-group w3-form-group pop-ng  ">
            <span class="width-td">TIÊU ĐỀ</span>
            <div class=" w3-form-field width-r ">
                <?php echo $form->textField($model, 'title', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('car', 'title'))); ?>
                <?php echo $form->error($model, 'title'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group pop-ng ">
            <span class=" width-td">Ý KIẾN </span> 
            <div class=" w3-form-field width-r ">
                <?php echo $form->textArea($model, 'content', array('class' => 'form-control w3-form-input input-textarea', 'placeholder' => Yii::t('car', 'content'))); ?>
                <?php echo $form->error($model, 'content'); ?>
            </div>
        </div>

        <div class="w3-form-group form-group">
            <div class=" w3-form-button clearfix">
                <div class="registered-action1">
                    <button type="submit" class="btn btn-primary"><span>Gửi </span></button>
                </div>
            </div>
        </div>
    </div>
    <?php
    $this->endWidget();
    ?>
</div>