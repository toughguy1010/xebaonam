<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('hospital', 'create') : Yii::t('hospital', 'update'); ?>
        </h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'language-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'url', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'url', array('class' => 'span10 col-sm-12', 'placeholder' => 'Hãy nhập URL Sản phẩm hoặc URL Danh mục sản phẩm')); ?>
                            <?php echo $form->error($model, 'url'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'campaign_source', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'campaign_source', array('class' => 'span10 col-sm-12', 'placeholder' => 'VD: google, facebook...')); ?>
                            <?php echo $form->error($model, 'campaign_source'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'aff_type', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'aff_type', array('class' => 'span10 col-sm-12', 'placeholder' => 'VD: cpc, banner, email...')); ?>
                            <?php echo $form->error($model, 'aff_type'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'campaign_name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'campaign_name', array('class' => 'span10 col-sm-12', 'placeholder' => 'VD: Tên Sản Phẩm, Chương trình, Sự kiện...')); ?>
                            <?php echo $form->error($model, 'campaign_name'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'campaign_content', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'campaign_content', array('class' => 'span10 col-sm-12', 'placeholder' => 'Nội dung chiến dịch dùng để phân biệt các quảng cáo')); ?>
                            <?php echo $form->error($model, 'campaign_content'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('hospital', 'create') : Yii::t('hospital', 'update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
