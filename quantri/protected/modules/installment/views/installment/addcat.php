<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('category', 'category_course_create') : Yii::t('category', 'category_course_update'); ?>
        </h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'category-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'name', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                            <div style="clear: both;"></div>
                            <div id="installmentavatar" style="display: block; margin-top: 10px;">
                                <div id="installment_img"
                                     style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">
                                    <?php if ($model->image_path && $model->image_name) { ?>
                                        <img
                                                src="<?php echo ClaUrl::getImageUrl($model->image_path, $model->image_name, ['width' => 100, 'height' => 100]); ?>"
                                                style="width: 100%;"/>
                                    <?php } ?>
                                </div>
                                <div id="installment_form" style="display: inline-block;">
                                    <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                                </div>
                                <?php if ($model->image_path && $model->image_name) { ?>
                                    <div style="margin-top: 15px;">
                                        <button type="button" onclick="removeAvatar(<?= $model->id ?>)"
                                                class="btn btn-danger btn-xs delete_ava">Delete avatar
                                        </button>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php echo $form->error($model, 'avatar'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'interes', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'interes', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'interes'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'collection_fee', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'collection_fee', array('class' => 'span10 col-sm-12 numberFormat')); ?>
                            <?php echo $form->error($model, 'collection_fee'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'insurrance', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'insurrance', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'insurrance'); ?>
                        </div>
                    </div>


                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'create') : Yii::t('common', 'update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#installment_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/installment/installment/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Installment_avatar').val(obj.data.avatar);
                        if (jQuery('#installment_img img').attr('src')) {
                            jQuery('#installment_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#installment_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#installment_img').css({"margin-right": "10px"});
                    }
                } else {
                    if (obj.message)
                        alert(obj.message);
                }

            }
        });
    });
    function removeAvatar(id) {
        if (confirm("Are you sure delete avatar?")) {
            $.getJSON(
                '<?php echo Yii::app()->createUrl('installment/installment/deleteAvatar') ?>',
                {id: id},
                function (data) {
                    if (data.code == 200) {
                        $('#installment_img img').remove();
                        $('.delete_ava').remove();
                    }
                }
            );
        }
    }

</script>
