<?php
if (count($videos)) {
    ?>
    <div class="box-news-right">
        <div class="title-news-right">
            <h2><?php echo $widget_title?></h2>
        </div>
        <div class="cont">
            <?php foreach ($videos as $video) { ?>
                <div class="box-news">
                    <div class="box-img img-news">
                        <a href="/vi-sao-nen-lua-chon-mau-xe-dap-dien-d1-suzika-cuc-doc-cuc-la-nd,12897" title="Vì sao nên lựa chọn mẫu xe đạp điện D1 Suzika cực độc, cực lạ?">
                            <img src="<?php echo ClaHost::getImageHost(), $video['avatar_path'], 's200_200/', $video['avatar_name']; ?>" alt="<?php echo $video['video_title'] ?>" />

                        </a>
                    </div>
                    <div class="box-info">
                        <h4>
                            <a href="<?php echo $video['link'] ?>" title="<?php echo $video['video_title']; ?>">
                                <?php echo $video['video_title']; ?>
                            </a>
                        </h4>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>