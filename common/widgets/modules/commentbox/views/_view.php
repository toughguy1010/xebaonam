<?php $user_profile = Users::model()->findByPk(Yii::app()->user->id); ?>
<div class="comment-box">
    <div class="" style="display: block;">
        <form action="" method="post" id='comment-form'>
            <div class="row">
                <div class="text col-sm-12" id="detail_wrapper">
                    <label for="review_detail">Viết bình luận của bạn vào bên dưới:</label>
                    <textarea style="height:80px;min-height:80px;max-height:200px;"
                              placeholder="Nhập nội dung tại đây. Tối thiểu 20 từ, tối đa 1000 từ." class="form-control"
                              name="detail" id="review_detail" cols="20" rows="3" hei=""></textarea>
                    <span class="help-block" id="detail_error"></span>
                </div>
                <div class="comment-user hide">
                    <div
                        style="padding: 15px;color: #0000FF;font-size: 11px;"><?php echo 'Để gửi bình luận bạn vui lòng nhập các thông tin bên dưới.' ?></div>
                    <div class="col-sm-6">
                        <!--<label for="review_name">* Tên:</label>-->
                        <input type="text" placeholder="Vui lòng nhập tên bạn" name="title" id="review_name"
                               class="form-control input-sm" required="required"
                               value="<?php echo ($user_profile->name) ? $user_profile->name : ''; ?>">
                        <span class="help-block" id="title_error"></span>
                    </div>
                    <div class="col-sm-6" id="detail_wrapper">
                        <!--<label for="review_email">* Email/Phone:</label>-->
                        <input type="text" placeholder="Email hoặc số điện thoại" name="title" id="review_email"
                               class="form-control input-sm" required="required"
                               value="<?php echo ($user_profile->email) ? $user_profile->email : ''; ?>"><span
                            class="help-block" id="title_error"></span>
                    </div>
                </div>
                <div class="action col-sm-12" style="text-align: right">
                    <div class="word-counter"></div>
                    <button type="button" class="btn" id="btn-post-comment">Gửi</button>
                </div>
            </div>
        </form>
    </div>
    <div class="content-block">
        <?php
        foreach ($comment as $key => $each_coment) {
            ?>
            <div class="comment_as_lv1 comment_ask" id="<?php echo 'com-', $each_coment['id'] ?>">
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
                    <div>
                        <?php echo $each_coment['content'] ?>
                    </div>
                    <div class="user-cmt-time">
                        <?php echo ProductRating::time_elapsed_string($each_coment['created_time']) ?>
                        <b class="dot">-</b>
                        <a href="javascript:void(0)" class="show-rep-form"
                           onclick="<?php echo 'commentAnswer(', $each_coment['id'], ');' ?>">Trả lời</a>
                    </div>
                </div>
                <div class="comment_reply">
                    <!--                       width: 0;
                                           height: 0;
                                           border-left: 10px solid transparent;
                                           border-right: 10px solid transparent;
                                           border-bottom: 10px solid #f1f1f1;
                                           position: relative"-->
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
                                            <span style=""><?php echo substr($each_comment_ans['name'], 0, 1); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-cmt-cont">
                                    <span class="user-cmt-name">
                                        <strong><?php echo $each_comment_ans['name'] ?></strong>
                                        <?php if ($each_comment_ans['user_type'] == 1) { ?>
                                            <b class="qtv">quản trị viên</b>
                                        <?php } ?>
                                        <span> <?php echo ' - ', ProductRating::time_elapsed_string($each_comment_ans['created_time']) ?></span>

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
    <?php if ($total_page > 1) {
        ?>
        <div class="pager">
            <ul id="yw1" class="W3NPager">
                <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                    <li class="page <?php echo ($i === 1) ? 'selected' : '' ?>">
                        <a href="javascript:void(0)"
                           onclick="getCommentPage(<?php echo (int)$i; ?>, this)"><?php echo $i ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
</div>
<script>
    //Show more comment - append page
    function getCommentPage(page, thisTag) {
        $('.loading-shoppingcart').show();
        $('.page').removeClass('selected');
        $(thisTag).parent().addClass('selected');
        jQuery.getJSON(
            '<?php echo Yii::app()->createUrl('economy/commentRating/commentPage') ?>',
            {
                page: page,
                object_id: <?php echo $object_id ?>,
                pagesize:<?php echo $limit ?>,
                comment_type:<?php echo $type ?>},
            function (data) {
                $('.loading-shoppingcart').hide();
                if (data.html) {
                    $('.content-block').html(data.html);
                    a++;
                } else {
                    $('.box-product-page').hide();
                }
            }
        );
    }
    //Add form to answer comment
    function commentAnswer(comment_id) {
        var html = ' <form action="" method="post"> ';

        html += ' <div class="text" id="detail_wrapper">'
            + '<label for="review_detail">Viết nhận xét của bạn vào bên dưới:</label>'
            + '<textarea placeholder="Nhập nội dung nhận xét tại đây. Tối thiểu 20 từ, tối đa 1000 từ." class="form-control" name="detail" id="review_detail" cols="20" rows="3" hei></textarea>'
            + '<span class="help-block" id="detail_error">'
            + '</span></div>';
        html += '<div class="row"><div class="col-sm-6">'
//                + '<label for="review_name">1. Tên:</label>'
            + '<input type="<?php echo ($user_profile->name) ? 'hidden' : 'text' ?>" value="<?php echo ($user_profile->name) ? $user_profile->name : '' ?>" placeholder="Vui lòng nhập tên của bạn" name="title" id="review_name" class="form-control input-sm" required="required">'
            + '<span class="help-block" id="title_error"></span>'
            + '</div>';
        html += '<div class="col-sm-6" id="detail_wrapper">'
//                + '<label for="review_email">2. Email:</label>'
            + '<input type="<?php echo ($user_profile->email) ? 'hidden' : 'text' ?>" value="<?php echo ($user_profile->email) ? $user_profile->email : '' ?>" placeholder="Email hoặc số điện thoại" name="title" id="review_email" class="form-control input-sm" required="required">'
            + '<span class="help-block" id="title_error"></span>'
            + '</div></div>';
        html += '<div class="action">'
            + '<div class="word-counter"></div>'
            + '<button type="button" class="btn btn-add-review " id="btn-rep-comment" name="' + comment_id + '">Gửi</button>'
            + '</div></form>';
        $('.comment-box .reply-coment-' + comment_id).html(html);
        $('.comment-box .reply-coment-' + comment_id).css('display', 'block');
    }
    $(document).ready(function () {
        // Show all comment ansert of comment
        $(document).on('click', '.show-all-cmt-total', function () {
            var comment_id = $(this).attr('show-ans');
            $('#com-' + comment_id + ' .hidden_reply_cm').removeClass('hidden_reply_cm');
            $(this).hide();
        });
        // Create comment
        $(document).on('click', '#btn-post-comment', function () {
            var review_name = $(this).parent().parent().find('#review_name').val();
            var review_email = $(this).parent().parent().find('#review_email').val();
            var review_detail = $(this).parent().parent().find('#review_detail').val();
            var type = <?php echo $type ?>;
            var object_id = <?php echo $object_id ?>;
            var form_hide = $('#comment-form .comment-user').hasClass('hide');
            if (review_detail.length < 20) {
                alert('Nội dung phải dài hơn 20 kí tự.');
                return;
            }
            if (review_name == '' && review_email == '' && form_hide == true) {
                $('#comment-form .comment-user').removeClass('hide');
                return;
            }
            if ((review_name == '') || (review_email == '') || (review_detail == '') || (object_id === null)) {
                alert('Bạn vui lòng nhập đầy đủ thông tin.');
            }
            else {
                $('.loading-shoppingcart').show();
                $.ajax({
                    url: '<?php echo Yii::app()->createUrl('economy/commentRating/ajaxCommentCreate'); ?>',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        "type": type,
                        "review_name": review_name,
                        "review_email": review_email,
                        "review_detail": review_detail,
                        "object_id": object_id
                    },
                    beforeSend: function (xhr) {
                    },
                    success: function (data) {
                        $('.loading-shoppingcart').hide();
                        $('.content-block').prepend(data.html);
                        $('#review_detail').val('');
                        <?php if(!$user_profile){?>
                        $('#review_name').val('');
                        $('#review_email').val('');
                        <?php }?>
                    }
                });
            }
        });
        //Rep comment
        $(document).on('click', '#btn-rep-comment', function () {
            var review_detail = $(this).parent().parent().find('#review_detail').val();
            var review_name = $(this).parent().parent().find('#review_name').val();
            var review_email = $(this).parent().parent().find('#review_email').val();
            var comment_id = $(this).attr('name');
            if ((review_detail == '') || (review_name == '') || (review_email == '') || (review_detail === null) || (comment_id === null)) {
                alert('Bạn vui lòng nhập đầy đủ thông tin.');
            } else if (review_detail.length < 20) {
                alert('Nội dung phải dài hơn 20 kí tự.');
            }
            else {
                $('.loading-shoppingcart').show();
                $.ajax({
                    url: '<?php echo Yii::app()->createUrl('economy/commentRating/ajaxCommentAnswer'); ?>',
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
                        $('.loading-shoppingcart').hide();
                        $('.content-block .comment_reply .reply-coment-' + comment_id).html('');
                        $('.content-block .comment_reply .reply-coment-' + comment_id).after(data.html);
                    }
                });
            }
        });
    });
</script>