<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        CKEDITOR.replace("Banners_description", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
</script>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12', 'placeholder' => 'Tên')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<?php
$bgroupoptions = [1 => 'Phòng họp chung', 2 => 'Quầy lễ tân', 3 => 'Bàn lãnh đạo', 4 => 'Bàn làm việc', 5 => 'Diện tích'];
?>
<div class="control-group form-group">
    <?php echo $form->label($model, 'type', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php if (!is_array($bgroupoptions)) $bgroupoptions = array(); ?>
        <?php echo $form->dropDownList($model, 'type', array('' => Yii::t('image', 'Loại')) + $bgroupoptions, array('class' => 'span12 col-sm-12', 'options' => $bgroupoptions['options'])); ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'from_area', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'from_area', array('class' => 'col-sm-5', 'placeholder' => 'Diện tích min')); ?>
        <?php echo $form->error($model, 'from_area'); ?>

        <?php echo $form->textField($model, 'to_area', array('class' => 'col-sm-5', 'placeholder' => 'Diện tích max')); ?>
        <?php echo $form->error($model, 'to_area'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'src', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'src', array('class' => 'span12 col-sm-12')); ?>
        <div class="row" style="margin: 10px 0px;">
            <?php if ($model->id && $model->src) { ?>
                <img src="<?= $model->src ?>" style="max-width: 200px;" width="200">
            <?php } ?>
            <?php echo CHtml::fileField('src', ''); ?>
        </div>
        <?php echo $form->error($model, 'src'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'link', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'link', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'link'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->label($model, 'order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'order', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'order'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->label($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'target', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownlist($model, 'target', array_reverse(Menus::getTagetArr()), array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'target'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'show', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <label>
            <?php echo $form->checkBox($model, 'actived', array('class' => 'ace ace-switch ace-switch-6')); ?>
            <span class="lbl"></span>
        </label>
    </div>
</div>
