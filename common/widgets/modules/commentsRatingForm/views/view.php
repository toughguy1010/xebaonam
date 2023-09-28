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
<div class="row">
    <div class="col-xs-6">
        <div class="item-form-group">
            <div class="input-form-group">
                <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'required' => 'required', 'placeholder' => 'Biệt danh*')); ?>
                <?php echo $form->hiddenField($model, 'type', array('class' => 'form-control', 'required' => 'required')); ?>
                <?php echo $form->error($model, 'name'); ?>
                <?php echo $form->hiddenField($model, 'email', array('class' => 'form-control', 'value' => 'guest@nanoweb.vn')); ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <div class="item-form-group">
            <div class="input-form-group">
                <?php echo $form->textField($model, 'tittle', array('class' => 'form-control', 'placeholder' => 'Tiêu đề bình luận*')); ?>
                <?php echo $form->error($model, 'tittle'); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-6" style="display:flex;">
        <span class="avaiable">Đánh Giá:</span>
        <div id="rateYo1" style=""></div>
        <input type="hidden" class="rating-input" id="CommentRating_rating" name="CommentRating[rating]"
               value="">
        <!--        <span>Tốt <img src="-->
        <?php //echo Yii::app()->theme->baseUrl ?><!--/images/icon-check-o.png"></span>-->
    </div>
</div>
<div class="text" id="detail_wrapper">
    <?php echo $form->textArea($model, 'comment', array('class' => 'form-control', 'placeholder' => 'Nội dung bình luận của bạn*')); ?>
    <?php echo $form->error($model, 'comment'); ?>
</div>
<div class="map-popup-inshop">
    <div class="item-checker-tool">
        <div class="squaredFour">
            <input type="checkbox" id="ticket2" name="check">
            <label for="ticket2"></label>
        </div>
        <div class="title-item-checker"><p>Tôi đồng ý với điều
                    khoản sử dụng của Website</p></div>
    </div>
    <div class="btn-comment-review">
        <button type="button" value="Gửi" id="rating-prd-submit" class="">GỬI BÌNH LUẬN</button>
    </div>
</div>
<!--    --><?php //echo CHtml::button('Gửi', array('class' => 'btn btn-default', 'type' => 'submit', 'disable' => 'disable')); ?>
<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerScript('comemnt_rating', "
 $(document).ready(function () {
        $('#rating-prd-submit').click(function () {
            data = $('.form-popup-inshop').find('input,textarea,textarea').serialize();
            var agree = $('#ticket2').is(':checked');
            if (!agree) {
                alert('Bạn cần đồng ý với điều khoản sử dụng.');
                return false;
            }
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
",CClientScript::POS_END);
Yii::app()->clientScript->registerCss('comments_rating', '
    #rateYo1 {
        margin-top: 7px;
    }

    #rating-prd-submit {
        padding: 11px 27px 8px 27px;
        background: #333;
        display: inline-block;
        font-family: \'lato black\';
        color: #ffcd08;
        margin-right: 0px;
        font-size: 13px;
        white-space: nowrap;
        margin-right: 25px;
        border: 1px solid #333333;
    }

    #rating_wrapper label {
        float: left;
        line-height: 20px
    }');
?>


