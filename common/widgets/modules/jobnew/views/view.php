<?php if (count($jobs)) { ?>
    <div class="list-jobs">
        <?php if ($show_widget_title) { ?>
            <div class="job-title">
                <h3><?php echo $widget_title; ?></h3>
            </div>
        <?php } ?>
        <div class="list">
            <?php foreach ($jobs as $job) { ?>
                <div class="list-item">
                    <div class="list-content">
                        <div class="list-content-box">
                            <?php if ($job['image_path'] && $job['image_name']) { ?>
                                <div class="list-content-img">
                                    <a href="<?php echo $job['link']; ?>" title="<?php echo $job['position']; ?>">
                                        <img src="<?php echo ClaHost::getImageHost() . $job['image_path'] . 's100_100/' . $job['image_name']; ?>" alt="<?php echo $job['news_title']; ?>" />
                                    </a>
                                </div>
                            <?php } ?>
                            <div class="list-content-body">
                                <span class="list-content-title">
                                    <a href="<?php echo $job['link']; ?>" title="<?php echo $job['position']; ?>">
                                        <h3><?php echo $job['position']; ?></h3>
                                    </a>
                                </span> 
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>