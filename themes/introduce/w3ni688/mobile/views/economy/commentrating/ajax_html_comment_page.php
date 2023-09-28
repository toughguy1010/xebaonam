<?php
foreach ($comments as $key => $each_coment) {
    ?>
    <div class = "comment_as_lv1 comment_ask" id = "<?php echo 'com-', $each_coment['id'] ?>">
        <div class = "user-cmt">
            <div class = "user-cmt-avat">
                <div class="avatar-name-fword" style="">
                    <span style=""><?php echo substr($each_coment['name'], 0, 1); ?></span>
                </div>
            </div>
        </div>
        <div class="user-cmt-cont" style="margin-bottom: 10px">
            <span class = "user-cmt-name">
                <strong><?php echo $each_coment['name'] ?></strong>
            </span>
            <div>
                <?php echo $each_coment['content'] ?>
            </div>
            <div class = "user-cmt-time">
                <?php echo ProductRating::time_elapsed_string($each_coment['created_time']) ?>
                <b class = "dot">-</b>
                <a href = "javascript:void(0)" class = "show-rep-form" onclick="<?php echo 'commentAnswer(', $each_coment['id'], ');' ?>">Trả lời</a>
            </div>
        </div>
        <div class="comment_reply">
            <div class="reply-coment <?php echo ' reply-coment-', $each_coment['id'] ?>" style="" >
            </div>
            <?php
            $count = count($each_coment['answers']);
            if ($count) {
                $n = 0;
                foreach ($each_coment['answers'] as $each_comment_ans) {
                    ?>
                    <div class="comment_ask <?php echo ($n++ >= 2) ? 'hidden_reply_cm' : '' ?>" id="<?php echo 'ans-', $each_comment_ans['id']; ?>">
                        <div class="user-cmt">
                            <div class="user-cmt-avat">
                                <div class="avatar-name-fword" style="">
                                    <?php if (!$each_comment_ans['user_type'] == 1) { ?>
                                        <span style=""><?php echo substr($each_comment_ans['name'], 0, 1); ?></span>
                                    <?php } else { ?>
                                        <img src="<?php echo Yii::app()->theme->baseUrl ?>/css/img/suzika.png" width="100%" height="100%">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="user-cmt-cont">
                            <span class="user-cmt-name">

                                <?php if ($each_comment_ans['user_type'] == 1) { ?>
                                    <b class="qtv">Quản trị viên</b>
                                <?php } else { ?>
                                    <strong><?php echo $each_comment_ans['name'] ?></strong>
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
                    <a href="javascript::void(0)" style="" class="show-all-cmt-total" show-ans='<?php echo $each_coment['id'] ?>'>Xem thêm bình luận...</a>
                </p>
            <?php }
            ?>
        </div>
    </div>
    <?php
}
?>