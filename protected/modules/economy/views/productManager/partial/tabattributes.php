<?php $this->renderPartial('script/attributescript'); ?>
<div class="product-attribute-tab">
    <?php
    $category = ProductCategories::model()->findByPk($model->product_category_id);
    $attribute_set_id = ($category) ? $category->attribute_set_id : 0;
    if ($attribute_set_id) {
        echo EconomyAttributeHelper::helper()->attRenderHtmlAll($attribute_set_id, $productInfo);
        if (count($attributes_cf)) {
            ?>                           
            <?php $this->renderPartial('partial/subtabconfigurable', array('model' => $model, 'productInfo' => $productInfo, 'attributes_cf' => $attributes_cf)); ?>                                    
            <?php
        }
    } else {
        if ($model->isNewRecord) {
            echo "Vui lòng chọn danh mục sản phẩm";
        } else {
            echo "Sản phẩm không có thuộc tính! Vui lòng chọn bộ thuộc tính cho danh mục sản phẩm này";
        }
    }
    ?>
</div>