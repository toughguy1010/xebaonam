
<div class="colcenterask">
    <div class="top-colcenterask">
        <h1 class="name-chct"><?php echo ($question['question_title'] != '') ? $question['question_title'] : '' ?></h1>
        <a class="user-acc" href="#" title="#"><?php echo $question['name'] ?></a>
        <p class="reply-ch"> <span class="time-reply"><?php echo date('d/m/Y H:i', $question['created_time']) ?></span></p>
    </div>
    <div class="cont">
        <div class="divContent">
            <p>  <?php echo $question['question_content']; ?></p>
            <?php
            echo $question['question_answer'];
            ?>
        </div>

    </div>
    <?php
    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
    ?>
</div>