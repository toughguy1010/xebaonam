<?php
$form = $this->beginWidget('CActiveForm', array(
    'method' => 'POST',
    'id' => 'comment-form',
    'action' => Yii::app()->createUrl('economy/comment/adminrep', array('id' => $answer->comment_id)),
    'htmlOptions' => array('class' => 'form-horizontal'),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
        ));
?>
<div class="col-xs-12 no-padding">
    <div class="widget-main">
        <div class="form-group no-margin-left">
            <?php echo $form->labelEx($answer, 'content', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($answer, 'content', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($answer, 'content'); ?>
            </div>
        </div>
        <div class="widget-toolbar no-border">
            <div class="control-group form-group buttons">
                <?php echo CHtml::submitButton(Yii::t('comment', 'reply'), array('class' => 'btn btn-info')); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>