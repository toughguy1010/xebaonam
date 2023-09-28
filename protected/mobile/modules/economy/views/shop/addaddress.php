<div class="item_infocontact">
    <div class="form-group no-margin-left">
        <label class="col-xs-2 control-label no-padding-left" for="ShopStore_<?php echo $count_address; ?>_address">Địa chỉ</label>
        <div class="controls col-sm-10 success">
            <input class="span12 col-sm-12" placeholder="Địa chỉ" name="ShopStore[<?php echo $count_address; ?>][address]" id="ShopStore_<?php echo $count_address; ?>_address" type="text" maxlength="255" />
        </div>
    </div>
    <div class="form-group no-margin-left">
        <label class="col-xs-2 control-label no-padding-left required" for="ShopStore_<?php echo $count_address; ?>_province_id">Tỉnh / thành phố <span class="required">*</span></label>
        <div class="controls col-sm-10">
            <select class="span12 col-sm-12" name="ShopStore[<?php echo $count_address; ?>][province_id]" id="ShopStore_<?php echo $count_address; ?>_province_id">
                <?php foreach ($listprovince as $key => $province) { ?>
                    <option value="<?php echo $key; ?>"><?php echo $province; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group no-margin-left">
        <label class="col-xs-2 control-label no-padding-left required" for="ShopStore_<?php echo $count_address; ?>_district_id">Quận / huyện <span class="required">*</span></label>
        <div class="controls col-sm-10">
            <select class="span12 col-sm-12" name="ShopStore[<?php echo $count_address; ?>][district_id]" id="ShopStore_<?php echo $count_address; ?>_district_id">
                <?php foreach ($listdistrict as $key => $district) { ?>
                    <option value="<?php echo $key; ?>"><?php echo $district; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group no-margin-left">
        <label class="col-sm-2 control-label no-padding-left required" for="ShopStore_<?php echo $count_address; ?>_ward_id">Phường xã <span class="required">*</span></label>
        <div class="controls col-sm-10">
            <select class="span12 col-sm-12" name="ShopStore[<?php echo $count_address; ?>][ward_id]" id="ShopStore_<?php echo $count_address; ?>_ward_id">
                <?php foreach ($listward as $key => $ward) { ?>
                    <option value="<?php echo $key; ?>"><?php echo $ward; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group no-margin-left">
        <label class="col-sm-2 control-label no-padding-left" for="ShopStore_<?php echo $count_address; ?>_phone">Điện thoại liên hệ</label>
        <div class="controls col-sm-10">
            <input class="span12 col-sm-12" name="ShopStore[<?php echo $count_address; ?>][phone]" id="ShopStore_<?php echo $count_address; ?>_phone" type="text" maxlength="50">
            <label class="col-sm-2 align-right" for="ShopStore_<?php echo $count_address; ?>_hotline">Hotline</label>
            <input class="span12 col-sm-12" name="ShopStore[<?php echo $count_address; ?>][hotline]" id="ShopStore_<?php echo $count_address; ?>_hotline" type="text" maxlength="50">
        </div>
    </div>
    <script type="text/javascript">
        jQuery(document).on('change', '#ShopStore_<?php echo $count_address; ?>_province_id', function () {
            jQuery.ajax({
                url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
                data: 'pid=' + jQuery('#ShopStore_<?php echo $count_address; ?>_province_id').val(),
                dataType: 'JSON',
                beforeSend: function () {
                    w3ShowLoading(jQuery('#ShopStore_<?php echo $count_address; ?>_province_id'), 'right', 20, 0);
                },
                success: function (res) {
                    if (res.code == 200) {
                        jQuery('#ShopStore_<?php echo $count_address; ?>_district_id').html(res.html);
                    }
                    w3HideLoading();
                    getWard<?php echo $count_address; ?>();
                },
                error: function () {
                    w3HideLoading();
                }
            });
        });

        jQuery(document).on('change', '#ShopStore_<?php echo $count_address; ?>_district_id', function () {
            getWard<?php echo $count_address; ?>();
        });

        function getWard<?php echo $count_address; ?>() {
            jQuery.ajax({
                url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getward') ?>',
                data: 'did=' + jQuery('#ShopStore_<?php echo $count_address; ?>_district_id').val(),
                dataType: 'JSON',
                beforeSend: function () {
                    w3ShowLoading(jQuery('#ShopStore_<?php echo $count_address; ?>_district_id'), 'right', 20, 0);
                },
                success: function (res) {
                    if (res.code == 200) {
                        jQuery('#ShopStore_<?php echo $count_address; ?>_ward_id').html(res.html);
                    }
                    w3HideLoading();
                },
                error: function () {
                    w3HideLoading();
                }
            });
        }
    </script>
    <hr style="margin-top: 0px;">
</div>