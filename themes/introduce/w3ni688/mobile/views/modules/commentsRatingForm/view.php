<div class="comment_pro">
    <h2>Khách hàng nhận xét</h2>
    <div class="dv-js-binhluan dv-js-binhluan-0">
    </div>

</div>

<div class="boxComment_danhgia">
    <?php
    $model->type = $type;
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'request-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array('class' => 'form-popup-inshop'),
        'action' => Yii::app()->createUrl($action)
    ));
    ?>
    <h3>GỬI NHẬN XÉT CỦA BẠN</h3>
    <li><span>1. Đánh giá của bạn về sản phẩm này:</span>
        <span class="js_danhgia">
            <div class="dangia">
                <div id="rateYo1" style=""></div>
                <input type="hidden" class="rating-input" id="CommentRating_rating" name="CommentRating[rating]"
                       value="">
            </div>
        </span>
    </li>
    <li>2. Tiêu đề của nhận xét (*):</li>
    <li>
        <?php echo $form->textField($model, 'name', array('class' => 'form-control js_check_null_1', 'required' => 'required')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </li>
    <div class="space_sm"></div>
    <li>3. Viết nhận xét của bạn vào bên dưới (*):</li>
    <div class="col-md row-frm">
        <?php echo $form->textArea($model, 'comment', array('class' => 'form-control js_check_null_2', 'placeholder' => 'Mời bạn đánh giá, vui lòng nhập chữ có dấu', 'style' => 'height:80px;')); ?>
        <?php echo $form->error($model, 'comment'); ?>
        <button id="rating-prd-submit" type="button" class="dangbt_btn" name="btn_dangbinhluan">Gửi đánh giá</button>
        <div class="clr"></div>
    </div>
    <?php echo $form->hiddenField($model, 'email', array('class' => 'form-control', 'required' => 'required', 'value' => 'customer@gmail.com')); ?>
    <?php echo $form->hiddenField($model, 'tittle', array('class' => 'inputText', 'value' => 'Khách hàng đánh giá')); ?>
    <?php echo $form->hiddenField($model, 'type', array('class' => 'form-control', 'required' => 'required')); ?>
    <?php $this->endWidget(); ?>

</div>

<?php
Yii::app()->clientScript->registerScript('comemnt_rating', "
   $(document).ready(function () {
    $('#rating-prd-submit').click(function () {
        data = $('.form-popup-inshop').find('input,textarea,textarea').serialize();
        var agree = $('#ticket2').is(':checked');
        $.ajax({
            url: '" . Yii::app()->createUrl($action) . "',
            dataType: 'json',
            data: data,
            success: function (data) {
                if (data.code == 200) {
                    alert(data.msg);
                    $('#request-form').get(0).reset();
                    $('#review-product-popup').magnificPopup('close');
                    } else {
                        alert(data.msg);
                    }
                }
                });
                });

                $(\"#rateYo1\").on(\"rateyo.init\", function () {
                    console.log(\"rateyo.init\");
                    });
                    $(\"#rateYo1\").rateYo({
                        rating: 0,
                        readOnly: false,
                        numStars: 5,
                        precision: 0,
                        starWidth: \"20px\",
                        spacing: \"5px\",
                        fullStar: true,
                        multiColor: {
                            startColor: \"#f5c50c\",
                            endColor: \"#f5c50c\"
                            },
                            onInit: function () {
                                },
                                onSet: function (rating, rateYoInstance) {
                                    $('#CommentRating_rating').val(rating);
                                }
                                }).on(\"rateyo.set\", function () {
                                    }).on(\"rateyo.change\", function () {
                                        });
                                        });
                                        ",CClientScript::POS_END);Yii::app()->clientScript->registerCss('comments_rating', '

    #rating_wrapper label {
    float: left;
    line-height: 20px
}');
?>
