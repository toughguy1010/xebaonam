<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('reviews', 'reviews_create') : Yii::t('reviews', 'reviews_update'); ?>
        </h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'broker-form',
                        'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'customer_name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'customer_name', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'customer_name'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'customer_desc', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'customer_desc', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'customer_desc'); ?>
                        </div>
                    </div>
                    <script>
                        jQuery(document).ready(function () {
                            CKEDITOR.replace("CustomerReviews_review", {
                                height: 400,
                                language: '<?php echo Yii::app()->language ?>'
                            });
                        });
                    </script>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'review', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'review', array('class' => 'span10 col-sm-12', 'style' => 'width: 100%;')); ?>
                            <?php echo $form->error($model, 'review'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                            <div id="CustomerReviewsavatar" style="display: block; margin-top: 0px;">
                                <div id="CustomerReviewsavatar_img"
                                     style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">
                                    <?php if ($model->avatar_path && $model->avatar_name) { ?>
                                        <img src="<?php echo ClaHost::getImageHost(), $model->avatar_path, 's100_100/', $model->avatar_name; ?>"
                                             style="width: 100%;"/>
                                    <?php } ?>
                                </div>
                                <div id="CustomerReviewsavatar_form" style="display: inline-block;">
                                    <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                                </div>
                            </div>
                            <?php echo $form->error($model, 'avatar'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'show', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <label>
                                <?php echo $form->checkBox($model, 'actived', array('class' => 'ace ace-switch ace-switch-6')); ?>
                                <span class="lbl"></span>
                            </label>
                        </div>
                    </div>
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('bds_broker', 'broker_create') : Yii::t('bds_broker', 'broker_update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
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
        jQuery('#CustomerReviewsavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/interface/customerReviews/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#CustomerReviews_avatar').val(obj.data.avatar);
                        if (jQuery('#CustomerReviewsavatar_img img').attr('src')) {
                            jQuery('#CustomerReviewsavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#CustomerReviewsavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#CustomerReviewsavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });


    });
</script>
