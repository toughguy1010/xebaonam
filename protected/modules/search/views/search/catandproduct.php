<div class="product-cat-search"> 
    <?php
    if (count($data)) {
        foreach ($data as $each_cat) {
            if (count($each_cat['products'])) {
                ?>
                <div class="box-product">
                    <div class="title clearfix">
                        <div class="title-l">
                            <a href="<?php echo $each_cat['link']; ?>" title="<?php echo $each_cat['cat_name']; ?>">    
                                <?php if ($each_cat['icon_path'] && $each_cat['icon_name']) { ?>
                                    <img alt="<?php echo $each_cat['cat_name']; ?>" src="<?php echo ClaHost::getImageHost() . $each_cat['icon_path'] . 's150_150/' . $each_cat['icon_name'] ?>">
                                    <?php
                                } else {
                                    echo $each_cat['cat_name'];
                                }
                                ?>
                            </a>
                        </div>
                        <div class="title-r">
                            <?php echo '(' . Yii::t('common', 'search_result', array('{results}' => $each_cat['count_value'], '{keyword}' => '<span class="bold">' . $keyword . '</span>')) . '). '; ?> 
                            <a href="<?php echo Yii::app()->createUrl('/search/search/searchbyCat') . '?' . ClaCategory::CATEGORY_KEY . '=' . $each_cat['cat_id'] . '&q=' . $keyword; ?>" title="#" class="view-all-product">Xem tất cả > </a></div>
                    </div>
                    <div class="cont">
                        <div class="row-reb clearfix">
                            <?php foreach ($each_cat['products'] as $product) { ?>
                                <div class="col-20">
                                    <div class="item-product">
                                        <div class="box-img img-item-product"> 
                                            <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>" >
                                                <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's200_200/' . $product['avatar_name'] ?>">
                                            </a>
                                        </div>
                                        <div class="box-info">
                                            <!--<p class="logo-thuonghieu"><img src="css/img/thuonghieu1.jpg" alt="#" /></p>-->
                                            <h3 class="title-product">
                                                <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>" >
                                                    <?php echo $product['name']; ?>
                                                </a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }
    if (count($data) == 1) {
        ?>
        <div class="wpager">
            <?php
            $this->widget('common.extensions.LinkPager.LinkPager', array(
                'itemCount' => array_shift($data)['count_value'],
                'pageSize' => $limit,
                'header' => '',
                'selectedPageCssClass' => 'active',
            ));
            ?>
        </div>
    <?php } ?>
</div>