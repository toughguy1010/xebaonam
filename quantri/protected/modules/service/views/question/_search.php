<div class="form-search">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));
    ?>
    <?php 
    $campaigns = QuestionCampaign::getAllCampaigns();
    $options_campaign = ['' => '---Chọn chiến dịch---'] + array_column($campaigns, 'name', 'id');
    ?>
    <?php echo $form->dropDownList($model, 'campaign_id', $options_campaign, array('class' => '', 'placeholder' => $model->getAttributeLabel('campaign_id'))); ?>
    <?php echo $form->textField($model, 'username', array('class' => '', 'placeholder' => $model->getAttributeLabel('username'), 'style' => 'max-width: 130px;')); ?>
    <?php echo $form->textField($model, 'email', array('class' => '', 'placeholder' => $model->getAttributeLabel('email'), 'style' => 'max-width: 130px;')); ?>
    <?php
    echo $form->dropDownList($model, 'status_answer', [
        '' => '---Tình trạng---',
        ActiveRecord::STATUS_ACTIVED => 'Đã trả lời',
        ActiveRecord::STATUS_DEACTIVED => 'Chưa trả lời'
            ], array('class' => ''));
    ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->