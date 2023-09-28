<?php 
    $shop_categories = ShopProductCategory::getShopCategoriesAdmin();
?>
<div>
    <?php if (count($categories)) { ?>
        <div class="control-group">
            <!--<label class="control-label bolder blue"><?php echo Yii::t('shop', 'chosen_category'); ?></label>-->
            <?php foreach ($categories as $category) { ?>
                <div class="checkbox">
                    <label>
                        <input disabled <?php if(in_array($category['cat_id'], $shop_categories)) echo 'checked'; ?> name="ShopCategory[]" value="<?php echo $category['cat_id'] ?>" class="ace ace-checkbox-2" type="checkbox">
                        <span class="lbl"> <?php echo $category['cat_name'] ?></span>
                    </label>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<script type="text/javascript">
    if (!Array.prototype.remove) {
        Array.prototype.remove = function (val) {
            var i = this.indexOf(val);
            return i > -1 ? this.splice(i, 1) : [];
        };
    }
    var arr_cat = <?php echo json_encode($shop_categories); ?>;
    if(arr_cat.length >= 3) {
        $('.ace-checkbox-2').not(":checked").attr('disabled', true);
    }
    $(document).ready(function () {
        $('.ace-checkbox-2').change(function () {
            var cat_id = $(this).val();
            if ($(this).is(":checked")) {
                arr_cat.push(cat_id);
            } else {
                arr_cat.remove(cat_id);
            }
            var arr_cat_length = arr_cat.length;
            if(arr_cat_length >= 3) {
                $('.ace-checkbox-2').not(":checked").attr('disabled', true);
            } else {
                $('.ace-checkbox-2').not(":checked").attr('disabled', false);
            }
        });
    });
</script>