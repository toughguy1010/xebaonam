<div class="review-detail-product">
    <div class="title-review-detail">
        <h2>Đánh Giá</h2>
    </div>
    <div class="filter-review-detail">
        <h3>Bình Luận <span>(<?php echo $total_votes ?> bình luận)</span></h3>
        <!--        <div class="filter-review">-->
        <!--            <span>Sắp xếp bình luận:</span>-->
        <!--            <select name="sortBy">-->
        <!--                <option selected="" value="default">Mặc định</option>-->
        <!--                <option value="alpha-asc">A → Z</option>-->
        <!--                <option value="alpha-desc">Z → A</option>-->
        <!--                <option value="price-asc">Giá tăng dần</option>-->
        <!--                <option value="price-desc">Giá giảm dần</option>-->
        <!--                <option value="created-desc">Hàng mới nhất</option>-->
        <!--                <option value="created-asc">Hàng cũ nhất</option>-->
        <!--            </select>-->
        <!--        </div>-->
        <div class="btn-comment-review">
            <a class="open-popup-link" href="#review-product-popup">VIẾT BÌNH LUẬN</a>
        </div>
    </div>
    <?php if (count($comment)) { ?>
        <div class="list-comment-review">
            <?php
            foreach ($comment as $key => $each_coment) {
                ?>
                <div class="item-comment-review" id="<?php echo 'rat-', $each_coment['id'] ?>">
                    <div class="header-item-comment">
                        <span class="review-star-user">5<img src="/themes/introduce/w3ni477/images/Star.png"></span>
                        <h3><?php echo $each_coment['name']; ?></h3>
                        <span class="time-comment"><?php echo date('d/m/Y', $each_coment['created_time']) ?></span>
                    </div>
                    <div class="ctn-item-comment">
                        <h4><?php echo $each_coment['tittle'] ?></h4>
                        <p>
                            <?php echo $each_coment['comment'] ?>
                        </p>
                        <a href="javascript:void(0)"><img src="/themes/introduce/w3ni477/images/like.png">
                            Thích<span>0</span></a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div id="view_more" style="float:right; max-width: 500px; text-align: right; ">
            <ul id="yw0" class="">
                <a href="javascript:void(0)" onclick="getRatingPage(<?php echo $i = 2; ?>, this)"
                   title="Xem thêm"><?php echo 'Xem thêm' ?></a>
            </ul>
        </div>
        <?php
    }
    ?>
</div>

<script>
    var a = 0;
    function getRatingPage(page, thisTag) {
        $(thisTag).parent().addClass('active');
        jQuery.getJSON(
            '<?php echo Yii::app()->createUrl('economy/commentRating/getRatingPage') ?>',
            {page: page + a, object_id: <?php echo $object_id ?>, pagesize:<?php echo $limit ?>},
            function (data) {
                if (data.html) {
                    $('.list-comment-review').append(data.html);
                    a++;
                } else {
                    $('#view_more').hide();
                }
            }
        );
    }
</script>
