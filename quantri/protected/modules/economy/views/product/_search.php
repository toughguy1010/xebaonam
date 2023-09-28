<div class="form-search">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));
    $option0 = array('' => Yii::t('product', 'product_category'));
    $option = $this->category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $option0);
    ?>
    <?php echo $form->textField($model, 'name', array('class' => '', 'placeholder' => $model->getAttributeLabel('name'))); ?>
    <?php echo $form->textField($model, 'code', array('class' => '', 'placeholder' => $model->getAttributeLabel('code'), 'style' => 'max-width: 130px;')); ?>
    <?php echo $form->textField($model, 'slogan', array('class' => '', 'placeholder' => $model->getAttributeLabel('slogan'), 'style' => 'max-width: 130px;')); ?>
    <?php echo $form->textField($model, 'position', array('class' => '', 'placeholder' => $model->getAttributeLabel('position'), 'style' => 'max-width: 130px;')); ?>
    <?php echo $form->dropDownList($model, 'isnew', array('' => $model->getAttributeLabel('isnew'), 1 => Yii::t('common', 'yes'), 0 => Yii::t('common', 'no')), array('class' => '')); ?>
    <?php echo $form->dropDownList($model, 'ishot', array('' => $model->getAttributeLabel('ishot'), 1 => Yii::t('common', 'yes'), 0 => Yii::t('common', 'no')), array('class' => '')); ?>
    <?php echo $form->dropDownList($model, 'viewed', array('' => $model->getAttributeLabel('viewed'),
        2 => Yii::t('common', 'decrease'),
        1 => Yii::t('common', 'ascending')), array('class' => '', 'name' => 'view')); ?>
    <?php echo $form->dropDownList($model, 'status', ['' => '---'.Yii::t('common','status').'---'] + ActiveRecord::statusArray(), array('class' => '')); ?>
    <?php
    echo $form->dropDownList($model, 'state', [
        '' => '---'.Yii::t('common','state').'---',
        ActiveRecord::STATUS_ACTIVED => Yii::t('product','in_stock'),
        ActiveRecord::STATUS_DEACTIVED => Yii::t('product','out_stock')
            ], array('class' => ''));
    ?>
    <?php echo $form->dropDownList($model, 'product_category_id', $option, array('class' => '')); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->