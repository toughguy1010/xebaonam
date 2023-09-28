<div class="form-search form-inline">

    <?php

    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));
    $option0 = array('' => Yii::t('news', 'news_category'));
    $category = new ClaCategory();
    $category->type = ClaCategory::CATEGORY_NEWS;
    $category->generateCategory();
    $option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $option0);
    ?>

    <?php echo $form->textField($newsModel, 'news_title', array('class' => '', 'placeholder' => $newsModel->getAttributeLabel('news_title'))); ?>
    <?php echo $form->dropDownList($newsModel, 'news_category_id', $option, array('class' => '')); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->