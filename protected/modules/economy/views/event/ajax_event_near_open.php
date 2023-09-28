<?php if (count($events)) { ?>
    <?php foreach ($events as $event) {
        ?>
        <div class="item-event-description">
            <p class="time-event clearfix">
                                    <span
                                        class="day-event"><?php echo $event['date-text'] ?></span>
                                    <span
                                        class="hours-event"><?php echo date('H:i', strtotime($event['event_time'])); ?></span>
            </p>
            <h4 class="name-event">
                <a href="<?php echo $event['link']; ?>" title="<?php echo $event['name']; ?>">
                    <?php echo $event['name']; ?>
                </a>
            </h4>
        </div>
    <?php } ?>
<?php } else {
    echo '<span>Hiện chưa có sự kiện nào diễn ra trong ngày</span>';
} ?>
