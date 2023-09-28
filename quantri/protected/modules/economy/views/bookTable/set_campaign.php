<div class="widget-box">
    <div class="widget-header">
        <h4>
            Quản lý chiến dịch đặt bàn
        </h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'book-table-campaign',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'type', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            echo $form->dropDownList($model, 'type', BookTableCampaign::optionType(), array('class' => 'span12 col-sm-12'));
                            echo $form->error($model, 'type');
                            ?>
                        </div>
                    </div>
                    <div class="control-group form-group" id="wrapper-percent-campaign" style="display: <?php echo $model->type == BookTableCampaign::TYPE_PERCENT ? 'block' : 'none' ?>">
                        <?php echo $form->labelEx($model, 'percent', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            echo $form->textField($model, 'percent', array('class' => 'span12 col-sm-12'));
                            echo $form->error($model, 'percent');
                            ?>
                        </div>
                    </div>
                    <div class="control-group form-group" id="wrapper-price-campaign" style="display: <?php echo $model->type == BookTableCampaign::TYPE_PRICE ? 'block' : 'none' ?>">
                        <?php echo $form->labelEx($model, 'price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            echo $form->textField($model, 'price', array('class' => 'span12 col-sm-12'));
                            echo $form->error($model, 'price');
                            ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <label>
                                <?php echo $form->checkBox($model, 'status', array('class' => 'ace ace-switch ace-switch-6')); ?>
                                <span class="lbl"></span>
                            </label>
                        </div>
                    </div>
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'save') : Yii::t('common', 'save'), array('class' => 'btn btn-info', 'id' => 'savenews')); ?>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#BookTableCampaign_type').change(function () {
            var type = $(this).val();
            if (type == <?php echo BookTableCampaign::TYPE_PERCENT ?>) {
                $('#wrapper-price-campaign').css('display', 'none');
                $('#wrapper-percent-campaign').css('display', 'block');
            } else if (type == <?php echo BookTableCampaign::TYPE_PRICE ?>) {
                $('#wrapper-price-campaign').css('display', 'block');
                $('#wrapper-percent-campaign').css('display', 'none');
            }
        });
    });
</script>