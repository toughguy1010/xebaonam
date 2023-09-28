<?php foreach ($listnews as $new) { ?>
    <div class="col-sm-3 box-product-tour">
        <div class="product-tour">
            <div class="img-tour">
                <a href="<?php echo $new['link'] ?>" title="<?php echo $new['news_title'] ?>">
                    <img src="<?php echo ClaHost::getImageHost(), $new['image_path'], 's250_0/', $new['image_name'] ?>" alt="<?php echo $new['news_title'] ?>">
                </a>
            </div>
            <div class="title-tour-in">
                <h3>
                    <a href="<?php echo $new['link'] ?>" title="<?php echo $new['news_title'] ?>"><?php echo $new['news_title'] ?></a>
                </h3>
                <div class="checkbox-product">
                    <a href="<?php echo $new['link'] ?>" title="chi tiết" class="a-btn-2">
                        <span class="a-btn-2-text"><?php echo Yii::t('common', 'detail') ?></span> 
                    </a> 
                </div>
            </div>
        </div>
    </div>
<?php } ?>