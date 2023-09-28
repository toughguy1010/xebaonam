<?php
$productModel = new Product();
$n = 1;
?>
<?php
if (isset($products) && count($products)) {
    ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th align="left">STT</th>
                <th align="left">ID</th>
                <th align="left"><?php echo $productModel->getAttributeLabel('name'); ?></th>
                <th width="110" align="left"><?php echo $productModel->getAttributeLabel('code'); ?></th>
                <th width="80" align="left"><?php echo Yii::t('common', 'quantity'); ?></th>
                <th width="110" align="left"><?php echo $productModel->getAttributeLabel('price'); ?></th>
                <th width="110" align="left"><?php echo Yii::t('common', 'total'); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($products as $product) { ?>
                <tr>
                    <td><?php echo $n++ ?></td>
                    <td>
                        <?php
                        $code = '';
                        if ($product['is_configurable']) {
                            echo $product['id_product_link'];
                            $product_link = ProductConfigurableValue::model()->findByAttributes(array('id_product_link' => $product['id_product_link']));
                            if (isset($product_link) && $product_link) {
                                $code = $product_link->code;
                            }
                        } else {
                            echo $product['id'];
                            $code = $product['code'];
                        }
                        ?>
                    </td>
                    <td>
                        <?php
//                        if(ClaUser::isSupperAdmin()) {
//                            $product_attributes = json_decode($product['product_attributes'], true);
//                            echo "<pre>";
//                            print_r($products);
//                            echo "</pre>";
//                            die();
//                        }
                        $url =  Yii::app()->createUrl('../economy/product/detail', array('id' => $product['id'], 'alias' => $product['alias']));
                        ?>
                        <?php echo $product["name"] . ((isset($product['label_ext']) && $product['label_ext']) ? ' - ' . $product['label_ext'] : ''); ?>
                        <?php
                        if ($product['product_attributes']) {
                            $product_attributes = json_decode($product['product_attributes'], true);
                            if ($product_attributes && count($product_attributes)) {
                                $shoppingCart = new ClaShoppingCart();
                                ?>
                                <div class="attr">
                                    <?php foreach ($product_attributes as $attr) { ?>
                                        <dl class="clearfix">
                                            <dt><?php echo $attr['name']; ?> : </dt>
                                            <dd><?php echo $shoppingCart->getAttributeText($attr); ?></dd>
                                        </dl>
                                    <?php } ?>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </td>
                    <td><?php echo $code ?></td>
                    <td>
                        <?php echo ($product["product_qty"]); ?>
                    </td>
                    <td>
                        <?php
                        if (isset($product['product_price']) && $product['product_price']) {
                            echo number_format($product['product_price'], 0, ',', '.'), 'đ';
                        } else {
                            echo Product::getPriceText($product);
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if (isset($product['product_price']) && $product['product_price']) {
                            echo number_format($product['product_price'] * $product['product_qty'], 0, ',', '.'), 'đ';
                        } else {
                            echo Product::getTotalPrice($product, $product["product_qty"]);
                        }
                        ?>
                    </td>
                </tr>
            <?php }; ?>
            <tr>
                <td class="span-b" colspan="3" rowspan="4"></td>
                <td  rowspan="4"> </td>
                <td style="font-weight: bold; text-align: right">1. Tổng giá</td>
                <td><?php echo Product::getPriceText(array('price' => $model['old_order_total'])); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold; text-align: right">2. Giảm giá (<?php echo $model['discount_percent'].' %'; ?>)</td>
                <td><?php echo Product::getPriceText(array('price' => $model['discount_for_dealers'])); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold; text-align: right">3. Phí vận chuyển</td>
                <td><?php echo Product::getPriceText(array('price' => $model['transport_freight'])); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold; text-align: right">Tổng cộng (1-2+3)</td>
                <td><?php echo Product::getPriceText(array('price' => $model['order_total'])); ?></td>
            </tr>
        </tbody>
    </table>
<?php } ?>