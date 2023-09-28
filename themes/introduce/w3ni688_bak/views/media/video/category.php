<link href='<?php echo $themUrl ?>/css/jquery.mCustomScrollbar.css?v=18.04.16' rel='stylesheet'
      type='text/css'/>
<div class="list-video list-video1 clearfix">
     <?php if (count($list_album)) {
          ?>
          <div class="content-lv">
               <div class="row-lv">
                    <?php
                    foreach ($list_album as $album) {
                         ?>
                         <div class="col-lv-2">
                              <div class="col-video">
                                   <a href="<?php echo $album['link']; ?>"
                                      title="<?php echo $album['video_title']; ?>">
                                        <?php if (isset($album['avatar_path']) && isset($album['avatar_name'])) { ?>
                                             <img src="<?php echo ClaHost::getImageHost() . $album['avatar_path'] . 's220_220/' . $album['avatar_name']; ?>">
                                        <?php } ?>

                                   </a>
                              </div>
                              <div class="col-title">
                                   <h3><a href="<?php echo $video['link']; ?>"
                                          title="<?php echo $album['video_title']; ?>"><?php echo $album['video_title']; ?></a>
                                   </h3>
                              </div>
                         </div>
                    <?php } ?>
               </div>
          </div>
          <div class='video-page clearfix' style="float: right;">
               <?php
               $this->widget('common.extensions.LinkPager.LinkPager', array(
                    'itemCount' => $totalitem,
                    'pageSize' => $limit,
                    'header' => '',
                    'selectedPageCssClass' => 'active',
               ));
               ?>
          </div>
     <?php } else { ?>
          <p style="text-align: center;"> Danh mục hiện tại chưa có video!</p>
     <?php } ?>
</div>

