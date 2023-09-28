<?php
$productModel = new Product();
//
if (isset($product) && count($product)) {
    ?>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th align="left">ID</th>
            <th align="left">
                <?php echo $productModel->getAttributeLabel('name'); ?>
            </th>
            <th width="110" align="left">
                <?php echo $productModel->getAttributeLabel('code'); ?>
            </th>
            <th width="110" align="left">
                <?php echo $productModel->getAttributeLabel('price'); ?>
            </th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td>
                <?php
                $code = '';
                if ($product['is_configurable'] && isset($product['id_product_link'])) {
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
                $url = Yii::app()->createUrl('../economy/product/detail', array('id' => $product['id'], 'alias' => $product['alias']));
                ?>
                <?php echo '<a target="_blank" href="' . $url . '">' . $product["name"] . ((isset($product['label_ext']) && $product['label_ext']) ? ' - ' . $product['label_ext'] : '') . '</a>.'; ?>
                <?php
                ?>
            </td>
            <td><?php echo $code ?></td>

            <td>
                <?php
                if (isset($product['product_price']) && $product['product_price']) {
                    echo number_format($product['product_price'], 0, ',', '.'), $model->currency;
                } else {
                    echo Product::getPriceText($product);
                }
                ?>
            </td>
        </tr>
        </tbody>
    </table>
<?php } ?>