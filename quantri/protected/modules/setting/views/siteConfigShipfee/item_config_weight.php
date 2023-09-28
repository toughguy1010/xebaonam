<?php
$i = 0;
foreach ($data_weight as $item) {
    ++$i;
    ?>
    <div class="item_config clearfix">
        <div class="item item_province">
            <label>Từ:</label>
            <input type="text" value="<?php echo $item['from'] ?>" name="SiteConfigShipfeeWeight[<?php echo $i; ?>][from]" />
        </div>
        <div class="item item_district">
            <label class="label_district">Đến nhỏ hơn hoặc bằng:</label>
            <input type="text" value="<?php echo $item['to'] ?>" name="SiteConfigShipfeeWeight[<?php echo $i; ?>][to]" />
        </div>
        <div class="item">
            <label>Phí:</label>
            <input class="numberFormat" value="<?php echo number_format($item['price'], 0, '', '.'); ?>" name="SiteConfigShipfeeWeight[<?php echo $i; ?>][price]" type="text" maxlength="10">
        </div>
        <div class="item">
            <a class="remove_item_config_weight" href="javascript:void(0)"><i class="removeattri icon-minus"></i></a>
        </div>
    </div>
    <?php
}
?>