<div class="form" style="margin: 10px;">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'widgets-form',
        'action' => Yii::app()->createUrl('widget/widget/create', array('wkey' => $wkey)),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'form-horizontal widget-form'),
    ));
    ?>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'wtype', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9">
            <?php
            $modules = Widgets::getWidgetTypes();
            ksort($modules[Yii::t('widget', 'widget_system')]);
            ?>
            <?php echo $form->dropDownList($model, 'wtype', $modules, array('class' => 'form-control', 'style' => 'width: 100%;')); ?>
            <?php echo $form->error($model, 'wtype'); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'wname', array('class' => 'col-sm-3 col-sm-3 control-label no-padding')); ?>
        <div class="col-sm-9">
            <?php echo $form->textField($model, 'wname', array('class' => 'form-control', 'style' => 'width: 100%;')); ?>
            <?php echo $form->error($model, 'wname'); ?>
        </div>
    </div>
    <div class="form-group" <?php if(!ClaSite::isSupperAdminSession()){ ?>style="display: none;" <?php } ?>>
        <?php echo $form->labelEx($model, 'wposition', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9">
            <?php echo $form->dropDownList($model, 'wposition', Widgets::getAllowPositionTitle(), array('class' => 'form-control', 'style' => 'width: 100%;')); ?>
            <?php echo $form->error($model, 'wposition'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?php echo CHtml::submitButton(Yii::t('common', 'save'), array('class' => 'btn btn-primary', 'id' => 'savewidget')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->