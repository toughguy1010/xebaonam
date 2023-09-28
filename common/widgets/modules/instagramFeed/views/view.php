<?php if ($data) { ?>
    <div class="row gallery instagram">
        <div class="col-xs-12">
            <div class="box-album">
                <?php if ($show_widget_title) { ?>
                    <div class="title"><h3><a href="<?php echo $instagram_site; ?>" title="#" target="_blank"><i><?php echo $widget_title ?></i></a></h3>
                        <div class="description">SHOW OFF YOUR SKIN #JUSTLAUNDERED</div>
                    </div>
                <?php } ?>
                <div class="cont">
                    <ul class="clearfix">
                        <?php
                        foreach ($data['data'] as $post) {

                            $pic_text = $post['caption']['text'];
                            $pic_link = $post['link'];
                            $pic_like_count = $post['likes']['count'];
                            $pic_comment_count = $post['comments']['count'];
                            $pic_src = str_replace("http://", "https://", $post['images']['standard_resolution']['url']);
                            $pic_created_time = date("F j, Y", $post['caption']['created_time']);
                            $pic_created_time = date("F j, Y", strtotime($pic_created_time . " +1 days"));
                            ?>

                            <li>
                                <a href="<?php echo $pic_link; ?>" title="<?php echo $pic_text; ?>" target="_blank">
                                    <img u="image"  alt="<?php echo $image['name'] ?>" src="<?php echo $pic_src; ?>" alt="<?php echo $pic_text; ?>"/>
                                </a>
                            <li>
                                <?php
                            }
                            ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php } ?>