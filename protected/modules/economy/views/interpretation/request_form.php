<div class="container">
    <div class="news-detail pad-70-0">
        <div class="form-bao-gia">
            <div class="form">
                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'bop-form',
                    'enableAjaxValidation' => false,
                )); ?>

                <div class="col-xs-12 text-center" style="padding-bottom: 40px">
                    <h2 style="text-transform: uppercase"><?= Yii::t('translate', 'bpo_title_not_in_vn') ?></h2>
                </div>
                <!--                --><?php //echo $form->errorSummary($model, array('htmlOptions' => array('class' => 'alert alert-block alert-error'))); ?>
                <div class="row-5">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'name'); ?>
                            <?php echo $form->textField($model, 'name', array('class' => 'input-1')); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'company'); ?>
                            <?php echo $form->textField($model, 'company', array('class' => 'input-1')); ?>
                            <?php echo $form->error($model, 'company'); ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'phone'); ?>
                            <?php echo $form->textField($model, 'phone', array('class' => 'input-1')); ?>
                            <?php echo $form->error($model, 'phone'); ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'email'); ?>
                            <?php echo $form->textField($model, 'email', array('class' => 'input-1')); ?>
                            <?php echo $form->error($model, 'email'); ?>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'country'); ?>
                            <?php echo $form->dropDownList($model, 'country', array('' => $model->getAttributeLabel('country')) + ClaLanguage::getCountries(), array('class' => 'select input-1')); ?>
                            <?php echo $form->error($model, 'country'); ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'from'); ?>
                            <?php echo $form->dropDownList($model, 'from', array('' => $model->getAttributeLabel('from')) + ClaLanguage::getCountries(), array('class' => 'select input-1', 'placeholder' => $model->getAttributeLabel('from'))); ?>
                            <?php echo $form->error($model, 'from'); ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'currency'); ?>
                            <?php echo $form->dropDownList($model, 'currency', array('' => $model->getAttributeLabel('currency')) + TranslateLanguage::$_dataCurrency, array('class' => 'select input-1')); ?>

                            <?php echo $form->error($model, 'currency'); ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'to'); ?>
                            <?php echo $form->dropDownList($model, 'to', ClaLanguage::getCountries(), array('class' => 'select input-1', 'multiple' => 'multiple', 'placeholder' => $model->getAttributeLabel('to'))); ?>
                            <?php echo $form->error($model, 'to'); ?>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'payment_method'); ?>
                            <?php echo $form->dropDownList($model, 'payment_method', array('' => $model->getAttributeLabel('payment_method')) + TranslateOrder::getPaymentMethod(), array('class' => 'select input-1')); ?>
                            <?php echo $form->error($model, 'payment_method'); ?>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <?php echo $form->textArea($model, 'note', array('rows' => '10', 'cols' => '30', 'class' => 'input-1', 'style' => 'width:100%', 'placeholder' => $model->getAttributeLabel('note'))); ?>
                            <?php echo $form->error($model, 'note'); ?>
                        </div>
                    </div>
                    <div class="col-lg-12" style="margin-bottom: 40px">
                        <p><?= Yii::t('translate', 'please_enter') ?></p>
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'submit-form-1')); ?>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.select').select2({
            minimumResultsForSearch: -1
        });
        // $('select').niceSelect();
        $('.grid').masonry({
            // options
            itemSelector: '.grid-item',
            columnWidth: '.grid-sizer'
            //
        });
    })
</script>