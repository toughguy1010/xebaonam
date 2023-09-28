<div class="category_product_detail_div_desction">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody>
            <tr>
                <td class="category_product_information_title" colspan="2">Thông tin sản phẩm</td>
            </tr>
            <?php if ($product['code']) { ?>
                <tr>
                    <td>Mã sản phẩm:</td><td><?php echo $product['code']; ?></td>
                </tr>
            <?php } ?>
            <?php
            if ($attributesShow && count($attributesShow)) {
                $attributesDynamic = AttributeHelper::helper()->getDynamicProduct($model, $attributesShow);
                foreach ($attributesDynamic as $key => $item) {
                    if (is_array($item['value']) && count($item['value'])) {
                        $item['value'] = implode(", ", $item['value']);
                    }
                    if ($item['value'])
                        echo '<tr><td>' . $item['name'] . ':</td><td>' . $item["value"] . '</td>';
                }
            }
            ?>      
        </tbody>
    </table>
</div>