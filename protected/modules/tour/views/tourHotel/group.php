<?php
if (count($groupHotels)) { ?>
     <div class="grid">
          <?php foreach ($groupHotels as $group) {

               ?>
               <div class="list-item">
                    <div class="list-content clearfix">
                         <div class="list-content-box">
                              <div class="list-content-img">
                                   <a href="<?php echo $group['link'] ?>"
                                      title="<?php echo $group['name'] ?>">
                                        <img alt="<?php echo $group['name'] ?>"
                                             src="<?php echo ClaHost::getImageHost(), $group['image_path'], 's220_220/', $group['image_name']; ?>">
                                   </a>
                              </div>
                              <div class="list-content-body">
                                   <h3 class="list-content-title">
                                        <a href="<?php echo $group['link'] ?>"
                                           title="<?php echo $group['name'] ?>"><?php echo $group['name'] ?></a>
                                        <span class="hotstar_small star_5"></span>
                                   </h3>
                                   <div class="adress-hotel">
                                        <p><span><?php echo Yii::t('common', 'address') ?>
                                                  :</span> <?php echo implode(' - ', array($group['ward_name'], $group['district_name'], $group['province_name'])); ?>
                                        </p>
                                        <!--<a href="#" title="#" class="search-map">Xem bản đồ</a>-->
                                   </div>
                                   <?php if (isset($group['min_price']) && $group['min_price'] > 0) { ?>
                                        <div class="price">
                                             <p>
                                                  <span><?php echo Yii::t('tour_hotel', 'price_from') ?></span> <?php echo number_format($group['min_price'], 0, '', '.') ?>
                                                  ð</p>
                                        </div>
                                   <?php } ?>
                                   <?php
                                   $comforted = array();
                                   if (isset($group['comforts_ids']) && $group['comforts_ids']) {
                                        $comforted = explode(',', $group['comforts_ids']);
                                   }
                                   if (count($comforted)) {
                                        ?>
                                        <div class="attribute_hotel">
                                             <ul>
                                                  <?php
                                                  foreach ($comforts as $comfort) {
                                                       if (in_array($comfort['id'], $comforted)) {
                                                            ?>
                                                            <li>
                                                                 <?php if ($comfort['image_path'] && $comfort['image_name']) { ?>
                                                                      <a href="javascript:void(0)"
                                                                         title="<?php echo $comfort['name'] ?>">
                                                                           <img alt="<?php echo $comfort['name'] ?>"
                                                                                src="<?php echo ClaHost::getImageHost(), $comfort['image_path'], $comfort['image_name']; ?>"/>
                                                                      </a>
                                                                 <?php } ?>
                                                            </li>
                                                            <?php
                                                       }
                                                  }
                                                  ?>
                                             </ul>
                                        </div>
                                        <?php
                                   }
                                   ?>
                                   <div class="ProductAction clearfix">
                                        <div class="ProductActionAdd">
                                             <a href="<?php echo $group['link'] ?>"
                                                title="<?php echo $group['name'] ?>"
                                                class="a-btn-2">
                                                  <span class="a-btn-2-text">Xem phòng</span>
                                             </a>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          <?php } ?>
     </div>
     <div class="box-product-page clearfix">
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