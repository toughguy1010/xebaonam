<?php
//
$category = new ClaCategory();
$category->type = ClaCategory::CATEGORY_NEWS;
$category->generateCategory();
//
$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP);
unset($option[0]);
//
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        CKEDITOR.replace("News_news_desc", {
            height: 400,
            language: 'vi'
        });
    });
</script>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'news-form',
        'htmlOptions' => array('class' => 'form-horizontal'),
        'enableAjaxValidation' => false,
    ));
    ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'news_title', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'news_title', array('class' => 'span12')); ?>
            <?php echo $form->error($model, 'news_title'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'news_category_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'news_category_id', $option, array('class' => 'span12')); ?>
            <?php echo $form->error($model, 'news_category_id'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'news_sortdesc', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'news_sortdesc', array('class' => 'span12')); ?>
            <?php echo $form->error($model, 'news_sortdesc'); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'news_desc', array('class' => 'control-label')); ?>
        <div class="controls">
            <div class="span12">
                <?php echo $form->textArea($model, 'news_desc', array('class' => 'span12')); ?>
                <?php echo $form->error($model, 'news_desc'); ?>
            </div>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'news_hot', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->checkBox($model, 'news_hot'); ?>
            <?php echo $form->error($model, 'news_hot'); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'avatar', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'avatar', array('class' => 'span12')); ?>
            <?php echo $form->error($model, 'avatar'); ?>
        </div>
    </div>


    <div class="control-group">
        <?php echo $form->labelEx($model, 'meta_kerwords', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'meta_kerwords', array('class' => 'span12')); ?>
            <?php echo $form->error($model, 'meta_kerwords'); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'meta_description', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'meta_description', array('class' => 'span12')); ?>
            <?php echo $form->error($model, 'meta_description'); ?>
        </div>
    </div>


    <div class="control-group">
        <?php echo $form->labelEx($model, 'status', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12')); ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'news_source', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'news_source', array('class' => 'span12')); ?>
            <?php echo $form->error($model, 'news_source'); ?>
        </div>
    </div>

    <div class="control-group buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('news', 'news_create') : Yii::t('news', 'news_edit'), array('class' => 'btn btn-info')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->