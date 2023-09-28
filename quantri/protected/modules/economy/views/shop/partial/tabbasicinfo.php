<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<style>
    input.col-sm-12 {
        width: auto;
        min-width: 33.333%;
    }
</style>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'address', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'address', array('class' => 'span12 col-sm-12', 'placeholder' => Yii::t('common', 'address'))); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'province_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'province_id', $listprovince, array('class' => 'span12 col-sm-12',)); ?>
        <?php echo $form->error($model, 'province_id'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'district_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'district_id', $listdistrict, array('class' => 'span12 col-sm-12',)); ?>
        <?php echo $form->error($model, 'district_id'); ?>
    </div>
</div> 
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'ward_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'ward_id', $listward, array('class' => 'span12 col-sm-12',)); ?>
        <?php echo $form->error($model, 'ward_id'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'phone', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'email', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'phone', array(), true, false); ?>
        <?php echo $form->error($model, 'email', array(), true, false); ?>
    </div>
</div>
<?php
$range_time = array_map(function($h) {
    return $h . 'h';
}, range(0, 23));
?>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'time_open', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'time_open', $range_time, array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->labelEx($model, 'time_close', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->dropDownList($model, 'time_close', $range_time, array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'time_open', array(), true, false); ?>
        <?php echo $form->error($model, 'time_close', array(), true, false); ?>
    </div>
</div>

<?php
$range_day = array_map(function($d) {
    $return = '';
    if ($d <= 7) {
        $return = 'Thứ ' . $d;
    } else if ($d == 8) {
        $return = 'Chủ nhật';
    }
    return $return;
}, array_combine(range(2, 8), range(2, 8)));
?>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'day_open', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'day_open', $range_time, array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->labelEx($model, 'day_close', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->dropDownList($model, 'day_close', $range_time, array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'day_open', array(), true, false); ?>
        <?php echo $form->error($model, 'day_close', array(), true, false); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'yahoo', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'yahoo', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->labelEx($model, 'skype', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'skype', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'yahoo', array(), true, false); ?>
        <?php echo $form->error($model, 'skype', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'facebook', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'facebook', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->labelEx($model, 'instagram', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'instagram', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'facebook', array(), true, false); ?>
        <?php echo $form->error($model, 'instagram', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'pinterest', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'pinterest', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->labelEx($model, 'twitter', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'twitter', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'pinterest', array(), true, false); ?>
        <?php echo $form->error($model, 'twitter', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>
</div>

<!--Chọn Ảnh-->

<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
    #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 200px; height: 210px; text-align: center; }
    #algalley .alimgbox .alimglist .alimgitem{
        width: 100%;
    }
    #algalley .alimgbox .alimglist .alimgitem .alimgitembox{
        height: 200px;
        position: relative;
    }
    #algalley .alimgbox .alimglist .alimgitem .alimgaction{
        position: absolute;
        bottom: 0px;
    }
</style>

<div class="form-group no-margin-left">
    <?php echo CHtml::label(Yii::t('shop', 'shop_image'), null, array('class' => 'col-sm-2 control-label')); ?>
    <div class="controls col-sm-10">

        <?php
        $this->widget('common.widgets.upload.Upload', array(
            'type' => 'images',
            'id' => 'imageupload',
            'buttonheight' => 25,
            'path' => array('shops', $this->site_id, Yii::app()->user->id),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "var firstitem   = jQuery('#algalley .alimglist').find('.ui-state-default:first');var alimgitem   = '<li class=\"ui-state-default\"><div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><div class=\"alimgaction\"><input class=\"position_image\" type=\"hidden\" name=\"order_img[]\" value=\"newimage\" /><input type=\"radio\" value=\"new_'+da.imgid+'\" name=\"setava\"><span>" . Yii::t('album', 'album_set_avatar') . "</span></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"newimage[]\" class=\"newimage\" /></div></div></li>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley #sortable').append(alimgitem);}; updateImgBox();",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ));
        ?>

        <div id="algalley" class="algalley">
            <span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>
            <div style="display:none" id="Albums_imageitem_em_" class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
            <div class="alimgbox">
                <div class="alimglist">
                    <ul id="sortable">
                        <?php
                        if (!$model->isNewRecord) {
                            $images = $model->getImages();
                            foreach ($images as $image) {
                                $this->renderPartial('imageitem', array('image' => $image, 'avatar_id' => $model->avatar_id));
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
                    $(ui.item).find('.newimage').attr('name', 'newimage[' + ui.item.index() + ']')
                }
            }
        });
        $("#sortable").disableSelection();
    });
    jQuery(document).on('click', '.new_delimgaction', function () {
        jQuery(this).closest('.alimgitem').remove();
        updateImgBox();
        return false;
    });
    jQuery(document).on('click', '.delimgaction', function () {
        if (confirm('<?php echo Yii::t('album', 'album_delete_image_confirm'); ?>')) {
            var thi = $(this);
            var href = thi.attr('href');
            if (href) {
                jQuery.ajax({
                    url: href,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (res) {
                        if (res.code == 200) {
                            jQuery(thi).closest('.alimgitem').remove();
                            updateImgBox();
                        }
                    }
                });
            }
        }
        return false;
    });
</script>

<!--End Chọn Ảnh-->

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->radioButtonList($model, 'status', ActiveRecord::statusArrayRealestate(), array('class' => '')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'type_sell', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->radioButtonList($model, 'type_sell', ActiveRecord::typeShopSell(), array('class' => '')); ?>
        <?php echo $form->error($model, 'type_sell'); ?>
    </div>
</div>

<!--End chọn danh mục-->