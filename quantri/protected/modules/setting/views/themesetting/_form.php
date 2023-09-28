<?php
$category = new ClaCategory();
$category->type = ClaCategory::CATEGORY_THEME;
$category->generateCategory();
//
$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP);
unset($option[0]);
//
?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/imagesloaded.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/masonry.min.js');
?>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'themes-form',
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
            'enableClientValidation' => true,
        ));
        ?>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'category_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'category_id', $option, array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'category_id'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'theme_name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'theme_name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'theme_name'); ?>
            </div>
        </div>
<!--        <div class="control-group form-group">
            <?php //echo $form->labelEx($model, 'theme_type', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php //echo $form->dropDownList($model, 'theme_type', ClaSite::getSiteTypes(), array('class' => 'span12 col-sm-12')); ?>
                <?php //echo $form->error($model, 'theme_type'); ?>
            </div>
        </div>-->
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'description'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'theme_src', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo CHtml::fileField('theme_src', ''); ?>
                <?php echo $form->error($model, 'theme_src'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'avatar_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php
                $this->widget('common.widgets.upload.Upload', array(
                    'type' => 'images',
                    'id' => 'imageupload',
                    'buttonheight' => 25,
                    'path' => array('products', $this->site_id, Yii::app()->user->id),
                    'limit' => 100,
                    'multi' => true,
                    'imageoptions' => array(
                        'resizes' => array(array(200, 200))
                    ),
                    'buttontext' => 'Thêm ảnh',
                    'displayvaluebox' => false,
                    'oncecomplete' => "var firstitem   = jQuery('#algalley .alimglist').find('.alimgitem:first');var alimgitem   = '<div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><div class=\"alimgaction\"><input type=\"radio\" value=\"new_'+da.imgid+'\" name=\"setava\"><span>" . Yii::t('album', 'album_set_avatar') . "</span></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"newimage[]\" class=\"newimage\" /></div></div>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley .alimglist').append(alimgitem);}; updateImgBox();",
                    'onUploadStart' => 'ta=false;',
                    'queuecomplete' => 'ta=true;',
                ));
                ?>

                <div id="algalley" class="algalley">
                    <div style="display:none" id="Albums_imageitem_em_" class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
                    <div class="alimgbox">
                        <div class="alimglist">
                            <?php
                            if (!$model->isNewRecord) {
                                $images = $model->getImages();
                                foreach ($images as $image) {
                                    $this->renderPartial('imageitem', array('image' => $image, 'avatar_id' => $model->avatar_id));
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'previewlink', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'previewlink', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'previewlink'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'status', Themes::getThemeStatus(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'order', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'order'); ?>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('theme', 'theme_create') : Yii::t('theme', 'theme_update'), array('class' => 'btn btn-info', 'id' => 'savetheme','onclick'=>'if(jQuery(this).hasClass("disable")) return false; jQuery(this).addClass("disable");')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->
<?php
$this->renderPartial('mainscript');
?>