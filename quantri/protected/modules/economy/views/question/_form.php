<?php
//$category = new ClaCategory();
//$category->type = ClaCategory::CATEGORY_NEWS;
//$category->generateCategory();
//$arr = array('' => Yii::t('category', 'category_parent_0'));
//$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css"></link>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen/chosen.css"></link>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen/chosen.jquery.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        $("#addCate").colorbox({width: "80%", overlayClose: false});
        CKEDITOR.replace("QuestionAnswer_question_answer", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
    });

    jQuery(function ($) {
        jQuery('#newsavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/question/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#QuestionAnswer_avatar').val(obj.data.avatar);
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
            'id' => 'question-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'question_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'question_title', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'question_title'); ?>
            </div>
        </div>
        <?php // if (!$model->isNewRecord) {  ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'alias', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'alias'); ?>
            </div>
        </div>
        <?php // }  ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <p><?php echo $model->name; ?></p>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <p><?php echo $model->email; ?></p>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <p><?php echo $model->phone; ?></p>
                <?php echo $form->error($model, 'phone'); ?>
            </div>
        </div>


        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'question_content', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <!--<input name="us-ck" type="checkbox" id="ck-check" value="" style="">-->
                <!--<label for="ck-check" style="font-size: 12px;color: blue;pointer:cursor">Sử dụng trình soạn thảo</label>-->

                <?php echo $form->textArea($model, 'question_content', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'question_content'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'question_answer', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <div class="span12">
                    <?php echo $form->textArea($model, 'question_answer', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'question_answer'); ?>
                </div>
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
            <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                <div style="clear: both;"></div>
                <div id="newsavatar" style="display: block; margin-top: 10px;">
                    <div id="newsavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                        <?php if ($model->image_path && $model->image_name) { ?>
                            <img src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>" style="width: 100%;" />
                        <?php } ?>
                    </div>
                    <div id="newsavatar_form" style="display: inline-block;">
                        <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                    </div>
                </div>
                <?php echo $form->error($model, 'avatar'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'order', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'order'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <div class="form-search">
                <?php echo $form->labelEx($model, 'product_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">

                    <!--asort($option_hotel);-->
                    <select data-placeholder="Chọn sản phẩm" name="QuestionAnswer[product_id]" id="QuestionAnswer_product_id" class="chosen-product" style="width:100%;" tabindex="2">
                        <?php foreach ($option_product as $option_product_id => $option_product_name) { ?>
                            <option <?php echo $model->product_id == $option_product_id ? 'selected' : '' ?> value="<?php echo $option_product_id ?>"><?php echo $option_product_name ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArrayQuestion(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'type', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'type', ActiveRecord::typeQuestionArray(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'type'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'meta_keywords', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <label style="font-size: 12px;font-style: italic"><?php echo Yii::t('common', 'tags_description') ?></label>
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
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('news', 'news_create') : Yii::t('news', 'news_edit'), array('class' => 'btn btn-info', 'id' => 'savenews')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>
<script type="text/javascript">
    var config = {
        '.chosen-product': {}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>