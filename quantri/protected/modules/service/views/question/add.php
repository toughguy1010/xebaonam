<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<?php
$campaign = QuestionCampaign::model()->findByPk($model->campaign_id);
?>
<div class="widget widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('service', 'create') : Yii::t('service', 'update'); ?>
        </h4>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'language-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <label class="col-sm-2 control-label no-padding-left">Chiến dịch</label>
                        <div class="controls col-sm-10">
                            <p><b><?= $campaign->name ?></b></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <label class="col-sm-2 control-label no-padding-left">Người hỏi</label>
                        <div class="controls col-sm-10">
                            <p><b><?= $model->username ?></b></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <label class="col-sm-2 control-label no-padding-left">Email</label>
                        <div class="controls col-sm-10">
                            <p><b><?= $model->email ?></b></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <label class="col-sm-2 control-label no-padding-left">Nội dung hỏi</label>
                        <div class="controls col-sm-10">
                            <p><b><?= $model->content ?></b></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'guest_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $guestsByCampaign = QuestionGuest::getGuestById($campaign->guests);
                            $guests = ['0' => '------------------'] + array_column($guestsByCampaign, 'name', 'id');
                            ?>
                            <?php echo $form->dropDownList($model, 'guest_id', $guests, array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'guest_id'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'answer', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'answer', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'answer'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'status'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('service', 'create') : Yii::t('service', 'update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#questionCampaignavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/service/questionCampaign/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#QuestionCampaign_avatar').val(obj.data.avatar);
                        if (jQuery('#questionCampaignavatar_img img').attr('src')) {
                            jQuery('#questionCampaignavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#questionCampaignavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#questionCampaignavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });


    });
</script>
