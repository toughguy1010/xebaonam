<?php
$year = isset($year) ? (int) $year : (int) date('Y');
$monthsInYear = ClaDateTime::getMonths();
$dayOffs = isset($dayOffs) ? $dayOffs : SeDaysoff::getDaysOff(array('provider_id' => SeDaysoff::provide_id_null, 'parent_id' => SeDaysoff::parent_id_null, 'keyField' => 'id'));
?>
<div class="box-setting-calendar">
    <div class="calendar-year">
        <p class="box-center">
            <button class="btn btn-default changeYear" type="button" href="<?php echo Yii::app()->createUrl('service/setting/getcalendar', array('year' => $year, 'type' => 'prev')) ?>">
                <i class="icon-angle-left"></i>
            </button>
            <span><?php echo $year ?></span>
            <button class="btn btn-default changeYear" type="button" href="<?php echo Yii::app()->createUrl('service/setting/getcalendar', array('year' => $year, 'type' => 'next')) ?>">
                <i class="icon-angle-right"></i>
            </button>
        </p>
    </div>
    <div class="calendar-month">
        <div class="row">
            <?php foreach ($monthsInYear as $monthIndex => $month) { ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="item-calendar-month">
                        <h2><?php echo $month; ?></h2>
                        <?php
                        $daysInMonth = ClaDateTime::get_days_in_month($monthIndex, $year);
                        $firstDayIndex = (int) key(ClaDateTime::getDaysOfWeekFromDate('1-' . $monthIndex . '-' . $year));
                        ?>
                        <div class="calendar-day">
                            <div class="dow"><?php echo ClaDateTime::getDayTextFromIndex(1, array('short' => true)); ?></div>
                            <div class="dow"><?php echo ClaDateTime::getDayTextFromIndex(2, array('short' => true)); ?></div>
                            <div class="dow"><?php echo ClaDateTime::getDayTextFromIndex(3, array('short' => true)); ?></div>
                            <div class="dow"><?php echo ClaDateTime::getDayTextFromIndex(4, array('short' => true)); ?></div>
                            <div class="dow"><?php echo ClaDateTime::getDayTextFromIndex(5, array('short' => true)); ?></div>
                            <div class="dow"><?php echo ClaDateTime::getDayTextFromIndex(6, array('short' => true)); ?></div>
                            <div class="dow"><?php echo ClaDateTime::getDayTextFromIndex(0, array('short' => true)); ?></div>
                            <?php
                            $beforeDay = ($firstDayIndex == 0) ? 6 : $firstDayIndex - 1;
                            if ($beforeDay > 0) {
                                $daysInMonthBefore = ($monthIndex == 1) ? ClaDateTime::get_days_in_month(12, $year - 1) : ClaDateTime::get_days_in_month($monthIndex - 1, $year);
                                for ($j = 1; $j <= $beforeDay; $j++) {
                                    ?>
                                    <div class="day old"><?php echo $daysInMonthBefore - $beforeDay + $j; ?></div>
                                <?php } ?>
                            <?php } ?>
                            <?php
                            for ($i = 1; $i <= $daysInMonth; $i++) {
                                $date = $i . '-' . $monthIndex . '-' . $year;
                                $isOff = SeDaysoff::isDayOff($date, array('dayOffs' => $dayOffs));
                                $repeat = isset($dayOffs[$isOff]) ? $dayOffs[$isOff]['repeat'] : 0;
                                ?>
                                <div class="day <?php echo ($isOff) ? 'off' : ''; ?>">
                                    <a class="setoff" href="<?php echo Yii::app()->createUrl('service/setting/setdayoff') ?>" data-day="<?php echo $i ?>" data-month="<?php echo $monthIndex; ?>" data-year="<?php echo $year; ?>" <?php if ($isOff) { ?> data-off="1" data-id="<?php echo $isOff; ?>" <?php } ?> data-workrepeat="<?php echo $repeat; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php
                            $k = 1;
                            for ($m = $daysInMonth + $beforeDay; $m < 42; $m++) {
                                ?>
                                <div class="day old"><?php echo $k; ?></div>
                                <?php
                                $k++;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php if(!Yii::app()->request->isAjaxRequest){ ?>
<script type="text/javascript">
    jQuery(function () {
        jQuery(document).on('click', '.changeYear', function () {
            var _this = jQuery(this);
            var url = _this.attr('href');
            if (url) {
                jQuery.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'JSON',
                    beforeSend: function () {
                        w3ShowLoading(_this, 'right', 20, 0);
                    },
                    success: function (res) {
                        if (res.code==200 && res.html) {
                            jQuery('#holidays').html(res.html);
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
        jQuery(document).on('click', '.day .setoff', function () {
            var _this = jQuery(this);
            var workData = _this.data();
            var form = $("<form class='form-horizontal'></form>");
            var html = '<div class="checkbox"><label><input name="workoff" ' +
                    ((workData.off) ? 'checked="checked"' : '')
                    + ' type="checkbox" class="ace workoff" value="1"><span class="lbl"> <?php echo Yii::t('service', 'workoff_confirm_help_text'); ?></span></label></div>';
            html += '<div class="checkbox"><label><input name="repeat" '
                    + ((parseInt(workData.workrepeat) == 1) ? 'checked="checked"' : '')
                    + ' ' + ((workData.off) ? '' : 'disabled')
                    + ' type="checkbox" class="ace repeatyear" value="1"><span class="lbl"> <?php echo Yii::t('service', 'workoff_repeat_confirm_help_text'); ?></span></label></div>';
            form.append(html);
            var div = bootbox.dialog({
                message: form,
                size: 400,
                buttons: {
                    "save": {
                        "label": "<i class='icon-check'></i> <?php echo Yii::t('common', 'save'); ?>",
                        "className": "btn-sm btn-info",
                        "callback": function () {
                            var confirmData = {};
                            jQuery(this).closest('.bootbox').find('form').serializeArray().map(function (x) {
                                confirmData[x.name] = x.value;
                            });
                            if (confirmData.workoff || workData.id) {
                                var url = _this.attr('href');
                                if (url) {
                                    jQuery.ajax({
                                        url: url,
                                        data: jQuery.extend(confirmData, workData),
                                        type: 'POST',
                                        dataType: 'JSON',
                                        beforeSend: function () {
                                            w3ShowLoading(jQuery('#saveGeneral'), 'right', 20, 0);
                                        },
                                        success: function (res) {
                                            if (res.code) {
                                                switch (res.status) {
                                                    case 'deleted':
                                                        {
                                                            _this.data('id', null);
                                                            _this.data('off', null);
                                                            _this.closest('.day').removeClass('off');
                                                        }
                                                        break;
                                                    case 'updated':
                                                        {
                                                            _this.data('id', res.id);
                                                            _this.data('off', 1);
                                                            _this.data('workrepeat', res.repeat);
                                                        }
                                                        break;
                                                    case 'created':
                                                        {
                                                            _this.attr('data-id', res.id);
                                                            _this.attr('data-off', 1);
                                                            _this.attr('data-workrepeat', res.repeat);
                                                            _this.data('id', res.id);
                                                            _this.data('off', 1);
                                                            _this.data('workrepeat', res.repeat);
                                                            _this.closest('.day').addClass('off');
                                                        }
                                                        break;
                                                }
                                            }
                                            w3HideLoading();
                                        },
                                        error: function () {
                                            w3HideLoading();
                                        }
                                    });
                                }
                            }
                        }
                    },
                    "close": {
                        "label": "<i class='icon-remove'></i> <?php echo Yii::t('common', 'close'); ?>",
                        "className": "btn-sm"
                    }
                }

            });
            return false;
        });
        jQuery(document).on('change', '.workoff', function () {
            if ($(this).is(':checked')) {
                jQuery('.repeatyear').removeAttr('disabled');
            } else {
                jQuery('.repeatyear').attr("disabled", true);
            }
        });
    });
</script>
<?php } ?>