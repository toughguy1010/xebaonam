<div class="form-report">
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
    <table>
        <tbody>
            <tr>
                <td colspan="2">
                    <?php echo $form->textArea($model, 'comment', array('class' => 'inputText rating-content', 'placeholder' => 'Mời bạn đánh giá, vui lòng nhập chữ có dấu', 'style' => 'height:80px;')); ?>
                    <?php echo $form->error($model, 'comment'); ?>
                </td>
            </tr>
            <tr class="rowr none">
                <td><label>Đánh giá:</label></td>
                <td>
                    <div class="dangia" style="display:flex;">
                        <div id="rateYo2" style=""></div>
                        <input type="hidden" class="rating-input" id="CommentRating_rating" name="CommentRating[rating]"
                        value="">
                    </div>
                </td>
            </tr>
            <tr class="rowr none">
                <td><label>Tên bạn</label></td>
                <td>
                    <?php echo $form->textField($model, 'name', array('class' => 'inputText', 'required' => 'required')); ?>
                    <?php echo $form->error($model, 'name'); ?>
                </td>
            </tr>
            <tr class="rowr none">
                <td><label>Email</label></td>
                <td>
                    <?php echo $form->textField($model, 'email', array('class' => 'inputText', 'required' => 'required')); ?>
                    <?php echo $form->error($model, 'email'); ?>
                    <?php echo $form->hiddenField($model, 'tittle', array('class' => 'inputText', 'value' => 'Khách hàng đánh giá')); ?>
                    <?php echo $form->hiddenField($model, 'type', array('class' => 'form-control', 'required' => 'required')); ?>
                </td>
            </tr>
            <tr class="rowr none">
                <td></td>
                <td><a id="rating-prd-submit" href="javascript:void(0);" class="btn btn-red">Gửi đánh giá</a></td>
            </tr>
        </tbody>
    </table>
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

                $(\"#rateYo2\").on(\"rateyo.init\", function () {
                    console.log(\"rateyo.init\");
                    });
                    $(\"#rateYo2\").rateYo({
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
                                        ",CClientScript::POS_END);
Yii::app()->clientScript->registerCss('comments_rating', '

    #rating_wrapper label {
    float: left;
    line-height: 20px
}');
?>


