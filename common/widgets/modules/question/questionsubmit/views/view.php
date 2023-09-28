<div class="postask">
    <?php if ($show_widget_title) { ?>
        <div class="titlepostask"><strong><?php echo $widget_title ?></strong></div>
    <?php } ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'question-form',
        'action' => Yii::app()->createUrl('economy/question/submit'),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array(
            'onsubmit' => "return false;",
            'class' => 'form-horizontal',
            'role' => 'form'
        ),
    ));
    ?>
    <div id="txtContentQS">
        <?php echo $form->textArea($model, 'question_content', array('class' => 'form-control', 'id' => 'question_content')); ?>
        <?php // echo CHtml::textArea($model->question_content, '', array('id' => 'question_content', 'class' => "form-control", 'placeholder' => Yii::t('question', 'question_content'))); ?>
    </div>
    <div class="addandsend">
        <div class="buttomch buttomch1 btn btn-default ">Gửi câu hỏi</div>
    </div>
    <div class="sendinfo sendinfo1" style="display: none">
        <strong>Gửi với tên bạn muốn:</strong>
        <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'placeholder' => 'Tên của bạn (bắt buộc)')); ?>
        <?php echo $form->textField($model, 'email_phone', array('class' => 'form-control', 'placeholder' => 'Số điện thoại')); ?>
        <!--<input name="email" type="Email" class="form-control" placeholder="Email (nhận email khi có trả lời)">-->
        <?php echo CHtml::submitButton(Yii::t('question', 'question_submit'), array('class' => 'btn  btn-primary', 'onclick' => 'send();')); ?>
    </div>
    <?php
    $this->endWidget();
    ?>
    <script>
        $(document).ready(function () {
            $(".buttomch1").click(function () {
                var content_lenth = 20;
                var qc = $('#question_content').val();
                if (qc.length > 20) {
                    $(this).parent().parent().find(".sendinfo1").slideToggle('slow');
                } else {
                    alert('Câu hỏi phải có độ dài lớn hơn ' + content_lenth + ' kí tự');
                }
            })
        });
        function send() {
            var data = $("#question-form").serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('economy/question/submit'); ?>',
                data: data,
                success: function (data) {
                    if (data.code = 200) {
//                    console.log(data);
                        location.reload();
                    }
//                    document.getElementById("#question-form").reset();
                },
                error: function (data) { // if error occured
                    alert("Error occured.please try again");
                    alert(data);
                },
                dataType: 'html'
            });
        }
    </script>
</div>

<?php if (Yii::app()->user->hasFlash('success')) { ?>
    <style>
        .popup-alert {
            position: fixed;
            left: 0px;
            right: 0px;
            bottom: 0px;
            top: 0px;
            width: 400px;
            height: 200px;
            background: #fff;
            margin: auto;
            z-index: 999999999999;
            box-shadow: 0px 3px 12px #807b7b;
            border-top: 6px solid #6e9a43;
            padding: 30px;
            text-align: center;
        }

        .ctn-popup-alert p {
            font-size: 15px;
        }

        .ctn-popup-alert p span {
            font-size: 16px;
            font-family: 'UTM Avo';
            font-weight: 600;
            text-transform: uppercase;
            color: #6e9a43;
            float: left;
            width: 100%;
            margin-top: 35px;
            margin-bottom: 12px;
        }

        .btn-close-popup {
            position: absolute;
            right: -11px;
            top: -17px;
            color: #fff;
            background: #6e9a43;
            border-radius: 50%;
            width: 25px;
            font-size: 15px;
            height: 25px;
            padding-top: 2px;
            box-shadow: -1px 1px 3px #423737;
        }
    </style>
    <div class="popup-alert">
        <div class="ctn-popup-alert">
            <p>
                <span>Bạn đã đăng kí đặt bàn thành công!</span> Vui lòng đợi chúng tôi sẽ liên lạc lại với bạn.
            </p>
            <a class="btn-close-popup">
                x
            </a>
        </div>
    </div>
    <script>
        $('document').ready(function () {
            $('.btn-close-popup').on('click', function () {
                $('.popup-alert').hide();
            })
        })
    </script>
<?php } ?>