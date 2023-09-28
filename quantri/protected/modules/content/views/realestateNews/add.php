<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/upload/ajaxupload.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {

        CKEDITOR.replace("RealEstateNews_description", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
</script>
<?php $option_category = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr); ?>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'realestate-news-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'cat_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'cat_id', $option_category, array('class' => 'span12 col-sm-12',)); ?>
                <?php echo $form->error($model, 'cat_id'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                <div id="RealEstateravatar" style="display: block; margin-top: 0px;">
                    <div id="RealEstateavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                        <?php if ($model->image_path && $model->image_name) { ?>
                            <img src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>" style="width: 100%;" />
                        <?php } ?>
                    </div>
                    <div id="RealEstateavatar_form" style="display: inline-block;">
                        <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                    </div>
                </div>
                <?php echo $form->error($model, 'avatar'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->label($model, 'price', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="col-xs-3 w3-form-field">
                <?php echo $form->textField($model, 'price', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('product', 'price'))); ?>
                <?php echo $form->error($model, 'price'); ?>
            </div>
            <div class="col-xs-2 w3-form-field">
                <?php echo $form->dropDownList($model, 'unit_price', RealEstateNews::unitPrice(), array('class' => 'form-control w3-form-input input-text')); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->label($model, 'area', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="col-xs-3 w3-form-field">
                <?php echo $form->textField($model, 'area', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('realestate', 'area'))); ?>
                <?php echo $form->error($model, 'area'); ?>
            </div>
            <div class="col-xs-2 w3-form-field">
                <?php echo $form->dropDownList($model, 'unit_area', RealEstateNews::unitArea(), array('class' => 'form-control w3-form-input input-text')); ?>
            </div>
        </div>
        
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->radioButtonList($model, 'status', ActiveRecord::statusArray(), array('class' => '')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
        
        <div class="control-group form-group">
            <?php echo $form->label($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'address', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'address'))); ?>
                <?php echo $form->error($model, 'address'); ?>
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
    </div>

    <div class="control-group form-group buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('news', 'news_create') : Yii::t('news', 'news_edit'), array('class' => 'btn btn-info', 'id' => 'savenews')); ?>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">

    jQuery(function ($) {
        jQuery('#RealEstateavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/content/realestateNews/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#RealEstateNews_avatar').val(obj.data.avatar);
                        if (jQuery('#RealEstateavatar_img img').attr('src')) {
                            jQuery('#RealEstateavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#RealEstateavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#RealEstateavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });

    });
</script>