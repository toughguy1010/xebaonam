<div class="box_view_more" id="danhgia_nhatxer">
    <div class="titile_page_id">
        <ul>
            <h3>Đánh giá &amp; Nhận xét</h3>
            <div class="clr"></div>
        </ul>
    </div>
    <div class="page_more">
        <div class="danhgia_tringbinh"><span class="heading">Đánh giá trung bình</span>
            <p>
                <?php if ($total_votes) { ?>
                    Dựa trên <?php echo $total_votes ?> bài đánh giá
                <?php } else {
                    echo 'Sản phẩm chưa có lượt đánh giá nào. Rất vui khi bạn là người đầu tiên đánh giá sản phẩm này!';
                } ?>
            </p>
        </div>
        <div class="row">
            <?php
            Yii::app()->controller->renderPartial('//modules/commentsRating/patial/html_rating_result', array(
                'product_rating' => $object_rating,
                'total_votes' => $total_votes,
                'grouprating' => $grouprating
            ));
            ?>
        </div>

        <?php if (isset($comment) && $comment) { ?>

            <div class="list-comment-review">
                <?php
                foreach ($comment as $key => $each_coment) {

                    ?>
                    <div class="item-comment-review" id="<?php echo 'rat-', $each_coment['id'] ?>">
                        <div class="header-item-comment">
                            <div class="name"><?= $each_coment['name'][0] ?></div>
                            <label> <?php echo $each_coment['name']; ?> </label>
                            <?php if (isset($each_coment['user_id']) && $each_coment['user_id']) {
                                $da = ClaUser::getUserInfo($each_coment['user_id']);
                                ?>
                                <span class="adr">Đến từ: <label><?= $da['address'] ?></label></span>
                                <span class="time-comment">tham gia từ <?php echo date('m/Y', $da['created_time']) ?> </span>
                            <?php } ?>
                        </div>
                        <div class="ctn-item-comment">
                        <span class="review-star-user">Đánh giá
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                ?>
                                <i class="fa fa-star <?= ($i <= $each_coment["rating"]) ? 'active' : '' ?>"
                                   aria-hidden="true"></i>
                                <?php
                            } ?>
                            <?php if (isset($each_coment['ordered'][0]) && count($each_coment['ordered'][0])) { ?>
                                <p class="buy-already">Đã mua sản phẩm này tại Akishop</p>
                            <?php } ?>
                        </span>
                            <b><?php echo $each_coment['tittle'] ?></b>
                            <p class="cmt-rt">
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
        <?php
        //        Form đánh giá
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_COMMENT2)); ?>
    </div>
