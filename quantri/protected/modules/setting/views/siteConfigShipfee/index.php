<style type="text/css">
    .item_config{ padding: 15px; border-bottom: 1px solid #eeeeee; }
    .item_config .item{ float: left; margin-right: 25px; }
    .add_district_bonus{ font-size: 18px; margin-left: 10px; display: inline-block; color: #428bca; }
    .remove_district_bonus{ font-size: 18px; margin-left: 10px; display: inline-block; color: #ff0000; }
    .remove_district_bonus:hover{ color: #ff2d2d; }
    .remove_item_config{color: #ff0000; font-size: 18px;}
    .remove_item_config:hover{color: #ff2d2d}
    .wrap_value_district{ display: inline-block; }
    .wrap_value_district select{ display: block; margin-bottom: 5px; width: 150px; }
    .label_district{ display: block; float: left; margin-right: 5px; }
    .item_province select{ width: 150px; }
</style>
<div class="widget widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('site', 'manage_config_shipfee'); ?>
        </h4>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php if (Yii::app()->user->hasFlash('success')): ?>
                        <div class="alert alert-success" role="alert"><?php echo Yii::app()->user->getFlash('success'); ?></div>
                    <?php endif; ?>
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'site-settings-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
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
                                    <label>Giá:</label>
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
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'update') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var count_tag = $('.wrapper_config_shipfee').children('.item_config').length;
    $(document).ready(function () {
        jQuery('.add_district_bonus_1').click(function () {
            var html = '<select name="SiteConfigShipfee[district_id][1][]">';
            var option_select = $(this).prev('.wrap_value_district').children('select').first().html();
            html += option_select;
            html += '</select>';
            $(this).prev('.wrap_value_district').append(html);
        });

        jQuery('.add_config_shipfee').click(function () {
            ++count_tag;
            jQuery.getJSON(
                    "<?php echo Yii::app()->createUrl('setting/siteConfigShipfee/htmlItemconfig'); ?>",
                    {count_tag: count_tag},
                    function (data) {
                        $('.wrapper_config_shipfee').append(data.html);
                    }
            );
        });

        jQuery('.remove_item_config').click(function () {
            if (confirm('Bạn có chắc muốn xóa cấu hình này?')) {
                jQuery(this).parents('.item_config').remove();
            }
        });

    });

    jQuery(document).on('change', '#SiteConfigShipfee_province_id_1', function () {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/setting/siteConfigShipfee/getdistrict') ?>',
            data: 'pid=' + jQuery('#SiteConfigShipfee_province_id_1').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#SiteConfigShipfee_province_id_1'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#SiteConfigShipfee_district_id_1').html(res.html);
                }
                w3HideLoading();
            },
            error: function () {
                w3HideLoading();
            }
        });
    });
    jQuery(".numberFormat").keypress(function (e) {
        return w3n.numberOnly(e);
    }).keyup(function (e) {
        var value = $(this).val();
        if (value != '') {
            var valueTemp = w3n.ToNumber(value);
            var formatNumber = w3n.FormatNumber(valueTemp);
            if (value != formatNumber)
                $(this).val(formatNumber);
        }
    });
</script>
