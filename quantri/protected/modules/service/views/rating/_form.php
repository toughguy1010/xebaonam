<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'news-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="control-group form-group">
            <label class="col-sm-2 control-label no-padding-left required">Người review</label>
            <div class="controls col-sm-10">
                <?php
                    $user = Users::model()->findByPk($model->user_id);
                    echo isset($user->name) ? $user->name : '';
                ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'rating', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'rating', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'rating'); ?>
            </div>
        </div>
        
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'content', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'content', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'content'); ?>
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
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('rating', 'rating_create') : Yii::t('rating', 'rating_edit'), array('class' => 'btn btn-info', 'id' => 'savenews')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>