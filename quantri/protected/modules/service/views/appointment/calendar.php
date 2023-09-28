<div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="row">
        <div class="col-sm-2">
            <div class="space"></div>
            <div class="widget-box transparent">
                <div class="widget-header">
                    <h4><?php echo Yii::t('service', 'provider'); ?></h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <div id="external-events">
                            <?php
                                $_params = $params;
                                unset($_params[ClaService::query_provider_key]);
                            ?>
                            <a href="<?php echo Yii::app()->createUrl('service/appointment/dashboard', $_params); ?>">
                                <div class="external-event <?php if (!$provider_id) { ?>label-info<?php } ?>" style="cursor: pointer;" data-class="label-grey" style="position: relative;">
                                    <i class="icon-user"></i>
                                    <?php echo Yii::t('common','all'); ?>
                                </div>
                            </a>
                            <?php
                            if ($providers) {
                                foreach ($providers as $pro) {
                                    ?>
                                    <a href="<?php echo Yii::app()->createUrl('service/appointment/dashboard', array_merge($params, array(ClaService::query_provider_key => $pro['id']))); ?>" style="cursor: pointer; display: block;">
                                        <div class="external-event label-grey <?php if ($provider_id==''.$pro['id']) { ?>label-info<?php } ?>" style="cursor: pointer;" data-class="label-grey" style="position: relative;">
                                            <i class="icon-user"></i>
                                            <?= $pro['name']; ?>
                                        </div>
                                    </a>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="space"></div>
            <?php
            $this->renderPartial('calendar_month', array(
                'appointments' => $appointments,
                'year' => $year,
                'params' => $params,
                'time' => $time,
            ));
            ?>
        </div>
    </div>
    <!-- PAGE CONTENT ENDS -->
</div>