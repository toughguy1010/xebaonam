<div id="event" class="page-main">
    <?php if ($show_widget_title) { ?>
        <h2 class="title-page"><?php echo $widget_title ?></h2>
    <?php } ?>
    <div class="cont clearfix">
        <div class="col-43">
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
                                                $(".nav.nav-pills.nav-justified").click();
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
        <div class="col-57">
            <div class="event-description">
<!--                                <div class="panel-group" id="accordion">-->
<!--                                    <div class="panel panel-default">-->
<!--                                        <div class="panel-heading">-->
<!--                                            <h4 class="panel-title">-->
<!--                                                                                       <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">--><?php //echo Yii::t('event', 'event_current') ?><!--</a>-->
<!--                                            </h4>-->
<!--                                        </div>-->
<!--                                        <div id="collapse1" class="panel-collapse collapse in">-->
<!--                                            <div class="panel-body">-->
<!--                                                <div class="cont-event-description" id="event_ajax" style="height: 139px">-->
<!--                                                    --><?php //if (count($events)) { ?>
<!--                                                        --><?php //foreach ($events as $event) {
//                                                            ?>
<!--                                                            <div class="item-event-description">-->
<!--                                                                <p class="time-event clearfix">-->
<!--                                                                                        <span-->
<!--                                                                                            class="day-event">-->
<!--                --><?php //echo $event['date-text']; ?><!--</span>-->
<!--                                                                    <span-->
<!--                                                                        class="hours-event">-->
<!--                --><?php //echo date('H:i', strtotime($event['event_time'])); ?><!--</span>-->
<!--                                                                </p>-->
<!--                                                                <h4 class="name-event">-->
<!--                                                                    <a href="-->
<!--                --><?php //echo $event['link']; ?><!--"-->
<!--                                                                       title="-->
<!--                --><?php //echo $event['name']; ?><!--">-->
<!--                                                                        --><?php //echo $event['name']; ?>
<!--                                                                    </a>-->
<!--                                                                </h4>-->
<!--                                                            </div>-->
<!--                                                        --><?php //} ?>
<!--                                                    --><?php //} else {
//                                                        echo 'Không có sự kiện nào diễn ra trong ngày.';
//                                                    } ?>
<!--                                                </div>-->
<!---->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="panel panel-default">-->
<!--                                        <div class="panel-heading">-->
<!--                                            <h4 class="panel-title">-->
<!--                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">--><?php //echo Yii::t('event', 'event_near_open') ?><!--</a>-->
<!--                                            </h4>-->
<!--                                        </div>-->
<!--                                        <div id="collapse2" class="panel-collapse collapse">-->
<!--                                            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,-->
<!--                                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim-->
<!--                                                veniam,-->
<!--                                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="panel panel-default">-->
<!--                                        <div class="panel-heading">-->
<!--                                            <h4 class="panel-title">-->
<!--                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">--><?php //echo Yii::t('event', 'event_old') ?><!--</a>-->
<!--                                            </h4>-->
<!--                                        </div>-->
<!--                                        <div id="collapse3" class="panel-collapse collapse" style="overflow: hidden">-->
<!--                                            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,-->
<!--                                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim-->
<!--                                                veniam,-->
<!--                                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <style>-->
<!--                                    .collapse {-->
<!--                                        display: none;-->
<!--                                    }-->
<!---->
<!--                                    .collapse.in {-->
<!--                                        display: block;-->
<!--                                    }-->
<!---->
<!--                                    tr.collapse.in {-->
<!--                                        display: table-row;-->
<!--                                    }-->
<!---->
<!--                                    tbody.collapse.in {-->
<!--                                        display: table-row-group;-->
<!--                                    }-->
<!---->
<!--                                    .collapsing {-->
<!--                                        position: relative;-->
<!--                                        height: 0;-->
<!--                                        overflow: hidden;-->
<!--                                        -webkit-transition-timing-function: ease;-->
<!--                                        -o-transition-timing-function: ease;-->
<!--                                        transition-timing-function: ease;-->
<!--                                        -webkit-transition-duration: .35s;-->
<!--                                        -o-transition-duration: .35s;-->
<!--                                        transition-duration: .35s;-->
<!--                                        -webkit-transition-property: height, visibility;-->
<!--                                        -o-transition-property: height, visibility;-->
<!--                                        transition-property: height, visibility;-->
<!--                                    }-->
<!--                                </style>-->
                <ul class="nav nav-pills  nav-justified">
                    <li class="active"><a data-toggle="tab"
                                          href="#home">
                            <?php echo Yii::t('event', 'event_current') ?></a></li>
                    <li><a data-toggle="tab" href="#menu1">
                            <?php echo Yii::t('event', 'event_near_open') ?></a></a></li>
                    <li><a data-toggle="tab" href="#menu2">
                            <?php echo Yii::t('event', 'event_old') ?></a></a></li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <div class="cont-event-description" id="event_ajax">
                            <?php if (count($events)) { ?>
                                <?php foreach ($events as $event) {
                                    ?>
                                    <div class="item-event-description">
                                        <p class="time-event clearfix">
                                            <span class="day-event"><?php echo $event['date-text']; ?></span>
                                            <span
                                                class="hours-event"><?php echo date('H:i', strtotime($event['event_time'])); ?></span>
                                        </p>
                                        <h4 class="name-event">
                                            <a href="<?php echo $event['link']; ?>"
                                               title="<?php echo $event['name']; ?>">
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
                    <div id="menu1" class="tab-pane fade">
                        <div class="cont-event-description" id="">
                            <?php if (count($eventsOld)) { ?>
                                <?php foreach ($eventsOld as $event) {
                                    ?>
                                    <div class="item-event-description">
                                        <p class="time-event clearfix">
                                                    <span
                                                        class="day-event">
                <?php echo $event['date-text']; ?></span>
                                            <span
                                                class="hours-event">
                <?php echo date('H:i', strtotime($event['event_time'])); ?></span>
                                        </p>
                                        <h4 class="name-event">
                                            <a href="<?php echo $event['link']; ?>"
                                               title="<?php echo $event['name']; ?>">
                                                <?php echo $event['name']; ?>
                                            </a>
                                        </h4>
                                    </div>
                                <?php } ?>
                            <?php } else {
                                echo 'Không có sự kiện nào';
                            } ?>
                        </div>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <div class="cont-event-description" id="">
                            <?php if (count($eventsNearOpen)) { ?>
                                <?php foreach ($eventsNearOpen as $event) {
                                    ?>
                                    <div class="item-event-description">
                                        <p class="time-event clearfix">
                                                    <span
                                                        class="day-event">
                <?php echo $event['date-text']; ?></span>
                                            <span
                                                class="hours-event">
                <?php echo date('H:i', strtotime($event['event_time'])); ?></span>
                                        </p>
                                        <h4 class="name-event">
                                            <a href="<?php echo $event['link']; ?>"
                                               title="<?php echo $event['name']; ?>">
                                                <?php echo $event['name']; ?>
                                            </a>
                                        </h4>
                                    </div>
                                <?php } ?>
                            <?php } else {
                                echo 'Không có sự kiện nào';
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>