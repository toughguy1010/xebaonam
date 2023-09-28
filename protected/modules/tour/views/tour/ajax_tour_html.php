<?php foreach ($tours as $tour) { ?>
    <div class="col-sm-3 box-product-tour">
        <div class="product-tour">
            <div class="img-tour">
                <a href="<?php echo $tour['link'] ?>" title="<?php echo $tour['name'] ?>">
                    <img src="<?php echo ClaHost::getImageHost(), $tour['avatar_path'], 's250_0/', $tour['avatar_name'] ?>" alt="<?php echo $tour['name'] ?>">
                </a>
            </div>
            <div class="title-tour-in">
                <h3>
                    <a href="<?php echo $tour['link'] ?>" title="<?php echo $tour['name'] ?>"><?php echo $tour['name'] ?></a>
                </h3>
                <div class="checkbox-product">
                    <a href="<?php echo $tour['link'] ?>" title="chi tiết" class="a-btn-2">
                        <span class="a-btn-2-text"><?php echo Yii::t('common', 'detail') ?></span> 
                    </a> 
                </div>
            </div>
        </div>
    </div>
<?php } ?>