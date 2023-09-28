<div class="form-search">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));
    $shop_categories = ShopProductCategory::getShopCategories();
    $option0 = array('' => Yii::t('product', 'product_category'));
    $option = $this->category->createOptionArrayShop(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $option0, $shop_categories);
    ?>

    <?php echo $form->textField($model, 'name', array('class' => '', 'placeholder' => $model->getAttributeLabel('name'))); ?>
    <?php echo $form->dropDownList($model, 'product_category_id', $option, array('class' => '')); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->