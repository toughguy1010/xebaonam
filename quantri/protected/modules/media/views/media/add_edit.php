<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('common', 'update') : Yii::t('common', 'update'); ?>
        </h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'category-form',
                        'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'name', array('class' => 'span10 col-sm-12', 'disabled' => true)); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'email', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'email'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'phone', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'phone'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'address', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'address'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo CHtml::label(Yii::t('file', 'select_image'), '', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->hiddenField($model, 'image_src', array('class' => 'span12 col-sm-12')); ?>
                            <div class="row" style="margin: 10px 0px;">
                                <?php if ($model->id && $model->image_src) { ?>
                                    <div style="max-height: 200px; overflow: hidden; display: block; margin-bottom: 15px;">
                                        <?php $this->renderPartial('partial/image_view', array('model' => $model)); ?>
                                    </div>
                                <?php } ?>
                                <?php echo CHtml::fileField('image_src', ''); ?>
                            </div>
                            <?php echo $form->error($model, 'image_src'); ?>
                        </div>

                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'status', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusPrintImageArray(), array('class' => 'form-control w3-form-input')); ?>
                            <?php echo $form->error($model, 'status'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'payment_method', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'payment_method', ActiveRecord::statusPaymentMethod(), array('class' => 'form-control w3-form-input')); ?>
                            <?php echo $form->error($model, 'payment_method'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'payment_status', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'payment_status', ActiveRecord::statusPayment(), array('class' => 'form-control w3-form-input')); ?>
                            <?php echo $form->error($model, 'payment_status'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'transport_method', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'transport_method', ActiveRecord::transportMethod(), array('class' => 'form-control w3-form-input')); ?>
                            <?php echo $form->error($model, 'transport_method'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'note', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'note', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'note'); ?>
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
