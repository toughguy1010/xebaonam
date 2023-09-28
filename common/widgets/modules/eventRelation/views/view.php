<?php if (count($events)) { ?>
    <div class="news-other multi-columns-row">
        <h2 class="title-page" style="font-size:18px;"><?php echo $widget_title ?></h2>
        <div class="news-relation mar-10">
            <?php foreach ($events as $event) {
            ?>
            <div class="item-relate col-lg-4 col-sm-4 col-md-4 col-xs-6">
                <div class="item-img">
                    <a href="<?php echo $event['link'] ?>"
                       title="<?php echo $event['name'] ?>">
                        <img
                            src="<?php echo ClaHost::getImageHost() . $event['image_path'] . 's300_300/' . $event['image_name'] ?>"
                            alt="<?php echo $event['name'] ?>">
                    </a>
                </div>
                <div class="item-info">
                    <h2 class="item-title"><a href="<?php echo $event['link'] ?>"
                                              title="<?php echo $event['name'] ?>"><?php echo $event['name'] ?></a>
                    </h2>
                    <p class="new-time"><?php echo 'Từ ', date('h:m', strtotime($event['event_time'])), ' Ngày', date('d-m-Y', strtotime($event['start_date'])); ?></p>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
