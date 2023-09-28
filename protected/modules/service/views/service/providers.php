<?php
$data = isset($data) ? $data : array();
foreach ($data as $provider) {
    ?>

    <div class="infor-booking style-2">
        <div class="staff">
            <div class="info-staff">
                <div class="img-info-staff">
                    <a href="javascript:void(0)">
                        <?php if ($provider['provider']['avatar_path'] && $provider['provider']['avatar_name']) { ?>
                            <img src="<?php echo ClaHost::getImageHost(), $provider['provider']['avatar_path'], 's200_200/', $provider['provider']['avatar_name'] ?>" alt="<?php echo $provider['provider']['name'] ?>">
                        <?php } else { ?>
                            <img src="<?php echo Yii::app()->baseUrl . '/images/no-image.png'; ?>" alt="<?php echo $provider['provider']['name'] ?>">
                        <?php } ?>
                    </a>
                </div>
                <div class="title-staff">
                    <h2>
                        <a href=""><?php echo $provider['provider']['name']; ?></a>
                    </h2>
                    <span>
                        <?php echo $provider['service']['name']; ?>
                    </span>
                    <span>
                        Price $<?php echo HtmlFormat::money_format($provider['providerService']['price']); ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="time-booking">
            <?php
            $dateTime = strtotime($provider['date']);
            ?>
            <p><?php echo date('l, M-d-Y', $dateTime); ?></p>
            <?php
            $times = $provider['times'];
            $count = count($times);
            $morning = 43200;
            $afternoon = 64800;
            $open = true;
            $i=1;
            $class = '';
            $text = '';
            ?>
            <?php foreach ($times as $time) { ?>
                <?php if ($open) {
                    if($time > 0 && $time<$morning){
                        $class = 'am';
                        $text = 'Morning';
                    }elseif($time > $morning & $time<$afternoon){
                        $class = 'pm';
                        $text = 'Afternoon';
                    }else{
                         $class = 'pm';
                        $text = 'Evening';
                    }
                    ?>
                    <div class="<?php echo $class; ?>">
                        <ul>
                         <label><?php echo $text; ?></label> 
                        <?php } ?>
                        <li><a data-toggle="modal" data-target="#Time11h" onclick="jQuery('#Time11h .modal-content').html('');" href="<?php
                            echo Yii::app()->createUrl('service/service/booking', array(
                                'service_id' => $provider['service']['id'],
                                'provider_id' => $provider['provider']['id'],
                                'date' => strtotime($provider['date']),
                                'start_time' => $time['start_time'],
                            ))
                            ?>">
                                   <?php echo gmdate('H:i A', $time['start_time']); ?>
                            </a>
                        </li>
                        <?php if (!$open || $i>=$count) {
                            $open = true;
                            ?>
                        </ul>
                    </div>
                <?php } ?>
            <?php 
                $i++;
                } ?>
        </div>
    </div>

<?php } ?>
