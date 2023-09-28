<div class="Course-Registration">
    <div class="header-popup clearfix"> <i class="icon-popup"></i>
        <div class="title-popup"><?php echo Yii::t('course', 'course_register'); ?></div>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'course-register-form',
        'action' => Yii::app()->createUrl('economy/course/register', array('id' => $form_id)),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'form-horizontal w3f-form', 'role' => 'form'),
    ));
    ?>

    <div class="form-group w3-form-group">
        <div class="col-xs-12 w3-form-field">
            <?php echo $form->textField($model, 'name', array('class' => 'form-control w3-form-input input-text', 'placeholder' => yii::t('user', 'user_name'))); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>
    </div>

    <div class="form-group w3-form-group">
        <div class="col-xs-12 w3-form-field">
            <?php echo $form->textField($model, 'email', array('class' => 'form-control w3-form-input input-text', 'placeholder' => yii::t('course', 'email'))); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>
    </div>

    <div class="form-group w3-form-group">
        <div class="col-xs-12 w3-form-field">
            <?php echo $form->textField($model, 'phone', array('class' => 'form-control w3-form-input input-text', 'placeholder' => yii::t('course', 'tel'))); ?>
            <?php echo $form->error($model, 'phone'); ?>
        </div>
    </div>

    <div class="form-group w3-form-group">
        <div class="col-xs-12 w3-form-field">
            <?php
            echo $form->dropDownList($model, 'course_id', $option_course, array('class' => 'form-control', 'options' =>
                array(
                    $course_id => array('selected' => 'selected')
            )));
            ?>
            <?php echo $form->error($model, 'course_id'); ?>
        </div>
    </div>

    <div class="form-group w3-form-group">
        <div class="col-xs-12 w3-form-field">
            <?php echo $form->textArea($model, 'message', array('class' => 'form-control w3-form-input input-textarea', 'placeholder' => yii::t('course', 'message'))); ?>
            <?php echo $form->error($model, 'message'); ?>
        </div>
    </div>

    <input type="hidden" name="url_back" value="<?php echo Yii::app()->request->url ?>" />

    <div class="w3-form-group form-group">
        <div class=" col-xs-12 w3-form-button">
            <div class="registered-action">
                <button type="button" class="btn btn-primary" onclick="submit_course_register_form();"><span><?php echo yii::t('course', 'register') ?></span><span class="hiden-mobile"> <?php echo yii::t('course', 'now') ?> </span></button>
            </div>
        </div>
    </div>

    <?php
    $this->endWidget();
    ?>

</div>
<script>
    function submit_course_register_form() {
        var name = $('#CourseRegister_name').val();
        if (name == '') {
            alert('Bạn cần nhập họ và tên');
            $('#CourseRegister_name').focus();
            return false;
        }
        var email = $('#CourseRegister_email').val();
        if (email == '') {
            alert('Bạn cần nhập email');
            $('#CourseRegister_email').focus();
            return false;
        }
        var phone = $('#CourseRegister_phone').val();
        if (phone == '') {
            alert('Bạn cần nhập số điện thoại');
            $('#CourseRegister_phone').focus();
            return false;
        }
        var course_id = $('#CourseRegister_course_id').val();
        if (course_id == '') {
            alert('Bạn cần chọn khóa học');
            return false;
        }
        var message = $('#CourseRegister_message').val();
        if (message == '') {
            alert('Bạn cần nhập tin nhắn');
            $('#CourseRegister_message').focus();
            return false;
        }

        document.getElementById("course-register-form").submit();
        return false;
    }
</script>
