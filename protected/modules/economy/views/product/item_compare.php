<?php
if ($first) {
    ?>
    <div class="box-compare-product">
    <h2>BẢNG SO SÁNH<span class="fa fa-minus"></span></h2>
    <?php
}
if (isset($product)) {
    ?>
    <div class="item-compare-product" id="<?php echo 'item-' . $product->id ?>">
        <div class="img-item-compare">
            <a href="<?php echo Yii::app()->createUrl('economy/product/detail', array('id' => $product->id, 'alias' => $product->alias)); ?>"
               title="<?php echo $product['name']; ?>">
                <img
                    src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's150_150/' . $product['avatar_name'] ?>"
                    alt="<?php echo $product['name']; ?>">
            </a>
        </div>
        <div class="ctn-item-compare">
            <h2>
                <a href="<?php echo Yii::app()->createUrl('economy/product/detail', array('id' => $product->id, 'alias' => $product->alias)); ?>"
                   title="<?php echo $product['name']; ?>">
                    <?php echo $product['name']; ?>
                </a>
            </h2>
            <a class="remove-product" href="javascript:void(0)" onclick="removeit(this)"
               data-id="<?php echo $product['id']; ?>">XÓA</a>
        </div>
    </div>
    <?php
} ?>
<?php
if ($first) {
    ?>
    <div class="box-clear-product">
        <div class="btn-compare">
            <a href="<?php echo Yii::app()->createUrl('economy/product/compareProduct')?>">SO SÁNH</a>
        </div>
        <div class="btn-clear-all">
            <a href="javascript:void(0)" onclick="removeitall()">XÓA Tất CẢ</a>
        </div>
    </div>
    </div>
    <?php
}
