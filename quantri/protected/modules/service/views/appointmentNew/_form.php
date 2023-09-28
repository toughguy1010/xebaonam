<?php
//
$providers = isset($providers) ? $providers : SeProviders::getProviders();
$services = isset($services) ? $services : SeServices::getServices();
$providerOptions = array('' => "") + ClaArray::builOptions($providers, 'id', 'name');
$serviceOptions = array('' => "") + ClaArray::builOptions($services, 'id', 'name');
$timeOptions = ClaService::getWorkTimeInDay(array('none' => false));
//
?>  
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'news-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'dob', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php
                $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                    'model' => $model, //Model object
                    'name' => 'SeAppointmentsNew[dob]', //attribute name
                    'mode' => 'date', //use "time","date" or "datetime" (default)
                    'value' => ((int) $model->dob > 0) ? date('d-m-Y', (int) $model->dob) : date('d-m-Y'),
                    'language' => 'vi',
                    'options' => array(
                        'showSecond' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'timeFormat' => 'HH:mm:ss',
                        'controlType' => 'select',
                        'stepHour' => 1,
                        'stepMinute' => 1,
                        'stepSecond' => 1,
                        //'showOn' => 'button',
                        'showSecond' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'tabularLevel' => null,
                    //'addSliderAccess' => true,
                    //'sliderAccessArgs' => array('touchonly' => false),
                    ), // jquery plugin options
                    'htmlOptions' => array(
                        'class' => 'span12 col-sm-12',
                    )
                ));
                ?>
                <?php echo $form->error($model, 'dob'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'email', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'phone', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'phone'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'profile_number', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'profile_number', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'profile_number'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'provider_name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'provider_name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'provider_name'); ?>
            </div>
        </div>
        <?php
        $stores = ShopStore::getShopstoreLocation(array('limit' => 10));
        $options_store = [];
        foreach ($stores as $store) {
            $options_store[$store['id']] = $store['name'];
        }
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'description'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'store_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'store_id', $options_store, array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'store_id'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'time_appointment', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'time_appointment', ['' => 'Chọn thời gian khám'] + SeAppointmentsNew::timeAppointmentArr(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'time_appointment'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'date_appointment', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php
                $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                    'model' => $model, //Model object
                    'name' => 'SeAppointmentsNew[date_appointment]', //attribute name
                    'mode' => 'date', //use "time","date" or "datetime" (default)
                    'value' => ((int) $model->date_appointment > 0) ? date('d-m-Y', (int) $model->date_appointment) : date('d-m-Y H:i:s'),
                    'language' => 'vi',
                    'options' => array(
                        'showSecond' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'timeFormat' => 'HH:mm:ss',
                        'controlType' => 'select',
                        'stepHour' => 1,
                        'stepMinute' => 1,
                        'stepSecond' => 1,
                        //'showOn' => 'button',
                        'showSecond' => true,
                        'changeMonth' => true,
                        'changeYear' => false,
                        'tabularLevel' => null,
                    //'addSliderAccess' => true,
                    //'sliderAccessArgs' => array('touchonly' => false),
                    ), // jquery plugin options
                    'htmlOptions' => array(
                        'class' => 'span12 col-sm-12',
                    )
                ));
                ?>
                <?php echo $form->error($model, 'date_appointment'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'status', SeAppointmentsNew::appointmentStatus(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('service', 'appointment_create') : Yii::t('service', 'appointment_edit'), array('class' => 'btn btn-primary pull-right', 'id' => 'saveappointment')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>