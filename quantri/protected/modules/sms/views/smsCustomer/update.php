<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('sms', 'customer_create') : Yii::t('sms', 'customer_update'); ?>
        </h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'sms-customer-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'name', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'phone', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'phone'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'group_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            echo $form->dropDownList($model, 'group_id', $option_group, array('class' => 'span10 col-sm-12'));
                            ?>
                            <?php echo $form->error($model, 'group_id'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('sms', 'customer_create') : Yii::t('sms', 'customer_update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
