<style type="text/css">
    #att_options .attributeitem-head {
        margin-top: 8px;
    }
    #att_options .attributeitem {
        margin-top: 8px;
        margin-bottom: 30px;
    }
    #att_options .attributeitem input, select {
        margin-right: 20px;
    }
    #att_options .attributeitem-head span.head-t {
        margin-right: 20px;
    }
    .addattri {
        cursor: pointer;
    }
    .removeattri, .removeattriold{
        cursor: pointer;
        margin-left: 20px;
    }
</style>
<?php
$options = RentProductPrice::getAllPriceByProductId($model->id);
?>
<div class="wrapper-rent-price" id="att_options">
    <div class="attributeitem-head controls row">
        <span class="col-sm-2 head-t">Dung lượng</span>
        <span class="col-sm-2 head-t">Giá thị trường</span>
        <span class="col-sm-2 head-t">Giá</span>
        <span class="col-sm-2 head-t">Phí bảo hiểm</span>
        <span class="col-sm-2 head-t">Đặt cọc</span>
        <span class="col-sm-1 head-t">Thêm/xóa</span>
    </div>
    <?php if (isset($options) && $options) { ?>
        <?php foreach ($options as $opt) { ?>
            <div class="attributeitem controls row opupdate" id="<?php echo $opt['id']; ?>">
                <select name="RentProductPrice[update][<?= $opt['id'] ?>][rent_category_id]" class="col-sm-2">
                    <?php foreach ($option_category as $category_id => $category_name) { ?>
                        <option <?= $category_id == $opt['rent_category_id'] ? 'selected' : '' ?> value="<?= $category_id ?>"><?= $category_name ?></option>
                    <?php } ?>
                </select>
                <input name="RentProductPrice[update][<?= $opt['id'] ?>][price_market]" class="col-sm-2" value="<?= $opt['price_market'] ?>" type="text">            
                <input name="RentProductPrice[update][<?= $opt['id'] ?>][price]" class="col-sm-2" value="<?= $opt['price'] ?>" type="text">
                <input name="RentProductPrice[update][<?= $opt['id'] ?>][insurance_fee]" class="col-sm-2" value="<?= $opt['insurance_fee'] ?>" type="text">
                <input name="RentProductPrice[update][<?= $opt['id'] ?>][deposits]" class="col-sm-2" value="<?= $opt['deposits'] ?>" type="text">
                <span class="help-inline action col-sm-1">
                    <i class="addattri icon-plus" onclick="addNewPrice()"></i>
                    <i class="removeattriold icon-minus" onclick="removeNewPrice(this)"></i>
                </span>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="attributeitem controls row">
            <select name="RentProductPrice[new][0][rent_category_id]" class="col-sm-2">
                <?php foreach ($option_category as $category_id => $category_name) { ?>
                    <option value="<?= $category_id ?>"><?= $category_name ?></option>
                <?php } ?>
            </select>
            <input name="RentProductPrice[new][0][price_market]" class="col-sm-2" value="" type="text">            
            <input name="RentProductPrice[new][0][price]" class="col-sm-2" value="" type="text">
            <input name="RentProductPrice[new][0][insurance_fee]" class="col-sm-2" value="" type="text">
            <input name="RentProductPrice[new][0][deposits]" class="col-sm-2" value="" type="text">
            <span class="help-inline action col-sm-1">
                <i class="addattri icon-plus" onclick="addNewPrice()"></i>
                <i class="removeattri icon-minus" style="display: none;"></i>
            </span>
        </div>
    <?php } ?>
</div>

<script type="text/javascript">
    var stt = 0;
    function addNewPrice() {
        stt++;
        var html = '';
        html += '<div class="attributeitem controls row">';
        //
        html += '<select name="RentProductPrice[new][' + stt + '][rent_category_id]" class="col-sm-2">';
<?php foreach ($option_category as $category_id => $category_name) { ?>
            html += '<option value="<?= $category_id ?>"><?= $category_name ?></option>';
<?php } ?>
        html += '</select>';
        //
        html += '<input name="RentProductPrice[new][' + stt + '][price_market]" class="col-sm-2" value="" type="text">';
        html += '<input name="RentProductPrice[new][' + stt + '][price]" class="col-sm-2" value="" type="text">';
        html += '<input name="RentProductPrice[new][' + stt + '][insurance_fee]" class="col-sm-2" value="" type="text">';
        html += '<input name="RentProductPrice[new][' + stt + '][deposits]" class="col-sm-2" value="" type="text">';
        //
        html += '<span class="help-inline action col-sm-1">';
        html += '<i class="addattri icon-plus" onclick="addNewPrice()"></i>';
        html += '<i class="removeattri icon-minus" onclick="removeNewPrice(this)"></i>';
        html += '</span>';
        //
        html += '</div>';
        $('#att_options').append(html);
    }

    function removeNewPrice(_this) {
        if (confirm('Bạn có chắc muốn xóa')) {
            if (jQuery(_this).parents('.attributeitem').hasClass('opupdate')) {
                jQuery(_this).parents('#att_options').append('<input name=\"RentProductPrice[delete][' + jQuery(_this).parents('.attributeitem').attr('id') + ']\" type=\"hidden\" value=\"' + jQuery(_this).parents('.attributeitem').attr('id') + '\">');
            }
            $(_this).closest('.row').remove();
        }
    }

</script>