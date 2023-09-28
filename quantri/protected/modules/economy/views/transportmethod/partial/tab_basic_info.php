<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
$arr = array('' => Yii::t('category', 'category_parent_0'));
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'tranport_name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'tranport_name', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'tranport_name'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'type', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php // echo $form->dropdown($model, 'unit', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->dropDownList($model, 'type', OrderTranports::TRANSPORT_TYPE_UNIT, array('class' => 'span12 col-sm-12'), array('options' => array('1' => array('selected' => true)))); ?>

        <?php echo $form->error($model, 'type'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'price', array('class' => 'col-sm-2 control-label no-padding-left ')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'price', array('class' => 'span12 col-sm-12 numberFormat')); ?>
        <?php echo $form->error($model, 'price'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'price_from', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'price_from', array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'price_to', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'price_to', array('class' => 'numberFormat col-sm-2')); ?>
        <?php echo $form->error($model, 'price_from', array(), true, false); ?>
        <?php echo $form->error($model, 'price_to', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'tranport_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'tranport_description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'tranport_description'); ?>
    </div>
</div>
