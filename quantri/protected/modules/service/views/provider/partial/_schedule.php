<?php
$businessHours = isset($businessHours) ? $businessHours : array();
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'businesshours-form',
    'action' => Yii::app()->createUrl('service/provider/businesshours', array('provider_id' => $model->id)),
    'htmlOptions' => array(
        'class' => 'form-horizontal', 'enctype' => 'multipart/form-data',
    ),
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
        ));
$timeOptions = ClaService::getWorkTimeInDay();
?>
<div class="col-sm-9">
    <?php
    foreach ($businessHours as $dayIndex => $schedule) {
        $hidden = (!$schedule['start_time'] || !$schedule['end_time']) ? 'hidden' : '';
        ?>

        <div class="item-breaktime">
            <div class="header-services-staff">
                <label class=" width-50">
                    <?php echo ClaDateTime::getDayTextFromIndex($dayIndex); ?>
                </label>
                <label><?php echo Yii::t('service', 'breaks'); ?></label>
            </div>
            <div class="item-services-staff">
                <div class="time-services width-50 pad-15 bsTime">
                    <div class="controls col-sm-4 sstime">
                        <?php echo CHtml::dropDownList("BusinessHours[$dayIndex][start_time]", $schedule['start_time'], $timeOptions, array('class' => 'form-control')); ?>
                    </div>
                    <div class="controls col-sm-2 text-center sto <?php echo $hidden; ?>">
                        <?php echo Yii::t('common', 'to'); ?>
                    </div>
                    <div class="controls col-sm-4 setime <?php echo $hidden; ?>">
                        <?php echo CHtml::dropDownList("BusinessHours[$dayIndex][end_time]", $schedule['end_time'], $timeOptions, array('class' => 'form-control')); ?>
                    </div>
                    <?php
                    echo CHtml::hiddenField("BusinessHours[$dayIndex][id]", $schedule['id']);
                    ?>
                </div>
                <?php
                $timeBreakOptions = ClaArray::removeFirstElement($timeOptions);
                $timeLenght = ClaService::getTimeSlotLength();
                ?>
                <div class="breaktime width-50">
                    <div class="add-break-time pad-15">
                        <?php
                        $listBreakTimeModel = SeProviderScheduleBreaks::model()->findAllByAttributes(array(
                            'site_id' => Yii::app()->controller->site_id,
                            'provider_schedule_id' => $schedule['id'],
                        ));
                        ?>
                        <div class="listBreak">
                            <?php foreach ($listBreakTimeModel as $breakTime) { ?>
                                <?php $this->renderPartial('partial/_breakTimeBox', array('model' => $breakTime)); ?>
                            <?php } ?>
                        </div>
                        <button type="button" class="btn btn-success left btn-addbreaktime">
                            <i class="icon-plus"></i> <?php echo Yii::t('service', 'add_breaks') ?>
                        </button>
                        <div class="box-addbreak-time bsTime hidden">
                            <div class="controls col-sm-5 sstime">
                                <?php echo CHtml::dropDownList("BreakTime[start_time]", $schedule['start_time'] + $timeLenght, $timeBreakOptions, array('class' => 'form-control')); ?>
                            </div>
                            <div class="controls col-sm-2 text-center sto">
                                <?php echo Yii::t('common', 'to'); ?>
                            </div>
                            <div class="controls col-sm-5 setime">
                                <?php echo CHtml::dropDownList("BreakTime[end_time]", $schedule['start_time'] + $timeLenght * 2, $timeBreakOptions, array('class' => 'form-control')); ?>
                            </div>
                            <?php
                            echo CHtml::hiddenField("BreakTime[schedule_id]", $schedule['id']);
                            ?>
                            <span class="boder-bottom-form"></span>
                            <div class="form-group right width-100">
                                <button class="btn btn-default stl_btn_remove btn-close-box show-input" style="float:right ;margin-left:15px;"><?php echo Yii::t('common', 'close'); ?></button>
                                <button class="btn btn-primary btnSave" style="float:right ;margin-left:15px;"><?php echo Yii::t('common', 'save'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <span class="boder-bottom-form"></span>
    <div class="form-group right width-100">
        <?php echo CHtml::submitButton(Yii::t('common', 'save'), array('style' => 'margin-right:15px;', 'class' => 'btn btn-info pull-right', 'id' => 'saveBusinessHours')); ?>
    </div>
</div>
<script type="text/javascript">
    jQuery(function () {
        jQuery(document).on('click', '.add-break-time .btn-addbreaktime', function () {
            jQuery('.box-addbreak-time').addClass('hidden');
            jQuery(this).closest('.add-break-time').find('.box-addbreak-time').removeClass('hidden');
            return false;
        });
        jQuery(document).on('click', '.add-break-time .stl_btn_remove', function () {
            jQuery(this).closest('.add-break-time').find('.box-addbreak-time').addClass('hidden');
            return false;
        });
        jQuery(document).on('click', '.add-break-time .btnSave', function () {
            var _this = jQuery(this);
            var _data = jQuery(this).closest('.add-break-time').find(':input').serialize();
            jQuery.ajax({
                url: '<?php echo Yii::app()->createUrl('service/provider/addbreaktime', array('provider_id' => $model->id)); ?>',
                data: _data,
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    w3ShowLoading(_this, 'right', 20, 0);
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
                        if (res.code == 200) {
                            _this.closest('.add-break-time').find('.box-addbreak-time').addClass('hidden');
                            if(res.breakTimeBox){
                                _this.closest('.add-break-time').find('.listBreak').append(res.breakTimeBox);
                            }
                        }
                    }
                    w3HideLoading();
                },
                error: function () {
                    w3HideLoading();
                }
            });
            return false;
        });
        jQuery(document).on('click', '.btnDeleteBreak', function () {
            var _this = jQuery(this);
            var _url = _this.attr('href');
            if (_url) {
                bootbox.confirm("<?php echo Yii::t('notice','areyousuredelete'); ?>", function (result) {
                    if (result) {
                        jQuery.ajax({
                            url: _url,
                            type: 'POST',
                            dataType: 'JSON',
                            beforeSend: function () {
                                w3ShowLoading(_this, 'right', 20, 0);
                            },
                            success: function (res) {
                                if (res.code == 200) {
                                    _this.closest('.breakTime').remove();
                                }
                                w3HideLoading();
                            },
                            error: function () {
                                w3HideLoading();
                            }
                        });
                    }
                });
            }
            return false;
        });
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