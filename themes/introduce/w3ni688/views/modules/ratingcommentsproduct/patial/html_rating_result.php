<div class="star-rate">
    <h5>Đánh Giá</h5>
    <p class="value-rate" itemprop="ratingValue"><?php echo($product_rating) ?></p>
    <div class="text-center">
        <div class="rating-box-comment">
            <div id="rateYo2" style=""></div>
        </div>
    </div>
    <span class="count-user-rate">(<span itemprop="reviewCount"> <?php echo $total_votes ?> </span> đánh giá)</span>
</div>
<div class="progess-rate">
    <div class="wrap-progress">
        <span class="pull-left count-star"><span></span> <i class="icon icon-t"></i></span>
        <div class="progress pull-left">
            <div class="progress-bar" style="width:<?php echo $grouprating['rating_percent'][5] ?>;">

            </div>
        </div>
        <span class="pull-left count-user-rate"><span
                class="rate-number"><?php echo '(', $grouprating['number_rating'][5], ')' ?></span>Rất hài lòng</span>
    </div>
    <div class="wrap-progress">
        <span class="pull-left count-star"><span></span> <i class="icon icon-t"></i></span>
        <div class="progress pull-left">
            <div class="progress-bar" style="width:<?php echo $grouprating['rating_percent'][4] ?>;">
            </div>
        </div>
        <span class="pull-left count-user-rate"><span
                class="rate-number"> <?php echo '(', $grouprating['number_rating'][4], ')' ?></span>Hài lòng</span>
    </div>
    <div class="wrap-progress">
        <span class="pull-left count-star"><span></span> <i class="icon icon-t"></i></span>
        <div class="progress pull-left">
            <div class="progress-bar" style="width:<?php echo $grouprating['rating_percent'][3] ?>;">
            </div>
        </div>
        <span class="pull-left count-user-rate"><span
                class="rate-number"><?php echo '(', $grouprating['number_rating'][3], ')' ?></span>Bình thường</span>
    </div>
    <div class="wrap-progress">
        <span class="pull-left count-star"><span></span> <i class="icon icon-t"></i></span>
        <div class="progress pull-left">
            <div class="progress-bar" style="width:<?php echo $grouprating['rating_percent'][2] ?>;">
            </div>
        </div>
        <span class="pull-left count-user-rate"><span
                class="rate-number"><?php echo '(', $grouprating['number_rating'][2], ')' ?></span>Dưới trung bình</span>
    </div>
    <div class="wrap-progress">
        <span class="pull-left count-star"><span></span> <i class="icon icon-t"></i></span>
        <div class="progress pull-left">
            <div class="progress-bar" style="width:<?php echo $grouprating['rating_percent'][1] ?>;">
            </div>
        </div>
        <span class="pull-left count-user-rate"><span
                class="rate-number"><?php echo '(', $grouprating['number_rating'][1], ')' ?></span>Thất vọng</span>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#rateYo2").on("rateyo.init", function () {
            console.log("rateyo.init");
        });
        $("#rateYo2").rateYo({
            rating: <?php echo $product_rating ?>,
            readOnly: true,
            numStars: 5,
            precision: 0,
            starWidth: "16px",
            spacing: "2px",
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