<?php if (count($questions)) {
    ?>
    <div class="ch-lq">
        <?php if ($show_widget_title) { ?>
            <h3 class="title-chlq"><?php echo $widget_title; ?></h3>
        <?php } ?>
        <div class="cont-chlq">
            <ul>
                <?php foreach ($questions as $question) { ?>
                    <li>
                        <a href="<?php echo $question['link'] ?>" title="<?php echo ($question['question_title'] != '') ? $question['question_title'] : $question['question_content'] ?>">
                            <?php echo ($question['question_title'] != '') ? $question['question_title'] : $question['question_content'] ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>