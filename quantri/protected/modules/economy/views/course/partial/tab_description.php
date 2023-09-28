<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script type="text/javascript">
    var ta = true;
    jQuery(document).ready(function () {
        //
        CKEDITOR.replace("CourseInfo_description", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
    jQuery(function ($) {
    });
</script>

<script type="text/javascript">
    var tb = true;
    jQuery(document).ready(function () {
        //
        CKEDITOR.replace("Course_preferred", {
            height: 150,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
    jQuery(function ($) {
    });
</script>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'catalog', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'catalog', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'catalog'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'sort_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'sort_description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'sort_description'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($courseInfo, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($courseInfo, 'description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($courseInfo, 'description'); ?>
    </div>
</div>