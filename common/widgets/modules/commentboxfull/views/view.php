<?php $user_profile = Users::model()->findByPk(Yii::app()->user->id); ?>
<div class="comment-box" id="comment-box<?= $object_id ?>">
    <div class="" style="display: block;">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'widget-comment-form' . $object_id,
            'action' => Yii::app()->createUrl('economy/commentRatingTemp/commentSubmit'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'htmlOptions' => array('class' => 'form-horizontal widget-form'),
        ));
        $model->object_id = $object_id;
        $model->type = $type;
        ?>
        <div class="row">
            <div class="text col-sm-12" id="detail_wrapper">
                <?php echo $form->labelEx($model, 'content', array('class' => '')); ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'content', array('style' => 'height:80px;min-height:80px;max-height:200px;', 'class' => 'form-control', 'placeholder' => 'Nhập nội dung tại đây. Tối thiểu 20 từ, tối đa 1000 từ.', 'title' => $model->getAttributeLabel('content'))); ?>
                    <?php echo $form->error($model, 'content'); ?>
                    <?php echo $form->hiddenField($model, 'object_id', array('class' => 'form-control input-sm'), 'hatv'); ?>
                    <?php echo $form->error($model, 'object_id'); ?>
                    <?php echo $form->hiddenField($model, 'type', array('class' => 'form-control input-sm'), 'hatv'); ?>
                    <?php echo $form->error($model, 'type'); ?>
                </div>
            </div>
            <div class="comment-user clearfix">
                <div class="notice-comment">
                    <?php echo 'Để gửi bình luận bạn vui lòng nhập các thông tin bên dưới.' ?>
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
                            'id' => "reset-cap-$object_id",
                            'buttonLabel' => '<i class="ico ico-refrest"></i>',
                            'imageOptions' => array(
                                'style' => 'height:31px;',
                                'class' => 'img-capcha'
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
                    Yii::t('common', 'send'),
                    Yii::app()->createUrl('economy/commentRatingTemp/commentSubmit'),
                    array(
                        'type' => 'POST',
                        'data' => "js:$('#widget-comment-form$object_id').serialize()",
                        'success' => "js:function(data){
                             var datacb = JSON.parse(data);
                             if(datacb.code == 200){
                                 $('#content-block$object_id').prepend(datacb.html);
                                 $('#widget-comment-form$object_id').trigger('reset').find('.errorMessage').hide();}
                             else if(datacb.errors){
                                 parseJsonErrors(datacb.errors, $('#widget-comment-form$object_id'));}
                             }",
                    ),
                    array('class' => 'btn btn-sm', 'id' => "btn-post-comment$object_id", 'style' => 'background: #365899;
    padding: 3px 25px;
    color: #fff;
    border-radius: 5px;
    display: block;'));
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <div class="content-block" id="content-block<?= $object_id ?>">
        <?php
        $modelAnswer = new CommentAnswer;
        foreach ($comment as $key => $each_coment) {
            ?>
            <div class="comment_as_lv1 comment_ask" id="<?php echo 'com-', $each_coment['id'] ?>">
                <div class="user-cmt">
                    <div class="user-cmt-avat">
                        <div class="avatar-name-fword" style="">
                            <span style="">
<!--                                --><?php //echo substr($each_coment['name'], 0, 1, "utf-8"); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="user-cmt-cont" style="margin-bottom: 10px">
                    <span class="user-cmt-name">
                        <strong><?php echo $each_coment['name'] ?></strong>
                    </span>
                    - <?php echo ProductRating::time_elapsed_string($each_coment['created_time']) ?>
                    <div>
                        <?php echo $each_coment['content'] ?>
                    </div>
                    <div class="user-cmt-time">
                        <a href="javascript:void(0)" data-id="<?php echo $each_coment['id'] ?>" class="show-rep-form">
                            <?= Yii::t('question', 'question_answer') ?>
                        </a>
                    </div>
                </div>
                <div class="comment_reply">
                    <div class="reply-coment <?php echo ' reply-coment-', $each_coment['id'] ?>" style="">
                    </div>
                    <?php
                    $count = count($each_coment['answers']);
                    if ($count) {
                        $n = 0;
                        foreach ($each_coment['answers'] as $each_comment_ans) {
                            ?>
                            <div class="comment_ask <?php echo ($n++ >= 2) ? 'hidden_reply_cm' : '' ?>"
                                 id="<?php echo 'ans-', $each_comment_ans['id']; ?>">
                                <div class="user-cmt">
                                    <div class="user-cmt-avat">
                                        <div class="avatar-name-fword" style="">
                                            <span style="">
                                                <?php echo substr($each_comment_ans['name'], 0, 1); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-cmt-cont">
                                    <span class="user-cmt-name">
                                        <strong><?php echo $each_comment_ans['name'] ?></strong>
                                        <?php if ($each_comment_ans['user_type'] == 1) { ?>
                                            <b class="qtv"><? Yii::t('comment', 'admin') ?></b>
                                        <?php } ?>
                                        <span>
                                            <?php echo ' - ', ProductRating::time_elapsed_string($each_comment_ans['created_time']) ?>
                                        </span>
                                    </span>
                                    <div>
                                        <?php echo $each_comment_ans['content'] ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <?php if ($count > 2) { ?>
                        <p style="" class="showmore">
                            <a href="javascript::void(0)" style="" class="show-all-cmt-total"
                               show-ans='<?php echo $each_coment['id'] ?>'>Xem thêm bình luận...</a>
                        </p>
                    <?php }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<?php
$url = Yii::app()->createUrl("/economy/commentRatingTemp/renderAnswerForm");
Yii::app()->clientScript->registerScript('prosta', ' 
$(document).on(\'click\', \'.show-all-cmt-total\', function () {
            var comment_id = $(this).attr(\'show-ans\');
            $(\'#com-\' + comment_id + \' .hidden_reply_cm\').removeClass(\'hidden_reply_cm\');
            $(this).hide();
        });
jQuery(document).on(\'click\', \'.show-rep-form\', function(){
 var comment_id = $(this).attr(\'data-id\');
        $.ajax({
            url: \'' . $url . '\',
            dataType: \'json\',
            type: \'POST\',
            data: {"comment_id": comment_id},
            beforeSend: function (xhr) {
            },
            success: function (data) {
                if (data.code === 200) {
                    $(\'.comment-box .reply-coment-\' + comment_id).html(data.html).css(\'display\', \'block\');
                    $(\'#comment-form\').trigger(\'reset\').find(\'.errorMessage\').hide();
                } else {
                    if (data.errors) {
                        parseJsonErrors(data.errors, actform);
                    }
                }
            }
        });
    })');
?>


