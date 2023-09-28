<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<style>
    input.col-sm-12 {
        width: auto;
        min-width: 33.333%;
    }
</style>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'image', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-4">
        <?php echo $form->hiddenField($model, 'image', array('class' => 'span12 col-sm-12')); ?>
        <div id="shop_image" style="display: block; margin-top: 0px;">
            <div id="shop_image_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->image) echo 'margin-right: 10px;'; ?>">  
                <?php if ($model->image_path && $model->image_name) { ?>
                    <img src="<?php echo ClaHost::getImageHost(), $model->image_path, 's100_100/', $model->image_name; ?>" style="width: 100%;" />
                <?php } ?>
            </div>
            <div id="shop_image_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('shop', 'btn_select_image'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'image'); ?>
    </div>

    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-1 control-label no-padding-left')); ?>
    <div class="controls col-sm-5">
        <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
        <div id="shop_avatar" style="display: block; margin-top: 0px;">
            <div id="shop_avatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                <?php if ($model->avatar_path && $model->avatar_name) { ?>
                    <img src="<?php echo ClaHost::getImageHost(), $model->avatar_path, 's100_100/', $model->avatar_name; ?>" style="width: 100%;" />
                <?php } ?>
            </div>
            <div id="shop_avatar_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('shop', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'avatar'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'name'); ?>
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
        <?php echo $form->dropDownList($model, 'day_open', $range_day, array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->labelEx($model, 'day_close', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->dropDownList($model, 'day_close', $range_day, array('class' => 'span12 col-sm-12')); ?>
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
        <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12', 'placeholder' => 'Text...(không quá 100 chữ)')); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>
</div>
<!--Chọn Ảnh-->

<div class="form-group no-margin-left">
    <div class="item-contact">
        <div class="">

        </div>
    </div>
</div>

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
    .bonsai li{
        width: 200px;
        float: left;
    }
    #auto-checkboxes{
        border: 1px solid #d5d5d5;
        padding: 10px;
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
            'oncecomplete' => "var firstitem   = jQuery('#algalley .alimglist').find('.ui-state-default:first');var alimgitem   = '<li class=\"ui-state-default\"><div class=\"alimgitem\"><div class=\"alimgitembox\" style=\"height:180px\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"newimage[]\" class=\"newimage\" /></div></div></li>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley #sortable').append(alimgitem);}; updateImgBox();",
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

<div class="form-group no-margin-left" style="border: 1px solid #d5d5d5;padding: 10px;">
    <div class="form-group no-margin-left">
        <label class="col-sm-2 control-label no-padding-left"><b>Thông tin liên hệ</b></label>
        <div class="controls col-sm-10">
            <div class="radio col-sm-3 no-padding-left">
                <label class="no-padding-left">
                    <input <?php echo ($model->type_sell == 1) ? 'checked' : ''; ?> name="Shop[type_sell]" value="1" type="radio" class="ace">
                    <span class="lbl"> Gian hàng có địa chỉ</span>
                </label>
            </div>
            <div class="radio col-sm-3">
                <label>
                    <input <?php echo ($model->type_sell == 2) ? 'checked' : ''; ?> name="Shop[type_sell]" value="2" type="radio" class="ace">
                    <span class="lbl"> Gian hàng online</span>
                </label>
            </div>
            <label style="font-size: 12px;"><i>(Nếu bạn là gian hàng chỉ bán online thì không cần điền vào ô Địa chỉ. Tuy nhiên vẫn phải chọn các ô Tỉnh thành phố, Quận huyện và Phường xã để đưa vào bộ tìm kiếm địa bàn phục vụ tốt nhất của bạn.)</i></label>
        </div>
    </div>
    <?php
    $stores = ShopStore::getAllStorebyShopid($model->id, '*');
    ?>
    <div class="container_infocontact">
        <?php
        if (count($stores)) {
            foreach ($stores as $store) {
                ?>
                <div class="item_infocontact">
                    <div class="form-group no-margin-left">
                        <label class="col-xs-2 control-label no-padding-left" for="ShopStoreExist_<?php echo $store['id'] ?>_address">Địa chỉ</label>
                        <div class="controls col-sm-10 success">
                            <input class="span12 col-sm-12" placeholder="Địa chỉ" value="<?php echo $store['address'] ?>" name="ShopStoreExist[<?php echo $store['id'] ?>][address]" id="ShopStoreExist_<?php echo $store['id'] ?>_address" type="text" maxlength="255" />
                        </div>
                    </div>
                    <div class="form-group no-margin-left">
                        <label class="col-xs-2 control-label no-padding-left required" for="ShopStoreExist_<?php echo $store['id'] ?>_province_id">Tỉnh / thành phố <span class="required">*</span></label>
                        <div class="controls col-sm-10">
                            <select disabled class="span12 col-sm-12" name="ShopStoreExist[<?php echo $store['id'] ?>][province_id]" id="ShopStoreExist_<?php echo $store['id'] ?>_province_id">
                                <?php foreach ($listprovince as $key => $province) { ?>
                                    <option <?php echo ($key == $store['province_id']) ? 'selected' : '' ?> value="<?php echo $key; ?>"><?php echo $province; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group no-margin-left">
                        <label class="col-xs-2 control-label no-padding-left required" for="ShopStoreExist_<?php echo $store['id'] ?>_district_id">Quận / huyện <span class="required">*</span></label>
                        <div class="controls col-sm-10">
                            <select disabled class="span12 col-sm-12" name="ShopStoreExist[<?php echo $store['id'] ?>][district_id]" id="ShopStoreExist_<?php echo $store['id'] ?>_district_id">
                                <option value="<?php echo $store['district_id'] ?>"><?php echo $store['district_name'] ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group no-margin-left">
                        <label class="col-sm-2 control-label no-padding-left required" for="ShopStoreExist_<?php echo $store['id'] ?>_ward_id">Phường xã <span class="required">*</span></label>
                        <div class="controls col-sm-10">
                            <select disabled class="span12 col-sm-12" name="ShopStoreExist[<?php echo $store['id'] ?>][ward_id]" id="ShopStoreExist_<?php echo $store['id'] ?>_ward_id">
                                <option value="<?php echo $store['ward_id'] ?>"><?php echo $store['ward_name'] ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group no-margin-left">
                        <label class="col-sm-2 control-label no-padding-left" for="ShopStoreExist_<?php echo $store['id'] ?>_phone">Điện thoại liên hệ</label>
                        <div class="controls col-sm-10">
                            <input class="span12 col-sm-12" value="<?php echo $store['phone'] ?>" name="ShopStoreExist[<?php echo $store['id'] ?>][phone]" id="ShopStoreExist_<?php echo $store['id'] ?>_phone" type="text" maxlength="50">
                            <label class="col-sm-2 align-right" for="ShopStoreExist_<?php echo $store['id'] ?>_hotline">Hotline</label>
                            <input class="span12 col-sm-12" value="<?php echo $store['hotline'] ?>" name="ShopStoreExist[<?php echo $store['id'] ?>][hotline]" id="ShopStoreExist_<?php echo $store['id'] ?>_hotline" type="text" maxlength="50">
                        </div>
                    </div>
                    <script type="text/javascript">
                        jQuery(document).on('change', '#ShopStoreExist_<?php echo $store['id'] ?>_province_id', function () {
                            jQuery.ajax({
                                url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
                                data: 'pid=' + jQuery('#ShopStoreExist_<?php echo $store['id'] ?>_province_id').val(),
                                dataType: 'JSON',
                                beforeSend: function () {
                                    w3ShowLoading(jQuery('#ShopStoreExist_<?php echo $store['id'] ?>_province_id'), 'right', 20, 0);
                                },
                                success: function (res) {
                                    if (res.code == 200) {
                                        jQuery('#ShopStoreExist_<?php echo $store['id'] ?>_district_id').html(res.html);
                                    }
                                    w3HideLoading();
                                    getWard<?php echo $store['id'] ?>();
                                },
                                error: function () {
                                    w3HideLoading();
                                }
                            });
                        });

                        jQuery(document).on('change', '#ShopStoreExist_<?php echo $store['id'] ?>_district_id', function () {
                            getWard<?php echo $store['id'] ?>();
                        });

                        function getWard<?php echo $store['id'] ?>() {
                            jQuery.ajax({
                                url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getward') ?>',
                                data: 'did=' + jQuery('#ShopStoreExist_<?php echo $store['id'] ?>_district_id').val(),
                                dataType: 'JSON',
                                beforeSend: function () {
                                    w3ShowLoading(jQuery('#ShopStoreExist_<?php echo $store['id'] ?>_district_id'), 'right', 20, 0);
                                },
                                success: function (res) {
                                    if (res.code == 200) {
                                        jQuery('#ShopStoreExist_<?php echo $store['id'] ?>_ward_id').html(res.html);
                                    }
                                    w3HideLoading();
                                },
                                error: function () {
                                    w3HideLoading();
                                }
                            });
                        }
                    </script>
                    <hr style="margin-top: 0px;">
                </div>
                <?php
            }
        } else {
            ?>
            <div class="item_infocontact">
                <div class="form-group no-margin-left">
                    <label class="col-xs-2 control-label no-padding-left" for="ShopStore_1_address">Địa chỉ</label>
                    <div class="controls col-sm-10 success">
                        <input class="span12 col-sm-12" placeholder="Địa chỉ" name="ShopStore[1][address]" id="ShopStore_1_address" type="text" maxlength="255" />
                    </div>
                </div>
                <div class="form-group no-margin-left">
                    <label class="col-xs-2 control-label no-padding-left required" for="ShopStore_1_province_id">Tỉnh / thành phố <span class="required">*</span></label>
                    <div class="controls col-sm-10">
                        <select class="span12 col-sm-12" name="ShopStore[1][province_id]" id="ShopStore_1_province_id">
                            <?php foreach ($listprovince as $key => $province) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $province; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group no-margin-left">
                    <label class="col-xs-2 control-label no-padding-left required" for="ShopStore_1_district_id">Quận / huyện <span class="required">*</span></label>
                    <div class="controls col-sm-10">
                        <select class="span12 col-sm-12" name="ShopStore[1][district_id]" id="ShopStore_1_district_id">
                            <?php foreach ($listdistrict as $key => $district) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $district; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group no-margin-left">
                    <label class="col-sm-2 control-label no-padding-left required" for="ShopStore_1_ward_id">Phường xã <span class="required">*</span></label>
                    <div class="controls col-sm-10">
                        <select class="span12 col-sm-12" name="ShopStore[1][ward_id]" id="ShopStore_1_ward_id">
                            <?php foreach ($listward as $key => $ward) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $ward; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group no-margin-left">
                    <label class="col-sm-2 control-label no-padding-left" for="ShopStore_1_phone">Điện thoại liên hệ</label>
                    <div class="controls col-sm-10">
                        <input class="span12 col-sm-12" name="ShopStore[1][phone]" id="ShopStore_1_phone" type="text" maxlength="50">
                        <label class="col-sm-2 align-right" for="ShopStore_1_hotline">Hotline</label>
                        <input class="span12 col-sm-12" name="ShopStore[1][hotline]" id="ShopStore_1_hotline" type="text" maxlength="50">
                    </div>
                </div>
                <script type="text/javascript">
                    jQuery(document).on('change', '#ShopStore_1_province_id', function () {
                        jQuery.ajax({
                            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
                            data: 'pid=' + jQuery('#ShopStore_1_province_id').val(),
                            dataType: 'JSON',
                            beforeSend: function () {
                                w3ShowLoading(jQuery('#ShopStore_1_province_id'), 'right', 20, 0);
                            },
                            success: function (res) {
                                if (res.code == 200) {
                                    jQuery('#ShopStore_1_district_id').html(res.html);
                                }
                                w3HideLoading();
                                getWard();
                            },
                            error: function () {
                                w3HideLoading();
                            }
                        });
                    });

                    jQuery(document).on('change', '#ShopStore_1_district_id', function () {
                        getWard();
                    });

                    function getWard() {
                        jQuery.ajax({
                            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getward') ?>',
                            data: 'did=' + jQuery('#ShopStore_1_district_id').val(),
                            dataType: 'JSON',
                            beforeSend: function () {
                                w3ShowLoading(jQuery('#ShopStore_1_district_id'), 'right', 20, 0);
                            },
                            success: function (res) {
                                if (res.code == 200) {
                                    jQuery('#ShopStore_1_ward_id').html(res.html);
                                }
                                w3HideLoading();
                            },
                            error: function () {
                                w3HideLoading();
                            }
                        });
                    }
                </script>
                <hr style="margin-top: 0px;">
            </div>
        <?php } ?>
    </div>
    <div class="form-group no-margin-left">
        <label class="col-sm-2"></label>
        <div class="col-sm-10">
            <button class="btn btn-info" onclick="addaddress()" type="button">
                Thêm chi nhánh
            </button>
        </div>
    </div>
</div>
<script type="text/javascript">
    var count_address = $('.container_infocontact').children('.item_infocontact').length;
    function addaddress() {
        count_address++;
        $.getJSON(
                '<?php echo Yii::app()->createUrl('economy/shop/addaddress') ?>',
                {count_address: count_address},
                function (data) {
                    $('.container_infocontact').append(data.html);
                }
        );

    }

    $(document).ready(function () {

    });
</script>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'policy', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'policy', array('class' => 'span12 col-sm-12', 'placeholder' => 'Text...(không quá 1000 chữ)')); ?>
        <?php echo $form->error($model, 'policy'); ?>
    </div>
</div>

<!--Chọn danh mục-->
<?php
$shop_categories = ShopProductCategory::getShopCategories();
$category = new ClaCategory();
$category->type = ClaCategory::CATEGORY_PRODUCT;
$category->generateCategory();
$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $array);
$category->createBonsaiHtml(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, 'ShopCategory', $shop_categories, $html);
?>

<div class="form-group no-margin-left">
    <label class="col-sm-2 control-label no-padding-left required">Chọn ngành hàng kd</label>
    <?php if ($html) { ?>
        <div class="controls col-sm-10">
            <?php echo $html; ?>
        </div>
    <?php } ?>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-bonsai-master/jquery.bonsai.css" />
<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-bonsai-master/jquery.bonsai.js?v=1.0.1"></script>
<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-bonsai-master/jquery.qubit.js?v=1.0.1"></script>
<script type="text/javascript">
    $('#auto-checkboxes').bonsai({
        expandAll: true,
        checkboxes: true, // depends on jquery.qubit plugin
        createInputs: 'checkbox', // takes values from data-name and data-value, and data-name is inherited
        addSelectAll: false,
        addExpandAll: false
    });
<?php if (!$model->isNewRecord) { ?>
        $(document).ready(function () {
            $('#auto-checkboxes input:checkbox').attr("disabled", true);
        });
<?php } ?>


    if (!Array.prototype.remove) {
        Array.prototype.remove = function (val) {
            var i = this.indexOf(val);
            return i > -1 ? this.splice(i, 1) : [];
        };
    }
    var arr_cat = <?php echo json_encode($shop_categories); ?>;
    var allow_number_cat = <?php echo $model->allow_number_cat ?>;
    if (arr_cat.length >= allow_number_cat) {
        $('.ace-checkbox-2').not(":checked").attr('disabled', true);
    }
    $(document).ready(function () {
        $('.ace-checkbox-2').change(function () {
            var cat_id = $(this).val();
            if ($(this).is(":checked")) {
                arr_cat.push(cat_id);
            } else {
                arr_cat.remove(cat_id);
            }
            var arr_cat_length = arr_cat.length;
            if (arr_cat_length >= allow_number_cat) {
                $('.ace-checkbox-2').not(":checked").attr('disabled', true);
            } else {
                $('.ace-checkbox-2').not(":checked").attr('disabled', false);
            }
        });
    });

    jQuery(function ($) {
        jQuery('#shop_avatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/shop/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Shop_avatar').val(obj.data.avatar);
                        if (jQuery('#shop_avatar_img img').attr('src')) {
                            jQuery('#shop_avatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#shop_avatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#shop_avatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
        jQuery('#shop_image_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/shop/uploadfileimage"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Shop_image').val(obj.data.image);
                        if (jQuery('#shop_image_img img').attr('src')) {
                            jQuery('#shop_image_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#shop_image_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#shop_image_img').css({"margin-right": "10px"});
                    }
                }
            }
        });


    });


</script>

<!--End chọn danh mục-->