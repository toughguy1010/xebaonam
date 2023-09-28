<?php if (isset($realestates) && count($realestates)) { ?>

    <div class="wrep">
        <?php foreach ($realestates as $realestate) { ?>
            <div class="ire clearfix">
                <div class="bire">
                    <a href="<?php echo $realestate['link'] ?>">
                        <img src="<?php echo ClaHost::getImageHost() . $realestate['image_path'] . 's200_200/' . $realestate['image_name'] ?>" alt="<?php echo $realestate['name'] ?>">
                    </a>
                </div>
                <div class="box-info-real-estate">
                    <h3>
                        <a href="<?php echo $realestate['link'] ?>" title="<?php echo $realestate['name'] ?>">
                            <?php echo $realestate['name'] ?>
                        </a>
                    </h3>
                    <div class="info-detail">
                        <div class="price"><label><?php echo Yii::t('product', 'price') ?></label>: <span><?php echo HtmlFormat::money_format($realestate['price']) . ' ' . Yii::t('realestate', 'vnd'); ?></span></div>
                        <div class="area"><label><?php echo Yii::t('realestate', 'area') ?></label>: <span><?php echo $realestate['area'] ?></span></div>
                        <div>
                            <label><?php echo Yii::t('common', 'address') ?></label>: <span><?php echo $realestate['full_address'] ?></span>  
                        </div>
                        <div>
                            <?php echo date('d/m/Y H:i', $realestate['created_time']); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

<?php } ?>