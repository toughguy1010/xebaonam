<?php
$year = isset($year) ? $year : (int) date('Y');
$currentDay = (int) date('d');
$currentDate = date('Y-m-d');
$currentMonth = (int) date('m');
$monthIndex = (isset($time) && $time) ? $time : $currentMonth;
$daysInMonth = ClaDateTime::get_days_in_month($monthIndex, $year);
$firstDayIndex = (int) key(ClaDateTime::getDaysOfWeekFromDate('1-' . $monthIndex . '-' . $year));
$services = array();
$providers = array();
?>
<div id="calendar" class="fc fc-ltr">
    <table class="fc-header" style="width:100%">
        <tbody>
            <tr>
                <td class="fc-header-left">
                    <span class="fc-button fc-button-prev fc-state-default fc-corner-left" unselectable="on">
                        <?php
                        $preMonth = ($monthIndex == 1) ? 12 : ($monthIndex - 1);
                        ?>
                        <a href="<?php echo Yii::app()->createUrl('service/appointment/dashboard', array_merge($params, array('time' => $preMonth))); ?>">
                            <i class="icon-chevron-left"></i>
                        </a>
                    </span>
                    <span class="fc-button fc-button-next fc-state-default fc-corner-right" unselectable="on">
                         <?php
                        $nextMonth = ($monthIndex == 12) ? 1 : ($monthIndex + 1);
                        ?>
                        <a href="<?php echo Yii::app()->createUrl('service/appointment/dashboard', array_merge($params, array('time' => $nextMonth))); ?>">
                            <i class="icon-chevron-right"></i>
                        </a>
                    </span>
                    <span class="fc-header-space"></span>
