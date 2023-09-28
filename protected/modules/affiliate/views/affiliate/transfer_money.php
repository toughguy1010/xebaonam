<p>Số tiền tối thiểu bạn có thể yêu cầu là: <b><?= number_format($config->min_price, 0, ',', '.') ?> VNĐ</b></p>
<?php
$max_money = $commission[Orders::ORDER_COMPLETE] - ($money_transfered + $money_waiting);
?>
<p>Số tiền bạn đang có là: <b><?= number_format($max_money, 0, ',', '.') ?> VNĐ</b></p>
<?php if ($max_money >= $config['min_price']) { ?>
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
                            'id' => 'payment-info-form',
                            'htmlOptions' => array('class' => 'form-horizontal'),
                            'enableAjaxValidation' => false,
                        ));
                        ?>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'money', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php echo $form->textField($model, 'money', array('class' => 'span10 col-sm-12', 'placeholder' => 'Hãy nhập số tiền bạn muốn chúng tôi chuyển khoản cho bạn')); ?>
                                <?php echo $form->error($model, 'money'); ?>
                            </div>
                        </div>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'note', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php echo $form->textArea($model, 'note', array('class' => 'span10 col-sm-12', 'placeholder' => 'Hãy nhập thông tin thanh toán của bạn')); ?>
                                <?php echo $form->error($model, 'note'); ?>
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
<?php } else { ?>
    <div>
        Bạn chưa đủ tiền hoa hồng để yêu cầu chuyển tiền
    </div>
<?php } ?>
