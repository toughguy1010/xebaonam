<div class="accessories-item">
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
<div class="row pk-tgxd">
    <div class="col-md-12 col-sl-12 col-xs-12">
        <h2>
            <a class="fs-hotit" href="/phu-kien" title="Phụ kiện">
                <?php echo $widget_title ?>
            </a>
            <a href="/phu-kien" title="Phụ kiện" style="float: right;color: #2965a8;font-size:13px;">
                Xem tất cả
            </a>
        </h2>
        <ul class="fs-hokey">
            <?php if (count($category)) {
                foreach ($category['child'] as $cat) { ?>
                    <li>
                        <a href="<?php $cat['link']; ?>">
                            <?php $cat['cat_name']; ?>
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
                            <a href="<?php echo $product['link']; ?>" title="<?php echo$product['name'] ?>">
                                <span class="fs-hopkimg">
                                    <img src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . '/s220_220/' . $product['avatar_name'] ?>" alt="<?php echo$product['name'] ?>">
                                </span>
                                <h3 class="fs-hopkname">
                                    <?php $product['name'] ?>
                                </h3>
                                <p class="fs-hopkpri">
                                    Giá: <?php $product['price_text'] ?>
                                </p>
                            </a>
                        </div>
                    <?php }
                } ?>
            </div>
        </div>
    </div>
</div>

</div>
<style type="text/css">
	a.fs-hotit::before{
		content: "";
		width: 100%;
	}
	a.fs-hotit {
    text-transform: uppercase;
    font-size: 19px!important;
    margin: 0px;
}
</style>