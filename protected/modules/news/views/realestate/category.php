<?php if (isset($list_realestate) && count($list_realestate)) { ?>

    <div class="wrep">
        <?php foreach ($list_realestate as $realestate) { ?>
            <div class="ire">
                    <div class="bire">
                        <a href="<?php echo $realestate['link'] ?>">
                            <?php if ($realestate['image_path'] && $realestate['image_name']) { ?>
                            <img src="<?php echo ClaHost::getImageHost() . $realestate['image_path'] . 's200_200/' . $realestate['image_name'] ?>" alt="<?php echo $realestate['name'] ?>">
                            <?php } ?>
                        </a>
                    </div>
                <div class="box-info-real-estate">
                    <h3>
                        <a class="<?php echo $realestate['type'] == 2 ? 'internal' : 'normal' ?>" href="<?php echo $realestate['link'] ?>" title="<?php echo $realestate['type'] == ActiveRecord::TYPE_INTERNAL ? Yii::t('realestate', 'realestate_internal') : Yii::t('realestate', 'realestate_normal'); ?>"><?php echo $realestate['type'] == ActiveRecord::TYPE_INTERNAL ? '[NB]' : '' ?> <?php echo $realestate['name'] ?></a>
                    </h3>
                    <div class="info-detail">
                        <div class="price">
                            <label><?php echo Yii::t('product', 'price') ?></label>: 
                            <?php if ($realestate['price']) { ?>
                                <span><?php echo $realestate['price'] . ' ' . $unit_price[$realestate['unit_price']]; ?></span>
                            <?php } else { ?>
                                <span><?php echo Yii::t('realestate', 'waiting_update') ?></span>
                            <?php } ?>
                        </div>
                        <div class="area">
                            <label><?php echo Yii::t('realestate', 'area') ?></label>: 
                            <?php if ($realestate['area']) { ?>
                                <span><?php echo $realestate['area'] ?>m2</span>
                            <?php } else { ?>
                                <span><?php echo Yii::t('realestate', 'waiting_update') ?></span>
                            <?php } ?>
                        </div>
                        <div class="percent">
                            <label><?php echo Yii::t('realestate', 'percent') ?>:</label>
                            <?php if ($realestate['percent']) { ?>
                                <span><?php echo $realestate['percent'] ?></span>
                            <?php } else { ?>
                                <span><?php echo Yii::t('realestate', 'waiting_update') ?></span>
                            <?php } ?>
                        </div>
                        <div>
                            <label><?php echo Yii::t('common', 'address') ?></label>: <span><?php echo $realestate['full_address'] ?></span>  
                        </div>
                        <div>
                            <label><?php echo Yii::t('common', 'modified_time2') ?></label>: <?php echo date('d/m/Y H:i', $realestate['modified_time']); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

<?php } ?>