<!--                    <span class="fc-button fc-button-today fc-state-default fc-corner-left fc-corner-right fc-state-disabled" unselectable="on">today</span>-->
                </td>
                <td class="fc-header-center">
                    <span class="fc-header-title">
                        <h2><?php echo ClaDateTime::getMonthText($monthIndex) . ' ' . $year; ?></h2>
                    </span>
                </td>
                <td class="fc-header-right">
                    <span class="fc-button fc-button-month fc-state-default fc-corner-left fc-state-active" unselectable="on">Month</span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="fc-content" style="position: relative;">
        <div class="fc-view fc-view-month fc-grid" style="position:relative" unselectable="on">
            <table class="fc-border-separate" style="width:100%" cellspacing="0">
                <thead>
                    <tr class="fc-first fc-last">
                        <th class="fc-day-header fc-sun fc-widget-header fc-first" style="width:14.285%;">
                            <?php echo ClaDateTime::getDayTextFromIndex(1, array('short' => true)); ?>
                        </th>
                        <th class="fc-day-header fc-mon fc-widget-header" style="width:14.285%;">
                            <?php echo ClaDateTime::getDayTextFromIndex(2, array('short' => true)); ?>
                        </th>
                        <th class="fc-day-header fc-tue fc-widget-header" style="width:14.285%;">
                            <?php echo ClaDateTime::getDayTextFromIndex(3, array('short' => true)); ?>
                        </th>
                        <th class="fc-day-header fc-wed fc-widget-header" style="width:14.285%;">
                            <?php echo ClaDateTime::getDayTextFromIndex(4, array('short' => true)); ?>
                        </th>
                        <th class="fc-day-header fc-thu fc-widget-header" style="width:14.285%;">
                            <?php echo ClaDateTime::getDayTextFromIndex(5, array('short' => true)); ?>
                        </th>
                        <th class="fc-day-header fc-fri fc-widget-header" style="width:14.285%;">
                            <?php echo ClaDateTime::getDayTextFromIndex(6, array('short' => true)); ?>
                        </th>
                        <th class="fc-day-header fc-sat fc-widget-header fc-last" style="width:14.285%;">
                            <?php echo ClaDateTime::getDayTextFromIndex(0, array('short' => true)); ?>
                        </th>
                    </tr>
                </thead>
                <?php
                $countOfMonth = 1;
                ?>
                <tbody>
                    <tr class="fc-week fc-first">
                        <?php
                        $beforeDay = ($firstDayIndex == 0) ? 6 : $firstDayIndex - 1;
                        if ($beforeDay > 0) {
                            $daysInMonthBefore = ($monthIndex == 1) ? ClaDateTime::get_days_in_month(12, $year - 1) : ClaDateTime::get_days_in_month($monthIndex - 1, $year);
                            for ($j = 1; $j <= $beforeDay; $j++) {
                                $countOfMonth++;
                                ?>
                                <td class="fc-day fc-mon fc-widget-content fc-other-month fc-past">
                                    <div>
                                        <div class="fc-day-number"><?php echo $daysInMonthBefore - $beforeDay + $j; ?></div>
                                        <div class="fc-day-content">
                                            <div style="position: relative; height: 19px;">&nbsp;</div>
                                        </div>
                                    </div>
                                </td>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($countOfMonth % 7 == 0) { ?>
                        </tr>
                    <?php } ?>
                    <?php
                    for ($i = 1; $i <= $daysInMonth; $i++) {
                        $date = $year . '-' . (($monthIndex > 9) ? $monthIndex : '0' . $monthIndex) . '-' . (($i > 9) ? $i : '0' . $i);
                        $old = $countOfMonth % 7;
                        ?>
                        <?php if ($old == 1) { ?>
                            <tr class="fc-week">
                            <?php } ?>
                            <?php
                            $appointmentsForDate = isset($appointments[$date]) ? $appointments[$date] : array();
                            ?>
                            <td class="fc-day fc-sun fc-widget-content fc-future <?php if ($old == 1) { ?>fc-first<?php } elseif ($old == 0) { ?>fc-last<?php } ?> <?php if ($date == $currentDate) { ?>fc-today fc-state-highlight<?php } ?>" data-date="<?php echo $year . '-' . $monthIndex . '-' . $i ?>">
                                <div style="min-height: 105px;">
                                    <div class="fc-day-number"><?php echo $i; ?></div>
                                    <?php
                                    foreach ($appointmentsForDate as $app) {
                                        $service = isset($services[$app['service_id']]) ? $services[$app['service_id']] : SeServices::model()->findByPk($app['service_id']);
                                        if ($service) {
                                            $services[$app['service_id']] = $service;
                                        }
                                        $provider = isset($providers[$app['provider_id']]) ? $providers[$app['provider_id']] : SeProviders::model()->findByPk($app['provider_id']);
                                        if ($provider) {
                                            $providers[$app['provider_id']] = $provider;
                                        }
                                        $status = SeAppointments::appointmentStatus();
                                        $statusColor = SeAppointments::appointmentStatusColor();
                                        ?>
                                        <a href="<?php echo Yii::app()->createUrl('service/appointment/update', array('id' => $app['id'])); ?>" target="_blank" style="color:#fff;">
                                            <div class="fc-day-content">
                                                <div style="background-color: <?php echo $statusColor[$app['status']]; ?>;">
                                                    <p><strong><?php echo gmdate('h:i a', $app['start_time']) . ' - ' . gmdate('h:i a', $app['end_time']); ?></strong></p>
                                                    <?php if ($service) { ?>
                                                        <p><?php echo $service['name']; ?></p>
                                                    <?php } ?>
                                                    <?php if ($provider) { ?>
                                                        <p><?php echo $provider['name']; ?></p>
                                                    <?php } ?>
                                                    <p><?php echo Yii::t('common', 'status') . ' : ' . $status[$app['status']]; ?></p>
                                                </div>
                                            </div>
                                        </a>
                                    <?php } ?>
                                </div>
                            </td>
                            <?php if ($old == 0) { ?>
                            </tr>
                        <?php } ?>
                        <?php
                        $countOfMonth++;
                    }
                    ?>
                    <?php
                    $k = 1;
                    for ($m = $daysInMonth + $beforeDay; $m < 42; $m++) {
                        $old = $countOfMonth % 7;
                        ?>
                        <?php if ($old == 1) { ?>
                            <tr class="fc-week fc-last">
                            <?php } ?>
                            <td class="fc-day fc-wed fc-widget-content fc-other-month fc-future <?php if ($old == 1) { ?>fc-first<?php } elseif ($old == 0) { ?>fc-last<?php } ?>" data-date="2017-04-05">
                                <div style="min-height: 120px;">
                                    <div class="fc-day-number"><?php echo $k; ?></div>
                                    <div class="fc-day-content">
                                        <div style="position: relative; height: 0px;">&nbsp;</div>  
                                    </div>     
                                </div>
                            </td>
                            <?php if ($old == 0) { ?>
                            </tr>
                        <?php } ?>
                        <?php
                        $k++;
                        $countOfMonth++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

