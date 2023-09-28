<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen/chosen.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen/chosen.jquery.js"></script>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('comment', 'commentrating_manger'); ?>
        </h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'commentrating',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                    ));
                    ?>

                    <div class="control-group form-group">
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
                                <?php echo $form->error($model, 'name'); ?>
                            </div>
                        </div>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'object_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <select data-placeholder="Chọn sản phẩm" name="Comment[object_id]" id="Comment_object_id"
                                        class="chosen-product span12 col-sm-6" tabindex="2">
                                    <?php foreach ($option_product as $option_product_id => $option_product_name) { ?>
                                        <option <?php echo $model->object_id == $option_product_id ? 'selected' : '' ?>
                                            value="<?php echo $option_product_id ?>"><?php echo $option_product_name ?></option>
                                    <?php } ?>
                                </select>
                                <?php echo $form->error($model, 'object_id'); ?>
                            </div>
                            <div class="controls col-sx-2">
                            </div>
                        </div>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'email_phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php echo $form->textField($model, 'email_phone', array('class' => 'span12 col-sm-12')); ?>
                                <?php echo $form->error($model, 'email_phone'); ?>
                            </div>
                        </div>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'content', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php echo $form->textArea($model, 'content', array('class' => 'span12 col-sm-12')); ?>
                                <?php echo $form->error($model, 'content'); ?>
                            </div>
                        </div>
                        <div class="control-group form-group buttons">
                            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'save') : Yii::t('common', 'save'), array('class' => 'btn btn-info', 'id' => 'savenews')); ?>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div><!-- form -->
            </div><!-- form -->
        </div><!-- form -->
    </div><!-- form -->
</div><!-- form -->

<script type="text/javascript">
    var config = {
        '.chosen-product': {}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>