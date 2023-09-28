<div id="event" class="page-main">
    <?php if ($show_widget_title) { ?>
        <h2 class="title-page"><?php echo $widget_title ?></h2>
    <?php } ?>
    <div class="cont clearfix">
        <div class="col-50">
            <div class="calendar-event">
                <div id="datepicker"></div>
                <script>
                    $(function () {
                        $("#datepicker").datepicker(
                            {
                                onSelect: function (dateText) {
                                    $('.loading-shoppingcart').show();
                                    if (typeof $("body").data(dateText) != 'undefined') {
                                        $('#event_ajax').html($("body").data(dateText));
                                        $('.loading-shoppingcart').hide();
                                    } else {
                                        $.ajax({
                                            url: '<?php echo Yii::app()->createUrl('economy/event/ajaxEventNearOpen'); ?>',
                                            data: {event_date: dateText},
                                            type: 'get',
                                            dataType: 'json',
                                            success: function (data) {
                                                $('.loading-shoppingcart').hide();
                                                $('#event_ajax').html(data.html);
                                                $("body").data(dateText, data.html);
                                            }
                                        });
                                    }

                                },
                                dateFormat: 'yy-mm-dd',
                            }
                        );
                    });
                </script>
            </div>
        </div>
        <div class="col-50">
            <div class="event-description">
                <h3 class="widget-title"><?php echo Yii::t('event', 'event_old') ?></h3>
                <div class="cont-event-description" id="event_ajax">
                    <?php if (count($events)) { ?>
                        <?php foreach ($events as $event) {
                            ?>
                            <div class="item-event-description">
                                <p class="time-event clearfix">
                                    <span
                                        class="day-event"><?php echo $event['date-text']; ?></span>
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
                        echo 'Không có sự kiện nào diễn ra trong ngày.';
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>