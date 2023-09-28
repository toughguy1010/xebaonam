<pre>
<?php 
    $data = [];
    if (isset($products) && $products) { 
        foreach ($products as $list_cat) {
            if($list_cat) {
                foreach ($list_cat as $list_product) {
                    if($list_product) {
                        foreach ($list_product as $product) {
                            $data[] = $product;
                        }
                    }
                }
            }
        } 
    }
?>
</pre>
<div class="row pk-tgxd">
    <div class="col-md-12 col-sl-12 col-xs-12">
        <h2>
            <a class="fs-hotit" href="<?= Yii::app()->createUrl("economy/product/category/",['alias'=>$category['parent']['alias'], 'id' => $category['parent']['cat_id']]) ?>">
                <?= $widget_title ?>
            </a>
            <a href="<?= Yii::app()->createUrl("economy/product/category/",['alias'=>$category['parent']['alias'], 'id' => $category['parent']['cat_id']]) ?>" style="float: right;color: #2965a8;font-size:13px;">
                Xem tất cả
            </a>
        </h2>
        <ul class="fs-hokey">
            <?php if (count($category)) {
                foreach ($category['child'] as $cat) { ?>
                    <li>
                        <a href="<?= $cat['link']; ?>">
                            <?= $cat['cat_name']; ?>
                        </a>
                    </li>
                <?php }
            } ?>
        </ul>
        <div class="fs-hopkb">
            <div class="fs-hopkrow clearfix">
                <?php if ($data) { 
                    foreach ($data as $product) {   ?>
                        <div class="fs-hopkcol">
                            <a href="<?= $product['link']; ?>" title="<?= $product['name'] ?>">
                                <span class="fs-hopkimg">
                                    <img src="<?= ClaHost::getImageHost() . $product['avatar_path'] . 's220_220/' . $product['avatar_name'] ?>" alt="<?= $product['name'] ?>">
                                </span>
                                <h3 class="fs-hopkname">
                                    <?= $product['name'] ?>
                                </h3>
                                <p class="fs-hopkpri">
                                    Giá: <?= $product['price_text'] ?>
                                </p>
                            </a>
                        </div>
                    <?php }
                } ?>
            </div>
        </div>
    </div>
</div>
