<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'config1', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'config1', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'config1'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'config1_content', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'config1_content', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'config1_content'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'config1_image', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'config1_image', array('class' => 'span12 col-sm-12')); ?>
        <div id="BdsProjectconfig1_image" style="display: block; margin-top: 0px;">
            <div id="BdsProjectconfig1_image_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->config1_image) echo 'margin-right: 10px;'; ?>">  
                <?php if ($model->config1_image_path && $model->config1_image_name) { ?>
                    <img src="<?php echo ClaHost::getImageHost(), $model->config1_image_path, 's100_100/', $model->config1_image_name; ?>" style="width: 100%;" />
                <?php } ?>
            </div>
            <div id="BdsProjectconfig1_image_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('bds_project_config', 'btn_select_config1_image'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'config1_image'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo CHtml::label(Yii::t('bds_project_config', 'images_config1'), null, array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">

        <?php
        $this->widget('common.widgets.upload.Upload', array(
            'type' => 'images',
            'id' => 'imageupload1',
            'buttonheight' => 25,
            'path' => array('projects', $this->site_id, Yii::app()->user->id),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "completeImage1(da);",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ));
        ?>
        <script type="text/javascript">
            function completeImage1(da) {
                var firstitem = jQuery('#algalley1 .alimglist').find('.ui-state-default:first');
                var html = '';
                html += '<li class="ui-state-default">';
                html += '<div class="alimgitem">';
                html += '<div class="alimgitembox">';
                html += '<div class="delimg">';
                html += '<a href="#" class="new_delimgaction">';
                html += '<i class="icon-remove">';
                html += '</i>';
                html += '</a>';
                html += '</div>';
                html += '<div class="alimgthum">';
                html += '<img src="' + da.imgurl + '">';
                html += '</div>';
                html += '<div class="alimgaction">';
                html += '<input class="position_image" type="hidden" name="order_img[1][]" />';
//                html += '<input type="radio" value="new_' + da.imgid + '" name="setava">';
//                html += '<span>';
//                html += 'Chọn làm ảnh đại diện';
//                html += '</span>';
                html += '</div>';
                html += '<input type="hidden" value="' + da.imgid + '" name="newimage[1][]" class="newimage" />';
                html += '</div>';
                html += '</div>';
                html += '</li>';
                if (firstitem.html()) {
                    firstitem.before(html);
                } else {
                    jQuery('#algalley1 #sortable1').append(html);
                }
            }
        </script>

        <div id="algalley1" class="algalley">
            <span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>
            <div style="display:none" id="Albums_imageitem_em_"
                 class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
            <div class="alimgbox">
                <div class="alimglist">
                    <ul id="sortable1">
                        <?php
                        if (!$model->isNewRecord) {
                            $images = $model->getImages();
                            foreach ($images as $image) {
                                if($image['type'] == BdsProjectConfigImages::TYPE_CONFIG1) {
                                    $this->renderPartial('imageitem', array('image' => $image));
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>