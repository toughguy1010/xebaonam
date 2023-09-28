<?php if (count($comment)) { ?>
    <div class="box-cmt-dgsp">
        <div class="box-dgsp">
            <div class="danhgia">
                <?php
                $this->render('patial/html_rating_result', array(
                    'product_rating' => $product_rating,
                    'total_votes' => $total_votes,
                    'grouprating' => $grouprating
                ));
                ?>
            </div>
        </div>
        <div class="box-cmt">
            <div class="review-block">
                <!--<div class="infocomment">-->
                <?php
                foreach ($comment as $key => $each_coment) {
                    ?>
                    <div class="comment_as_lv1 comment_ask" id="<?php echo 'rat-', $each_coment['id'] ?>">
                        <div class="user-cmt">
                            <div class="user-cmt-avat">
                                <div class="avatar-name-fword" style="">
                                    <span style=""><?php echo substr($each_coment['name'], 0, 1); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="user-cmt-cont" style="margin-bottom: 10px">
                            <span class="user-cmt-name">
                                <strong><?php echo $each_coment['name'] ?></strong>
                            </span>
                            <label class="sttB" style="">(Đã mua sản phẩm)</label>
                            <style>
                                .sttB {
                                    cursor: pointer;
                                    color: #2ba832;
                                    font-size: 13px;
                                }

                                .iconcom-checkbuy {
                                    /*background-image: url(themes/introduce/w3ni350/css/img/Tick_Mark_Circle.png&quot;);*/
                                    /* background-size: 270px 128px; */
                                    background-repeat: no-repeat;
                                    display: inline-block;
                                    height: 20px;
                                    width: 20px;
                                    line-height: 30px;
                                    vertical-align: middle;
                                }
                            </style>
                            <span class="icon-star" style="color: gold;font-size: 18px;line-height: 18px">
                                <?php for ($i = 0; $i < $each_coment['rating']; $i++) {
                                    echo '☆';
                                } ?>
                            </span>
                            <p class="user-cmt-title" style="color: #2196F3;">
                                <?php echo $each_coment['tittle'] ?>
                            </p>
                            <div>
                                <?php echo $each_coment['comment'] ?>
                            </div>
                            <div class="user-cmt-time">
                                <?php echo ProductRating::time_elapsed_string($each_coment['created_time']) ?>
                                <!--                                <b class="dot">-</b>-->
                                <!--                                <a href="javascript:void(0)" class="show-rep-form"-->
                                <!--                                   onclick="-->
                                <?php //echo 'commentRatingAnswer(', $each_coment['id'], ');' ?><!--">Trả lời</a>-->
                            </div>
                        </div>
                        <div class="comment_reply">
                            <div class="reply-coment <?php echo ' reply-coment-', $each_coment['id'] ?>" style="">
                            </div>
                            <?php
                            $count = count($each_coment['rating_answers']);
                            if ($count) {
                                $n = 0;
                                foreach ($each_coment['rating_answers'] as $each_comment_ans) {
                                    ?>
                                    <div class="comment_ask <?php echo ($n++ >= 2) ? 'hidden_reply_cm' : '' ?>"
                                         id="<?php echo 'ans-', $each_comment_ans['id']; ?>">
                                        <div class="user-cmt">
                                            <div class="avatar-name-fword" style="">
                                                <span
                                                        style=""><?php echo substr($each_comment_ans['name'], 0, 1); ?></span>
                                            </div>
                                        </div>
                                        <div class="user-cmt-cont">
                                            <span class="user-cmt-name">
                                                <strong><?php echo $each_comment_ans['name'] ?></strong>
                                                <span> <?php echo ' - ', ProductRating::time_elapsed_string($each_comment_ans['created_time']) ?></span>
                                                <!--<b class="qtv">quản trị viên</b>-->
                                            </span>
                                            <div>
                                                <?php echo $each_comment_ans['content'] ?>
                                            </div>
                                        </div>
                                        <div class="user-cmt-time" style="">
                                            <!--<a href="javascript:void(0)" class="show-rep-form" rep-for="rep10902511">Trả lời</a>-->

                                        </div>
                                    </div>

                                    <?php
                                }
                            }
                            ?>
                            <?php if ($count > 2) { ?>
                                <p style="" class="showmore">
                                    <a href="javascript::void(0)" style="" class="view-all-cmt-total"
                                       show-ans='<?php echo $each_coment['id'] ?>'>Xem thêm bình luận...</a>
                                </p>
                            <?php }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <!--</div>-->
            </div>
        </div>
        <div class="box-product-page clearfix">
            <div class="product-page" style="float:right; max-width: 500px; text-align: right; ">
                <ul id="yw0" class="W3NPager">
                    <?php
                    //                for ($i = 1; $i <= $total_page; $i++) {
                    ?>
                    <!--<li class="page <?php // echo $i == 1 ? 'active' : ''                      ?>">-->
                    <a href="javascript:void(0)" onclick="getRatingPage(<?php echo $i = 2; ?>, this)"
                       title="Xem thêm"><?php echo 'Xem thêm' ?></a>
                    <!--</li>-->
                    <?php
                    //                }
                    ?>
                </ul>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $('.show-rep-form').on('click', function () {
                    var comment = $(this).attr('rep-for');
                    $('#' + comment).show();
                })
            })
        </script>
        <script type="text/javascript">
            function commentRatingAnswer(comment_id) {
                var html = ' <form action="" method="post"> <div class="row">';
                html += '<div class="col-sm-6">'
                    + '<label for="review_name">1. Tên:</label>'
                    + '<input type="text" placeholder="Nhập tiêu đề nhận xét" name="title" id="review_name" class="form-control input-sm" required="required">'
                    + '<span class="help-block" id="title_error">'
                    + '</span></div>';
                html += '<div class="col-sm-6" id="detail_wrapper">'
                    + '<label for="review_email">2. Email:</label>'
                    + '<input type="text" placeholder="Nhập tiêu đề nhận xét" name="title" id="review_email" class="form-control input-sm" required="required">'
                    + '<span class="help-block" id="title_error">'
                    + '</span></div></div>';
                html += ' <div class="text" id="detail_wrapper">'
                    + '<label for="review_detail">3. Viết nhận xét của bạn vào bên dưới:</label>'
                    + '<textarea placeholder="Nhập nội dung nhận xét tại đây. Tối thiểu 20 từ, tối đa 1000 từ." class="form-control" name="detail" id="review_detail" cols="20" rows="3" hei></textarea>'
                    + '<span class="help-block" id="detail_error">'
                    + '</span></div>';
                html += '<div class="action">'
                    + '<div class="word-counter"></div>'
                    + '<button type="button" class="btn btn-add-review " id="btn-send-comment" name="' + comment_id + '">Gửi</button>'
                    + '</div></form>';
                $('.reply-coment-' + comment_id).html(html);
                $('.reply-coment-' + comment_id).css('display', 'block');
            }
            var a = 0;
            function getRatingPage(page, thisTag) {
                $('.page').removeClass('active');
                $(thisTag).parent().addClass('active');
                jQuery.getJSON(
                    '<?php echo Yii::app()->createUrl('economy/commentRating/getRatingPage') ?>',
                    {page: page + a, object_id: <?php echo $object_id ?>, pagesize:<?php echo $limit ?>},
                    function (data) {
                        if (data.html) {
                            $('.review-block').append(data.html);
                            a++;
                        } else {
                            //                    $(this).hide();
                        }
                    }
                );
            }

            $(document).ready(function () {
                $(document).on('click', '.view-all-cmt-total', function () {
                    var comment_id = $(this).attr('show-ans');
                    $('#rat-' + comment_id + ' .hidden_reply_cm').removeClass('hidden_reply_cm');
                    $(this).hide();
                });

                $(document).on('click', '#btn-send-comment', function () {
                        var review_detail = $(this).parent().parent().find('#review_detail').val();
                        var review_name = $(this).parent().parent().find('#review_name').val();
                        var review_email = $(this).parent().parent().find('#review_email').val();
                        var comment_id = $(this).attr('name');
                        if ((review_detail == '') || (review_name == '') || (review_email == '') || (review_detail === null) || (comment_id === null)) {
                            alert('Bạn vui lòng nhập đầy đủ thông tin.');
                        } else {
                            $.ajax({
                                url: '<?php echo Yii::app()->createUrl('economy/commentrating/ajaxratinganswer'); ?>',
                                type: 'GET',
                                dataType: 'json',
                                data: {
                                    "review_detail": review_detail,
                                    "review_name": review_name,
                                    "review_email": review_email,
                                    "comment_id": comment_id
                                },
                                beforeSend: function (xhr) {
                                },
                                success: function (data) {
                                    $('.comment_reply .reply-coment-' + comment_id).html('');
                                    $('.comment_reply .reply-coment-' + comment_id).after(data.html);
                                }
                            });
                        }
                    }
                );
            });

        </script>
    </div>
    <?php
} ?>
<div class="review-detail-product">
    <div class="title-review-detail">
        <h2>Đánh Giá</h2>
    </div>
    <div class="filter-review-detail">
        <h3>Bình Luận <span>(10 bình luận)</span></h3>
        <!--                                    <div class="filter-review">-->
        <!--                                        <span>Sắp xếp bình luận:</span>-->
        <!--                                        <select name="sortBy">-->
        <!--                                            <option selected="" value="default">Mặc định</option>-->
        <!--                                            <option value="alpha-asc">A → Z</option>-->
        <!--                                            <option value="alpha-desc">Z → A</option>-->
        <!--                                            <option value="price-asc">Giá tăng dần</option>-->
        <!--                                            <option value="price-desc">Giá giảm dần</option>-->
        <!--                                            <option value="created-desc">Hàng mới nhất</option>-->
        <!--                                            <option value="created-asc">Hàng cũ nhất</option>-->
        <!--                                        </select>-->
        <!--                                    </div>-->
        <div class="btn-comment-review">
            <a class="open-popup-link" href="#review-product-popup">VIẾT BÌNH LUẬN</a>
        </div>
    </div>
    <div class="list-comment-review">
        <div class="item-comment-review">
            <div class="header-item-comment">
                <span class="review-star-user">5<img src="/themes/introduce/w3ni477/images/Star.png"></span>
                <h3>Nick Name 1</h3>
                <span class="time-comment">10/8/2016</span>
            </div>
            <div class="ctn-item-comment">
                <h4>Tiêu Đề Bình Luận</h4>
                <p>

                    Maecenas nec sapien turpis. Nunc luctus, mauris ac tincidunt fermentum,
                    dolor risus fermentum dui, non molestie ante nisi volutpat metus.
                    Praesent
                    aliquam leo vel nunc pharetra, ut fermentum nulla accumsan. Proin
                    sollicitudin tortor placerat nisi efficitur consectetur sit amet vitae
                    ipsum. Phasellus viverra aliquam ipsum, et tempor augue ultricies
                    dignissim.
                    In ornare nisi at ipsum viverra vehicula. Etiam nec facilisis erat, at
                    luctus odio. Sed non dolor dictum, malesuada libero sed, sodales justo.
                    Aenean egestas lacinia leo, quis aliquet nibh condimentum quis.
                </p>
                <a href=""><img src="/themes/introduce/w3ni477/images/like.png">
                    Thích<span>10</span></a>
            </div>
        </div>
        <div class="item-comment-review">
            <div class="header-item-comment">
                <span class="review-star-user">5<img src="/themes/introduce/w3ni477/images/Star.png"></span>
                <h3>Nick Name 1</h3>
                <span class="time-comment">10/8/2016</span>
            </div>
            <div class="ctn-item-comment">
                <h4>Tiêu Đề Bình Luận</h4>
                <p>

                    Maecenas nec sapien turpis. Nunc luctus, mauris ac tincidunt fermentum,
                    dolor risus fermentum dui, non molestie ante nisi volutpat metus.
                    Praesent
                    aliquam leo vel nunc pharetra, ut fermentum nulla accumsan. Proin
                    sollicitudin tortor placerat nisi efficitur consectetur sit amet vitae
                    ipsum. Phasellus viverra aliquam ipsum, et tempor augue ultricies
                    dignissim.
                    In ornare nisi at ipsum viverra vehicula. Etiam nec facilisis erat, at
                    luctus odio. Sed non dolor dictum, malesuada libero sed, sodales justo.
                    Aenean egestas lacinia leo, quis aliquet nibh condimentum quis.
                </p>
                <a href=""><img src="/themes/introduce/w3ni477/images/like.png">
                    Thích<span>10</span></a>
            </div>
        </div>
    </div>
</div>
