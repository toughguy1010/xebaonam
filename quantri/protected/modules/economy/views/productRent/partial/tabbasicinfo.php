<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        CKEDITOR.replace("ProductGroups_description", {
            height: 200,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
</script>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<?php if (!$model->isNewRecord) { ?>
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'alias', array('class' => 'span10 col-sm-12')); ?>
            <?php echo $form->error($model, 'alias'); ?>
        </div>
    </div>
<?php } ?>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'showinhome', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'showinhome'); ?>
        <?php echo $form->error($model, 'showinhome'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'meta_keywords', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'meta_keywords', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'meta_keywords'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'meta_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'meta_description', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'meta_description'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'meta_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'meta_title', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'meta_title'); ?>
    </div>
</div>
<div class="form-group no-margin-left ">
    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('product', 'product_group_create') : Yii::t('product', 'product_group_update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
</div>