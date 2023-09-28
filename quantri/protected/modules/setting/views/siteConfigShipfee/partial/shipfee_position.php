<div class="col-xs-12 no-padding">
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success" role="alert"><?php echo Yii::app()->user->getFlash('success'); ?></div>
    <?php endif; ?>
    <div class="wrapper_config_shipfee">

        <?php
        if (isset($data) && count($data)) {
            $i = 0;
            foreach ($data as $province_id => $array_price) {
                ++$i;
                $this->renderPartial('item_config', array(
                    'province_id' => $province_id,
                    'ary_price' => $array_price,
                    'increment' => $i,
                        )
                );
                if (count($array_price) > 1) {
                    $i += count($array_price) - 1;
                }
            }
        } else {
            ?>
            <div class="item_config clearfix">
                <div class="item item_province">
                    <label>Thành phố:</label>
                    <select name="SiteConfigShipfee[province_id][1]" id="SiteConfigShipfee_province_id_1">
                        <?php foreach ($listprovince as $province_id => $province_name) { ?>
                            <option value="<?php echo $province_id ?>"><?php echo $province_name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="item item_district">
                    <label class="label_district">Quận huyện:</label>
                    <div class="wrap_value_district">
                        <select name="SiteConfigShipfee[district_id][1][]" id="SiteConfigShipfee_district_id_1">
                            <?php foreach ($listdistrict as $district_id => $district_name) { ?>
                                <option value="<?php echo $district_id; ?>"><?php echo $district_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <a class="add_district_bonus add_district_bonus_1" href="javascript:void(0)"><i class="addattri icon-plus"></i></a>
                </div>
                <div class="item">
                    <label>Phí:</label>
                    <input class="numberFormat" name="SiteConfigShipfee[price][1]" id="SiteConfigShipfee_price_1" type="text" maxlength="10">
                </div>
                <div class="item">
                    <a class="remove_item_config" href="javascript:void(0)"><i class="removeattri icon-minus"></i></a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="control-group form-group buttons">
        <a class="btn add_config_shipfee">Thêm</a>
    </div>
</div>