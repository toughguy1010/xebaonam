<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'bonus-settings-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
        ));
        ?>
        <div class="col-sm-12">
            <!--            <h3 style="color: blue">Lưu ý:</h3>-->
            <p>Điểm thưởng sẽ chỉ được cộng khi đơn hàng đã <span style="color: red">hoàn thành</span> </p>
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
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'unit', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-3">
                <?php echo $form->textField($model, 'unit', array('class' => 'span9 col-sm-12')); ?>
            </div>
            <div class="controls col-sm-7">
                <span class="help-inline">
                    <i style="color: blue;">Đơn vị tính vd:"xu, sò"</i>
                    <?php echo $form->error($model, 'unit'); ?>
                </span>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'default_point', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-3">
                <?php echo $form->textField($model, 'default_point', array('class' => 'span12 col-sm-12')); ?>
            </div>
            <div class="controls col-sm-7">
                <span class="help-inline">
                    <i style="color: blue;">Áp dụng cho khách hàng đăng kí tài khoản trên website của bạn</i>
                    <?php echo $form->error($model, 'default_point'); ?>
                </span>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'minimum_order_amount', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-3">
                <?php echo $form->textField($model, 'minimum_order_amount', array('class' => 'span9 col-sm-12')); ?>
            </div>
            <div class="controls col-sm-7">
                <span class="help-inline">
                    <i style="color: blue;"> Giá tiền đơn hàng tối thiểu để áp dụng mã giảm giá</i>
                    <?php echo $form->error($model, 'minimum_order_amount'); ?>
                </span>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'plus_point', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-4">
                <span class="help-inline">
                    <i style="color: blue;">Điểm thưởng dựa trên tổng hóa đơn. Với mỗi </i>
                </span>
            </div>
            <div class="controls col-sm-2">
                <?php echo $form->textField($model, 'plus_point', array('class' => 'col-sm-12')); ?>
            </div>
            <div class="controls col-sm-4">
                <span class="help-inline">
                    <i style="color: blue;"> đồng sẽ quy đổi được 1 điểm thưởng</i>
                    <?php echo $form->error($model, 'plus_point'); ?>
                </span>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'price_per_point', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-4">
                <span class="help-inline">
                    <i style="color: blue;">1 điểm quy đổi sẽ tương ứng</i>
                </span>
            </div>
            <div class="controls col-sm-2">
                <?php echo $form->textField($model, 'price_per_point', array('class' => 'col-sm-12')); ?>
            </div>
            <div class="controls col-sm-4">
                <span class="help-inline">
                    <i style="color: blue;">đồng thanh toán trừ vào hóa đơn.</i>
                    <?php echo $form->error($model, 'price_per_point'); ?>
                </span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'min_point', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-4">
                <span class="help-inline">
<!--                    <i style="color: blue;">Số điểm tối thiểu</i>-->
                </span>
            </div>
            <div class="controls col-sm-2">
                <?php echo $form->textField($model, 'min_point', array('class' => 'col-sm-12')); ?>
            </div>
            <div class="controls col-sm-4">
                <span class="help-inline">
                    <i style="color: blue;">được sử dụng trong một đơn hàng</i>
                    <?php echo $form->error($model, 'min_point'); ?>
                </span>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'max_point', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-4">
                <span class="help-inline">
<!--                    <i style="color: blue;">Số điểm tối đa</i>-->
                </span>
            </div>
            <div class="controls col-sm-2">
                <?php echo $form->textField($model, 'max_point', array('class' => 'col-sm-12')); ?>
            </div>
            <div class="controls col-sm-4">
                <span class="help-inline">
                    <i style="color: blue;">được sử dụng trong một đơn hàng</i>
                    <?php echo $form->error($model, 'max_point'); ?>
                </span>
            </div>
        </div>


        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'update') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
        </div>
        <?php if (ClaUser::isSupperAdmin()) { ?>
        <?php } ?>
        <?php $this->endWidget(); ?>
    </div>
</div>