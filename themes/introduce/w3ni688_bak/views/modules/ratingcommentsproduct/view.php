<?php if (count($comment)) {
    ?>
    <div class="result-review-product">
        <div class="rating-star">
            <h4>Đánh Giá Chung</h4>
            <?php echo HtmlFormat::show_rating($product_rating, $total_votes) ?>
        </div>
        <p>Thống Kê Đánh Giá</p>
        <div class="pull-left">
            <div class="pull-left" style="width:35px; line-height:1;">
                <div class="title-process">5 <img src="/themes/introduce/w3ni477/images/Star.png">
                </div>
            </div>
            <div class="pull-left" style="width:180px;">
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5"
                         aria-valuemin="0" aria-valuemax="5"
                         style="width: <?php echo (isset($grouprating['rating_percent'][5])) ? $grouprating['rating_percent'][5] : '0' ?>">
                        <span class="sr-only">80% Complete (danger)</span>
                    </div>
                </div>
            </div>
            <div class="pull-right count-review"
                 style="margin-left:10px;"><?php echo (isset($grouprating['number_rating'][5])) ? $grouprating['number_rating'][5] : '0' ?></div>
        </div>
        <div class="pull-left">
            <div class="pull-left" style="width:35px; line-height:1;">
                <div class="title-process">4 <img src="/themes/introduce/w3ni477/images/Star.png">
                </div>
            </div>
            <div class="pull-left" style="width:180px;">
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="4"
                         aria-valuemin="0" aria-valuemax="4"
                         style="width: <?php echo (isset($grouprating['rating_percent'][4])) ? $grouprating['rating_percent'][4] : '0' ?>">
                        <span class="sr-only">60% Complete (danger)</span>
                    </div>
                </div>
            </div>
            <div class="pull-right count-review"
                 style="margin-left:10px;"><?php echo (isset($grouprating['number_rating'][4])) ? $grouprating['number_rating'][4] : '0' ?></div>
        </div>
        <div class="pull-left">
            <div class="pull-left" style="width:35px; line-height:1;">
                <div class="title-process">3 <img src="/themes/introduce/w3ni477/images/Star.png">
                </div>
            </div>
            <div class="pull-left" style="width:180px;">
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="3"
                         aria-valuemin="0" aria-valuemax="3"
                         style="width: <?php echo (isset($grouprating['rating_percent'][3])) ? $grouprating['rating_percent'][3] : '0' ?>">
                        <span class="sr-only">40% Complete (danger)</span>
                    </div>
                </div>
            </div>
            <div class="pull-right count-review"
                 style="margin-left:10px;"><?php echo (isset($grouprating['number_rating'][3])) ? $grouprating['number_rating'][3] : '0' ?></div>
        </div>
        <div class="pull-left">
            <div class="pull-left" style="width:35px; line-height:1;">
                <div class="title-process">2 <img src="/themes/introduce/w3ni477/images/Star.png">
                </div>
            </div>
            <div class="pull-left" style="width:180px;">
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="2"
                         aria-valuemin="0" aria-valuemax="2"
                         style="<?php echo (isset($grouprating['rating_percent'][2])) ? $grouprating['rating_percent'][2] : '0' ?>">
                        <span class="sr-only">20% Complete (danger)</span>
                    </div>
                </div>
            </div>
            <div class="pull-right count-review" style="margin-left:10px;">1</div>
        </div>
        <div class="pull-left">
            <div class="pull-left" style="width:35px; line-height:1;">
                <div class="title-process">1 <img src="/themes/introduce/w3ni477/images/Star.png">
                </div>
            </div>
            <div class="pull-left" style="width:180px;">
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="1"
                         aria-valuemin="0" aria-valuemax="1"
                         style="<?php echo (isset($grouprating['rating_percent'][1])) ? $grouprating['rating_percent'][1] : '0' ?>">
                        <span class="sr-only">0% Complete (danger)</span>
                    </div>
                </div>
            </div>
            <div class="pull-right count-review"
                 style="margin-left:10px;"><?php echo (isset($grouprating['number_rating'][1])) ? $grouprating['number_rating'][1] : '0' ?></div>
        </div>
    </div>
    <?php
}
