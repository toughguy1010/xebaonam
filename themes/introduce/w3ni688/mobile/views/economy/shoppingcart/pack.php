<?php
$productModel = new Product();
?>
<?php
$productModel = new Product();
$count_pr = count($shoppingCart->findAllProducts());
?>
<style>
    .infoproduct div.km {
        margin: 0;
    }
    .km1 {
        color: #4a90e2;
        cursor: pointer;
        position: relative;
        margin-left: 80px !important;
        font-weight: 600;
    }
    .infoproduct div a label {
        color: #333;
    }
    .choosenumber {
        float: right;
        overflow: hidden;
        position: relative;
        width: 100px;
        border: 1px solid #dfdfdf;
        background: #fff;
        border-radius: 3px;
        line-height: 30px;
        font-size: 14px;
        color: #333;
    }
    .choosenumber .minus {
        float: left;
        border-right: 1px solid #dfdfdf;
        background: #fff;
        width: 30px;
        height: 30px;
        position: relative;
        cursor: pointer;
        border: none;
    }
    .choosenumber .number {
        width: 30px;
        height: 30px;
        border: none;
        text-align: center;
        outline: none;
        border: 1px solid #ededed;
        position: relative;
    }
    .choosenumber {
        width: 93px;
        display: flex !important;
        position: absolute;
        top: 80px;
        right: inherit;
        left: 115px;
    }
    .infoproduct div.delete-item {

    }
    .infoproduct div.delete-item span {
        float: left;
        text-decoration: none;
        width: 12px;
        height: 12px;
        background: #ccc;
        color: #fff;
        line-height: 8px;
        text-align: center;
        border-radius: 100%;
        margin-right: 5px;
    }
    .infoproduct div.delete-item a {
        display: flex;
        align-items: center;
        color: #999;
    }
    #wrap_cart {
        background: #fff;
        padding-top: 30px;
    }
    .area-total {
        display: block;
        overflow: visible;
        border-top: 1px solid #ececec;
        padding: 10px 30px;
        float: left;
        width: 100%;
    }
    .infoproduct {
        padding: 10px 30px;
    }
    .area-total .total-provisional {
        display: block;
        overflow: hidden;
        padding-bottom: 10px;
    }
    .area-total .total-provisional span,.area-total .total-price strong {
        float: left;
        color: #333;
    }
    .area-total .total-provisional span:nth-child(2) {
        float: right;
    }
    .area-total .total-price strong:nth-child(2) {
        float: right;
        color: #f30c28;
    }

</style>
<?php foreach ($shoppingCart->findAllProducts() as $key => $product) {
    ?>
    <div class="infoproduct">
        <a class="linksp">
            <img width="40" height="40"
                 src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's80_80/' . $product['avatar_name'] ?>"
                 alt="<?= $product['name'] ?>">
        </a>
        <div>
            <a href="<?= Yii::app()->createUrl('economy/product/detail', ['id' => $product->id, 'alias' => $product->alias]) ?>"
               title="<?= $product['name'] ?> target=" _blank">
            <label><?= $product['name'] ?></label>
            </a>
        </div>
        <div id="price-Product">
            <?php if ($product['price_market'] >0) {
                $discount = 'Giảm ' . ClaProduct::getDiscount((int)$product['price_market'], (int)$product['price']) . '%';
                ?>
                <i>-<?= $discount ?></i> Giá sản phẩm
                <span class="line-price"><?= number_format($product['price_market'], 0, '', '.') . '₫' ?></span>
            <?php } ?>
            <strong><?= number_format($product['price'], 0, '', '.') . '₫' ?> </strong>
        </div>
        <div class="km">Chi tiết khuyến mãi</div>
        <!-- Khuyến mãi -->
        <div class="boxShowKM" style="display: none;">
            <?= $product['product_sortdesc'] ?>
        </div>
        <?php
        $attributes = $shoppingCart->getAttributesByKey($key);
        if ($attributes && count($attributes)) {
            ?>
            <div class="km1">
                <?php foreach ($attributes as $attr) {
                    ?>

                    <?php echo $attr['name']; ?> : <?php echo $attr['value']; ?>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="a-center choosenumber">
            <button onclick="decreaseQty('#quantity-<?php echo $key; ?>', '<?= $key ?>')" class="reduced items-count btn-minus minus" type="button">–</button>
            <input onblur="updateQuantity('<?php echo $key; ?>', $('#quantity-<?php echo $key; ?>').val());" type="text" maxlength="3" min="1" step="1" class="input-text number-sidebar qtyItem number" id="quantity-<?php echo $key; ?>" name="qty" value="<?php echo $shoppingCart->getQuantity($key); ?>" />
            <button onclick="increaseQty('#quantity-<?php echo $key; ?>', '<?= $key ?>')" class="increase items-count btn-plus plus minus" type="button">+</button>
        </div>
        <div class="delete-item">
            <a onclick="return confirm('<?php echo Yii::t('notice', 'delete_product_from_cart_confirm'); ?>')" class="button remove-item remove-item-cart" title="<?php echo Yii::t('common', 'delete'); ?>" href="<?php echo $this->createUrl('/economy/shoppingcart/delete', array('key' => $key)); ?>">
                <span>x</span> Xóa
            </a>
        </div>
    </div>
<?php } ?>
<div class="area-total">
    <div class="total-provisional">
        <span class="total-product-quantity">Tạm tính (<?=$count_pr?> sản phẩm):</span>
        <span class="temp-total-money"><?php echo $shoppingCart->getTotalPrice(); ?></span>
    </div>
    <div class="total-price"><strong>Tổng tiền:</strong><strong><?php echo $shoppingCart->getTotalPrice(); ?>₫</strong>
    </div>
</div>

<script type="text/javascript">

    function increaseQty(id, key) {
        var current = $(id).val();
        current++;
        $(id).val(current);
        var quantity = $(id).val();
        document.location = "<?php echo $this->createUrl('/economy/shoppingcart/update') ?>" + "?key=" + key + "&qty=" + quantity;
    }

    function decreaseQty(id, key) {
        var current = $(id).val();
        if (current > 1) {
            current--;
        }
        $(id).val(current);
        var quantity = $(id).val();
        document.location = "<?php echo $this->createUrl('/economy/shoppingcart/update') ?>" + "?key=" + key + "&qty=" + quantity;
    }

</script>

