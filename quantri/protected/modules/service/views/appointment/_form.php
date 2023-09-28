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
            <?php echo $form->labelEx($model, 'provider_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'provider_id', $providerOptions, array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'provider_id'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'service_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'service_id', $serviceOptions, array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'service_id'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'date', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php
                $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                    'model' => $model, //Model object
                    'attribute' => 'date', //attribute name
                    'mode' => 'date', //use "time","date" or "datetime" (default)
                    'value' => ($model->date) ? date('d-m-Y', (int) strtotime($model->date)) : date('d-m-Y'),
                    'language' => Yii::app()->language,
                    'options' => array(
                        //'minDate' => '+0',
                        'showSecond' => true,
                        'dateFormat' => 'dd-mm-yy',
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
                <?php echo $form->error($model, 'date'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'status', SeAppointments::appointmentStatus(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'start_time', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <div class="form-group no-margin-left bsTime">
                    <div class="controls col-sm-4 sstime">
                        <?php echo $form->dropDownList($model, "start_time", ClaService::insertWorkTimeDuration($timeOptions, array('time'=>$model->start_time)), array('class' => 'form-control')); ?>
                    </div>
                    <div class="controls col-sm-1 text-center sto">
                        <?php echo Yii::t('common', 'to'); ?>
                    </div>
                    <div class="controls col-sm-4 setime">
                        <?php echo $form->dropDownList($model, "end_time", ClaService::insertWorkTimeDuration($timeOptions, array('time'=>$model->end_time)), array('class' => 'form-control')); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'internal_note', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'internal_note', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'internal_note'); ?>
            </div>
        </div>
        <?php if(!$model->isNewRecord && $model->total>0){ ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'total', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <strong><?=  SeServices::getCurrencyText().$model->total?></strong>
            </div>
        </div>
        <?php } ?>
        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('service', 'appointment_create') : Yii::t('service', 'appointment_edit'), array('class' => 'btn btn-primary pull-right', 'id' => 'saveappointment')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
<script type="text/javascript">
    jQuery(document).on('change', '.sstime select', function () {
        var sval = parseInt(jQuery(this).val());
        var bsTime = jQuery(this).closest('.bsTime');
        if (sval > 0) {
            bsTime.find('.sto').removeClass('hidden');
            bsTime.find('.setime').removeClass('hidden');
            var seOptions = bsTime.find('.setime select option');
            var seVal = bsTime.find('.setime select').val();
            var sselected = (seVal > sval) ? true : false;
            if (!sselected) {
                bsTime.find('.setime select').children('option').removeAttr("selected");
            }
            seOptions.each(function (index, option) {
                var opVal = parseInt(jQuery(option).val());
                if (opVal <= sval) {
                    jQuery(option).addClass('hidden');
                } else {
                    jQuery(option).removeClass('hidden');
                    if (!sselected) {
                        jQuery(option).attr('selected', 'selected');
                        sselected = true;
                    }
                }
            });
        } else {
            bsTime.find('.sto').addClass('hidden');
            bsTime.find('.setime').addClass('hidden');
        }
    });
</script>