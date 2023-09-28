<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<div class="widget widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::app()->controller->action->id != "update" ? 'Thêm nhóm mới' : 'Cập nhật nhóm'; ?>
        </h4>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'category-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'name', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'ids_group', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $selectedCat = array();
                            if (!$model->isNewRecord) {
                                $categories = $model->getGroup();
                                foreach ($categories as $key => $cat)
                                    $selectedCat[$key] = array('selected' => 'selected');
                            }

                            $this->widget('common.extensions.echosen.Chosen', array(
                                'model' => $model,
                                'attribute' => 'ids_group',
                                'multiple' => true,
                                'data' => ProductCategoryGroup::getCategoryArr(),
                                'value' => $model->ids_group,
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                    'options' => $selectedCat,
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'ids_group'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'save') : Yii::t('common', 'save'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