</div>
<style>
    .list-comment-review .name {
        border-radius: 50%;
        background: #d3d2d3;
        color: #919090;
        font-weight: 500;
        width: 50px;
        height: 50px;
        display: inline-block;
        text-align: center;
        line-height: 50px;
        font-size: 18px;
        font-family: Roboto;
        text-transform: uppercase;
        margin: 0 auto;
    }

    .box_view_more {
        background: #fff;
        margin-bottom: 20px;
        float: left;
        width: 100%;
        border: 1px solid #dedede;
    }

    .titile_page_id {
        background: #fff;
        border-bottom: solid #CCC 1px;
        margin-bottom: 15px;
        padding: 15px 15px 10px 15px;
        float: left;
        width: 100%;
    }

    .titile_page_id ul {
        padding: 0px;
        margin: 0;
    }

    .titile_page_id ul h1, .titile_page_id ul h3 {
        font-weight: 500;
        text-transform: uppercase;
        font-size: 22px;
        line-height: 40px;
        float: left;
        color: #333;
        margin: 0;
    }

    .clr {
        clear: both;
    }

    .page_more {
        padding: 15px;
        padding-top: 0;
    }

    .page_more .row {
        margin: 0;
        margin-bottom: 20px;
    }

    .danhgia_tringbinh {
        font-size: 20px;
    }

    .heading {
        font-size: 18px;
        font-weight: 500;
        text-transform: uppercase;
        color: #d0011b;
    }

    .danhgia_tringbinh p {
        font-size: 17px;
        padding-bottom: 10px;
        padding-top: 0;
        color: #666;
        margin: 0 !important;
    }

    .side, .middle {
        height: 18px;
        overflow: hidden;
    }

    .side {
        float: left;
        width: 8%;
        margin-top: 10px;
        font-size: 15px;
    }

    .side > div {
        line-height: 100%;
        font-size: 14px;
        font-weight: 600;
        color: #333333eb;
    }

    .middle {
        float: left;
        width: 84%;
        margin-top: 10px;
        background: #f1f1f1;
    }

    .bar-container {
        width: 100%;
        background-color: #f1f1f1;
        text-align: center;
        color: white;
    }

    .bar-5 {
        width: 0;
        height: 18px;
        background-color: #369a00;
        float: left;
        max-width: 100% !important;
    }

    .bar-4 {
        width: 0;
        height: 18px;
        background-color: #00bcd4;
        float: left;
        max-width: 100% !important;
    }

    .bar-3 {
        width: 0;
        height: 18px;
        background-color: #2196F3;
        float: left;
        max-width: 100% !important;
    }

    .bar-2 {
        width: 0;
        height: 18px;
        background-color: #ffa500;
        float: left;
        max-width: 100% !important;
    }

    .bar-1 {
        width: 0;
        height: 18px;
        background-color: #f44336;
        float: left;
        max-width: 100% !important;
    }

    .right {
        text-align: right;
    }

    .comment_pro {
        text-align: center;
    }

    /*review detail product*/

    .review-detail-product {
        float: left;
        width: 100%;
        margin-top: 30px;
    }

    .title-review-detail {
        float: left;
        width: 100%;
    }

    .title-review-detail h2 {
        font-weight: 800;
        font-size: 16px;
        color: #73b11a;
        margin-bottom: 30px;
    }

    .review-detail-product .filter-review-detail {
        float: left;
        width: 100%;
        margin-top: 20px;
    }

    .filter-review-detail h3 {
        float: left;
        font-weight: 800;
        font-size: 14px;
        margin-right: 60px;
    }

    .filter-review-detail h3 span {
        font-weight: 300;
        float: right;
        margin-left: 10px;
    }

    .filter-review-detail span {
        float: left;
    }

    .filter-review {
        float: left;
        display: flex;
    }

    .filter-review span {
        font-weight: 800;
        color: #b4b4b4;
    }

    .filter-review .nice-select {
        float: left;
        border: none;
        margin-left: 5px;
        height: 25px;
        font-size: 15px;
        margin-top: -9px;
    }

    .filter-review .nice-select span {
        color: #333;
        font-size: 12px;
    }

    .filter-review .nice-select::after {
        border-bottom: 2px solid #000;
        border-right: 2px solid #000;
        content: '';
        margin-top: 0px;
    }

    .btn-comment-review {
        float: right;
        margin-top: -12px;
    }

    .btn-comment-review a {
        padding: 9px 27px 10px 27px;
        background: #449d44;
        display: inline-block;
        font-weight: 800;
        color: #fff;
        margin-right: 0px;
        font-size: 13px;
        white-space: nowrap;
        margin-top: 70px;
        border: 1px solid #449d44;
    }

    .btn-comment-review a:hover {
        text-decoration: none;
        color: #333;
    }

    .list-comment-review {
        float: left;
        width: 100%;
        margin: 30px 0px;
    }

    .item-comment-review {
        float: left;
        width: 100%;
        /*margin-bottom: 40px;*/
    }

    .header-item-comment {
        float: left;
        width: 100%;
        background: #efe4e4;
    }

    .header-item-comment span {
        color: #333;
        font-size: 12px;
        margin-left: 20px;
        float: left;
    }

    .header-item-comment span.time-comment {
        display: none;
    }

    .header-item-comment span.review-star-user {
        float: left;
        font-weight: 800;
        color: #000;
        margin-left: 0px;
    }

    .review-star-user img {
        margin-left: 5px;
    }

    .header-item-comment h3 {
        color: #9dc66f;
        clear: initial;
        font-weight: 800;
        float: left;
        margin-left: 20px;
        font-size: 15px;
    }

    .ctn-item-comment {
        float: left;
        width: 100%;
    }

    .ctn-item-comment h4 {
        color: #333;
        font-weight: 800;
        float: left;
        font-size: 15px;
        width: 100%;
        margin-bottom: 15px;
    }

    .ctn-item-comment p {
        color: #333;
        font-size: 14px;
        float: left;
        width: 100%;
    }

    .ctn-item-comment a {
        font-weight: 800;
        color: #ffcd08;
        float: left;
        width: 100%;
        margin-top: 10px;
    }

    .ctn-item-comment a img {
        float: left;
        margin-top: -2px;
        margin-right: 5px;
    }

    .ctn-item-comment a span {
        color: #333;
        font-size: 12px;
        margin-left: 10px;
    }

    .package-detail-product .title-package {
        float: left;
        width: 100%;
        text-align: left;
        text-transform: uppercase;
        font-size: 14px;
        font-weight: 800;
        margin-bottom: 50px;
        position: relative;
        /* z-index: 999; */
    }

    .result-review-product {
        float: left;
        width: 100%;
        margin-top: 80px;
    }

    .result-review-product .rating-star {
        float: left;
        width: 100%;
        margin-bottom: 20px;
    }

    .result-review-product .rating-star h4 {
        float: left;
        font-size: 14px;
        font-weight: 800;
    }

    .result-review-product p {
        float: left;
        font-size: 14px;
        font-weight: 800;
        width: 100%;
        margin-bottom: 15px;
    }

    .result-review-product .title-process {
        height: 10px;
        margin: 5px 0;
        font-size: 14px;
        font-weight: 800;
        margin-right: 4px;
    }

    .result-review-product .progress {
        height: 10px;
        margin: 8px 0;
    }

    .result-review-product .count-review {
        margin: 5px 0
    }

    .result-review-product .progress-bar-success {
        background-color: #ffcd08;
    }


    /*end review detail product*/

    .comment_pro h2 {
        display: inline-table;
        font-size: 23px;
        font-weight: normal;
        text-transform: uppercase;
        color: #323232;
        border-bottom: solid #d0011b 2px;
        margin-bottom: 15px;
        line-height: 35px;
    }

    .boxComment_danhgia {
        background: #f4f4f4;
        padding: 20px;
        margin: 20px 0px;
        float: left;
        width: 100%;
    }

    .boxComment_danhgia h3 {
        border-bottom: solid #ccc 1px;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-size: 22px;
        font-weight: normal;
        text-transform: uppercase;
        line-height: 30px;
        color: #d0011b;
        margin-top: 0;
    }

    .boxComment_danhgia li {
        padding-bottom: 10px;
        font-size: 15px;
        color: #333333eb;
        list-style: none;
        float: left;
        width: 100%;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        font-weight: 600;
    }

    .boxComment_danhgia li span {
        float: left;
        margin-right: 5px;
    }

    .boxComment_danhgia .form-control {
        display: block;
        width: 100%;
        height: 40px;
        padding: 5px 12px;
        font-size: 15px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
        box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        resize: vertical;
        box-sizing: border-box;
        font-family: 'Roboto Condensed', Arial, Helvetica, Tahoma, sans-serif;
        font-weight: 300;
    }

    .dangbt_btn, .boxComment_danhgia h4 a {
        border: none;
        cursor: pointer;
        float: right;
        display: block;
        font-size: 17px;
        font-weight: normal;
        text-transform: uppercase;
        line-height: 35px;
        padding: 5px 20px;
        margin-top: 20px;
        color: #fff;
        background: #337ab7;
        border-radius: 4px;
        transition: color .33s cubic-bezier(.33, 0, .2, 1) 0s, fill .33s cubic-bezier(.33, 0, .2, 1) 0s, background .33s cubic-bezier(.33, 0, .2, 1) 0s;
        -moz-transition: color .33s cubic-bezier(.33, 0, .2, 1) 0s, fill .33s cubic-bezier(.33, 0, .2, 1) 0s, background .33s cubic-bezier(.33, 0, .2, 1) 0s;
    }

    .space_sm {
        float: left;
        width: 100%;
        margin-bottom: 15px;
    }

    @media only screen and (max-width: 991px) {
        .titile_page_id {
            background: #fff;
            border-bottom: solid #e0e0e0 1px;
            margin-bottom: 10px;
            padding: 10px;
        }

        .titile_page_id ul h1, .titile_page_id ul h3 {
            font-size: 20px;
            line-height: 30px;
        }

        .page_more {
            padding: 10px;
            padding-top: 0;
        }
    }

    @media only screen and (max-width: 767px) {
        .danhgia_tringbinh p {
            font-size: 14px;
            padding-bottom: 5px;
        }

        .side {
            float: left;
            width: 35px;
            margin-top: 10px;
            font-size: 13px;
            line-height: 18px;
        }

        .middle {
            width: calc(100% - 100px);
            float: left;
            margin-left: 5px;
            margin-right: 5px;
        }

        .comment_pro h2 {
            font-size: 18px;
            line-height: 30px;
        }

        .boxComment_danhgia {
            padding: 10px;
            margin: 20px 0px;
        }

        .boxComment_danhgia h3 {
            padding-bottom: 10px;
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: normal;
            text-transform: uppercase;
            line-height: 20px;
        }

        .boxComment_danhgia li {
            padding-bottom: 10px;
            font-size: 14px;
            font-weight: 500;
            line-height: 22px;
        }

        .dangbt_btn, .boxComment_danhgia h4 a {
            font-size: 14px;
            line-height: 30px;
            padding: 5px 20px;
        }
    }

    @media only screen and (max-width: 479px) {
        .titile_page_id ul h1, .titile_page_id ul h3 {
            font-size: 17px;
            line-height: 27px;
            margin: 0;
        }

        .comment_pro h2 {
            margin-bottom: 0;
        }
    }

    .progress-bar {
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }

    .progress.pull-left {
        border-radius: 5px;
        width: 80%;
    }

    .progess-rate {
        padding-top: 0;
        width: 55%;
    }

    .star-rate {
        width: 25%;
    }

    .comment_reply {
        background: #f8f8f8;
    }

    .comment_reply span.user-cmt-name strong {
        color: #000;
    }

    .qtv {
        background: #f1c40f;
        border-radius: 2px;
        padding: 0 5px;
        margin: 4px 0 4px 10px;
        line-height: normal;
        border: 1px solid #f1c40f;
        font-size: 11px;
        color: #333;
        font-weight: normal;
        display: inline-block;
    }

    .avatar-name-fword {
        width: 35px;
        height: 35px;
    }

    .review-star-user i {
        color: #e3e3e3;
    }

    .ctn-item-comment b {
        padding-left: 10px;
    }

    .review-star-user i.active {
        color: #ffc120;
    }

    .review-star-user {
        padding: 0;
        margin-left: 0;
    }

    .buy-already {
        font-size: 12px !important;
        padding: 1px 0 1px 22px;
        background: url(https://salt.tikicdn.com/desktop/img/icon/security-checked@2x.png) no-repeat;
        margin: 6px 0;
        color: #22b345 !important;
        font-weight: 400;
        background-size: 14px;
    }

    .item-comment-review {
        /*background: #f9f9f9;*/
    }

    .progress-bar {
        background-color: #449d44;
    }

    .header-item-comment {
        padding: 10px 0;
        background: none !important;
        text-align: center;
        display: inherit;
        width: 20%;
    }

    .header-item-comment label, .header-item-comment span {
        color: #000;
        padding: 0;
        margin: 0;
        width: 100%;
    }

    .adr label {
        font-weight: 500;
        width: auto;
    }

    .header-item-comment .name {
        border-radius: 50%;
        background: #d3d2d3;
        color: #919090;
        font-weight: 500;
        width: 50px;
        height: 50px;
        display: inline-block;
        text-align: center;
        line-height: 50px;
        font-size: 18px;
        font-family: Roboto;
        text-transform: uppercase;
        margin: 0 auto;
    }

    .ctn-item-comment {
        width: 80%;
    }

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

    @media (max-width: 480px) {
        .comment_reply {
            margin-left: 20px;
        }

        .ctn-item-comment p {
            font-size: 13px;
        }

        .ctn-item-comment b {
            font-size: 13px;
        }

        .header-item-comment label {
            width: 70%;
        }

        .header-item-comment .name {
            width: 40px;
            height: 40px;
            line-height: 40px;
        }

        .ctn-item-comment, .item-comment-review {
            background: none;
        }

        .ctn-item-comment {
            padding: 0 0 0 0;
            width: 100%;
        }

        .review-star-user {
            font-size: 13px;
        }

        .review-star-user i {
            font-size: 11px;
        }

        .header-item-comment label, .header-item-comment span {
            float: left;
        }

        .adr label {
            width: auto;
            float: right;
        }

        .adr {
            position: relative;
            padding-right: 10px !important;
        }

        .time-comment {
            padding-left: 10px !important;
        }

        .adr:after {
            content: "-";
            right: 0;
            position: absolute;
            top: 0;
        }

        .header-item-comment span {
            width: auto;
        }

        .header-item-comment .name {
            margin-right: 10px;
            float: left;
        }

        .header-item-comment {
            padding: 0;
            width: 100%;
            text-align: left;
        }

        .wrap-progress {
            margin-bottom: 0;
        }

        .value-rate {
            margin-bottom: 0;
            font-size: 20px;
        }

        .star-rate {
            padding-bottom: 13px;
            font-size: 13px;
        }

        .star-rate h5 {
            display: none;
        }

        .progress.pull-left {
            width: 70%;
        }

        .wrap-progress span {
            font-size: 11px;
        }

        .progress.pull-left {
            height: 6px;
        }

        .progess-rate {
            width: 60%;
            padding-right: 0;
        }

        .star-rate {
            width: 40%;
        }
    }
</style>