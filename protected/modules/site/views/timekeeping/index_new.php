<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<div class="widget widget-box timekeeping" id="timekeeping">
    <div class="widget-header">
        <h4>
            Tính công: <?= $model['name'] ?>
        </h4>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <?php

                function sum_time() {
                    $i = 0;
                    foreach (func_get_args() as $time) {
                        if ($time) {
                            sscanf($time, '%d:%d', $hour, $min);
                            $i += $hour * 60 + $min;
                        }
                    }
                    if ($h = floor($i / 60)) {
                        $i %= 60;
                    }
                    return sprintf('%02d:%02d', $h, $i);
                }

                $arrDay = [
                    'Mon' => 'T2',
                    'Tue' => 'T3',
                    'Wed' => 'T4',
                    'Thu' => 'T5',
                    'Fri' => 'T6',
                    'Sat' => 'T7',
                    'Sun' => 'CN',
                ];
                if (isset($result_final) && $result_final) {
                    $first = reset($result_final);
                    $alldays = [];
                    foreach ($first as $item) {
                        $alldays[$item['date']] = $item['day'];
                    }
                    ?>
                    <div class="content-table">
                        <table class="table table-bordered" border="1" cellpadding="0" cellspacing="0" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
                            <colgroup>
                                <col width="39" />
                                <col width="152" />
                                <col width="26" />
                                <?php foreach ($alldays as $item) { ?>
                                    <col width="26" />
                                <?php } ?>
                                <col width="81" />
                                <col width="108" />
                            </colgroup>
                            <thead>
                            <tr>
                                <td colspan="1" rowspan="2">
                                    <p>STT</p>
                                </td>
                                <td colspan="1" rowspan="2">
                                    <p>HỌ VÀ TÊN</p>
                                </td>
                                <td colspan="1" rowspan="2">
                                    <p>CA</p>
                                </td>
                                <?php foreach ($alldays as $date => $day) { ?>
                                    <td style="<?= $day == 'Sun' ? 'background-color: #00ace3; color: #fff;' : '' ?>"><?= $arrDay[$day] ?></td>
                                <?php } ?>
                                <td colspan="1" rowspan="2">
                                    <p>TSC</p>
                                </td>
                                <td colspan="1" rowspan="2">
                                    <p>GHI CHÚ</p>
                                </td>
                            </tr>
                            <tr>
                                <?php
                                $tongso = 0;
                                foreach ($alldays as $date => $day) {
                                    if ($day != 'Sun') {
                                        if ($day == 'Sat') {
                                            $tongso += 1;
                                        } else {
                                            $tongso += 2;
                                        }
                                    }
                                    $date_temp = explode('-', $date);
                                    ?>
                                    <td style="<?= $day == 'Sun' ? 'background-color: #00ace3; color: #fff;' : '' ?>"><?= $date_temp[2] ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 0;
                            foreach ($result_final as $tennv => $items) {
                                if ($tennv) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td colspan="1" rowspan="4">
                                            <p><?= $i ?></p>
                                        </td>
                                        <td colspan="1" rowspan="4">
                                            <p><?= $tennv ?></p>
                                        </td>
                                        <td>S</td>
                                        <?php
                                        foreach ($items as $item) {
                                            ?>
                                            <td style="<?= $item['day'] == 'Sun' ? 'background-color: #00ace3; color: #fff;' : '' ?>">
                                                <?php
                                                if ($item['day'] != 'Sun') {
                                                    echo $item['morning'];
                                                } else {
                                                    echo '&nbsp;';
                                                }
                                                ?>
                                            </td>
                                        <?php } ?>
                                        <td >&nbsp;</td>
                                        <td colspan="1" rowspan="4">
                                            <p>TỔNG SỐ <?= $tongso ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>C</td>
                                        <?php
                                        foreach ($items as $item) {
                                            ?>
                                            <td style="<?= $item['day'] == 'Sun' ? 'background-color: #00ace3; color: #fff;' : '' ?>">
                                                <?php
                                                if ($item['day'] != 'Sun') {
                                                    echo $item['afternoon'];
                                                } else {
                                                    echo '&nbsp;';
                                                }
                                                ?>
                                            </td>
                                        <?php } ?>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>T</td>
                                        <?php
                                        foreach ($items as $item) {
                                            ?>
                                            <td style="<?= $item['day'] == 'Sun' ? 'background-color: #00ace3; color: #fff;' : '' ?>">
                                                <?php
                                                if ($item['morning'] || $item['afternoon']) {
                                                    echo sum_time($item['morning'], $item['afternoon']);
                                                } else {
                                                    echo '&nbsp;';
                                                }
                                                ?>
                                            </td>
                                        <?php } ?>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr style="background: green; color: #fff; font-weight: bold;">
                                        <td>=</td>
                                        <?php
                                        $tsc = 0;
                                        foreach ($items as $item) {
                                            ?>
                                            <td style="<?= $item['day'] == 'Sun' ? 'background-color: #00ace3; color: #fff;' : '' ?>">
                                                <?php
                                                $tc = 0;
                                                if ($item['day'] != 'Sun') {
                                                    if ($item['morning'] || $item['afternoon']) {
                                                        $fullTime = strtotime('08:00');
                                                        $totalTime = sum_time($item['morning'], $item['afternoon']);
                                                        $totalTime = strtotime($totalTime);
                                                        if ($totalTime >= $fullTime) {
                                                            $tc = 2;
                                                        } else {
                                                            $percent = number_format((1 - (abs($totalTime - $fullTime) / 28800)), 2, '.', ',');
                                                            $tc = $percent * 2;
                                                        }
                                                    }
                                                    if ($item['day'] == 'Sat') {
                                                        if ($tc > 1) {
                                                            $tc = 1;
                                                        }
                                                    }
                                                    if ($tc == 0) {
                                                        if ($item['checkin'] || $item['checkout']) {
                                                            $tc = 1;
                                                            echo '<a style="color: #ff7800;" href="javascript:void(0)" title="Checkin: ' . $item['checkin'] . ' - Checkout: ' . $item['checkout'] . '">' . $tc . '</a>';
                                                        } else {
                                                            echo '<a style="color: #fff;" href="javascript:void(0)" title="Checkin: ' . $item['checkin'] . ' - Checkout: ' . $item['checkout'] . '">' . $tc . '</a>';
                                                        }
                                                    } else {
                                                        echo '<a style="color: #fff;" href="javascript:void(0)" title="Checkin: ' . $item['checkin'] . ' - Checkout: ' . $item['checkout'] . '">' . $tc . '</a>';
                                                    }
                                                } else {
                                                    echo '&nbsp;';
                                                }
                                                $tsc += $tc;
                                                ?>
                                            </td>
                                        <?php } ?>
                                        <td><?= $tsc ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <style>
                        .content-table{
                            text-align: center;
                        }
                        .content-table table{
                            margin: 0 auto;
                        }
                        td{
                            padding: 0px 8px;
                        }
                    </style>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

