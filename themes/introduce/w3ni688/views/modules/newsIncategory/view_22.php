<?php if (count($news)) { ?>
     <div class="content-repairs content-promotion clearfix">
          <div class="row-banner-promotion">
               <?php foreach ($news as $ne) {
                    ?>
                    <div class="col-sm-6">
                         <div class="item-promotion clearfix">
                              <div class="border-pro">
                                   <div class="box-img-promotion">
                                        <a href="<?php echo $ne['link'] ?>"
                                           title="<?php echo $ne['news_title'] ?>">
                                             <img
                                                  src="<?php echo ClaHost::getImageHost(), $ne['image_path'], 's600_600/', $ne['image_name'] ?>"
                                                  alt="<?php echo $ne['news_title']; ?>">
                                        </a>
                                   </div>
                                   <div class="box-body-promotion">
                                        <div class="title-pro">
                                             <a href="<?php echo $ne['link'] ?>"
                                                title="<?php echo $ne['news_title'] ?>"><?php echo $ne['news_title'] ?></a>
                                        </div>
                                        <div class="date-pro">
                                             <span><?php echo ProductRating::time_elapsed_string($ne['created_time']) ?></span>
                                        </div>
                                        <div class="description-pro">
                                             <span><?php echo $ne['news_sortdesc']; ?></span>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               <?php } ?>
          </div>
     </div>
     <?php
}
?>