<?php
//
$category = new ClaCategory();
$category->type = ClaCategory::CATEGORY_PROJECT;
$category->generateCategory();
$arr = array('' => Yii::t('category', 'category_parent_0'));
$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);
//
?>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'logo', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'logo', array('class' => 'span12 col-sm-12')); ?>
        <div id="BdsProjectlogo" style="display: block; margin-top: 0px;">
            <div id="BdsProjectlogo_img"
                 style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->logo) echo 'margin-right: 10px;'; ?>">
                <?php if ($model->logo_path && $model->logo_name) { ?>
                    <img src="<?php echo ClaHost::getImageHost(), $model->logo_path, 's100_100/', $model->logo_name; ?>"
                         style="width: 100%;"/>
                <?php } ?>
            </div>
            <div id="BdsProjectlogo_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_logo'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'logo'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'alias', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'alias'); ?>
    </div>
</div>



<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
        <div id="BdsProjectavatar" style="display: block; margin-top: 0px;">
            <div id="BdsProjectavatar_img"
                 style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">
                <?php if ($model->avatar_path && $model->avatar_name) { ?>
                    <img
                            src="<?php echo ClaHost::getImageHost(), $model->avatar_path, 's100_100/', $model->avatar_name; ?>"
                            style="width: 100%;"/>
                <?php } ?>
            </div>
            <div id="BdsProjectavatar_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'avatar'); ?>
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
    <?php echo $form->labelEx($model, 'province_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php
        asort($listprovince);
        ?>
        <?php echo $form->dropDownList($model, 'province_id', $listprovince, array('class' => 'span12 col-sm-12',)); ?>
        <?php echo $form->error($model, 'province_id'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'district_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php
        asort($listdistrict);
        ?>
        <?php echo $form->dropDownList($model, 'district_id', $listdistrict, array('class' => 'span12 col-sm-12',)); ?>
        <?php echo $form->error($model, 'district_id'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'ward_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php
        asort($listward);
        ?>
        <?php echo $form->dropDownList($model, 'ward_id', $listward, array('class' => 'span12 col-sm-12',)); ?>
        <?php echo $form->error($model, 'ward_id'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'address', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'order', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'order'); ?>
    </div>
</div>

<style>
    #sortable, #sortable1 {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    #sortable li, #sortable1 li {
        margin: 3px 3px 3px 0;
        padding: 1px;
        float: left;
        width: 200px;
        height: 210px;
        text-align: center;
    }

    #algalley .alimgbox .alimglist .alimgitem, #algalley1 .alimgbox .alimglist .alimgitem {
        width: 100%;
    }

    #algalley .alimgbox .alimglist .alimgitem .alimgitembox, #algalley1 .alimgbox .alimglist .alimgitem .alimgitembox {
        height: 200px;
        position: relative;
    }

    #algalley .alimgbox .alimglist .alimgitem .alimgaction, #algalley1 .alimgbox .alimglist .alimgitem .alimgaction {
        position: absolute;
        bottom: 0px;
    }
</style>



<div class="control-group form-group">
    <?php echo CHtml::label(Yii::t('bds_project_config', 'images'), null, array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">

        <?php
        $this->widget('common.widgets.upload.Upload', array(
            'type' => 'images',
            'id' => 'imageupload',
            'buttonheight' => 25,
            'path' => array('projects', $this->site_id, Yii::app()->user->id),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "completeImage(da);",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ));
        ?>
        <script type="text/javascript">
            function completeImage(da) {
                var firstitem = jQuery('#algalley .alimglist').find('.ui-state-default:first');
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
                html += '<input class="position_image" type="hidden" name="order_img[0][]" />';
//                html += '<input type="radio" value="new_' + da.imgid + '" name="setava">';
//                html += '<span>';
//                html += 'Chọn làm ảnh đại diện';
//                html += '</span>';
                html += '</div>';
                html += '<div class="imgAlt">';
                html += '<input class="controls" name="NewImageAlt[' + da.imgid + ']" type="text" maxlength="250" value="" placeHolder="<?php echo Yii::t('common', 'title') ?>">';
                html += '</div>';
                html += '<input type="hidden" value="' + da.imgid + '" name="newimage[0][]" class="newimage" />';
                html += '</div>';
                html += '</div>';
                html += '</li>';
                if (firstitem.html()) {
                    firstitem.before(html);
                } else {
                    jQuery('#algalley #sortable').append(html);
                }
                updateImgBox();
            }
        </script>

        <div id="algalley" class="algalley">
            <span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>
            <div style="display:none" id="Albums_imageitem_em_"
                 class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
            <div class="alimgbox">
                <div class="alimglist">
                    <ul id="sortable">
                        <?php
                        if (!$model->isNewRecord) {
                            $images = $model->getImages();
                            foreach ($images as $image) {
                                if ($image['type'] == BdsProjectConfigImages::TYPE_NORMAL) {
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
<script>
    $(function () {
        $("#sortable").sortable({
            stop: function (event, ui) {
                var img_id = $(ui.item).find('.position_image').val();
                if (img_id == 'newimage') {
                    $(ui.item).find('.newimage').attr('name', 'newimage[0][' + ui.item.index() + ']')
                }
            }
        });
        $("#sortable").disableSelection();
        $("#sortable1").sortable({
            stop: function (event, ui) {
                var img_id = $(ui.item).find('.position_image').val();
                if (img_id == 'newimage') {
                    $(ui.item).find('.newimage').attr('name', 'newimage[0][' + ui.item.index() + ']')
                }
            }
        });
        $("#sortable1").disableSelection();
    });
</script>
<script type="text/javascript">
    jQuery(document).on('change', '#BdsProjectConfig_province_id', function () {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
            data: 'pid=' + jQuery('#BdsProjectConfig_province_id').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#BdsProjectConfig_province_id'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#BdsProjectConfig_district_id').html(res.html);
                }
                w3HideLoading();
                getWard();
            },
            error: function () {
                w3HideLoading();
            }
        });
    });

    jQuery(document).on('change', '#BdsProjectConfig_district_id', function () {
        getWard();
    });

    function getWard() {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getward') ?>',
            data: 'did=' + jQuery('#BdsProjectConfig_district_id').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#BdsProjectConfig_district_id'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#BdsProjectConfig_ward_id').html(res.html);
                }
                w3HideLoading();
            },
            error: function () {
                w3HideLoading();
            }
        });
    }
</script>
<style>
    .imgAlt{padding: 5px;}
    .imgAlt .controls{width: 100%;}
</style>