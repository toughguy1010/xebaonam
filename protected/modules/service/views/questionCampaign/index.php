<div class="left-content col-lg-8 col-md-8 col-sm-12 col-xs-12">
    <div class="heading-on-page center">
        <h1 class="heading">Hỏi đáp trực tuyến</h1>
        <span class="border-heading"></span>
    </div>
    <div class="list-faq">
        <?php
        if (isset($campaigns) && $campaigns) {
            foreach ($campaigns as $campaign) {
                ?>
                <div class="item-faq">
                    <h4 class="title-faq">
                        <a href="<?= $campaign['link'] ?>" title="<?= $campaign['name'] ?>">
                        <?= $campaign['name'] ?>
                        </a>
                    </h4>
                    <a href="javascript:void(0)" class="place"><?= $campaign['department'] ?></a>
                    <div class="detail-item-faq">
                        <div class="img-faq">
                            <a href="<?= $campaign['link'] ?>">
                                <img src="<?= ClaHost::getImageHost(), $campaign['avatar_path'], 's200_200/', $campaign['avatar_name'] ?>" class="img-responsive" alt="<?= $campaign['name'] ?>" />
                            </a>
                        </div>
                        <div class="desc-faq">
                            <p><?= $campaign['description'] ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>

</div>