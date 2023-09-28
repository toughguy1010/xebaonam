<!-- 'news' => $news,
'products' => $product,
'productCategories' => $productCategories,
'newsCategories' => $newsCategories,
'menus' => $menus -->
<?php
$listproduct = array();
$listnews = array();
?>

<style>
    .sitemap-tree {
        margin: 20px 0;
    }

    .sitemap-tree ul {
        padding-left: 20px;
        padding-top: 8px;
    }

    .sitemap-tree li {
        list-style: disc;
        margin-bottom: 8px;
    }

    .sitemap-tree a {
        font-size: 15px;
        line-height: 1.5;
    }
</style>
<div class="sitemap-tree">
    <div class="content-product-detail-detail" style="margin-bottom: 30px;">
        <h1 style="margin-bottom: 20px;">Sơ đồ trang web</h1>
        <div class="desc">
            <p>Sơ đồ trang web <?= $this->pageTitle; ?></p>
            <a href="#" style="color:#009247" class="close-all">Đóng tất cả</a> - <a href="#" class="open-all"
                                                                                     style="color:#009247">Mở tất cả</a>
        </div>
    </div>
    <ul class="root">
        <li><a href="/">Trang chủ</a></li>
        <li><a href="/san-pham">Sản phẩm
                <span class="toggle-down">
							<i class="fa fa-angle-down"></i>
						</span>
            </a>
            <ul>
                <?php foreach ($productCategories as $key => $productCat): ?>
                    <li>
                        <a href="<?= Yii::app()->createUrl('economy/product/category', array('id' => $productCat['cat_id'], 'alias' => $productCat['alias'])) ?>">
                            <?= $productCat['cat_name'] ?>
                            <?php if ($productCat['children']): ?>
                                <span class="toggle-down">
							<i class="fa fa-angle-down"></i>
						</span>
                            <?php endif ?>
                        </a>
                        <?php if ($productCat['children']): ?>
                            <ul>
                                <?php foreach ($productCat['children'] as $key => $cat): ?>
                                    <li>
                                        <?php $listproduct = $products[$cat['cat_id']] ? $products[$cat['cat_id']] : array() ?>
                                        <a href="<?= Yii::app()->createUrl('economy/product/category', array('id' => $cat['cat_id'], 'alias' => $cat['alias'])) ?>">
                                            <?= $cat['cat_name'] ?>
                                            <?php if ($listproduct): ?>
                                                <span class="toggle-down">
											<i class="fa fa-angle-down"></i>
										</span>
                                            <?php endif ?>
                                        </a>
                                        <?php if ($listproduct): ?>
                                            <ul>
                                                <?php foreach ($listproduct as $key => $product): ?>
                                                    <li>
                                                        <a href="<?= Yii::app()->createUrl('economy/product/detail', array('id' => $product['id'], 'alias' => $product['alias'])) ?>"><?= $product['name'] ?></a>
                                                    </li>
                                                <?php endforeach ?>
                                            </ul>
                                        <?php endif ?>
                                    </li>

                                <?php endforeach ?>
                            </ul>
                        <?php endif ?>
                    </li>

                <?php endforeach ?>
            </ul>
        </li>

        <?php foreach ($newsCategories as $key => $newsCat): ?>
            <li>
                <a href="<?= Yii::app()->createUrl('news/news/category', array('id' => $newsCat['cat_id'], 'alias' => $newsCat['alias'])) ?>">
                    <?= $newsCat['cat_name'] ?>
                    <?php if ($newsCat['children']): ?>
                        <span class="toggle-down">
							<i class="fa fa-angle-down"></i>
						</span>
                    <?php endif ?>
                </a>
                <?php if ($newsCat['children']): ?>
                    <ul>
                        <?php foreach ($newsCat['children'] as $key => $cat): ?>
                            <li>
                                <?php $listnews = $news[$cat['cat_id']] ? $news[$cat['cat_id']] : array() ?>
                                <a href="<?= Yii::app()->createUrl('news/news/category', array('id' => $cat['cat_id'], 'alias' => $cat['alias'])) ?>">
                                    <?= $cat['cat_name'] ?>
                                    <?php if ($listnews): ?>
                                        <span class="toggle-down">
											<i class="fa fa-angle-down"></i>
										</span>
                                    <?php endif ?>
                                </a>
                                <?php if ($listnews): ?>
                                    <ul>
                                        <?php foreach ($listnews as $key => $new): ?>
                                            <li>
                                                <a href="<?= Yii::app()->createUrl('news/news/detail', array('id' => $new['news_id'], 'alias' => $new['alias'])) ?>"><?= $new['news_title'] ?></a>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                <?php endif ?>
                            </li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </li>
        <?php endforeach ?>
        <li><a href="<?= Yii::app()->createUrl('site/site/contact') ?>">Liên hệ</a></li>
    </ul>
</div>
<script>
    $('.toggle-down').on('click', function (e) {
        e.preventDefault();
        $(this).parent().siblings('ul').slideToggle('400');
    })
    $('.close-all').on('click', function (e) {
        e.preventDefault();
        $('.sitemap-tree ul').not('.root').slideUp('400');
    })
    $('.open-all').on('click', function (e) {
        e.preventDefault();
        $('.sitemap-tree ul').not('.root').slideDown('400');
    })
</script>