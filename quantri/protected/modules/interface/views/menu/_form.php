<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen/chosen.css"></link>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen/chosen.jquery.js"></script>
<div class="row">
    <div class="col-xs-12 no-padding">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'menus-form',
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'menu_group', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownlist($model, 'menu_group', Menus::getMenuGroupArr(), array('class' => 'span12 col-sm-12', 'disabled' => 'disabled')); ?>
                <?php echo $form->error($model, 'menu_group'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'menu_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'menu_title', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'menu_title'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'parent_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'parent_id', $options, array('class' => 'span12 col-sm-12 ', 'disable' => 'disable')); ?>
                <?php echo $form->error($model, 'parent_id'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'menu_linkto', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php
                echo $form->radioButtonList($model, 'menu_linkto', Menus::getLinkToArr(), array(
                    'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                    'labelOptions' => array('style' => 'display:inline'),
                    'class' => 'linkto',
                        )
                );
                ?>
                <?php echo $form->error($model, 'menu_linkto'); ?>
            </div>
        </div>

        <div class="control-group form-group"
             style="<?php echo ($model->menu_linkto == Menus::LINKTO_INNER) ? 'display: block' : 'display: none'; ?>">
                 <?php echo $form->labelEx($model, 'menu_link', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->hiddenField($model, 'menu_values', array()); ?>
                <?php echo $form->error($model, 'menu_values'); ?>
                <span id="menuText"><?php echo Menus::getSelectedLinkLabel($model->menu_values); ?></span>
                <a class="btn btn-sm" href="<?php echo Yii::app()->createUrl('/interface/menu/getmenubox'); ?>" id="choiceMenu">
                    <i class="icon-link align-top bigger-125"></i>
                    <?php echo Yii::t('menu', 'choice_destination_link'); ?>
                </a>
            </div>
        </div>

        <div class="control-group form-group"
             style="<?php echo ($model->menu_linkto == Menus::LINKTO_OUTER) ? 'display: block' : 'display: none'; ?>">
                 <?php echo $form->labelEx($model, 'menu_link', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'menu_link', array('class' => 'span12 col-sm-12', 'placeholder' => Yii::t('menu', 'menu_url_outer'))); ?>
                <?php echo $form->error($model, 'menu_link'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'menu_order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'menu_order', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'menu_order'); ?>
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
            <?php echo $form->labelEx($model, 'menu_target', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownlist($model, 'menu_target', Menus::getTagetArr(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'menu_target'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'iconFile', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10" id="menuicon">
                <?php if (!$model->isNewRecord && $model->icon_name && $model->icon_path) { ?>
                    <img src="<?php echo ClaHost::getImageHost() . $model->icon_path . '/' . $model->icon_name; ?>"
                         style="display: inline; max-width: 68px; float: left; margin-right: 20px;"/>
                    <div style="margin-top: 15px;">
                        <button type="button" onclick="removeIcon(<?= $model->menu_id ?>)"
                                class="btn btn-danger btn-xs">Delete
                        </button>
                    </div>
                <?php } ?>
                <?php echo CHtml::fileField('iconFile', ''); ?>
                <?php echo $form->error($model, 'iconFile'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'backgroundFile', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10" id="menubackground">
                <?php if (!$model->isNewRecord && $model->background_name && $model->background_path) { ?>
                    <img
                        src="<?php echo ClaHost::getImageHost() . $model->background_path . '/' . $model->background_name; ?>"
                        style="display: inline; max-width: 68px; float: left; margin-right: 20px;"/>
                    <div style="margin-top: 15px;">
                        <button type="button" onclick="removeBackground(<?= $model->menu_id ?>)"
                                class="btn btn-danger btn-xs">Delete
                        </button>
                    </div>
                    <?php } ?>
                    <?php echo CHtml::fileField('backgroundFile', ''); ?>
                    <?php echo $form->error($model, 'backgroundFile'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'description'); ?>
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
                                <input <?php echo in_array($s['id'], $stores) ? 'checked' : '' ?> type="checkbox" name="Menus[store_ids][]" value="<?php echo $s['id'] ?>"> <?php echo $s['name'] ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
        }
        ?>
        <?php if (!$model->isNewRecord) { ?>
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">
                    <?php echo $form->textField($model, 'alias', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'alias'); ?>
                </div>
            </div>
        <?php } ?>
        <?php if (ClaUser::isSupperAdmin()) { ?>
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'type_site', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">
                    <?php echo $form->dropDownList($model, 'type_site', ActiveRecord::typeSite(), array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'type_site'); ?>
                </div>
            </div>
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'is_default_page', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">
                    <?php echo $form->checkBox($model, 'is_default_page'); ?>
                    <span class="lbl"
                          style="padding:0px 5px 4px 5px; color: #999; font-size: 12px; font-style: italic;"><?php echo Yii::t('setting', 'is_default_page_help') ?></span>
                          <?php echo $form->error($model, 'is_default_page'); ?>
                </div>
            </div>
        <?php } ?>
        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('menu', 'menu_create') : Yii::t('menu', 'menu_update'), array('class' => 'btn btn-info')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->
<script type="text/javascript">
    function removeIcon(id) {
        if (confirm("Are you sure delete icon?")) {
            $.getJSON(
                    '<?php echo Yii::app()->createUrl('interface/menu/deleteIcon') ?>',
                    {id: id},
                    function (data) {
                        if (data.code == 200) {
                            $('#menuicon img').remove();
                        }
                    }
            );
        }
    }
    function removeBackground(id) {
        if (confirm("Are you sure delete background?")) {
            $.getJSON(
                    '<?php echo Yii::app()->createUrl('interface/menu/deleteBackground') ?>',
                    {id: id},
                    function (data) {
                        if (data.code == 200) {
                            $('#menubackground img').remove();
                        }
                    }
            );
        }
    }
</script>
<script>
    var dialog = {};
    jQuery('input.linkto').change(function () {
        var val = jQuery(this).val();
        if (val ==<?php echo Menus::LINKTO_OUTER ?>) {
            jQuery('#Menus_menu_link').closest('.control-group').show();
            jQuery('#Menus_menu_values').closest('.control-group').hide();
        } else {
            jQuery('#Menus_menu_link').closest('.control-group').hide();
            jQuery('#Menus_menu_values').closest('.control-group').show();
        }
    });
    jQuery(document).on('change', 'input[type=radio][name=linkmenu]', function () {
        var val = jQuery(this).val();
        if (val !== false) {
            jQuery('#Menus_menu_values').val(val);
            jQuery('#menuText').html(jQuery(this).parent().find('span').text());
            dialog.modal('hide');
        }
    });
    //
    jQuery('#choiceMenu').on('click', function () {
        var _this = jQuery(this);
        var url = _this.attr('href');
        if (url) {
            jQuery.ajax({
                url: url,
                data: {value: jQuery('#Menus_menu_values').val()},
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    w3ShowLoading(jQuery('#choiceMenu'), 'right', 20, 0);
                },
                success: function (res) {
                    if (res.code) {
                        if (res.html) {
                            dialog = bootbox.dialog({
                                size: 900,
                                message: res.html
                            });
                        }
                    }
                    w3HideLoading();
                },
                error: function () {
                    w3HideLoading();
                }
            });
        }
        return false;
    });
</script>
