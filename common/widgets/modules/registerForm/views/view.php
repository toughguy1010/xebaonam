<div id="register-member" class="page-main">
    <?php if ($show_widget_title) { ?>
        <h2 class="title-register-member"><?php echo $widget_title ?></h2>
    <?php } ?>
    <div class="contRegister">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'user-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'class' => 'form-register-member',
//                'enctype' => 'multipart/form-data',
            ),
            'action'=>$action
        ));
        ?>
        <div class="item-form-register-member clearfix">
            <div class="title-item-form">
                <?php echo $form->labelEx($model, 'name', array('class' => '')); ?>
            </div>
            <div class="input-cont">
                <?php echo $form->textField($model, 'name', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class="item-form-register-member clearfix">
            <div class="title-item-form">
                <?php echo $form->labelEx($model, 'email', array('class' => '')); ?>
            </div>
            <div class="input-cont">
                <?php echo $form->textField($model, 'email', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>
        <div class="item-form-register-member clearfix">
            <div class="title-item-form">
                <?php echo $form->labelEx($model, 'password', array('class' => '')); ?>
            </div>
            <div class="input-cont">
                <?php echo $form->passwordField($model, 'password', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'password'); ?>
            </div>
        </div>
        <div class="item-form-register-member clearfix">
            <div class="title-item-form">
                <?php echo $form->labelEx($model, 'passwordConfirm', array('class' => '')); ?>
            </div>
            <div class="input-cont">
                <?php echo $form->passwordField($model, 'passwordConfirm', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'passwordConfirm'); ?>
            </div>
        </div>
        <div class="item-form-register-member clearfix">
            <div class="title-item-form">
                <?php echo $form->labelEx($model, 'phone', array('class' => '')); ?>

            </div>
            <div class="input-cont">
                <?php echo $form->textField($model, 'phone', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'phone'); ?>
            </div>
        </div>

        <div class="item-form-register-member clearfix">
            <div class="title-item-form">
                <?php echo $form->labelEx($model, 'type', array('class' => '')); ?>
            </div>
            <div class="input-cont">
                <?php echo $form->dropDownList($model, 'type', ActiveRecord::typeArrayUserEvent(), array('class' => 'span9 form-control'));
                echo $form->error($model, 'type'); ?>
            </div>
        </div>
        <div class="item-form-register-member clearfix">
            <div class="title-item-form">
                <?php echo $form->labelEx($model, 'sex', array('class' => '')); ?>
            </div>
            <div class="input-cont">
                <?php
                echo $form->dropDownList($model, 'sex', ClaUser::getListSexArr(), array('class' => 'span9 form-control', 'style' => 'width:200px;'));
                ?>
                <!--                <select class="form-control" style="width:200px;">-->
                <!--                    <option>Nam</option>-->
                <!--                    <option>Nữ</option>-->
                <!--                </select>-->
            </div>
        </div>
        <div class="item-submit">
            <button class="btn btn-default button-submit" type="submit">Đăng ký</button>
        </div>
        <?php $this->endWidget(); ?>
        <p class="note-form">Bạn vui lòng nhập đủ các thông tin vào các trường có đánh dấu *</p>
    </div>
</div>