<p><h2 style="display: inline;padding-right:10px">Đánh giá về sản phẩm</h2><span> | </span>
<button class="btn btn-default btn-tg-rating" style="overflow: hidden;
width: auto;
border-left: solid 1px #ddd;
vertical-align: middle;
box-sizing: border-box;font-weight: bold">Viết đánh giá
</button></p>
<script>
    $(document).ready(function(){
        $(".btn-tg-rating").click(function(){
            $(".product-customer-rating").toggle();
        });
    });
</script>
<div class="product-customer-rating js-customer-col-4 " style="display: none;">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'request-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array('class' => 'form-horizontal'),
        'action' => Yii::app()->createUrl($action, array('id' => $product_id))
    ));
    ?>
    <div class="rate" id="rating_wrapper">
        <label>1. Đánh giá của bạn về sản phẩm này:</label>
        <div id="rateYo1" style=""></div>
        <input type="hidden" class="rating-input" id="ProductRating_rating" name="ProductRating[rating]"
               value="">
    </div>
    <?php if (Yii::app()->user->isGuest) { ?>
        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->labelEx($model, 'name', array('class' => '')); ?>
                <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'required' => 'required')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
            <div class="col-sm-6" id="detail_wrapper">
                <?php echo $form->labelEx($model, 'email', array('class' => '')); ?>
                <?php echo $form->textField($model, 'email', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>
    <?php } ?>
    <div class="title" id="title_wrapper">
        <?php echo $form->labelEx($model, 'tittle', array('class' => '')); ?>
        <?php echo $form->textField($model, 'tittle', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'tittle'); ?>
    </div>
    <div class="text" id="detail_wrapper">
        <?php echo $form->labelEx($model, 'comment', array('class' => '')); ?>
        <?php echo $form->textArea($model, 'comment', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'comment'); ?>
    </div>
    <button type="button" value="Gửi" id="rating-prd-submit" class="btn btn-default">Gửi</button>
    <!--    --><?php //echo CHtml::button('Gửi', array('class' => 'btn btn-default', 'type' => 'submit', 'disable' => 'disable')); ?>
    <?php $this->endWidget(); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#rating-prd-submit').click(function () {
                data = $('.product-customer-rating').find('input,textarea,textarea').serialize();
                $.ajax({
                    url: '<?php echo Yii::app()->createUrl($action); ?>',
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        if(data.code = 200){
                            alert(data.msg);
                            $('.product-customer-rating').find('input,textarea,textarea').val('');
                        }else{
                            alert(data.msg);
                        }
                    }
                });
            });
        });
    </script>
</div>
<script>
    $(document).ready(function () {
        $("#rateYo1").on("rateyo.init", function () {
            console.log("rateyo.init");
        });
        $("#rateYo1").rateYo({
            rating: 0,
            readOnly: false,
            numStars: 5,
            precision: 0,
            starWidth: "24px",
            spacing: "5px",
            fullStar: true,
            multiColor: {
                startColor: "#ff0000",
                endColor: "#ff0000"
            },
            onInit: function () {
            },
            onSet: function (rating, rateYoInstance) {
                $('#ProductRating_rating').val(rating);
            }
        }).on("rateyo.set", function () {

        }).on("rateyo.change", function () {

        });

    });
</script>
<style>
    #rateYo1 {
        margin-left: 280px
    }

    #rating_wrapper label {
        float: left;
        line-height: 24px
    }
</style>