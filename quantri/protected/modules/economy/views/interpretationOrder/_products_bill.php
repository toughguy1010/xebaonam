<?php
if (isset($items) && count($items)) {
    ?>
    <table class="">
        <thead>
        <tr>
            <th align="left" width="55%"> <?php echo Yii::t('shoppingcart', 'bill_product_name'); ?></th>
            <th width="5%" align="left"><?php echo Yii::t('shoppingcart', 'bill_product_quantity'); ?></th>
            <th width="20%" align="left"><?php echo Yii::t('shoppingcart', 'bill_product_price'); ?></th>
            <th width="20%" align="left"><?php echo Yii::t('shoppingcart', 'bill_product_total'); ?></th>
        </tr>
        </thead>
        <div style="width: 100%;border-bottom: 1px dotted"></div>
        <tbody>
        <?php foreach ($items as $item) { ?>
            <tr>

            </tr>
        <?php }; ?>
        </tbody>
    </table>
<?php } ?>