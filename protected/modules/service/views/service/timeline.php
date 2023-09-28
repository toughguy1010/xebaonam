<?php
$info = isset($data) ? $data : array();
if ($info) {
    ?>
    <div class="time-booking">
        <?php
        $dateTime = strtotime($info['date']);
        ?>
        <p><?php echo date('l, M-d-Y', $dateTime); ?></p>
        <?php
        $times = $info['times'];
        $morning = 43200;
        $afternoon = 64800;
        $count = count($times);
        $open = true;
        $i = 1;
        $class = '';
        $text = '';
        $change = '';
        ?>
        <?php foreach ($times as $time) { ?>
            <?php
            if ($time['start_time'] > 0 && $time['start_time'] <= $morning) {
                $class = 'am';
                $text = 'Morning';
            } elseif ($time['start_time'] > $morning & $time['start_time'] <= $afternoon) {
                $class = 'pm';
                $text = 'Afternoon';
            } else {
                $class = 'pm';
                $text = 'Evening';
            }
            ?>
            <?php
            if (!$change || $change != $text) {
                if ($change) {
                    $open = false;
                }
                $change = $text;
                ?>
                <?php
                if (!$open) {
                    $open = true;
                    ?>
                </ul>
                </div>
            <?php } ?>
            <div class="<?php echo $class; ?>">
                <ul>
                    <label><?php echo $text; ?></label> 
                <?php } ?>
                <li><a data-toggle="modal" data-target="#Time11h" class="bookTime"  href="<?php
                       echo Yii::app()->createUrl('service/service/booking', array(
                           'service_id' => $info['services'],
                           'provider_id' => $info['providers'],
                           'date' => strtotime($info['date']),
                           'key' => $info['key'],
                           'start_time' => $time['start_time'],
                       ))
                       ?>">
                           <?php echo gmdate('g:i A', $time['start_time']); ?>
                    </a>
                </li>
                <?php
                if ($i >= $count) {
                    ?>
                </ul>
            </div>
        <?php } ?>
        <?php
        $i++;
    }
    ?>
    </div>
    </div>
<?php } ?>