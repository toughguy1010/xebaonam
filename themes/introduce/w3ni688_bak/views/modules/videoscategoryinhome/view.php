<?php
$x=0;
foreach ($cateinhome as $cat) {
    ++$x;
     ?>
     <div class="list-video list-video<?php echo $x;?> clearfix">
          <div class="title-lv">
               <h2>
                    <a href="<?php echo $cat['link']; ?>" title="<?php echo $cat['cat_name']; ?>">
                         <span><?php echo $cat['cat_name']; ?></span>
                    </a>
               </h2>
          </div>
          <?php if (isset($data[$cat['cat_id']]['videos'])) { ?>
               <div class="content-lv">
                    <div class="row-lv">
                         <?php foreach ($data[$cat['cat_id']]['videos'] as $video) { ?>
                              <div class="col-lv-2">
                                   <div class="col-video">
                                        <a href="<?php echo $video['link'] ?>"
                                           title="<?php echo $video['video_title'] ?>">
<!--                                             <iframe width="220" height="114" frameborder="0"-->
<!--                                                     src="--><?php //echo $video['video_embed']; ?><!--?autohide=1"-->
<!--                                                     allowfullscreen="1" allowtransparency="true">-->
<!--                                             </iframe>-->
                                             <img src="<?php echo ClaHost::getImageHost(), $video['avatar_path'], 's220_220/', $video['avatar_name']; ?>" alt="<?php echo $video['video_title'] ?>"/>
                                        </a>
                                   </div>
                                   <div class="col-title">
                                        <h3><a href="<?php echo $video['link'] ?>"
                                               title="<?php echo $video['video_title'] ?>"><?php echo $video['video_title'] ?></a>
                                        </h3>
                                   </div>
                              </div>
                         <?php } ?>
                    </div>
               </div>
          <?php } ?>
     </div>

<?php } ?>

