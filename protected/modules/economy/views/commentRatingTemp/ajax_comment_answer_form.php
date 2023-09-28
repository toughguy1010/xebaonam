<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'widget-comment-ans-form-' . $commentId,
    'action' => Yii::app()->createUrl('economy/commentRatingTemp/commentAnswerSubmit'),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'htmlOptions' => array('class' => 'form-horizontal widget-form'),
));
?>
    <div class="row">
        <div class="text col-sm-12" id="detail_wrapper">
            <?php echo $form->labelEx($model, 'content', array('class' => '')); ?>
            <div class="control">
                <?php echo $form->textArea($model, 'content', array('style' => 'height:80px;min-height:80px;max-height:200px;', 'class' => 'form-control', 'placeholder' => 'Nhập nội dung tại đây. Tối thiểu 20 từ, tối đa 1000 từ.', 'title' => $model->getAttributeLabel('content'))); ?>
                <?php echo $form->error($model, 'content'); ?>
                <?php echo $form->hiddenField($model, 'comment_id', array('class' => 'form-control input-sm'), 'hatv'); ?>
                <?php echo $form->error($model, 'comment_id'); ?>
                <?php echo $form->hiddenField($model, 'type', array('class' => 'form-control input-sm'), 'hatv'); ?>
                <?php echo $form->error($model, 'type'); ?>
            </div>
        </div>
        <div class="comment-user clearfix">
            <div class="notice-comment"><?php echo 'Để gửi bình luận bạn vui lòng nhập các thông tin bên dưới.' ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <?php echo $form->textField($model, 'name', array('class' => 'form-control input-sm')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <?php echo $form->textField($model, 'email_phone', array('class' => 'form-control input-sm')); ?>
                <?php echo $form->error($model, 'email_phone'); ?>
            </div>
        </div>
        <div class="text col-sm-12">
            <div class="input-group">
                <?php echo $form->textField($model, 'verifyCode', array('class' => 'form-control')); ?>
                <span class="input-group-addon" style="padding: 0px 5px; min-width: 110px;">
                        <?php
                        $this->widget('CCaptcha', array(
                            'id' => 'rep-capcha-' . $model->comment_id,
                            'buttonLabel' => '<i class="ico ico-refrest"></i>',
                            'imageOptions' => array(
                                'style' => 'height:31px;',
                            ),
                        ));
                        ?>
                    </span>
            </div>
            <?php echo $form->error($model, 'verifyCode'); ?>
        </div>
        <div class="action col-sm-12" style="text-align: right">
            <div class="word-counter"></div>
            <?php
            echo CHtml::ajaxSubmitButton(
                Yii::t('common', 'submit'),
                Yii::app()->createUrl('economy/commentRatingTemp/commentAnswerSubmit'),
                array(
                    'type' => 'POST',
                    'data' => "js:$('#widget-comment-ans-form-$commentId').serialize()",
                    'success' => "function(data){var datacb = JSON.parse(data);
                    if(datacb.code == 200){
                    $('.content-block .comment_reply .reply-coment.reply-coment-$commentId').after(data.html); 
                    $('#widget-comment-ans-form-$commentId').trigger('reset').find('.errorMessage').hide();
                    }if(datacb.errors){parseJsonErrors(datacb.errors, $('#widget-comment-ans-form-$commentId'));}
                    }",
                ),
                array('class' => 'btn btn-sm', 'id' => "btn-post-comment-answer-$commentId", 'style' => 'padding:0; background:#73af43; color:#fff; border-radius: 0px;  display: block;'));
            ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
