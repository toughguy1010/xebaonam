<div class="registration-right">
    <?php if ($show_widget_title) { ?>
        <div class="title-cmr">
            <h2> 
                <a href="javascript:void(0)" title="<?php echo $widget_title ?>"><?php echo $widget_title ?></a> 
                <span class="triangle"></span>
            </h2>
        </div>
    <?php } ?>
    <div class="newsletters">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'newsletter-form',
            'action' => Yii::app()->createUrl('site/site/receivenewsletter'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'htmlOptions' => array('class' => 'form-horizontal newsletter-form'),
        ));
        ?>
        <div class="form-group no-margin-left no-margin-right name">
            <div class="title-registration"> <span>Họ và tên:</span> </div>
            <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('name'), 'title' => $model->getAttributeLabel('name'))); ?>
            <div style="width: 193px;margin-left: 119px;">
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class="form-group no-margin-left no-margin-right">
            <div class="title-registration"> <span>Email:</span></div>
            <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('email'), 'title' => $model->getAttributeLabel('email'))); ?>
            <div style="width: 193px;margin-left: 119px;">
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>
        <div class="form-group no-margin-left no-margin-right">
            <?php echo CHtml::submitButton(Yii::t('common', 'signup'), array('class' => 'btn btn-sm', 'id' => 'newslettersubmit', 'style' => '')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
