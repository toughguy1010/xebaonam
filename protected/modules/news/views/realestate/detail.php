<?php
if ($user->type == ActiveRecord::TYPE_NORMAL_USER && $model['type'] == ActiveRecord::TYPE_INTERNAL) {
    ?>
    <div class="real-estate-detail">
        <p><?php echo Yii::t('common', 'forbidden'); ?></p>
    </div>
<?php } else { ?>
    <div class="real-estate-detail">
        <div class="info-realestate-detail">
            <div class="bire">
                <?php if ($model['image_path'] && $model['image_name']) { ?>
                    <img src="<?php echo ClaHost::getImageHost() . $model['image_path'] . 's330_330/' . $model['image_name'] ?>" alt="<?php echo $model['name'] ?>">
                <?php } ?>
            </div>
            <div class="info-detail">
                <h1>
                    <?php echo ($model['type'] == ActiveRecord::TYPE_INTERNAL) ? '[NB]' : '' ?> <?php echo $model['name'] ?>
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
                    <div class="percent">
                        <label><?php echo Yii::t('realestate', 'percent') ?>:</label>
                        <?php if ($model['percent']) { ?>
                            <span><?php echo $model['percent'] ?></span>
                        <?php } else { ?>
                            <span><?php echo Yii::t('realestate', 'waiting_update') ?></span>
                        <?php } ?>
                    </div>
                    <div class="address-detail">
                        <label><?php echo Yii::t('common', 'address') ?>:</label>
                        <span><?php echo $model['address'] . ', ' . $model['district_name'] . ', ' . $model['province_name'] ?></span>  
                    </div>
                    <div class="post_date">
                        <label><?php echo Yii::t('news', 'news_post_date') ?>:</label>
                        <span><?php echo date('d/m/Y H:i', $model['created_time']); ?></span>
                    </div>
                    <div class="box-contact">
                        <label><?php echo Yii::t('common', 'contact'); ?>:</label>
                        <ul>
                            <li><label><?php echo Yii::t('user', 'name') ?>:</label> <span><?php echo $model['contact_name'] ?></span></li>
                            <li><label><?php echo Yii::t('common', 'phone') ?>:</label> <span><?php echo $model['contact_phone'] ?></span></li>
                            <li><label><?php echo Yii::t('common', 'email') ?>:</label> <span><?php echo$model['contact_email'] ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="description">
            <label class="title-realestate"><?php echo Yii::t('common', 'description') ?></label>
            <?php echo $model['description'] ?>
        </div>
    </div>
<?php } ?>
