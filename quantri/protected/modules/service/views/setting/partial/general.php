<?php
$model = isset($GeneralModel) ? $GeneralModel : new GeneralModel();
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'general-form',
    'action' => Yii::app()->createUrl('service/setting/general'),
    'htmlOptions' => array(
        'class' => 'form-horizontal', 'enctype' => 'multipart/form-data',
    ),
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
        ));
?>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'time_slot_length', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
    <div class="controls col-sm-9">
        <?php echo $form->dropDownList($model, 'time_slot_length', ClaService::getTimeSlotLengthArr(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'time_slot_length'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'appointment_status_default', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
    <div class="controls col-sm-9">
        <?php echo $form->dropDownList($model, 'appointment_status_default', SeAppointments::appointmentStatus(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'appointment_status_default'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'date_delay', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
    <div class="controls col-sm-9">
        <?php echo $form->numberField($model, 'date_delay', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'date_delay'); ?>
    </div>
</div>
<div class="control-group form-group buttons">
    <?php echo CHtml::submitButton(Yii::t('common', 'save'), array('class' => 'btn btn-info', 'id' => 'saveGeneral')); ?>
</div>

<script type="text/javascript">
    jQuery(function () {
        jQuery('#general-form').on('submit', function () {
            var _this = jQuery(this);
            var url = _this.attr('action');
            if (url) {
                jQuery.ajax({
                    url: url,
                    data: _this.serialize(),
                    type: 'POST',
                    dataType: 'JSON',
                    beforeSend: function () {
                        w3ShowLoading(jQuery('#saveGeneral'), 'right', 20, 0);
                    },
                    success: function (res) {
                        if (res.code == 200) {
                            if (res.message) {
                                var dialog = bootbox.dialog({
                                    size: 450,
                                    message: res.message

                                });
                                setTimeout(function () {
                                    dialog.modal('hide');
                                    window.location.href=window.location.href;
                                }, 1000);
                            }
                        }
                        w3HideLoading();
                    },
                    error: function () {
                        w3HideLoading();
                    }
                });
            }
            return false;
        });
    });
</script>
<?php $this->endWidget(); ?>