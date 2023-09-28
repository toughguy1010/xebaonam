<?php
$businessHours = isset($businessHours) ? $businessHours : array();
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'businesshours-form',
    'action' => Yii::app()->createUrl('service/setting/businesshours'),
    'htmlOptions' => array(
        'class' => 'form-horizontal', 'enctype' => 'multipart/form-data',
    ),
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
        ));
$timeOptions = ClaService::getWorkTimeInDay();
?>
<p class="alert alert-info">
    <?php echo Yii::t('service', 'business_hours_help_text'); ?>
</p>
<div class="col-sm-9">
    <?php
    foreach ($businessHours as $dayIndex => $hour) {
        $hidden = (!$hour['start_time'] || !$hour['end_time']) ? 'hidden' : '';
        ?>
        <label class="col-sm-12"><strong><?php echo ClaDateTime::getDayTextFromIndex($dayIndex); ?></strong></label>
        <div class="form-group no-margin-left bsTime">
            <div class="controls col-sm-4 sstime">
                <?php echo CHtml::dropDownList("BusinessHours[$dayIndex][start_time]", $hour['start_time'], $timeOptions, array('class' => 'form-control')); ?>
            </div>
            <div class="controls col-sm-1 text-center sto <?php echo $hidden; ?>">
                <?php echo Yii::t('common', 'to'); ?>
            </div>
            <div class="controls col-sm-4 setime <?php echo $hidden; ?>">
                <?php echo CHtml::dropDownList("BusinessHours[$dayIndex][end_time]", $hour['end_time'], $timeOptions, array('class' => 'form-control')); ?>
            </div>
        </div>
    <?php } ?>
    <div class="control-group form-group buttons">
        <?php echo CHtml::submitButton(Yii::t('common', 'save'), array('class' => 'btn btn-info', 'id' => 'saveBusinessHours')); ?>
    </div>
    <div class="form-group right width-100">
        <?php echo CHtml::submitButton(Yii::t('common', 'save'), array('class' => 'btn btn-info pull-right', 'id' => 'saveBusinessHours')); ?>
    </div>
</div>
<script type="text/javascript">
    jQuery(function () {
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
        jQuery('#businesshours-form').on('submit', function () {
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
                        if (res.code) {
                            if (res.message) {
                                var dialog = bootbox.dialog({
                                    size: 450,
                                    message: res.message

                                });
                                setTimeout(function () {
                                    dialog.modal('hide');
                                }, 2000);
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