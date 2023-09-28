<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('car', 'create') : Yii::t('car', 'update'); ?>
        </h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'receipt-fee-form',
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
                        <?php echo $form->labelEx($model, 'number_plate_fee', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'number_plate_fee', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'number_plate_fee'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'registration_fee', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'registration_fee', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'registration_fee'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'inspection_fee', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'inspection_fee', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'inspection_fee'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'road_toll', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'road_toll', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'road_toll'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'insurance_fee', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'insurance_fee', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'insurance_fee'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('car', 'create') : Yii::t('car', 'update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
