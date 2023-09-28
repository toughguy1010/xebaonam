<div class="review-detail-product" style="margin-top: 0 ">
    <div class="filter-review-detail">
        <h3>
            <span>(<?php echo $total_votes ?> <?= Yii::t('product', 'comment') ?>)</span>
        </h3>
        <div class="btn-comment-review">
            <a class="open-popup-link" href="#review-product-popup"
               style="text-transform: uppercase;"><?= Yii::t('common', 'write_comment') ?></a>
        </div>
    </div>
    <?php if (count($comment)) { ?>

        <div class="list-comment-review">
            <?php
            foreach ($comment as $key => $each_coment) {
                ?>
                <div class="item-comment-review" id="<?php echo 'rat-', $each_coment['id'] ?>">
                    <div class="header-item-comment">
                        <span class="review-star-user"><?php echo $each_coment['rating']; ?><img
                                    src="/themes/introduce/w3ni477/images/Star.png"></span>
                        <p><?php echo $each_coment['name']; ?></p>
                        <span class="time-comment"><?php echo date('d/m/Y', $each_coment['created_time']) ?></span>
                    </div>
                    <div class="ctn-item-comment">
                        <b><?php echo $each_coment['tittle'] ?></b>
                        <p>
                            <?php echo $each_coment['comment'] ?>
                        </p>
                    </div>
                    <?php if (isset($each_coment['answers']) && count($each_coment['answers'])) {
                        ?>
                        <div class="reply-block">
                            <?php
                            foreach ($each_coment['answers'] as $ans) {
                                ?>
                                <div class="item-reply">
                                    <div class="header-item-comment">
                                        <h3><?= $ans['name'] ?></h3>
                                        <span class="time-comment"><?php echo date('d/m/Y', $ans['created_time']) ?></span>
                                    </div>
                                    <div class="content-reply">
                                        <p><?= $ans['content'] ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    } ?>

                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
    ?>
</div>
<script>
    var a = 0;
    function getRatingPage(page, thisTag) {
        $(thisTag).parent().addClass('active');
        jQuery.getJSON(
            '<?php echo Yii::app()->createUrl('economy/commentRating/getRatingPage') ?>',
            {page: page + a, object_id: <?php echo $object_id ?>, pagesize:<?php echo $limit ?>},
            function (data) {
                if (data.html) {
                    $('.list-comment-review').append(data.html);
                    a++;
                } else {
                    $('#view_more').hide();
                }
            }
        );
    }
</script>
<style>
    .reply-block {
        padding-left: 40px;
        width: 100%;
        float: left;
        margin-top: 25px;
    }

    .item-reply {
        width: 100%;
        float: left;
        position: relative;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        padding: 5px;
        -webkit-border-radius: 5px;;
        -moz-border-radius: 5px;;
        border-radius: 5px;
    }

    .item-reply .header-item-comment {
        margin-bottom: 10px;
    }

    .item-reply:before {
        content: '';
        position: absolute;
        top: -6px;
        left: 15px;
        width: 10px;
        height: 10px;
        border-top: 1px solid #ccc;
        border-right: 1px solid #ccc;
        transform: rotate(315deg);
        background-color: #fff;
    }
</style>