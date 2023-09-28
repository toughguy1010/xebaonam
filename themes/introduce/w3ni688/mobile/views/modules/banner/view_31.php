<?php if (count($banners)) {
      ?>
          <div class="banner-home">
               <div class="row">
                    <?php
                    foreach ($banners as $banner) {
                         $height = $banner['banner_height'];
                         $width = $banner['banner_width'];
                         $src = $banner['banner_src'];
                         $link = $banner['banner_link'];
                         if ($banner['banner_type'] == Banners::BANNER_TYPE_IMAGE) {
                              ?>
                              <div class="col-xs-12 col-sm-12 box-banner-img" style="padding: 0;">
                                   <div class="banner-img">
                                        <a href="<?php echo $link; ?>"
                                           title="<?php echo $banner['banner_name'] ?>">
                                             <img src="<?php echo $src; ?>"
                                                     alt="<?php echo $banner['banner_name'] ?>">
                                        </a>
                                   </div>
                              </div>
                              <?php
                         }
                    }
                    ?>
               </div>
          </div>
          <?php

}
?>

