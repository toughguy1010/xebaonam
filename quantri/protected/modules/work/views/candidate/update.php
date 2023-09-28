<div class="widget widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('work', 'candidate_create') : Yii::t('work', 'candidate_update'); ?>
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
                        <?php echo $form->labelEx($model, 'country_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $this->widget('common.extensions.echosen.Chosen', array(
                                'model' => $model,
                                'attribute' => 'country_id',
                                'data' => (new JobsCountry())->options(['promt' => 'Chọn quốc gia']),
                                'value' => $model->country_id,
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'country_id'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'work_type_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $this->widget('common.extensions.echosen.Chosen', array(
                                'model' => $model,
                                'attribute' => 'work_type_id',
                                'data' => ['' => 'Chọn lĩnh vực']+ Trades::getTradeArr(),
                                'value' => $model->work_type_id,
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'work_type_id'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'name', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'year_of_birth', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'year_of_birth', array_combine(range(1980, 2005), range(1980, 2005)), array('class' => 'span10 col-sm-1')); ?>
                            <label class="col-sm-2 control-label no-padding-left"><i>&nbsp; (Năm sinh)</i></label>
                            <?php echo $form->error($model, 'year_of_birth'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'sex', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $this->widget('common.extensions.echosen.Chosen', array(
                                'model' => $model,
                                'attribute' => 'sex',
                                'data' => [0 => 'Nữ', 1=> 'Nam'],
                                'value' => $model->sex,
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'sex'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'province_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $this->widget('common.extensions.echosen.Chosen', array(
                                'model' => $model,
                                'attribute' => 'province_id',
                                'data' => ['' => 'chọn tỉnh thành'] + Province::getAllProvinceArr(false),
                                'value' => $model->province_id,
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'province_id'); ?>
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
                        <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'phone', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'phone'); ?>
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
