<?php
//
$category = new ClaCategory();
$category->type = ClaCategory::CATEGORY_POST;
$category->generateCategory();
$arr = array($this->category_id => $this->categoryModel->cat_name);
//
$option = $category->createOptionArray($this->category_id, ClaCategory::CATEGORY_STEP, $arr);
//
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css"></link>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {

        $("#addCate").colorbox({width: "80%", overlayClose: false});

        CKEDITOR.replace("Posts_description", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
    jQuery(function ($) {
        jQuery('#postavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/content/post/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Posts_avatar').val(obj.data.avatar);
                        if (jQuery('#postavatar_img img').attr('src')) {
                            jQuery('#postavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#postavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#postavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
    });
</script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'post-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'title', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'title'); ?>
            </div>
        </div>
        <?php if (!$model->isNewRecord) { ?>
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">
                    <?php echo $form->textField($model, 'alias', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'alias'); ?>
                </div>
            </div>
        <?php } ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'category_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <div class="input-group">
                    <?php echo $form->dropDownList($model, 'category_id', $option, array('class' => 'form-control')); ?>
                    <div class="input-group-btn" style="padding-left: 10px;">  
                        <a href="<?php echo Yii::app()->createUrl('content/postcategory/addcat', array('pa' => $this->category_id, 'cid' => $this->category_id) + $_GET) ?>" id="addCate" class="btn btn-primary btn-sm" style="line-height: 16px;">
                            <?php echo Yii::t('category', 'category_add'); ?>
                        </a>
                    </div>
                </div>
                <?php echo $form->error($model, 'category_id'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'sortdesc', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'sortdesc', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'sortdesc'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <div class="span12">
                    <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'description'); ?>
                </div>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                <div style="clear: both;"></div>
                <div id="postavatar" style="display: block; margin-top: 10px;">
                    <div id="postavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                        <?php if ($model->image_path && $model->image_name) { ?>
                            <img src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>" style="width: 100%;" />
                        <?php } ?>
                    </div>
                    <div id="postavatar_form" style="display: inline-block;">
                        <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                    </div>
                </div>
                <?php echo $form->error($model, 'avatar'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'publicdate', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php
                $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                    'model' => $model, //Model object
                    'name' => 'Posts[publicdate]', //attribute name
                    'mode' => 'datetime', //use "time","date" or "datetime" (default)
                    'value' => ((int) $model->publicdate > 0 ) ? date('d-m-Y H:i:s', (int) $model->publicdate) : date('d-m-Y H:i:s'),
                    'language' => 'vi',
                    'options' => array(
                        'showSecond' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'timeFormat' => 'HH:mm:ss',
                        'controlType' => 'select',
                        'stepHour' => 1,
                        'stepMinute' => 1,
                        'stepSecond' => 1,
                        //'showOn' => 'button',
                        'showSecond' => true,
                        'changeMonth' => true,
                        'changeYear' => false,
                        'tabularLevel' => null,
                    //'addSliderAccess' => true,
                    //'sliderAccessArgs' => array('touchonly' => false),
                    ), // jquery plugin options
                    'htmlOptions' => array(
                        'class' => 'span12 col-sm-12',
                    )
                ));
                ?>
                <?php echo $form->error($model, 'publicdate'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'isnew', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">                            
                <?php echo $form->checkBox($model, 'isnew'); ?>
                <?php echo $form->error($model, 'isnew'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'ishot', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">                            
                <?php echo $form->checkBox($model, 'ishot'); ?>
                <?php echo $form->error($model, 'ishot'); ?>
            </div>
        </div>  
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'meta_keywords', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'meta_keywords', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'meta_keywords'); ?>
            </div>
            <div style="clear: both;"><br/></div>
            <?php echo $form->labelEx($model, 'meta_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'meta_description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'meta_description'); ?>
            </div>
            <div style="clear: both;"><br/></div>
            <?php echo $form->labelEx($model, 'meta_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'meta_title', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'meta_title'); ?>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('post', 'post_create') : Yii::t('post', 'post_edit'), array('class' => 'btn btn-info', 'id' => 'savepost')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>