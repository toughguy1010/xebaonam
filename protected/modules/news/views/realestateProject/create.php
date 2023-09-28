<?php if ($user_id) { ?>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/upload/ajaxupload.min.js"></script>
    <div class="wrap_create_real_estate">
        <?php if (Yii::app()->user->hasFlash('success')): ?>
            <div class="info">
                <p class="bg-success"><?php echo Yii::app()->user->getFlash('success'); ?></p>
            </div>
        <?php endif; ?>

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'real-estate-project-form',
            'action' => Yii::app()->createUrl('news/realestateProject/create', array('id' => $form_id)),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'htmlOptions' => array('class' => 'form-horizontal w3f-form', 'role' => 'form', 'enctype' => 'multipart/form-data'),
        ));
        ?>

        <div class="form-group w3-form-group">
            <?php echo $form->label($model, 'name', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="col-xs-10 w3-form-field">
                <?php echo $form->textField($model, 'name', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('realestate', 'name'))); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group">
            <?php echo $form->label($model, 'address', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="col-xs-10 w3-form-field">
                <?php echo $form->textField($model, 'address', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'address'))); ?>
                <?php echo $form->error($model, 'address'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group">
            <?php echo $form->labelEx($model, 'province_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="col-xs-10 w3-form-field">
                <?php echo $form->dropDownList($model, 'province_id', $listprovince, array('class' => 'form-control w3-form-input input-text',)); ?>
                <?php echo $form->error($model, 'province_id'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group">
            <?php echo $form->labelEx($model, 'district_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="col-xs-10 w3-form-field">
                <?php echo $form->dropDownList($model, 'district_id', $listdistrict, array('class' => 'form-control w3-form-input input-text',)); ?>
                <?php echo $form->error($model, 'district_id'); ?>
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
        
        <div class="w3-form-group form-group">
            <div class="col-xs-2 w3-form-button"></div>
            <div class="col-xs-10 w3-form-button" style="padding: 0px;">
                <button style="width: 100px;" onclick="submit_realestateproject();" type="button" class="btn btn-primary"><?php echo Yii::t('common', 'create'); ?></button>
            </div>
        </div>

        <?php
        $this->endWidget();
        ?>
        <script>
            function submit_realestateproject() {
                document.getElementById("real-estate-project-form").submit();
                return false;
            }
        </script>
    </div>
    <script type="text/javascript">
        jQuery(function ($) {
            jQuery('#RealEstateavatar_form').ajaxUpload({
                url: '<?php echo Yii::app()->createUrl("/news/realestateProject/uploadfile"); ?>',
                name: 'file',
                onSubmit: function () {
                },
                onComplete: function (result) {
                    var obj = $.parseJSON(result);
                    if (obj.status == '200') {
                        if (obj.data.realurl) {
                            jQuery('#RealEstateProject_avatar').val(obj.data.avatar);
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
    <script type="text/javascript">
        jQuery(document).on('change', '#RealEstateProject_province_id', function () {
            jQuery.ajax({
                url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
                data: 'pid=' + jQuery('#RealEstateProject_province_id').val(),
                dataType: 'JSON',
                beforeSend: function () {
                    w3ShowLoading(jQuery('#RealEstateProject_province_id'), 'right', 20, 0);
                },
                success: function (res) {
                    if (res.code == 200) {
                        jQuery('#RealEstateProject_district_id').html(res.html);
                    }
                    w3HideLoading();
                },
                error: function () {
                    w3HideLoading();
                }
            });
        });
    </script>

<?php } else { ?>
    <div class="wrap_create_real_estate">
        <span class="do-not-login"><?php echo Yii::t('realestate', 'do_not_login'); ?></span>
    </div>
<?php } ?>

