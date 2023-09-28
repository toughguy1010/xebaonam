<div class="category-info-box">
    <?php
    $first = ClaArray::getFirst($campaigns);
    $campaigns = ClaArray::removeFirstElement($campaigns);
    ?>
    <?php if ($show_widget_title) { ?>
        <p class="category-top-heading"><?= $widget_title ?></p>
    <?php } ?>
    <div class="category-image-box">
        <a href="<?php echo $first['link']; ?>">
            <img class="imglazyload img-responsive" 
                 src="<?php echo ClaUrl::getLazyloadDefaultImage(400, 0); ?>" 
                 data-original="<?php echo ClaUrl::getImageUrl($first['avatar_path'], $first['avatar_name'], array('width' => 400, 'height' => 0)); ?>"
                 alt="<?php echo $first['question_title']; ?>" />
        </a>
    </div>
    <div>
        <div class="faq-icon">
            <img src="<?= Yii::app()->theme->baseUrl ?>/images/question.svg" />
        </div>
        <div class="question">
            <a class="title-question" href="<?php echo $first['link']; ?>"><?php echo $first['name']; ?></a>
        </div>
    </div>
    <ul class="faq">
        <?php
        foreach ($campaigns as $key => $value) {
            ?>
            <li>
                <div class="faq-icon">
                    <img src="<?= Yii::app()->theme->baseUrl ?>/images/question.svg" />
                </div>
                <div class="question">
                    <a class="title-question" href="<?= $value['link'] ?>"><?php echo $value['name']; ?></a>
                </div>
            </li>
            <?php
        }
        ?>

    </ul>
    <div class="center">
        <a href="<?= Yii::app()->createUrl('/service/questionCampaign/') ?>" class="btn btn-primary">Xem tất cả</a>
    </div>
</div>