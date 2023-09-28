<div class="real-estate-detail">
    <div class="info-realestate-detail clearfix">
        <div class="bire">
            <?php if ($model['image_path'] && $model['image_name']) { ?>
                <img src="<?php echo ClaHost::getImageHost() . $model['image_path'] . 's330_330/' . $model['image_name'] ?>" alt="<?php echo $model['name'] ?>">
            <?php } ?>
        </div>
        <div class="info-detail">
            <h1>
                <?php echo $model['name'] ?>
            </h1>
            <div class="detail_info">
                <div class="price">
                    <label><?php echo Yii::t('product', 'price') ?>:</label>
                    <?php if ($model['price']) { ?>
                        <span><?php echo $model['price'] . ' ' . $unit_price[$model['unit_price']] ?></span>
                    <?php } else { ?>
                        <span><?php echo Yii::t('realestate', 'waiting_update') ?></span>
                    <?php } ?>
                </div>
                <div class="area">
                    <label><?php echo Yii::t('realestate', 'area') ?>:</label>
                    <?php if ($model['area']) { ?>
                        <span><?php echo $model['area'] ?>m2</span>
                    <?php } else { ?>
                        <span><?php echo Yii::t('realestate', 'waiting_update') ?></span>
                    <?php } ?>
                </div>
                <div class="address-detail">
                    <label><?php echo Yii::t('common', 'address') ?>:</label>
                    <span><?php echo $model['address'] ?></span>  
                </div>
                <div class="post_date">
                    <label><?php echo Yii::t('news', 'news_post_date') ?>:</label>
                    <span><?php echo date('d/m/Y H:i', $model['created_time']); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="description">
        <label class="title-realestate"><?php echo Yii::t('common', 'description') ?></label>
        <?php echo $model['description'] ?>
    </div>
</div>
