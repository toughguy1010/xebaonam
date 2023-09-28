<div class="comment_ask" id="<?php echo 'ans-', $comment['id']; ?>">
    <div class="user-cmt">
        <div class="user-cmt-avat">
            <div class="avatar-name-fword" style="">
                <span style=""><?php echo mb_substr($comment['name'],0,1, "utf-8"); ?></span>
            </div>
        </div>
    </div>
    <div class="user-cmt-cont">
        <span class="user-cmt-name">
            <strong><?php echo $comment['name'] ?></strong>
            <span> <?php echo ' - ', ProductRating::time_elapsed_string($comment['created_time']) ?></span>
            <!--<b class="qtv">quản trị viên</b>-->
        </span>
        <div>
            <?php echo $comment['content'] ?>
        </div>
    </div>
    <!--<div class="user-cmt-time" style="">-->
    <!--<a href="javascript:void(0)" class="show-rep-form" rep-for="rep10902511">Trả lời</a>-->
    <!--</div>-->
</div>