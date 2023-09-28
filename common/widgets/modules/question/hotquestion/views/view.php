<?php if (count($questions)) {
    ?>
    <div class="box-qtnn">
        <?php if ($show_widget_title) { ?>
            <h3 class="title-box-qtnn"><?php echo $widget_title; ?></h3>
        <?php } ?>
        <div class="cont">
            <?php foreach ($questions as $question) { ?>
                <div class="item-qtnn">
                    <h4 class="title-qtnn">
                        <a href="<?php echo $question['link'] ?>" title="<?php echo ($question['question_title'] != '') ? $question['question_title'] : $question['question_content'] ?>">
                            <?php echo ($question['question_title'] != '') ? $question['question_title'] : $question['question_content'] ?>
                        </a>
                    </h4>
                    <p class="description-qt"><?php echo ($question['question_title'] != '') ? $question['question_title'] : '' ?></p>
                    <p class="reply-ch"><span class="user-reply">Ngày đăng</span> <span class="time-reply"><?php echo date('d/m/Y H:i:s', $question['created_time']) ?></span></p>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>