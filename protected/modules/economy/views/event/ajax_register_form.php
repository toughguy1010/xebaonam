<div class="register-event-form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'event-register-form',
        'action' => Yii::app()->createUrl('economy/event/register'),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'form-horizontal w3f-form', 'role' => 'form'),
    ));
    ?>
    <input type="text" class="form-control" id="" placeholder="<?php echo trim($event['name']); ?>" disabled="disabled">
    <input type="hidden" class="form-control" id="" name="EventRegister[event_id]"
           value="<?php echo trim($event['id']); ?>">
    <!--   name-->
    <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'placeholder' => yii::t('user', 'user_name'))); ?>
    <?php echo $form->error($model, 'name'); ?>
    <!--    email-->
    <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => yii::t('event', 'email'))); ?>
    <?php echo $form->error($model, 'email'); ?>
    <!--    phone-->
    <?php echo $form->textField($model, 'phone', array('class' => 'form-control', 'placeholder' => yii::t('event', 'tel'))); ?>
    <?php echo $form->error($model, 'phone'); ?>
    <!--   mesage-->
    <?php echo $form->textArea($model, 'message', array('class' => 'form-control input-area', 'placeholder' => yii::t('event', 'message'))); ?>
    <?php echo $form->error($model, 'message'); ?>
    <input type="hidden" name="url_back" value="<?php echo $redirect_url ?>"/>
    <button type="button" class="btn btn-default regis-btn" onclick="submit_event_register_form();">
        <span><?php echo yii::t('event', 'register') ?></span>
    </button>
    <?php
    $this->endWidget();
    ?>
</div>
<script>
    function submit_event_register_form() {
        var name = $('#EventRegister_name').val();
        if (name == '') {
            alert('Bạn cần nhập họ và tên');
            $('#EventRegister_name').focus();
            return false;
        }
        var email = $('#EventRegister_email').val();
        if (email == '') {
            alert('Bạn cần nhập email');
            $('#EventRegister_email').focus();
            return false;
        }
        var phone = $('#EventRegister_phone').val();
        if (phone == '') {
            alert('Bạn cần nhập số điện thoại');
            $('#EventRegister_phone').focus();
            return false;
        }
        var event_id = $('#EventRegister_event_id').val();
        if (event_id == '') {
            alert('Bạn cần chọn khóa học');
            return false;
        }
        var message = $('#EventRegister_message').val();
        if (message == '') {
            alert('Bạn cần nhập tin nhắn');
            $('#EventRegister_message').focus();
            return false;
        }

        document.getElementById("event-register-form").submit();
        return false;
    }
</script>

