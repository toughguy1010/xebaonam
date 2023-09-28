<?php if (isset($jobs) && $jobs) { ?>
    <div class="your-company">
        <?php if ($show_widget_title) { ?>
            <h2>
                <?php echo $widget_title ?>
            </h2>
        <?php } ?>
        <ul>
            <?php foreach ($jobs as $job) { ?>
                <li>
                    <a href="<?php echo $job['link'] ?>" title="<?php echo $job['position'] ?>"><?php echo $job['position'] ?> 
                        <?php if ($job['company']) { ?>
                            <span><?php echo $job['company'] ?></span>
                        <?php } ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>