<div class="event-list clearfix">
    <?php if (count($listevent)) {
        foreach ($listevent as $event) {
            ?>
            <div class="event-item">
                <div class="event-img">
                    <a href="<?php echo $event['link']; ?>" title="<?php echo $event['name']; ?>">
                        <img
                            src="<?php echo ClaHost::getImageHost() . $event['image_path'] . 's400_400/' . $event['image_name']; ?>">
                    </a>
                </div>
                <div class="event-info">
                    <h3>
                        <a href="<?php echo $event['link']; ?>" class="event-title"
                           title="<?php echo $event['name']; ?>">
                            <?php echo $event['name']; ?>
                        </a>
                    </h3>
                    <div class="item-time"><?php echo date('d/m/Y', strtotime($c['start_date'])); ?></div>
                    <div class="item-location"> <?php echo $event['address']; ?></div>
                    <div class="item-actionbox clearfix">
<!--                        <a class="item-cat">--><?php //echo $event['category_id']; ?><!--</a>-->
                        <a class="item-sign-up item-sign-litsk"><?php echo yii::t('event', 'event_register') ?></a>
                    </div>
                </div>
            </div>
        <?php }
    } ?>
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
