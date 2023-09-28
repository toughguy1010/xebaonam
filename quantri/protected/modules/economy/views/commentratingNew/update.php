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
                                <?php echo $model->name; ?>
                            </div>
                        </div>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'product_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php
                                echo CommentRating::getNameAndLink(['id' => $model->object_id, 'type' => $model->type]);
                                ?>
                            </div>
                        </div>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php echo $model->name; ?>
                            </div>
                        </div>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'comment', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php echo $model->comment; ?>
                            </div>
                        </div>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'rating', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php echo $model->rating; ?>
                            </div>
                        </div>

                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'type', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php echo $model->name; ?>
                            </div>
                        </div>
                        <!--                        --><?php //if ($model->status == 0) { ?>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
                                <?php echo $form->error($model, 'status'); ?>
                            </div>
                        </div>
                        <!--                        --><?php //} ?>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'created_time', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php echo date("d-m-Y H:s:t", $model->created_time); ?>
                            </div>
                        </div>
                        <div class="control-group form-group buttons">
                            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'save') : Yii::t('common', 'save'), array('class' => 'btn btn-info', 'id' => 'savenews')); ?>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div><!-- form -->
                <hr>
                <?php
                $this->renderPartial('partial/_list_comment_ans', array(
                    'answer' => $answer,
                ));
                ?>
                <?php
                $this->renderPartial('partial/_form_anwser', array(
                    'answer' => $answer,
                ));
                ?>
            </div><!-- form -->
        </div><!-- form -->
    </div><!-- form -->
</div><!-- form -->