<?php $themUrl = Yii::app()->theme->baseUrl; ?>
<!--<link href='--><?php //echo $themUrl   ?><!--/css/jquery.mCustomScrollbar.css?v=18.04.16' rel='stylesheet'-->
<!--      type='text/css'/>-->
<div class="list-video list-video1 clearfix">
    <?php if ($show_widget_title) { ?>
        <div class="title-lv">
            <h2>
                <a href="javascript:void(0)" title="<?php echo $widget_title; ?>">
                    <span><?php echo $widget_title ?></span>
                </a>
            </h2>
        </div>
    <?php } ?>
    <?php if (count($videos)) {
        ?>
        <div class="content-lv">
            <div class="row-lv ms mCustomScrollbar" style="height: 480px;overflow: hidden">
                <?php foreach ($videos as $video) { ?>
                    <div class="col-lv-2">
                        <div class="col-video">
                            <a href="<?php echo $video['link']; ?>"
                               title="<?php echo $video['video_title']; ?>">
                                   <?php if (isset($video['avatar_path']) && isset($video['avatar_name'])) { ?>
                                    <img src="<?php echo ClaHost::getImageHost() . $video['avatar_path'] . 's220_220/' . $video['avatar_name']; ?>">
                                <?php } ?>
                            </a>
                        </div>
                        <div class="col-title">
                            <h3><a href="<?php echo $video['link']; ?>"
                                   title="<?php echo $video['video_title']; ?>"><?php echo $video['video_title']; ?></a>
                            </h3>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
