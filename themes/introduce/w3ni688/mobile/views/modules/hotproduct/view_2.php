<?php if (count($products)) { ?>
    <div class="news-technology news-chedobaohanh">
        <div class="title-cmr">
            <h2> 
                <a href="/san-pham" title="<?php echo $widget_title ?>"><?php echo $widget_title ?></a> 
                <span class="triangle"></span>
            </h2>
            <div class="see-all">
                <a href="/san-pham" title="<?php echo Yii::t('common', 'viewmore') ?>"> <?php echo Yii::t('common', 'viewmore') ?></a>
            </div>
        </div>
        <div class="cont-news-technology">
            <div class="list list-small">
                <?php foreach ($products as $product) { ?>
                    <div class="list-item">
                        <div class="list-content clearfix">
                            <div class="list-content-box">
                                <div class="list-content-img-r"> 
                                    <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"> 
                                        <img alt="<?php echo $product['name'] ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's200_200/' . $product['avatar_name'] ?>"> 
                                    </a>  
                                </div>
                                <div class="list-content-body-r"> 
                                    <span class="list-content-title"> 
                                        <h3>
                                            <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"><?php echo $product['name'] ?></a> 
                                        </h3>
                                    </span>
                                    <div class="price">
                                        <span>Giá:</span>  
                                        <span><?php echo $product['price_text']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
}
?>