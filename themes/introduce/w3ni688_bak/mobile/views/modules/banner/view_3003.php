<?php
if (count($banners)) {
     ?>
     <div class="logo-brand">
          <?php if($show_widget_title){ ?>
          <div class="title-brand">
               <h3><?php echo $widget_title ?>:</h3>
          </div>
          <?php } ?>
          <div class="cont-logo-brand">
               <div class="cont-logo">
                    <?php foreach ($banners as $banner) { ?>
                         <div class="item-logo">
                              <a href="<?php echo $banner['banner_link'] ?>" title="<?php echo $banner['banner_name'] ?>">
                                   <img src="<?php echo $banner['banner_src'] ?>" alt="<?php echo $banner['banner_name'] ?>"/>
                              </a>
                         </div>
                    <?php } ?>
               </div>
          </div>
     </div>
<?php } ?>