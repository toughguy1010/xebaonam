<?php 
    $shop_categories = ShopProductCategory::getShopCategories();
    $category = new ClaCategory();
    $category->type = ClaCategory::CATEGORY_PRODUCT;
    $category->generateCategory();
    $option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $array);
    
?>
<div>
    <?php if (count($categories)) { ?>
        <div class="control-group">
            <label class="control-label bolder blue"><?php echo Yii::t('shop', 'chosen_category'); ?></label>
            <p><span><i>(Bạn được chọn tối đa <?php echo $model->allow_number_cat ?> danh mục)</i></span></p>
            <?php foreach ($option as $cat_id => $cat_name) { ?>
                <div class="checkbox">
                    <label>
                        <input <?php if(in_array($cat_id, $shop_categories)) echo 'checked'; ?> name="ShopCategory[]" value="<?php echo $cat_id ?>" class="ace ace-checkbox-2" type="checkbox">
                        <span class="lbl"> <?php echo $cat_name ?></span>
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
    var allow_number_cat = <?php echo $model->allow_number_cat ?>;
    if(arr_cat.length >= allow_number_cat) {
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
            if(arr_cat_length >= allow_number_cat) {
                $('.ace-checkbox-2').not(":checked").attr('disabled', true);
            } else {
                $('.ace-checkbox-2').not(":checked").attr('disabled', false);
            }
        });
    });
</script>