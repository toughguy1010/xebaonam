<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'district-form',
        'enableAjaxValidation'=>true,
)); ?>
        <div class="row">
                <?php echo $form->labelEx($model,'country_id'); ?>
                <?php echo $form->dropDownList($model,'country_id',CHtml::listData(Country::model()->findAll(), 'country_id', 'country_id'),array('prompt'=>'---Chọn quốc gia---',
                    'ajax'=>array('type'=>'POST','url'=>CController::createUrl('FilterCountry/dynamiccountry'),'update'=>'#'.CHtml::activeId($model,'region_id'))));?>
                <?php echo $form->error($model,'country_id'); ?>
        </div>

        <div class="row">
                <?php echo $form->labelEx($model,'region_id'); ?>
                <?php echo $form->dropDownList($model,'region_id',array('prompt'=>'---Chọn tỉnh/thành---'),array('ajax'=>array('type'=>'POST','url'=>CController::createUrl('FilterCountry/dynamicregion'),'update'=>'#'.CHtml::activeId($model,'district_id'))));?>
                <?php echo $form->error($model,'region_id'); ?>
        </div>

        <div class="row">
                <?php echo $form->labelEx($model,'district_id'); ?>
                <?php echo $form->dropDownList($model,'district_id',array('prompt'=>'---Chọn quận/huyện---')); ?>
                <?php echo $form->error($model,'district_id'); ?>
        </div>
    <?php $this->endWidget(); ?>