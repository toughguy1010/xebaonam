<?php
$productModel = new Product();
?>
<?php
if (isset($products) && count($products)) {
    ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
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
                        ?>
                        <a href="<?php echo Yii::app()->createUrl('economy/product/update', array('id' => $product['id'])); ?>">
                            <?php echo $product["name"] . ((isset($product['label_ext']) && $product['label_ext']) ? ' - ' . $product['label_ext'] : ''); ?>
                        </a>
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
                    <td><?php echo Product::getPriceText($product); ?></td>
                    <td><?php echo Product::getTotalPrice($product, $product["product_qty"]); ?></td>
                </tr>
            <?php }; ?>		  
        </tbody>
    </table>
<?php } ?>