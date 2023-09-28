<?php
?>
<div class="title-2">
    <?php if ($show_widget_title) { ?>
        <h3><?= $widget_title ?></h3>
    <?php } ?>
    <div class="desc">
        <p><?= $helptext ?></p></div>
    <div></div>
</div>
<div class="contact-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'w3n-submit-form',
        'action' => Yii::app()->createUrl('site/site/expertransContact'),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
            'class' => 'exp-contact-form',
            'role' => 'form'
        ),
    ));
    ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <?php echo $form->textField($model, 'name', array('class' => 'input-1', 'placeholder' => $model->getAttributeLabel('name'))); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <?php echo $form->textField($model, 'email', array('class' => 'input-1', 'placeholder' => $model->getAttributeLabel('email'))); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <?php echo $form->textField($model, 'company_name', array('class' => 'input-1', 'placeholder' => $model->getAttributeLabel('company_name'))); ?>
                <?php echo $form->error($model, 'company_name'); ?>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <?php echo $form->textField($model, 'company', array('class' => 'input-1', 'placeholder' => $model->getAttributeLabel('company'))); ?>
                <?php echo $form->error($model, 'company'); ?>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <?php echo $form->textField($model, 'phone', array('class' => 'input-1', 'placeholder' => $model->getAttributeLabel('phone'))); ?>
                <?php echo $form->error($model, 'phone'); ?>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <?php

                $model->aff_id = $_GET['affiliate_id'];
                echo $form->hiddenField($model, 'aff_id', array('class' => 'input-1', 'placeholder' => $model->getAttributeLabel('phone'))); ?>
                <?php echo $form->error($model, 'aff_id'); ?>
            </div>
        </div>
        <div class="col-lg-12 type-dropdown">
            <div class="form-group">
                <?php echo $form->dropDownList($model, 'service', ExpertransService::getOptions(), array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'service'); ?>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <textarea class="plh-italic input-1" placeholder="Leave a message" name="W3NF[220][c1136]"
                          id="W3NF_220_c1136"></textarea>
                <div class="errorMessage" id="AutoForm_c1136_em_" style="display:none"></div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="cover-button-submit">
                <div class="form-group">
                    <button type="submit" class="submit-form-1 wide">Send</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    $this->endWidget();
    ?>
</div>
<script>
    jQuery(document).on('submit', '.exp-contact-form', function () {
        var thi = $(this);
        if (thi.hasClass('disable'))
            return false;
        thi.addClass('disable');
        //
        var info = $(this).serialize();
        var href = $(this).attr('action');
        if (href) {
            jQuery.ajax({
                url: href,
                type: 'POST',
                dataType: 'JSON',
                data: info,
                success: function (res) {
                    switch (res.code) {
                        case 200: {
                            if (res.redirect)

                                window.location.href = res.redirect;
                            else
                                window.location.href = window.location.href;
                        }
                            break;
                        default: {
                            if (res.errors) {
                                parseJsonErrors(res.errors, thi);
                            }
                        }
                            break;
                    }
                    thi.removeClass('disable');
                },
                error: function () {
                    thi.removeClass('disable');
                }
            });
        } else
            thi.removeClass('disable');
        return false;
    });
</script>