<div class="featured">
    <div class="panel panel-default categorybox">
        <?php if ($show_widget_title) { ?>
            <div class="panel-heading">
                <h2><?php echo $widget_title ?></h2>
            </div>
        <?php } ?>
        <?php if (count($hotels)) { ?>
            <div class="panel-body">
                <?php foreach ($hotels as $hotel) { ?>
                    <div class="list list-small">
                        <div class="list-item  ">
                            <div class="list-content clearfix">
                                <div class="list-content-box">
                                    <div class="list-content-img"> 
                                        <a href="<?php echo $hotel['link'] ?>" title="<?php echo $hotel['name'] ?>"> 
                                            <img alt="<?php echo $hotel['name'] ?>" src="<?php echo ClaHost::getImageHost(), $hotel['image_path'], 's100_100/', $hotel['image_name']; ?>"> 
                                        </a>
                                    </div>
                                    <div class="list-content-body">
                                        <h3 class="list-content-title"> 
                                            <a href="<?php echo $hotel['link'] ?>" title="<?php echo $hotel['name'] ?>"> <?php echo $hotel['name'] ?></a> 
                                        </h3>
                                        <div class="price">
                                            <p><span><?php echo Yii::t('tour_hotel', 'price_from') ?></span> <?php echo $hotel['min_price'] ?> đ</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>