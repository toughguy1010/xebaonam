<?php
$themUrl = Yii::app()->theme->baseUrl;
?>
<div class="services-index">
    <div class="bg-img">
        <img src="<?php echo $themUrl ?>/images/bg-dichvu.jpg" alt="">
    </div>
    <div class="title-standard">
        <h2><a href="">Dịch vụ</a></h2>
        <img src="<?php echo $themUrl ?>/images/wifi-ico.png" alt="">
    </div>
    <div class="container">
        <div class="slide-services-index">
            <div class="slide-services-index">
                <?php foreach ($products as $product) { ?>
                    <div class="item-services-index">
                        <div class="img-item-services-index">
                            <?php if ($product['image_path'] && $product['image_name']) { ?>
                                <a href="<?php echo $product['link']; ?>" title="<?php echo $product['position']; ?>">
                                    <img src="<?php echo ClaHost::getImageHost() . $product['image_path'] . 's200_200/' . $product['image_name']; ?>"
                                         alt="<?php echo $product['news_title']; ?>"/>
                                </a>
                            <?php } ?>
                        </div>
                        <div class="title-item-services-index">
                            <h2>
                                <a href="<?= $product['link_to_cart'] ?>"><?= $product['name'] ?></a>
                            </h2>
                            <p>
                                <?= $product['sortdesc'] ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

