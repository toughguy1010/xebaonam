<?php
$data_images = array();
foreach ($images as $image) {
    $data_images[$image['type']][] = $image;
}
?>
<div class="section" id="section0">
    <div class="wrap-menu" id="global">
        <div class="container">
            <div class="box-top-header">
                <h1 class="logo">
                    <a href="javascript:void(0)">
                        <img class="mobile"
                             src="<?php echo ClaHost::getImageHost(), $project['logo_path'], $project['logo_name'] ?>"
                             alt="<?php echo $project['name'] ?>">
                        <img class="destop"
                             src="<?php echo ClaHost::getImageHost(), $project['logo_path'], $project['logo_name'] ?>"
                             alt="<?php echo $project['name'] ?>">
                    </a>
                </h1>
                <div class="languages">
                    <a href="#">VN</a>
                    <a href="#">EN</a>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($data_images[BdsProjectConfigImages::TYPE_NORMAL]) && count($data_images[BdsProjectConfigImages::TYPE_NORMAL])) {
        $imgs = $data_images[BdsProjectConfigImages::TYPE_NORMAL];
        $i = 0;
        foreach ($imgs as $img) {
            $i++;
            ?>
            <div class="slide" id="slide<?php echo $i ?>"
                 style="background:url('<?php echo ClaHost::getImageHost(), $img['path'], $img['name'] ?>') top center no-repeat;background-size: cover;">
                <p class="title-project-<?php echo $i ?>"><?php echo $project['name'] ?></p>
            </div>
            <?php
        }
    }
    ?>
    <a href="#secondPage" class="btn-next-section"></a>
</div>
<div class="section" id="section1">
    <div class="intro-about">
        <div class="portfolio">
            <div class="content-blog">
                <div class="review-blog wow fadeInRight">
                    <div class="table-mid">
                        <div class="middle">
                            <h2><?php echo $project['config1'] ?></h2>
                            <?php echo $project['config1_content'] ?>
                        </div>
                    </div>
                </div>
                <div class="slide-blog wow fadeInLeft"
                     style="background:url('<?php echo ClaHost::getImageHost(), $project['config1_image_path'], $project['config1_image_name'] ?>') top center no-repeat;background-size: cover;">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section" id="section2">
    <?php
    if (isset($data_images[BdsProjectConfigImages::TYPE_CONFIG1]) && count($data_images[BdsProjectConfigImages::TYPE_CONFIG1])) {
        $imgs = $data_images[BdsProjectConfigImages::TYPE_CONFIG1];
        $i = 0;
        foreach ($imgs as $img) {
            $i++;
            ?>
            <div class="slide" id="slide<?php echo $i ?>"
                 style="background:url('<?php echo ClaHost::getImageHost(), $img['path'], $img['name'] ?>') center center no-repeat;background-size: cover;">
            </div>
            <?php
        }
    }
    ?>
</div>

<div class="section" id="section3">
    <div class="intro-about">
        <div class="portfolio">
            <div class="content-blog">
                <div class="review-blog wow fadeInLeft">
                    <div class="table-mid">
                        <div class="middle">
                            <h2><?php echo $project['config2'] ?></h2>
                            <?php echo $project['config2_content'] ?>
                        </div>
                    </div>
                </div>
                <div class="slide-blog wow fadeInRight"
                     style="background:url('<?php echo ClaHost::getImageHost(), $project['config2_image_path'], $project['config2_image_name'] ?>') top center no-repeat;background-size: cover;">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section" id="section4">
    <div class="intro-about">
        <div class="portfolio">
            <div class="content-blog">
                <div class="review-blog wow fadeInRight">
                    <div class="table-mid">
                        <div class="middle">
                            <h2><?php echo $project['config3'] ?></h2>
                            <?php echo $project['config3_content'] ?>
                        </div>
                    </div>
                </div>
                <div class="slide-blog wow fadeInLeft"
                     style="background:url('<?php echo ClaHost::getImageHost(), $project['config3_image_path'], $project['config3_image_name'] ?>') top center no-repeat;background-size: cover;">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section" id="section5">
    <div class="intro-about">
        <div class="portfolio">
            <div class="content-blog">
                <div class="review-blog wow fadeInRight">
                    <div class="table-mid">
                        <div class="middle">
                            <h2><?php echo $project['config4'] ?></h2>
                            <?php echo $project['config4_content'] ?>
                        </div>
                    </div>
                </div>
                <div class="slide-blog wow fadeInLeft"
                     style="background:url('<?php echo ClaHost::getImageHost(), $project['config4_image_path'], $project['config4_image_name'] ?>') top center no-repeat;background-size: cover;">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section" id="section6">
    <div class="intro-about">
        <div class="portfolio">
            <div class="content-blog">
                <div class="review-blog wow fadeInLeft">
                    <div class="table-mid">
                        <div class="middle">
                            <h2><?php echo $project['config5'] ?></h2>
                            <?php echo $project['config5_content'] ?>
                        </div>
                    </div>
                </div>
                <div class="slide-blog wow fadeInRight"
                     style="background:url('<?php echo ClaHost::getImageHost(), $project['config5_image_path'], $project['config5_image_name'] ?>') top center no-repeat;background-size: cover;">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section wow fadeInUp" id="section7">
    <div class="ld-pro-review">
        <h2 class="wow fadeInUp"><span>CHUYÊN GIA</span> TƯ VẤN Cho dự án</h2>
        <div class="container">
            <div id="owl-demo-ld" class="owl-carousel list-pro-review">
                <?php if (isset($consultants) && count($consultants) > 0) {
                    foreach ($consultants as $consultant) {
                        ?>
                        <div class="item item-pro-review wow fadeInUp">
                            <div class="img-pro-review">
                                <a href="<?php echo $consultant['link'] ?>">
                                    <img src="<?php echo ClaHost::getImageHost() . $consultant['avatar_path'] . 's400_400/' . $consultant['avatar_name']; ?>">
                                    <span class="hover-img-view"></span>
                                </a>
                            </div>
                            <div class="ctn-pro-review">
                                <h3><a title="<?php echo $consultant['name'] ?>"
                                       href="<?php echo $consultant['link'] ?>"><?php echo $consultant['name'] ?></a></h3>
                                <p><?php echo $consultant['job_title'] ? '(' . $consultant['job_title'] . ')' : '' ?></p>
                            </div>
                        </div>
                    <?php }
                } ?>
            </div>
        </div>
    </div>
    <div class="footer-index wow fadeInUp" style="background: #534741;border-top: 2px solid #776a62;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <div class="logo-footer-ld">
                        <a href=""><img src="images/ld-Logo.png"></a>
                        <p>Phân phối bởi Amber Property</p>
                    </div>
                </div>
                <div class="social-icon col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <div class="call-us">
                        <span>Call Us</span>
                        <p>0932 311 566</p>
                    </div>
                    <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                    <i class="fa fa-facebook-square" aria-hidden="true"></i>
                    <i class="fa fa-youtube-square" aria-hidden="true"></i>
                    <i class="fa fa-google-plus-square" aria-hidden="true"></i>
                </div>
                <div class="wid-100 col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <div class="news-letter-index">
                        <h3>Thông tin liên hệ</h3>
                        <div class="box-newsletter">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore .
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>