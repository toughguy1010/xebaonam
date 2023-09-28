<div class="form-search form-inline">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));
    $option0 = array('' => Yii::t('product', 'product_category'));
//    $category = new ClaCategory();
//    $category->type = ClaCategory::CATEGORY_;
//    $category->generateCategory();
//    $option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $option0);
    ?>
    <?php echo $form->textField($fileModel, 'display_name', array('class' => '', 'placeholder' => $fileModel->getAttributeLabel('file_title'))); ?>
<!--    --><?php //echo $form->dropDownList($fileModel, 'folder_id', $option, array('class' => '')); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>
    <?php $this->endWidget(); ?>

</div><!-- search-form -->