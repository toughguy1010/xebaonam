<div class="login-box" style="padding: 30px 20px;">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'websitelogin-form',
        'htmlOptions' => array(),
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
//        'clientOptions' => array(
//            'validateOnSubmit' => true,
//        ),
    ));
    ?>
    <!-- Login Fields -->
    <div class="form-group">
        <?php echo $form->label($model, 'username', array('for')); ?>
        <?php echo $form->textField($model, 'username', array('class' => 'form-control login user', 'placeholder' => $model->getAttributeLabel('username'))); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($model, 'password', array('for')); ?>
        <?php echo $form->passwordField($model, 'password', array('class' => 'form-control login password', 'placeholder' => $model->getAttributeLabel('password'))); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->checkBox($model, 'rememberMe', array('id' => 'Field', 'class' => 'field', 'onchange' => 'handleInput(this);')); ?>
        <?php echo $form->label($model, 'rememberMe', array('class' => 'choice', 'for' => 'Field')); ?>
    </div>
    <!-- Green Button -->
    <div class="button">
        <?php echo CHtml::submitButton(Yii::t('common', 'login'), array('class' => 'btn btn-primary', 'id' => 'btnwlogin')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php if ($isAjax) { ?>
    <script type="text/javascript">
        jQuery(function($) {
            var formSubmit = true;
            jQuery('#websitelogin-form').on('submit', function() {
                if (!formSubmit)
                    return false;
                formSubmit = false;
                var thi = jQuery(this);
                jQuery.ajax({
                    'type': 'POST',
                    'dataType': 'JSON',
                    'url': thi.attr('action'),
                    'data': thi.serialize(),
                    'beforeSend': function() {
                        w3ShowLoading(jQuery('#btnwlogin'), 'right', 60, 0);
                    },
                    'success': function(res) {
                        if (res.code != "200") {
                            if (res.errors) {
                                parseJsonErrors(res.errors);
                            }
                        } else if (res.redirect)
                            window.location.href = res.redirect;
                        w3HideLoading();
                        formSubmit = true;
                    },
                    'error': function() {
                        w3HideLoading();
                        formSubmit = true;
                    }
                });
                return false;
            });
        });
    </script>
<?php } ?>