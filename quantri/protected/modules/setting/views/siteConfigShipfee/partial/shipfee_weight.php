<div class="col-xs-12 no-padding">
    <div>
        <p style="color: #00b709;">Khối lượng tính theo kg ví dụ: 0.5 -> 1kg</p>
    </div>
    <div class="wrapper_config_shipfee_weight">
        <?php
        if (isset($data_weight) && count($data_weight)) {
            $this->renderPartial('item_config_weight', array(
                'data_weight' => $data_weight,
                    )
            );
        } else {
            ?>
            <div class="item_config clearfix">
                <div class="item item_province">
                    <label>Từ:</label>
                    <input type="text" name="SiteConfigShipfeeWeight[1][from]" />
                </div>
                <div class="item item_district">
                    <label class="label_district">Đến nhỏ hơn hoặc bằng:</label>
                    <input type="text" name="SiteConfigShipfeeWeight[1][to]" />
                </div>
                <div class="item">
                    <label>Phí:</label>
                    <input class="numberFormat" name="SiteConfigShipfeeWeight[1][price]" type="text" maxlength="10">
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
        <a class="btn add_config_shipfee_weight">Thêm</a>
    </div>
</div>
<script type="text/javascript">
    var count_tag_weight = $('.wrapper_config_shipfee_weight').children('.item_config').length;
    $(document).ready(function () {
        jQuery('.add_config_shipfee_weight').click(function () {
            ++count_tag_weight;
            jQuery.getJSON(
                    "<?php echo Yii::app()->createUrl('setting/siteConfigShipfee/htmlItemconfigWeight'); ?>",
                    {count_tag: count_tag_weight},
                    function (data) {
                        $('.wrapper_config_shipfee_weight').append(data.html);
                    }
            );
        });
        
        jQuery('.remove_item_config_weight').click(function () {
            if (confirm('Bạn có chắc muốn xóa cấu hình này?')) {
                jQuery(this).parents('.item_config').remove();
            }
        });
        
    });
</script>