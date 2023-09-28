<?php if (isset($list_realestate_news) && count($list_realestate_news)) { ?>

    <div class="wrep">
        <?php foreach ($list_realestate_news as $realestate_news) { ?>
            <div class="ire clearfix">
                    <div class="bire">
                        <a href="<?php echo $realestate_news['link'] ?>">
                            <?php if ($realestate_news['image_path'] && $realestate_news['image_name']) { ?>
                            <img src="<?php echo ClaHost::getImageHost() . $realestate_news['image_path'] . 's200_200/' . $realestate_news['image_name'] ?>" alt="<?php echo $realestate_news['name'] ?>">
                            <?php } ?>
                        </a>
                    </div>
                <div class="box-info-real-estate">
                    <h3>
                        <a href="<?php echo $realestate_news['link'] ?>" title="<?php echo $realestate_news['name'] ?>">
                            <?php echo $realestate_news['name'] ?>
                        </a>
                    </h3>
                    <div class="info-detail">
                        <div class="price">
                            <label><?php echo Yii::t('product', 'price') ?></label>: 
                            <?php if ($realestate_news['price']) { ?>
                                <span><?php echo $realestate_news['price'] . ' ' . $unit_price[$realestate_news['unit_price']]; ?></span>
                            <?php } else { ?>
                                <span><?php echo Yii::t('realestate', 'waiting_update') ?></span>
                            <?php } ?>
                        </div>
                        <div class="area">
                            <label><?php echo Yii::t('realestate', 'area') ?></label>: 
                            <?php if ($realestate_news['area']) { ?>
                                <span><?php echo $realestate_news['area'] ?>m2</span>
                            <?php } else { ?>
                                <span><?php echo Yii::t('realestate', 'waiting_update') ?></span>
                            <?php } ?>
                        </div>
                        <div>
                            <label><?php echo Yii::t('common', 'address') ?></label>: <span><?php echo $realestate_news['address'] ?></span>  
                        </div>
                        <div>
                            <?php echo date('d/m/Y H:i', $realestate_news['created_time']); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

<?php } ?>