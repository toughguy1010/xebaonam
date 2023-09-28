<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
    <?php
    $class = '';
    if (isset($style) && $style == SeServices::STYLE_COL2) {
        $class = 'list-services-style-2';
    }
    ?>
    <div class="list-services <?php echo $class ?>">
        <?php foreach ($services as $service) { ?>
            <div class="item-services">
                <div class="img-item-services">
                    <a href="javascript:void(0)">
                        <img src="<?= ClaHost::getImageHost(), $service['image_path'], 's250_250/', $service['image_name'] ?>" />
                    </a>

                    <?php if ($service['price_market'] > 0 && $service['price'] > 0 && $service['price_market'] > $service['price']) { ?>
                        <span class="sale-off">- <?php echo ClaProduct::getDiscount($service['price_market'], $service['price']) ?> %</span>
                    <?php } ?>
                </div>
                <div class="title-item-services">
                    <h2>
                        <a href=""><?php echo $service['name'] ?></a>
                    </h2>
                    <span class="time">Time Dur: <?= $service['duration'] / 60 ?> min.</span>
                    <p class="price">Price: <span>$<?= $service['price'] ?></span></p>
                    <p>
                        <?= $service['description'] ?>
                    </p>
                    <a href="<?php echo Yii::app()->createUrl('service/service/book', array('se' => $service['id'])) ?>" class="view-more">Book</a>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="paginate">
        <?php
        $this->widget('common.extensions.LinkPager.LinkPager', array(
            'itemCount' => $totalitem,
            'pageSize' => $limit,
            'header' => '',
            'htmlOptions' => array('class' => '',), // Class for ul
            'selectedPageCssClass' => 'active',
        ));
        ?>
        <!--        <ul>
                    <li class="active"><a href="">1</a></li>
                    <li><a href="">2</a></li>
                    <li><a href="">3</a></li>
                    <li><a href=""><i class="fa fa-angle-right"></i></a></li>
                </ul>-->
    </div>
</div>