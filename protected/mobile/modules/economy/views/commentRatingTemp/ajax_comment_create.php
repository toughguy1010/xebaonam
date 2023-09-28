<div class = "comment_as_lv1 comment_ask" id = "<?php echo 'rat-', $comment['id'] ?>">
    <div class = "user-cmt">
        <div class="user-cmt-avat">
            <div class="avatar-name-fword" style="">
                <span style=""><?php echo mb_substr($comment['name'],0,1, "utf-8"); ?></span>
               
            </div>
        </div>
    </div>
    <div class="user-cmt-cont" style="margin-bottom: 10px">
        <span class = "user-cmt-name">
            <strong><?php echo $comment['name'] ?></strong>
        </span>
        <div>
            <?php echo $comment['content'] ?>
        </div>
        <div class = "user-cmt-time">
            <?php echo ProductRating::time_elapsed_string($comment['created_time']) ?>
            <b class = "dot">-</b>
            <a href = "javascript:void(0)" class = "show-rep-form" onclick="<?php echo 'conmentAnswer(', $comment['id'], ');' ?>">Trả lời</a>
        </div>
    </div>
    <div class="comment_reply">
        <div class="reply-coment <?php echo ' reply-coment-', $comment['id'] ?>" style="" >
        </div>
    </div>
</div>