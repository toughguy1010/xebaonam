<div class="detail-product-page">
    <div class="container">
        <div class="row mar-10">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pad-10 awe-check">
                <?php
                $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_LEFT));
                ?>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 pad-10">
                <div class="filter-review-detail">
                    <div class="title-categories-page">
                        <h3>
                            <a href=""><?php echo $category['cat_name'] ?></a>
                            <!--                            <spam>(2000 sản phẩm)</spam>-->
                        </h3>
                    </div>
                    <?php if ($category['icon_path'] != '' && $category['icon_name'] != '') { ?>
                        <div class="banner-list-page">
                            <img src="<?php echo ClaHost::getImageHost() . $category['icon_path'] . $category['icon_name']; ?>">
                        </div>
                    <?php } ?>
                    <?php
//                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK3));
                    ?>
                </div>
                <?php
                $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_BANNER_IN));
                ?>
                <div class="list-product-categories bg-white multi-columns-row ">
                    <?php if (count($products)) { ?>
                        <?php
                        foreach ($products as $product) {
//                            $configurableFilter = AttributeHelper::helper()->getConfiguableFilter($category['attribute_set_id'], $product);
                            if ($product['price_market'] != 0)
                                $discount = '<spam>-' . ClaProduct::getDiscount($product['price_market'], $product['price']) . '%</spam>';
                            else {
                                $discount = null;
                            } ?>
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 pad-0">
                                <div class="box-product-standard new-product">
                                    <div class="item-product-standard">
                                        <div class="item-package-product">
                                            <div class="img-item-package">
                                                <div class="top-left">
                                                    <?php if ($product['ishot']): ?>
                                                        <span class="ic-hot"></span>
                                                    <?php elseif ($product['isnew']): ?>
                                                        <span class="ic-new"></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="top-right">
                                                    <?php if ($product['isfreeship']): ?>
                                                        <span class="ic-freeship"></span>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if ($product['slogan']): ?>
                                                    <div class="bot-left">
                                                        <?= '<span class="slogan">' . $product['slogan'] . '</span>' ?>
                                                        <!--                                                        <span class="sale-of"></span>-->
                                                    </div>
                                                <?php endif; ?>
                                                <a href="<?php echo $product['link']; ?>"
                                                   title="<?php echo $product['name']; ?>">
                                                    <img class="imglazyload"
                                                         src="<?php echo ClaUrl::getLazyloadDefaultImage(250, 250); ?>"
                                                         data-original="<?php echo ClaUrl::getImageUrl($product['avatar_path'], $product['avatar_name'],
                                                             array('width' => 250, 'height' => 250)); ?>"
                                                         alt="<?php echo $product['news_title']; ?>">
                                                </a>
                                            </div>
                                            <div class="title-item-package">
                                                <h2>
                                                    <a href="<?php echo $product['link']; ?>"><?php echo $product['name'] ?></a>
                                                </h2>
                                                <?php if ($product['price'] && $product['price'] > 0) { ?>
                                                    <p class="price"><?php echo number_format($product['price'], 0, '', ',') . ' VNĐ'; ?></p>
                                                <?php } else { ?>
                                                    <p class="price"><?php echo Yii::t('common', 'contact') ?></p>
                                                <?php } ?>
                                                <p class="price-market" style="">
                                                    <?php if ($product['price_market'] && $product['price_market'] > 0) { ?>

                                                        <?php
                                                        echo '<span>' . (number_format($product['price_market']) > 0) ? number_format($product['price_market'], 0, '', ',') . ' VNĐ' : '' . '</span>'; ?>
                                                        <?php
                                                        if ($product['price_market'] != 0)
                                                            $discount = '<spam>-' . ClaProduct::getDiscount($product['price_market'], $product['price']) . '%</spam>';
                                                        else {
                                                            $discount = null;
                                                        }
                                                        echo $discount;
                                                        ?>
                                                    <?php } else { ?>
                                                        <span> </span>
                                                    <?php } ?>

                                                </p>
                                                <div class="rating-star">
                                                    <?php echo HtmlFormat::show_rating($product['product_info']['total_rating'], $product['product_info']['total_votes']) ?>
                                                </div>
                                                <a class="compare" href="javascript:void(0)" onclick="getImage(this)"
                                                   data-id="<?php echo $product['id']; ?>"><?php echo Yii::t('shoppingcart', 'compare') ?></a>
                                                <div class="view-more-detail">
                                                    <a href="<?php echo $product['link']; ?>"><?php echo Yii::t('product', 'purchase') ?>
                                                        <i class="fa fa-shopping-cart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="paginate">
                            <?php
                            $this->widget('common.extensions.LinkPager.LinkPager', array(
                                'itemCount' => $totalitem,
                                'pageSize' => $limit,
                                'header' => '',
                                'htmlOptions' => array('class' => 'pagination',), // Class for ul
                                'selectedPageCssClass' => 'active',
                            ));
                            ?>
                        </div>
                    <?php } else {
                        echo 'Chưa có sản phẩm nào trong danh mục';
                    } ?>
                </div>
                <div class="col-xs-12 pad-10">

                    <div>
                        <?= $category['cat_description'] ?>
                    </div>
                    <?php
                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FACEBOOK_COMMENT));
                    ?>
                </div>
            </div>
        </div>
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
        ?>
    </div>
</div>
<script type="text/javascript">
    function getImage(ev) {
        var id = $(ev).attr('data-id');
        var url = '<?php echo Yii::app()->createUrl('economy/product/addToCompare') ?>';
        $.ajax({
            url: url,
            data: {id: id},
            type: 'get',
            dataType: 'json',
            success: function (data) {
                if (data.code == 200) {
                    if (data.first == true) {
                        $(".box-compare-page-list").html(data.html);
                    } else {
                        $(data.html).insertBefore(".box-compare-product .box-clear-product");
                    }
                } else {
                    if (data.msg) {
                        alert(data.msg);
                    }
                }
            }
        });
    }
</script>
