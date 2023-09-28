<div class="jobs">
    <div class="list">
        <?php if (count($jobs)) { ?>
            <?php
            foreach ($jobs as $job) {
                ?>
                <div class="list-item">
                    <div class="list-content">
                        <div class="list-content-box">
                            <?php if ($job['image_path'] && $job['image_name']) { ?>
                                <div class="list-content-img">
                                    <a href="<?php echo $job['link']; ?>" title="<?php echo $job['position']; ?>">
                                        <img src="<?php echo ClaHost::getImageHost() . $job['image_path'] . 's200_200/' . $job['image_name']; ?>" alt="<?php echo $job['news_title']; ?>" />
                                    </a>
                                </div>
                            <?php } ?>
                            <div class="list-content-body">
                                <span class="list-content-title">
                                    <a href="<?php echo $job['link']; ?>">
                                        <?php echo $job['position']; ?>
                                    </a>
                                </span>
                                <div class="list-content-detail">
                                    <?php
                                    $salary_text = Jobs::getSalaryText($job);
                                    $locations = explode(',', $job['location']);
                                    $location_text = Jobs::getListLocationText($locations, array('provinces' => $provinces));
                                    $degree_text = Jobs::getDegreeText($job);
                                    ?>
                                    <p class="job-info-text">
                                        <?php echo $salary_text . '<span class="job-separate">|</span>' . ($location_text) ? $location_text . '<span class="job-separate">|</span>' : '' . $degree_text . '<span class="job-separate">|</span>' . Yii::t('work', 'job_createdate') . ': ' . date('d - m - Y', $job['modified_time']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="wpager">
        <?php
        $this->widget('common.extensions.LinkPager.LinkPager', array(
            'itemCount' => $totalitem,
            'pageSize' => $limit,
            'header' => '',
            'selectedPageCssClass' => 'active',
        ));
        ?>
    </div>
</div>