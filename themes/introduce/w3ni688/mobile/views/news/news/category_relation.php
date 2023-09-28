<?php
if (count($listnews)) { ?>
     <?php
     $first = ClaArray::getFirst($listnews);
     $listnews = ClaArray::removeFirstElement($listnews);
     ?>
     <div class="list-news-page">
          <?php if ($first) {
               ?>
               <div class="first-news">
                    <div class="first-news clearfix">
                         <div class="first-news-img" style="width: 100%;">
                              <a href="<?php echo $first['link']; ?>">
                                   <img src="<?php echo ClaHost::getImageHost() . $first['image_path'] . 's800_800/' . $first['image_name']; ?>">
                              </a>
                         </div>
                         <div class="first-news-cont">
                              <h4>
                                   <a href="<?php echo $first['link']; ?>" title=" <?php echo $first['news_title']; ?>">
                                        <?php echo $first['news_title']; ?>
                                   </a>
                              </h4>
                              <p><?php echo HtmlFormat::subCharacter($first['news_sortdesc'], ' ', 60); ?></p>
                         </div>
                    </div>
               </div>
               <?php
          }
          if ($listnews) {
               foreach ($listnews as $ne) {
                    ?>
                    <div class="box-news-in clearfix">
                         <div class="box-img img-news-in">
                              <a href="<?php echo $ne['link']; ?>" title=" <?php echo $ne['news_title']; ?>">
                                   <img alt=" <?php echo $ne['news_title']; ?>" src="<?php echo ClaHost::getImageHost() . $ne['image_path'] . 's200_200/' . $ne['image_name']; ?>">
                              </a>
                         </div>
                         <div class="box-info">
                              <h4>
                                   <a href="<?php echo $ne['link']; ?>">
                                        <?php echo $ne['news_title']; ?>
                                   </a>
                              </h4>
                              <p>
                                   <?php
                                   echo $ne['news_sortdesc'];
                                   ?>
                              </p>
                         </div>
                    </div>
                    <?php
               }
          }
          ?>
     </div>
     <div class="wpager">
          <?php
          $this->widget('common.extensions.LinkPager.LinkPager', array(
               'itemCount' => $totalitem,
               'pageSize' => $limit,
               'header' => '',
               'selectedPageCssClass' => 'active',
          ));
          ?>
     </div>
<?php } ?>