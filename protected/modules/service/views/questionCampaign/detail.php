<style type="text/css">
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    .alert-info {
        color: #31708f;
        background-color: #d9edf7;
        border-color: #bce8f1;
    }
</style>
<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="alert alert-info">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
<div class="left-content col-lg-8 col-md-8 col-sm-12 col-xs-12">
    <div class="heading-title">
        <h1 class="title-on-page"><?= $model['name'] ?></h1>
    </div>

    <div class="text-note-padding mar-bot-10">
        <div class="left">
            <p class="note-text inline-block">
                <i class="fa fa-clock-o"></i><?= date('d/m/Y H:i', $model['created_time']) ?>
            </p>
        </div>
    </div>
    <div class="desc-faq-in-detail">
        <p><span style="font-weight: 500"><?= nl2br($model['description']) ?></span></p>
        <p>&nbsp;</p>
        <p>Mời bạn đọc theo dõi tư vấn trực tuyến cùng chuyên gia.</p>
    </div>
    <div class="list-detail-faq">
        <h2>Nội dung câu hỏi giao lưu:</h2>
        <?php if (isset($questionAnswer) && $questionAnswer) { ?>
            <ul>
                <?php
                foreach ($questionAnswer as $item) {
                    ?>
                    <li>
                        <div class="ask">
                            <div class="name-asker">
                                <p><?= $item['username'] ?></p>
                            </div>
                            <div class="question-asker">
                                <p>
                                    <?= nl2br($item['content']) ?>
                                </p>
                            </div>
                        </div>
                        <div class="answer">
                            <div class="doctor-avatar">
                                <a>
                                    <img src="<?= ClaHost::getImageHost(), $item['avatar_path'], 's80_80/', $item['avatar_name'] ?>" class="img-responsive" alt="Image">
                                </a>
                            </div>
                            <div class="doctor-answer">
                                <div class="doctor-name1">
                                    <p><?= $item['name'] ?> :</p>
                                </div>
                                <div class="detail-answer">
                                    <p><?= $item['answer'] ?></p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
        <?php } ?>
    </div>
    <?php if (isset($guests) && $guests) { ?>
        <div class="list-guest">
            <h2>Khách mời tham dự</h2>
            <div class="row-10 multi-columns-row">
                <?php foreach ($guests as $guest) { ?>
                    <div class="item-guest col-lg-6 col-md-6">
                        <div class="cover-item-guest">
                            <div class="avatar-guest thumb90">
                                <a href="javascript:void(0)">
                                    <img src="<?= ClaHost::getImageHost(), $guest['avatar_path'], 's100_100/', $guest['avatar_name'] ?>" class="img-responsive" alt="<?= $guest['name'] ?>" />
                                </a>
                            </div>
                            <div class="caption-guest">
                                <a href="javascript:void(0)" class="name-guest"><?= $guest['name'] ?></a>
                                <p><?= $guest['position'] ?></p>
                                <a href="javascript:void(0)" class="send-question">Đặt câu hỏi</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <div class="ask-question-form">
        <h2>Đặt câu hỏi</h2>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'w3n-submit-form',
            'action' => '',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
                'role' => 'form'
            ),
        ));
        ?>
        <div class="row-10">
            <div class="form-group">
                <?= $form->textField($question, 'username', array('placeholder' => 'Họ tên')); ?>
                <?= $form->error($question, 'username'); ?>
            </div>
            <div class="form-group">
                <?= $form->textField($question, 'email', array('placeholder' => 'Email')); ?>
                <?= $form->error($question, 'email'); ?>
            </div>
        </div>
        <div class="form-group">
            <?= $form->textArea($question, 'content', array('placeholder' => 'Nội dung câu hỏi', 'row' => '5')); ?>
            <?= $form->error($question, 'content'); ?>
        </div>
        <div class="form-group">
            <button class='send_requirement' type="submit">Gửi câu hỏi</button>
        </div>
        <?php
        $this->endWidget();
        ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.send-question').click(function () {
            var guest_name = $(this).closest('.caption-guest').find('.name-guest').text();
            var text_question = '@ ' + guest_name + ': ';
            $('#Question_content').val(text_question);
        });

        $('.send_requirement').click(function () {
            var username = $('#Question_username').val();
            var email = $('#Question_email').val();
            var content = $('#Question_content').val();
            //
            if (username == '') {
                alert('Bạn chưa nhập tên');
                $('#Question_username').focus();
                return false;
            } else if (email == '') {
                alert('Bạn chưa nhập email');
                $('#Question_email').focus();
                return false;
            } else if (content == '') {
                alert('Bạn chưa nhập nội dung câu hỏi');
                $('#Question_content').focus();
                return false;
            }
            //
            return true;
        });
    });
</script>