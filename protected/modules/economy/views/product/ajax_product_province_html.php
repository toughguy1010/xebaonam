<?php foreach ($products as $product) { ?>
    <div class="col-sm-3 box-product-tour">
        <div class="product-tour">
            <div class="img-tour">
                <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>">
                    <img src="<?php echo ClaHost::getImageHost(), $product['avatar_path'], 's250_0/', $product['avatar_name'] ?>" alt="<?php echo $product['name'] ?>">
                </a>
            </div>
            <div class="title-tour-in">
                <h3>
                    <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"><?php echo $product['name'] ?></a>
                </h3>
                <div class="checkbox-product">
                    <a href="<?php echo $product['link'] ?>" title="chi tiết" class="a-btn-2">
                        <span class="a-btn-2-text"><?php echo Yii::t('common', 'detail') ?></span> 
                    </a> 
                </div>
            </div>
        </div>
    </div>
<?php } ?>