<div class="header-popup clearfix"> <i class="icon-popup"></i>
    <div class="title-popup">Đăng ký mua </div>
    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
</div>
<div class="cont">
    <p class="more-popup">
        Bạn vui lòng nhập đầy đủ thông tin dưới đây. Tư vấn viên của chúng tôi sẽ gọi điện cho bạn
    </p>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'course-register-form',
        'action' => Yii::app()->createUrl('news/realestateProject/register', array('id' => $form_id)),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'form-horizontal w3f-form', 'role' => 'form'),
    ));
    ?>    
    <div class="form-group w3-form-group pop-ng ">
        <span class=" width-td">Họ và tên: </span> 
        <?php echo $form->textField($model, 'name', array('class' => 'form-control w3-form-input input-text', 'placeholder' => 'Họ và tên')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
    <div class="form-group w3-form-group pop-ng  ">
        <span class="width-td">Chọn dự án</span>

        <!--<div class="col-xs-12 w3-form-field">-->
        <?php
        echo $form->dropDownList($model, 'project_id', $option_course, array('class' => 'form-control', 'options' =>
            array(
                $course_id => array('selected' => 'selected')
        )));
        ?>
        <?php echo $form->error($model, 'project_id'); ?>
        <!--</div>-->
    </div>

    <div class="form-group w3-form-group pop-ng ">
        <span class=" width-td">Điện thoại: </span> 
        <!--<div class="col-xs-12 w3-form-field">-->
        <?php echo $form->textField($model, 'phone', array('class' => 'form-control w3-form-input input-text', 'placeholder' => 'Điện thoại')); ?>
        <?php echo $form->error($model, 'phone'); ?>
        <!--</div>-->
    </div>
    <div class="form-group w3-form-group pop-ng ">
        <span class=" width-td">Email: </span> 
        <!--<div class="col-xs-12 w3-form-field">-->
        <?php echo $form->textField($model, 'email', array('class' => 'form-control w3-form-input input-text', 'placeholder' => 'Email')); ?>
        <?php echo $form->error($model, 'email'); ?>
        <!--</div>-->
    </div>
    <div class="form-group w3-form-group pop-ng ">
        <span class=" width-td">Địa chỉ: </span> 
        <!--<div class="col-xs-12 w3-form-field">-->
        <?php echo $form->textArea($model, 'message', array('class' => 'form-control w3-form-input input-textarea', 'placeholder' => 'Địa chỉ của bạn')); ?>
        <?php echo $form->error($model, 'message'); ?>
        <!--</div>-->
    </div>
    <div class="w3-form-group form-group">
        <div class=" w3-form-button">
            <div class="registered-action1">
                <button type="button" class="btn btn-primary" onclick="submit_course_register_form();"><span>Đăng kí</span><span class="hiden-mobile"></span></button>
            </div>
        </div>
    </div>
    <input type="hidden" name="url_back" value="<?php echo Yii::app()->request->url ?>" />
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
