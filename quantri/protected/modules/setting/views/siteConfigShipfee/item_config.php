<?php
$k = 0;
foreach ($ary_price as $price => $array_data) {
    $increment += $k;
    $k++;
    ?>
    <div class="item_config clearfix">
        <div class="item item_province">
            <label>Thành phố:</label>
            <select name="SiteConfigShipfee[province_id][<?php echo $increment ?>]" id="SiteConfigShipfee_province_id_<?php echo $increment ?>">
                <option value="<?php echo $province_id ?>"><?php echo $array_data['province_name'] == 'all' ? 'Tất cả' : $array_data['province_name'] ?></option>
            </select>
        </div>
        <div class="item item_district">
            <label class="label_district">Quận huyện:</label>
            <div class="wrap_value_district">
                <?php foreach ($array_data['district'] as $district) { ?>
                    <select name="SiteConfigShipfee[district_id][<?php echo $increment ?>][]" id="SiteConfigShipfee_district_id_<?php echo $increment ?>">
                        <option value="<?php echo $district['district_id']; ?>"><?php echo $district['district_name'] == 'all' ? 'Tất cả' : $district['district_name']; ?></option>
                    </select>
                <?php } ?>
            </div>
            <!--<a class="add_district_bonus add_district_bonus_<?php echo $increment ?>" href="javascript:void(0)"><i class="addattri icon-plus"></i></a>-->
        </div>
        <div class="item">
            <label>Phí:</label>
            <input class="numberFormat" name="SiteConfigShipfee[price][<?php echo $increment ?>]" value="<?php echo number_format($price, 0, '', '.'); ?>" id="SiteConfigShipfee_price_<?php echo $increment ?>" type="text" maxlength="10">
        </div>
        <div class="item">
            <a class="remove_item_config" href="javascript:void(0)"><i class="removeattri icon-minus"></i></a>
        </div>
    </div>
    <?php
}
?>