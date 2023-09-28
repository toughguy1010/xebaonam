<div class="form" style="margin: 10px;">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'widget-config-form',
        'action' => Yii::app()->createUrl('widget/widget/saveconfig', array('pwid' => $model->page_widget_id)),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'form-horizontal widget-form'),
    ));
    ?>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'widget_title', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9">
            <?php echo $form->textField($model, 'widget_title', array('class' => 'form-control ckeditor', 'style' => 'width: 100%;')); ?>
            <?php echo $form->error($model, 'widget_title'); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'limit', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9">
            <?php echo $form->textField($model, 'limit', array('class' => 'form-control', 'style' => 'width: 100%;')); ?>
            <?php echo $form->error($model, 'limit'); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'itemslimit', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9">
            <?php echo $form->textField($model, 'itemslimit', array('class' => 'form-control', 'style' => 'width: 100%;')); ?>
            <?php echo $form->error($model, 'itemslimit'); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'onlyisHot', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9">
            <?php echo $form->checkBox($model, 'onlyisHot'); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'show_wiget_title', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9">
            <?php echo $form->checkBox($model, 'show_wiget_title'); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'showallpage', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9">
            <?php echo $form->checkBox($model, 'showallpage'); ?>
        </div>
    </div>

    <div class="form-group buttons">
        <div class="col-sm-offset-3 col-sm-9">
            <?php echo CHtml::submitButton(Yii::t('common', 'save'), array('class' => 'btn btn-primary', 'id' => 'savewidgetconfig')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->