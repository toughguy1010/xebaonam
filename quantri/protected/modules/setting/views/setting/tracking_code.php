<div class="widget widget-box">
    <div class="widget-header">
        <h4>Cấu hình mã tracking các trang</h4>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">


                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'site-settings-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'homepage', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'homepage', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'homepage'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'product', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'product', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'product'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'product_detail', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'product_detail', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'product_detail'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'news', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'news', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'news'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'news_detail', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'news_detail', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'news_detail'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'shoppingcart', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'shoppingcart', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'shoppingcart'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'checkout', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'checkout', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'checkout'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'checkout_success', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'checkout_success', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'checkout_success'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'update') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>