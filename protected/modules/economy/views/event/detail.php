<div id="cover-event" class="cover-event">
    <div id="banner wow fadeInUp animated">
        <img
            src="<?php echo ClaHost::getImageHost() . $event['cover_path'] . 's800_800/' . $event['cover_name'] ?>">
    </div>
</div>
<h1><?php echo $event['name']; ?>
</h1>
<div class="box-intro clearfix">
    <div class="left-column col-lg-8 col-md-8 col-sm-6 col-xs-12">
        <div class="inner-content row">
            <div class="event-action">
                <div class="style-event cate-event"><i class="fa fa-folder-open" aria-hidden="true"></i> Hội thảo & Đào
                    tạo
                    <?php echo $category->cat_name; ?>
                </div>
                <div class="style-event item-time-event"><i class="fa fa-clock-o" aria-hidden="true"></i> 10 : 20 -
                    23/08/2016
                </div>
                <div class="style-event item-location-event"><i class="fa fa-map-marker" aria-hidden="true">
                    </i> <?php echo $event['address']; ?>
                </div>
                <div class="style-event item-user-event"><i class="fa fa-user" aria-hidden="true"></i> Đăng bởi : <a
                        href="#"> Admin</a></div>

            </div>
        </div>
    </div>
    <div class="rightcolumn col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="inner-content row">

            <a class="order-ticket" href="#">Đăng kí tham gia</a>
            <!--            <a href="#" class="item-sign-up">Tham gia sự kiện</a>-->
            <?php
            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK2));
            ?>
        </div>
    </div>
</div>
<div class="box-detail">
    <?php echo $eventInfo['description']; ?>
</div>
<div class="tag">
    <ul>
        <li>
            <p><a href="#"><i class="fa fa-tag" aria-hidden="true"></i>Tag</a></p>
        </li>
        <li>
            <p><a href="#"><i class="fa fa-tag" aria-hidden="true"></i>Tag</a></p>
        </li>

    </ul>
</div>
<div class="comment-facebook">
    <?php
    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK5));
    ?>
</div>
