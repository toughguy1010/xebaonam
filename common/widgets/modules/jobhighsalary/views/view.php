<?php if (isset($jobs) && $jobs) { ?>
    <div class="location-hot-job money-bag bg-white">
        <?php if ($show_widget_title) { ?>
            <h2>
                <a href="javascript:void(0)">
                    <img src="<?php echo Yii::app()->theme->baseUrl ?>/images/money-bag.png"><?php echo $widget_title ?>
                </a>
            </h2>
        <?php } ?>
        <ul>
            <?php foreach ($jobs as $job) { ?>
                <li>
                    <a href="<?php echo $job['link'] ?>" title="<?php echo $job['position'] ?>"><?php echo $job['position'] ?><span>> <?php echo number_format($job['salary_min'], 0, ',', '.') ?></span></a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>