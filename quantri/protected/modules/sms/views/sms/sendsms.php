<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<div class="widget widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('sms', 'sendsms'); ?>
        </h4>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12">
                    <div style="float: right;margin-right: 12px;">
                        <span><i>Tài khoản của bạn hiện có <b><?php echo number_format($user_money, 0, '', '.') . ' ' . Yii::t('sms', 'unit_price') ?></b> -> <a style="color: blue" href="<?php echo Yii::app()->createUrl('sms/smsPayment'); ?>">Nạp thêm tiền</a></i></span>
                    </div>
                </div>
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'sms-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'text_message', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'text_message', array('class' => 'span10 col-sm-12')); ?>
                            <span><b>Lưu ý:</b> <i>Tin nhắn không dấu</i></span>
                            <?php echo $form->error($model, 'text_message'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <label class="col-sm-2 control-label no-padding-left required" for="Sms_group_customer_id">
                            Nhóm liên hệ
                            <span class="required">*</span>
                        </label>
                        <div class="controls col-sm-10">
                            <div style="margin-bottom: 10px;">
                                <input class="button_input_direct" id="button_input_direct" checked type="radio" name="type" value="1" /> <label for="button_input_direct">Nhập trực tiếp</label>
                                <input style="margin-left: 20px;" class="button_input_from_group" id="button_input_from_group" type="radio" name="type" value="2" /> <label for="button_input_from_group">Chọn nhóm liên hệ</label>
                            </div>
                            <div class="input_direct">
                                <?php echo $form->textArea($model, 'list_number', array('class' => 'span10 col-sm-12')); ?>
                                <span><b>Lưu ý:</b> <i>Các số cách nhau bởi dấu , (vd: 0972445xxx, 0165503xxxx)</i></span>
                            </div>
                            <div class="input_from_group" style="display: none">
                                <?php
                                echo $form->dropDownList($model, 'group_customer_id', $option_group, array('class' => 'span10 col-sm-12'));
                                ?>
                            </div>
                            <?php echo $form->error($model, 'group_customer_id'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group buttons">
                        <a type="button" id="verified_sendsms" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm"><?php echo Yii::t('sms', 'send') ?></a>
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content" style="width: 600px;padding: 20px;border-radius: 10px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function () {

        $('.button_input_from_group').click(function () {
            $('.input_direct').hide();
            $('.input_from_group').show();
        });
        $('.button_input_direct').click(function () {
            $('.input_from_group').hide();
            $('.input_direct').show();
        });

        $('#verified_sendsms').click(function () {
            var group_id = 0;
            var list_number = '';

            var message = $('#Sms_text_message').val();
            if (message == '') {
                alert('Bạn phải nhập tin nhắn');
                $('#Sms_text_message').focus();
                return false;
            }
            var type = $("input[name='type']:checked").val();
            if (type == 1) {
                list_number = $('#Sms_list_number').val();
                if (list_number == '') {
                    alert('Bạn phải nhập các số cần gửi');
                    $('#Sms_list_number').focus();
                    return false;
                } else {
                    list_number = list_number.replace(/[^ 0-9\.,-]/g , "");
                    $('#Sms_list_number').val(list_number)
                }
            } else if (type == 2) {
                group_id = $('#Sms_group_customer_id').val();
                if (group_id == 0) {
                    alert('Bạn phải chọn nhóm liên hệ');
                    return false;
                }
            }
            $('.modal-content').html('');
            $.getJSON(
                    "<?php echo Yii::app()->createUrl('sms/sms/verifiedsms'); ?>",
                    {
                        type: type,
                        group_id: group_id,
                        message: message,
                        list_number: list_number
                    },
            function (data) {
                if (data.code == 200) {
                    $('.modal-content').html(data.html);
                }
            }
            );
            return true;
        })
    });

</script>