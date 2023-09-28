<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        CKEDITOR.replace("Videos_video_description", {
            height: 200,
            language: 'vi',
            filebrowserBrowseUrl: baseUrl + "/js/plugins/ckfinder/ckfinder.html"
        });
    });
</script>
<div class="row">
    <div class="col-xs-12 no-padding">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'videos-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'htmlOptions' => array('class' => 'form-horizontal'),
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'video_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'video_title', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'video_title'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'video_link', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'video_link', array('class' => 'span12 col-sm-12', 'placeholder' => Yii::t('video', 'video_link_help')) + (($model->isNewRecord && !$model->video_id) ? array() : array())); ?>
                <?php echo $form->error($model, 'video_link'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'cat_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'cat_id', $option_category, array('class' => 'span2 col-sm-4')); ?>
                <?php echo $form->error($model, 'cat_id'); ?>
            </div>
        </div>  
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'product_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'product_id', $option_product, array('class' => 'span2 col-sm-4')); ?>
                <?php echo $form->error($model, 'product_id'); ?>
            </div>
        </div>  
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'video_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'video_description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'video_description'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->label($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php
                $this->widget('common.widgets.upload.Upload', array(
                    'type' => 'images',
                    'id' => 'vavatar',
                    'buttonheight' => 20,
                    'path' => array('video', $this->site_id, Yii::app()->user->id),
                    'limit' => 1,
                    'multi' => false,
                    'imageoptions' => array(
                        'resizes' => array()
                    ),
                    'fileSizeLimit' => '4MB',
                    'buttontext' => Yii::t('video', 'video_addimage_button'),
                    'oncecomplete' => 'jQuery("#videoavatar").hide();',
                ));
                ?>
                <?php if ((!$model->isNewRecord || $model->video_id) && $model->avatar_path) { ?>
                    <div id="videoavatar">
                        <img src="<?php echo ClaHost::getImageHost() . $model->avatar_path . 's100_100/' . $model->avatar_name; ?>" />
                    </div>
                <?php } ?>
                <?php echo $form->error($model, 'avatar'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'video_prominent', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->checkBox($model, 'video_prominent'); ?>
                <?php echo $form->error($model, 'video_prominent'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'status', Constant::statusArray(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'meta_keywords', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'meta_keywords', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'meta_keywords'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'meta_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'meta_description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'meta_description'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'keyword', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'keyword', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'keyword'); ?>
                <p class="muted"><?php echo Yii::t('video', 'video_keyword_help'); ?></p>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('video', 'video_create') : Yii::t('video', 'video_update'), array('class' => 'btn btn-info', 'id' => 'savevideo')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>
<script>
    jQuery('#savevideo').on('click', function () {
        var _this = $(this);
        if (_this.hasClass('disable'))
            return false;
        _this.addClass('disable');
        $('#videos-form').find('.errorMessage').hide();
        var action = $('#videos-form').attr('action');
        if (action) {
            for (instance in CKEDITOR.instances)
                CKEDITOR.instances[instance].updateElement();
            //
            jQuery.ajax({
                url: action,
                type: 'POST',
                data: $('#videos-form').serialize(),
                dataType: 'JSON',
                beforeSend: function () {
                    w3ShowLoading(_this, 'right', 40, 0);
                },
                success: function (data) {
                    w3HideLoading();
                    if (data.code == 200) {
                        window.location.href = data.redirect;
                    } else {
                        if (data.errors) {
                            parseJsonErrors(data.errors);
                        }
                    }
                    _this.removeClass('disable');
                },
                error: function () {
                    _this.removeClass('disable');
                }
            });
        } else {
            w3HideLoading();
            _this.removeClass('disable');
        }
        return false;
    });
</script>
