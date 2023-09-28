<div class="colcenterask">
    <div class="menu-colcenterask">
        <ul class="clearfix">
            <li class="active"><a href="<?php echo Yii::app()->createUrl('economy/question/') ?>" title="#">Mới nhất</a></li>
            <li><a href="<?php echo Yii::app()->createUrl('economy/question/', array('status' => ActiveRecord::STATUS_QUESTION_NOT_ANSWER)) ?>" title="#">Câu hỏi chưa được trả lời</a></li>
        </ul>
    </div>
    <div class="cont">
        <?php
        if (count($questions)) {
            foreach ($questions as $question) {
                ?>
                <div class="item-colcenterask">
                    <div class="clearfix">
                        <div class="img-colcenterask">
                            <a href="<?php echo $question['link'] ?>" title="<?php echo ($question['question_title'] != '') ? $question['question_title'] : $question['question_content'] ?>">
                                <img src="<?php echo ClaHost::getImageHost() . $question['image_path'] . 's200_200/' . $question['image_name']; ?>">

                            </a>
                        </div>

                        <div class="box-info">
                            <h4 class="name-ch"><a href="<?php echo $question['link'] ?>" title="<?php echo ($question['question_title'] != '') ? $question['question_title'] : $question['question_content'] ?>"><?php echo ($question['question_title'] != '') ? $question['question_title'] : $question['question_content'] ?></a></h4>
                            <p class="description-ch"><?php echo ($question['question_title'] != '') ? $question['question_content'] : '' ?></p>
                        </div>
                    </div>
                    <div class="bottom-item-colcenterask">
                        <p class="reply-ch"><span class="user-reply">Ngày đăng</span> <span class="time-reply">   <?php echo ProductRating::time_elapsed_string($question['created_time']) ?></span></p>
                    </div>

                </div>
                <?php
            }
        }
        ?>
        <div class="wpager">
            <?php
            $this->widget('common.extensions.LinkPager.LinkPager', array(
//                'itemCount' => 20,
//                'pageSize' => 8,
                'header' => '',
                'selectedPageCssClass' => 'active',
            ));
            ?>
        </div>
    <!--                                    <p class="see-more"><a href="#" title="#">Xem thêm câu hỏi</a></p>-->
    </div>
</div>