<style type="text/css">
    .right-content{
        padding-top: 4px;
    }
</style>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'transfer-money-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
        ));
        ?>

        <div class="control-group form-group">
            <label class="col-sm-2 control-label no-padding-left">Tên người yêu cầu</label>
            <div class="controls col-sm-10 right-content">
                <?php
                $user = Users::model()->findByPk($model->user_id);
                echo $user->name;
                ?>
            </div>
        </div>

        <div class="control-group form-group">
            <label class="col-sm-2 control-label no-padding-left">Thông tin chuyển khoản</label>
            <div class="controls col-sm-10 right-content">
                <?php
                $payment_info = AffiliatePaymentInfo::model()->findByPk($model->user_id);
                echo nl2br($payment_info->payment_info);
                ?>
            </div>
        </div>

        <div class="control-group form-group">
            <label class="col-sm-2 control-label no-padding-left">Số tiền yêu cầu chuyển</label>
            <div class="controls col-sm-10 right-content">
                <?= number_format($model->money, 0, ',', '.') ?> VNĐ
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'note', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10 right-content">
                <?= $model->note ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownlist($model, 'status', AffiliateTransferMoney::arrStatus(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->label($model, 'note_admin', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'note_admin', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'note_admin'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <label class="col-sm-2 control-label no-padding-left">Ảnh hóa đơn chuyển khoản (nếu có)</label>
            <div class="controls col-sm-10">
                <?php echo $form->hiddenField($model, 'image', array('class' => 'span12 col-sm-12')); ?>
                <div style="clear: both;"></div>
                <div id="transfer_image" style="display: block; margin-top: 10px;">
                    <div id="transfer_image_img"
                         style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->image) echo 'margin-right: 10px;'; ?>">
                             <?php if ($model->image_path && $model->image_name) { ?>
                            <img
                                src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>"
                                style="width: 100%;"/>
                            <?php } ?>
                    </div>
                    <div id="transfer_image_form" style="display: inline-block;">
                        <?php echo CHtml::button(Yii::t('affiliate', 'btn_select_image'), array('class' => 'btn  btn-sm')); ?>
                    </div>
                </div>
                <?php echo $form->error($model, 'image'); ?>
            </div>
        </div>

        <div class="control-group form-group buttons" style="border-bottom: none;">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('affiliate', 'update_transfer_money') : Yii::t('affiliate', 'update_transfer_money'), array('class' => 'btn btn-info', 'id' => 'savebanner')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#transfer_image_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/affiliate/affiliateTransferMoney/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#AffiliateTransferMoney_image').val(obj.data.avatar);
                        if (jQuery('#transfer_image_img img').attr('src')) {
                            jQuery('#transfer_image_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#transfer_image_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#transfer_image_img').css({"margin-right": "10px"});
                    }
                } else {
                    if (obj.message)
                        alert(obj.message);
                }

            }
        });
    });
</script>