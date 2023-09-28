<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "editcat" ? Yii::t('category', 'category_product_create') : Yii::t('category', 'category_product_update'); ?>
        </h4></div>
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
                        <?php echo $form->labelEx($model, 'cat_name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'cat_name', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'cat_name'); ?>
                        </div>
                    </div>
                    <?php if (!$model->isNewRecord) { ?>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php echo $form->textField($model, 'alias', array('class' => 'span10 col-sm-12')); ?>
                                <?php echo $form->error($model, 'alias'); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'cat_parent', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'cat_parent', $option, array('class' => 'span10 col-sm-4')); ?>
                            <?php echo $form->error($model, 'cat_parent'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'status'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('category', 'category_create') : Yii::t('category', 'category_save'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
                    </div>

                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>