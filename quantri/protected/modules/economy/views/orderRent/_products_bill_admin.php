<table style="margin-top: 40px" class="table table-hover table-bordered">
    <thead>
    <tr>
        <th class="col-3">Sản phẩm</th>
        <th class="col-3">Dung lượng</th>
        <th class="col-3">Số lượng</th>
        <th class="col-1">Thời gian thuê</th>
        <th class="col-3">Thành tiền</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($items) {
        ?>
        <?php foreach ($items as $key => $value) { ?>
            <tr>

                <td class="file-name">
                    <?php
                        echo RentProduct::model()->findByPk($value['rent_product_id'])->name;
                    ?>
                </td>
                <td class="file-name">
                    <?php
                        echo RentCategories::model()->findByPk($value['rent_category_id'])->cat_name;
                    ?>
                </td>
                <td class="count-char"><?=$value['quantity']; ?>  </td>
                <td class="count-char"><?= date('d/m/Y', $value['rent_from']) . ' -> ' . date('d/m/Y', $value['rent_to']); ?> </td>
                <td class="count-char"><?= ($value['price'] != '0.00') ? HtmlFormat::money_format($value['price'] * $value['quantity']) . ' ' . $value['currency'] : 'Liên hệ'; ?>  </td>
            </tr>
        <?php } ?>

    <?php } ?>
    </tbody>
</table>