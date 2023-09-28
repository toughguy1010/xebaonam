<?php
$serviceOptions = ClaArray::builOptions(SeServices::getServices(), 'id', 'name');
$providersOptions = ClaArray::builOptions(SeProviders::getProviders(), 'id', 'name');
//
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css"></link>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function () {
        $("#addCate").colorbox({width: "80%", overlayClose: false});
        CKEDITOR.replace("SeServicesInfo_description", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
    });

    jQuery(function ($) {
        jQuery('#newsavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/service/service/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#SeServices_avatar').val(obj.data.avatar);
                        if (jQuery('#newsavatar_img img').attr('src')) {
                            jQuery('#newsavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#newsavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#newsavatar_img').css({"margin-right": "10px"});
                    }
                } else {
                    if (obj.message)
                        alert(obj.message);
                }

            }
        });
    });</script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'news-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <?php // }  ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'service_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'service_id', $serviceOptions, array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'category_id'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'provider_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'provider_id', $providersOptions, array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'provider_id'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->numberField($model, 'price', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'price'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'duration', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->numberField($model, 'duration', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'duration'); ?>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('service', 'service_create') : Yii::t('service', 'service_edit'), array('class' => 'btn btn-info', 'id' => 'savenews')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>