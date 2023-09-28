<?php
$productModel = new Product();
?>
<?php
if (count($shoppingCart->findAllProducts()[$set])) {
    ?>

    <?php
    $productModel = new Product();
    ?>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th style="width: 80px; text-align: center"><?php echo Yii::t('common', 'picture'); ?></th>
            <th><?php echo $productModel->getAttributeLabel('name'); ?></th>
            <th style="width: 130px; text-align: center"><?php echo $productModel->getAttributeLabel('code'); ?></th>
            <th style="width: <?php echo (!isset($update) || $update) ? '180' : '80'; ?>px; text-align: center"><?php echo Yii::t('common', 'quantity'); ?></th>
            <th style="width: 110px; text-align: center"><?php echo $productModel->getAttributeLabel('price'); ?></th>
            <th style="width: 110px; text-align: center"><?php echo Yii::t('common', 'total'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($shoppingCart->findAllProducts()[$set] as $key => $product) { ?>
            <tr>
                <td class="muted center_text"><a href="<?php echo $product['link']; ?>">
                        <img
                            src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's50_50/' . $product['avatar_name']; ?>"></a>
                </td>
                <td>
                    <a href="<?php echo $product['link']; ?>" class="product-name">
                        <?php echo $product["name"]; ?>
                    </a>
                    <?php
                    $attributes = $shoppingCart->getAttributesByKey($key);
                    if ($attributes && count($attributes)) {
                        ?>
                        <div class="attr">
                            <?php foreach ($attributes as $attr) { ?>
                                <dl class="clearfix">
                                    <dt><?php echo $attr['name']; ?> :</dt>
                                    <dd><?php echo $shoppingCart->getAttributeText($attr); ?></dd>
                                </dl>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </td>
                <td>
                    <?php if (isset($product["code"])) echo $product["code"]; ?>
                </td>
                <td>
                    <?php if (!isset($update) || $update) { ?>
                        <form class="form-inline" role="form"
                              action="<?php echo $this->createUrl('/economy/shoppingcart/update', array('key' => $key,'set' => $set)); ?>"
                              method="GET" enctype="multipart/form-data">
                            <input
                                onchange="updateQuantity('<?php echo $key; ?>', $('#quantity-<?php echo $key; ?>').val(),<?php echo $set?>);"
                                id="quantity-<?php echo $key; ?>" type="number" class="form-control sc-quantity"
                                max-lenght="3" value="<?php echo $shoppingCart->getQuantity($key,$set); ?>" name="qty"
                                min="1" step="1" max-lenght="3"/>
                            <a onclick="updateQuantity('<?php echo $key; ?>', $('#quantity-<?php echo $key; ?>').val());"
                               class="btn btn-xs btn-primary"><i class="ico ico-refrest"></i></a>
                            <a href="<?php echo $this->createUrl('/economy/shoppingcart/delete', array('key' => $key,'set'=>$set)); ?>"
                               class="btn btn-xs btn-danger"><i class="ico ico-delete"></i></a>
                        </form>
                    <?php } else { ?>
                        <?php echo $shoppingCart->getQuantity($key); ?>
                    <?php } ?>
                </td>
                <td style="text-align:right;"><?php echo Product::getPriceText($product); ?></td>
                <td style="text-align:right;">  <?php echo HtmlFormat::money_format2($shoppingCart->getTotalPriceForProduct($key,
                            false, $product['is_configurable'], $set)) . ' VND'; ?></td>
            </tr>
        <?php }; ?>
        <tr class="sc-totalprice-row">
            <td colspan="5">
                <div class="sc-totalprice-text">
                    <span><?php echo Yii::t('shoppingcart', 'subtotal') ?>:</span>
                </div>
                <div class="sc-totalprice-text">
                    <span><?php echo Yii::t('shoppingcart', 'total') ?>:</span>
                </div>
            </td>
            <td style="text-align:right;">
                <div class="sc-totalprice"><?php echo HtmlFormat::money_format2($shoppingCart->getSetTotalPrice($set, false)).' VNĐ'; ?></div>
                <div class="sc-totalprice"><?php echo HtmlFormat::money_format2($shoppingCart->getSetTotalPrice($set, false)).' VNĐ'; ?></div>
            </td>
        </tr>
        </tbody>
    </table>
    <?php
} ?>