<?php
//
$category = new ClaCategory();
$category->type = ClaCategory::CATEGORY_NEWS;
$category->generateCategory();
$arr = array('' => Yii::t('category', 'category_parent_0'));
//
$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);
//
?>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css">
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>

    <script type="text/javascript">
        jQuery(document).ready(function () {
            $("#addCate").colorbox({width: "80%", overlayClose: false});
            CKEDITOR.replace("News_news_desc", {
                height: 400,
                language: '<?php echo Yii::app()->language ?>'
            });
            $('#ck-check').on("click", function () {
                if (this.checked) {
                    CKEDITOR.replace("News_news_sortdesc", {
                        height: 400,
                        language: '<?php echo Yii::app()->language ?>'
                    });
                } else {
                    var a = CKEDITOR.instances['News_news_sortdesc'];
                    if (a) {
                        a.destroy(true);
                    }

                }
            });
        });

        jQuery(function ($) {
            jQuery('#newsavatar_form').ajaxUpload({
                url: '<?php echo Yii::app()->createUrl("/content/news/uploadfile"); ?>',
                name: 'file',
                onSubmit: function () {
                },
                onComplete: function (result) {
                    var obj = $.parseJSON(result);
                    if (obj.status == '200') {
                        if (obj.data.realurl) {
                            jQuery('#News_avatar').val(obj.data.avatar);
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
        });
    </script>

<?php
//
$category = new ClaCategory();
$category->type = ClaCategory::CATEGORY_NEWS;
$category->generateCategory();
$arr = array('' => Yii::t('category', 'category_parent_0'));
//
$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);
//
?>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css">
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/imagesloaded.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/masonry.min.js');
?>

    <div class="widget-main">
        <div class="row">
            <div class="col-sm-12 col-xs-12 no-padding">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'news-form',
                    'htmlOptions' => array('class' => 'form-horizontal'),
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
                ));
                ?>

                <div class="tabbable">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active">
                            <a data-toggle="tab" href="#basicinfo">
                                <?php echo Yii::t('shop', 'basicinfo'); ?>
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#tabimage">
                                <?php echo Yii::t('news', 'advance_image'); ?>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="basicinfo" class="tab-pane active">
                            <div class="control-group form-group">
                                <?php echo $form->labelEx($model, 'news_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                                <div class="controls col-sm-10">
                                    <?php echo $form->textField($model, 'news_title', array('class' => 'span12 col-sm-12')); ?>
                                    <?php echo $form->error($model, 'news_title'); ?>
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
                                <?php echo $form->labelEx($model, 'news_category_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                                <div class="controls col-sm-10">
                                    <div class="input-group">
                                        <?php echo $form->dropDownList($model, 'news_category_id', $option, array('class' => 'form-control')); ?>
                                        <div class="input-group-btn" style="padding-left: 10px;">
                                            <a href="<?php echo Yii::app()->createUrl('content/newscategory/addcat', array('pa' => ClaCategory::CATEGORY_ROOT) + $_GET) ?>"
                                               id="addCate" class="btn btn-primary btn-sm" style="line-height: 16px;">
                                                <?php echo Yii::t('category', 'category_add'); ?>
                                            </a>
                                        </div>
                                    </div>
                                    <?php echo $form->error($model, 'news_category_id'); ?>
                                    <?php if(Yii::app()->siteinfo['news_in_multi_cat']) { ?>
                                        <div class="box-add-cat">
                                            <style type="text/css">
                                                .add-select-cat {
                                                    margin-top: 10px;
                                                    height: 32px;
                                                    border: 1px dashed #CFCFCF;
                                                    text-align: center;
                                                    width: 100%;
                                                    line-height: 32px;
                                                    cursor: pointer;
                                                    display: block;
                                                    font-size: 16px;
                                                    float: right;
                                                    color: #000;
                                                    background: #e5e5e5;
                                                }
                                                .item-cat {
                                                    padding-top: 10px;
                                                    clear: both;
                                                }
                                                .delete-cat {
                                                    background: red;
                                                    display: inline-block;
                                                    text-align: center;
                                                    color: #fff;
                                                    font-size: 16px;
                                                    padding: 3px 0px;
                                                    cursor: pointer;
                                                }
                                            </style>
                                            <div id="box-append-cat" class="">
                                                <?php
                                                if($model->news_id) {
                                                    $rels = $model->list_category ? explode(' ', $model->list_category) : [];
                                                    if($rels) {
                                                        unset($rels[0]);
                                                        foreach ($rels as $key => $value) { ?>
                                                            <div class="item-cat">
                                                                <?= CHtml::dropDownList('new_rel_cal[]',
                                                                    $value,
                                                                    $option,
                                                                    ['class' => 'col-md-11']
                                                                ); 
                                                                ?>
                                                                <span class="delete-cat col-md-1" data-id="<?= $rel->id ?>">x</span>
                                                            </div>
                                                            

                                                        <?php }
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <a class="add-select-cat">+</a>
                                            <script type="text/javascript">
                                                $('.add-select-cat').click( function () {
                                                    $('#box-append-cat').append('<div class="item-cat"><select class="col-md-11" name="new_rel_cal[]">'+$('#News_news_category_id').html()+' </select><span class="delete-cat col-md-1">x</span></div>');
                                                });
                                                $(document).on('click', '.delete-cat',function () {
                                                    if(confirm("Xác nhận xóa mục?")) {
                                                        $(this).parent().remove();
                                                    }
                                                });
                                            </script>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <?php echo $form->labelEx($model, 'file_src', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                                <div class="controls col-sm-10">
                                    <?php echo $form->hiddenField($model, 'file_src', array('class' => 'span12 col-sm-12')); ?>
                                    <div class="row" style="margin: 10px 0px;">
                                        <?php
                                        $file = [];
                                        if(isset($model->file_id) && $model->file_id) {
                                            $file = Files::model()->findByPk($model->file_id);
                                        }
                                        ?>
                                        <?php if (!$model->isNewRecord && $file) { ?>
                                            <?=$file->display_name;?>
                                            <div style="margin-top: 15px;">
                                                <button type="button" onclick="removeFile('<?=$model->file_id ?>')"
                                                        class="btn btn-danger btn-xs">Delete
                                                </button>
                                            </div>
                                        <?php } else { ?>
                                            <?php echo CHtml::fileField('file_src', ''); ?>
                                        <?php  } ?>
                                    </div>
                                    <?php echo $form->error($model, 'file_src'); ?>
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <?php echo $form->labelEx($model, 'news_sortdesc', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                                <div class="controls col-sm-10">
                                    <input name="us-ck" type="checkbox" id="ck-check" value="" style="">
                                    <label for="ck-check" style="font-size: 12px;color: blue;pointer:cursor">Sử dụng
                                        trình soạn thảo</label>
                                    <?php echo $form->textArea($model, 'news_sortdesc', array('class' => 'span12 col-sm-12')); ?>
                                    <?php echo $form->error($model, 'news_sortdesc'); ?>
                                </div>
                            </div>

                            <div class="control-group form-group">
                                <?php echo $form->labelEx($model, 'news_desc', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                                <div class="controls col-sm-10">
                                    <div class="span12">
                                        <?php echo $form->textArea($model, 'news_desc', array('class' => 'span12 col-sm-12')); ?>
                                        <?php echo $form->error($model, 'news_desc'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <?php echo $form->labelEx($model, 'news_hot', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                                <div class="controls col-sm-10">
                                    <?php echo $form->checkBox($model, 'news_hot'); ?>
                                    <?php echo $form->error($model, 'news_hot'); ?>
                                </div>
                            </div>

                            <div class="control-group form-group">
                                <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                                <div class="controls col-sm-10">
                                    <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                                    <div style="clear: both;"></div>
                                    <div id="newsavatar" style="display: block; margin-top: 10px;">
                                        <div id="newsavatar_img"
                                             style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">
                                            <?php if ($model->image_path && $model->image_name) { ?>
                                                <img
                                                        src="<?php echo ClaUrl::getImageUrl($model->image_path, $model->image_name, ['width' => 100, 'height' => 100]); ?>"
                                                        style="width: 100%;"/>
                                            <?php } ?>
                                        </div>
                                        <div id="newsavatar_form" style="display: inline-block;">
                                            <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                                        </div>
                                        <?php if ($model->image_path && $model->image_name) { ?>
                                            <div style="margin-top: 15px;">
                                                <button type="button" onclick="removeAvatar(<?= $model->news_id ?>)"
                                                        class="btn btn-danger btn-xs">Delete avatar
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php echo $form->error($model, 'avatar'); ?>
                                </div>
                            </div>

                            <div class="control-group form-group">
                                <?php echo $form->labelEx($model, 'news_source', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                                <div class="controls col-sm-10">
                                    <?php echo $form->textField($model, 'news_source', array('class' => 'span12 col-sm-12')); ?>
                                    <?php echo $form->error($model, 'news_source'); ?>
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <?php echo $form->labelEx($model, 'poster', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                                <div class="controls col-sm-10">
                                    <?php echo $form->textField($model, 'poster', array('class' => 'span12 col-sm-12')); ?>
                                    <?php echo $form->error($model, 'poster'); ?>
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <?php echo $form->labelEx($model, 'publicdate', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                                <div class="controls col-sm-10">
                                    <?php
                                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                                        'model' => $model, //Model object
                                        'name' => 'News[publicdate]', //attribute name
                                        'mode' => 'datetime', //use "time","date" or "datetime" (default)
                                        'value' => ((int)$model->publicdate > 0) ? date('d-m-Y H:i:s', (int)$model->publicdate) : date('d-m-Y H:i:s'),
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
                                <?php echo $form->labelEx($model, 'completed_time', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                                <div class="controls col-sm-10">
                                    <?php
                                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                                        'model' => $model, //Model object
                                        'name' => 'News[completed_time]', //attribute name
                                        'mode' => 'datetime', //use "time","date" or "datetime" (default)
                                        'value' => ((int)$model->completed_time > 0) ? date('d-m-Y H:i:s', (int)$model->completed_time) : date('d-m-Y H:i:s'),
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
                                    <?php echo $form->error($model, 'completed_time'); ?>
                                </div>
                            </div>

                            <div class="control-group form-group">
                                <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                                <div class="controls col-sm-10">
                                    <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArrayNews(), array('class' => 'span12 col-sm-12')); ?>
                                    <?php echo $form->error($model, 'status'); ?>
                                </div>
                            </div>
                            <?php
                            $shop_store = ShopStore::getAllShopstore();
                            if (count($shop_store)) {
                                ?>
                                <div class="control-group form-group">
                                    <?php echo $form->labelEx($model, 'store_ids', array('class' => 'col-sm-2 control-label no-padding-left')) ?>
                                    <?php
                                    $stores = explode(' ', $model->store_ids);
                                    ?>
                                    <div class="controls col-sm-10">
                                        <?php foreach ($shop_store as $s) { ?>
                                            <div class="checkbox">
                                                <label>
                                                    <input <?php echo in_array($s['id'], $stores) ? 'checked' : '' ?>
                                                            type="checkbox"
                                                            name="News[store_ids][]"
                                                            value="<?php echo $s['id'] ?>"> <?php echo $s['name'] ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="control-group form-group">
                                <?php echo $form->labelEx($model, 'video_links', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                                <div class="controls col-sm-9" id="add_video">
                                    <span style="color: blue;font-size: 12px">Link nhúng video của youtube. Chỉ chấp nhận link "https://www.youtube.com/embed/..."</span>
                                    <?php if (isset($model->video_links) && count($model->video_links) > 0 && $model->video_links) { ?>
                                        <?php foreach ($model->video_links as $key => $video_link) { ?>
                                            <div class="row <?php echo 'link' . $key ?>">
                                                <div class="col-sm-10">
                                                    <input class="span12 col-sm-12 " value="<?php echo $video_link ?>"
                                                           style="padding-top: 4px; margin-bottom: 4px;"
                                                           name="News[video_links][]" id="News_video_links"
                                                           type="text">
                                                </div>
                                                <div class="col-sm-2">
                                                    <a href="javascript:void(0)" class="new_video"
                                                       style="padding-top: 4px; margin-bottom: 4px;color: blue"
                                                       onclick="remove_video(this)"
                                                       data-id="<?php echo 'link' . $key ?>">Xóa</a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="controls col-sm-1">
                                    <a href="javascript:void(0)" class="new_video"
                                       style="padding-top: 4px; margin-bottom: 4px;color: blue"
                                       onclick="add_video(this)"> Thêm </a>
                                </div>
                            </div>
                            <script>
                                function add_video() {
                                    $('#add_video').append('<input class="span12 col-sm-12" style="margin-top: 10px" name="News[video_links][]" id="News_video_links" type="text">')
                                }

                                function remove_video(ev) {
                                    var key = $(ev).attr('data-id');
                                    $('.' + key).remove();
                                    $(ev).remove();
                                }
                            </script>
                            <div class="control-group form-group">
                                <?php echo $form->labelEx($model, 'meta_keywords', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                                <div class="controls col-sm-10">
                                    <label
                                            style="font-size: 12px;font-style: italic"><?php echo Yii::t('common', 'tags_description') ?></label>
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


                        </div>
                        <div id="tabimage" class="tab-pane">
                            <?php
                            $this->renderPartial('partial/tabimage', array('model' => $model, 'form' => $form));
                            ?>
                        </div>
                        <div class="control-group form-group buttons">
                            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('news', 'news_create') : Yii::t('news', 'news_edit'), array('class' => 'btn btn-info', 'id' => 'savenews')); ?>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function removeFile(file_id) {
            if (confirm("Are you sure delete icon?")) {
                $.getJSON(
                    '<?php echo Yii::app()->createUrl('media/file/delete') ?>',
                    {id: file_id},
                    function (data) {
                        if (data.code == 200) {
                            $('#menuicon img').remove();
                        }
                    }
                );
                window.location.href = "<?=Yii::app()->createUrl('content/news/update', array('id'=> $model->news_id))?>";
            }
        }
        function removeAvatar(id) {
            if (confirm("Are you sure delete avatar?")) {
                $.getJSON(
                    '<?php echo Yii::app()->createUrl('content/news/deleteAvatar') ?>',
                    {id: id},
                    function (data) {
                        if (data.code == 200) {
                            $('#newsavatar_img img').remove();
                        }
                    }
                );
            }
        }
    </script>
<?php
$this->renderPartial('partial/mainscript', array('model' => $model));
?>