<?php $this->renderPartial('script/attributescript'); ?>
<div class="product-attribute-tab">
    <?php
    $siteinfo = Yii::app()->siteinfo;
    $site_skin = str_replace('w3ni', '', $siteinfo['site_skin']);
    $category = ProductCategories::model()->findByPk($model->product_category_id);
    $attribute_set_id = ($category) ? $category->attribute_set_id : 0;
    if ($attribute_set_id) {
        // attribute normal
        echo EconomyAttributeHelper::helper()->attRenderHtmlAll($attribute_set_id, $productInfo);
        // attribute configurable
        if (count($attributes_cf)) {
            $this->renderPartial('partial/subtabconfigurablenew', array('model' => $model, 'productInfo' => $productInfo, 'attributes_cf' => $attributes_cf));
        }
        // attribute change price
        if (count($attributes_changeprice)) {
            $this->renderPartial('partial/subtabchangeprice', array('model' => $model, 'attributes_changeprice' => $attributes_changeprice));
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