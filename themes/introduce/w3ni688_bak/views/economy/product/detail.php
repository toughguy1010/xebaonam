<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/colorbox/jquery.colorbox-min.js');
?>
<!-- <style type="text/css">
    #owl-detail .owl-item {
        display: inline-block;
    }
  </style> -->
  <?php $themUrl = Yii::app()->theme->baseUrl;?>
  <?php
  $images = $model->getImages();
  ?>
  <link href='<?php echo $themUrl ?>/css/jquery.mCustomScrollbar.css?v=18.04.16' rel='stylesheet'
  type='text/css'/>
  <script type="text/javascript" src="<?=$themUrl?>/js/jssor.js"></script>
  <script type="text/javascript" src="<?=$themUrl?>/js/jssor.slider.js"></script>
  <script type="text/javascript" src="<?=$themUrl?>/js/threesixty.js"></script>

  <script type="text/javascript" src="<?php echo $themUrl ?>/js/magiczoomplus.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/magiczoomplus.css">

  <script type="text/javascript">
    $(document).ready(function () {
      MagicZoom.options = {
        'fps': 40,
        'hint': false,
        'zoom-fade-in-speed': 600,
        'zoom-fade-out-speed': 600,
        'right-click': true,
        'selectors-mouseover-delay': 200,
        'zoom-distance': 5,
        'zoom-position': 'right',
        'zoom-height': 400,
        'zoom-width': 400
      };
    });
  </script>


  <div class="page-in page-detail-product">
    <div class="container" style="position: relative">
      <div class="menu-active-product-detail" style="">
        <ul>
          <li class="mn-mt active">
            <a class="searchbychar" href="javascript:void(0)" data-toggle="tab" role="tab"
            data-target="cont-detail-product" title="#">Mô tả</a>
          </li>
          <li class="mn-pic ">
            <a class="searchbychar" href="javascript:void(0)" data-toggle="tab" role="tab"
            data-target="image360" title="#">Hình ảnh</a>
          </li>
          <li class="mn-cmt">
            <a class="searchbychar" href="javascript:void(0)" data-toggle="tab" role="tab"
            data-target="comment-box" title="#">Bình luận</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="container">
      <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb');?>
      <div class="top-detail-product ">
        <div class="header-product-detail clearfix">
          <h1 class="name-product-detail"><?php echo $product['name']; ?></h1>
          <?php
          $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK1));
          ?>
        </div>
        <div class="cont-top-product-detail clearfix">
          <div class="col-left-detail col-lg-6 col-md-12">
            <div class="avt-product">
              <!--Image-->
              <?php
              $product_configurable_images = ProductConfigurableImages::model()->findAll('site_id=:site_id AND product_id=:product_id', array(
               ':site_id' => $product['site_id'],
               ':product_id' => $product['id'],
             ));
              $images_config_arr = array();
              if (count($product_configurable_images)) {
               foreach ($product_configurable_images as $img_config) {
                $images_config_arr[$img_config->pcv_id][] = $img_config->attributes;
              }
            }
            $configurableFilter = AttributeHelper::helper()->getConfiguableFilter($category['attribute_set_id'], $product);
            $config = array();
            if ($configurableFilter && count($configurableFilter)) {
             ?>
             <?php
             foreach ($configurableFilter as $config) {
              if (isset($config['configuable']) && $config['configuable']) {
               $config = array_column($config['configuable'], 'id');
             }
           }
         }?>

         <div class="widget-product-detail">
          <!--Hình ảnh-->
          <div class="image360 widget-product-detail picture-detail">
            <div class=" widget-product-detail picture-detail-content">
              <?php
// print_r($product);
              $images = $model->getImages();

              $num_images = count($model->getImages());
              $first = reset($images);
              ?>
              <div class="widget-product-detail image-hot">
                <div class="show-img-product" id="show-img-product-main">
                  <div class="preview col">
                    <div class="app-figure" id="zoom-fig">
                      <?php
                      $images = $model->getImages();
                      foreach ($images as $key => $image) {
                       if ($product['avatar_id'] == $image['img_id']) {
                        unset($images[$key]);
                      }
                    }
                    $first = reset($images) ? reset($images) : ['path' => $product['avatar_path'], 'name' => $product['avatar_name']];
// print_r($images);
                    ?>
                    <div class="big-img" style="margin-bottom:10px;">
                      <a id="magiczoommain" class="MagicZoom"
                      title="<?php echo $product['name'] ?>"
                      href="<?php echo ClaHost::getImageHost(), $first['path'], $first['name'] ?>">
                      <img
                      src="<?php echo ClaHost::getImageHost(), $first['path'], 's800_600/', $first['name'] ?>"
                      alt="<?php echo $product['name'] ?>"/>
                    </a>
                  </div>
                  <?php if ($images && count($images)) {?>
                    <div class="thumb-img">
                      <div  id="owl-details" class="owl-carousel owl-theme">
                        <?php foreach ($images as $img) {?>
                          <a data-zoom-id="magiczoommain<?php echo $color_code ?>"
                           href="<?php echo ClaHost::getImageHost(), $img['path'], $img['name'] ?>"
                           data-image="<?php echo ClaHost::getImageHost(), $img['path'], 's500_500/', $img['name'] ?>"><img
                           src="<?php echo ClaHost::getImageHost(), $img['path'], 's50_50/', $img['name'] ?>"
                           alt="<?php echo $product['name'] ?>"/></a>
                         <?php }?>
                       </div>
                     </div>
                   <?php }?>

                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
       <!--End - Hình ảnh-->
     </div>

     <!-- doãn sửa ngày 1_8_2017 theo yêu cầu khách -->
   </div>
 </div>
 <div class="col-lg-6 col-md-12 box-info-detail clearfix">
  <script>
    $(window).scroll(function () {
      var scroll = $(window).scrollTop();
      var header_height = $('#header').height();
      var breadcrumb_height = $('.breadcrumb').height();
      var top_product_height = $('.top-detail-product ').height();
      var box_widget1 = $('.box-widget1').height();
      var box_widget2 = $('.box-widget2').height();
      var box_widget3 = $('.box-widget3').height();
      var box_widget4 = $('.box-widget4').height();
      var widget_height = $('.left-height').height();
                            //var comparet_height = $('.compare ').height();
                            //var image_height = $('.image360').height();
                            //var image_hot = $('.image-hot').height();
                            if (scroll >= (header_height + breadcrumb_height + top_product_height + box_widget1 + box_widget2 + box_widget3 + box_widget4)
                              && scroll <= (header_height + breadcrumb_height + top_product_height + box_widget1 + box_widget2 + box_widget3 + box_widget4 + widget_height - 300)) {
                                // $(".general-information").addClass("fixed");
                            }
                            else {
                            // $(".general-information").removeClass("fixed");
                          }
                        });
                      </script>
                      <!--Price Box-->

                      <div class="general-information">
                        <?php
                        if ($product['price'] && $product['price'] > 0) {
                         ?>
                         <p class="price-detail" style="padding: 10px ;border-top: 1px solid rgba(195, 195, 195, .5);border-bottom: 1px solid rgba(195, 195, 195, .5);">
                          <!-- giá -->
                          <?php echo number_format($product['price']); ?>
                          <sup>đ</sup>
                          <?php if ($product['price_market']) {?>
                            <span style="text-decoration: line-through;"><?php echo number_format($product['price_market']); ?></span>
                          <?php }?>
                          <span style="    padding: 3px 10px;background: #f68706;color: #fff;border-radius: 20px;line-height: 7px;">trả góp 0%</span>
                        </p>


                        <p class="rate-star">
                          <span class="star">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                          </span>
                          <span class="rate">

                            <?=$product['total_votes']?>
                            <span>
                              lượt đánh giá
                            </span>
                          </span>
                           <!--  <span class="turn-buy">
                                <i class="fa fa-tag"></i>
                                (2) lượt mua
                              </span> -->
                            </p>
                            <?php if ($product['color']) {
                              ?>
                              <p class="color-product">
                                <span class="title">
                                  Màu sắc
                                </span>
                                <span class="group-color">
                                  <?php

                                  $color_str = explode(",", $product['color']);
                                  foreach ($color_str as $color) {?>
                                    <a href="javascript:void(0)" >
                                      <?=$color?>
                                    </a>
                                  <?php }?>

                                </span>
                              </p>
                            <?php }?>
                            <p class="amount-product">
                              <span class="title">
                                Số lượng
                              </span>
                              <td data-th="Quantity">
                                <input id="qty" name="quantity" type="number" class="form-control text-center" value="1">
                              </td>
                            </p>


                            <?php if ($product['price_market'] && $product['price_market'] > 0) {?>
                            <!-- <p class="old-price-detail">Giá chưa khuyến mại:
                                <span> <?php echo number_format($product['price_market'], 0, '', '.'); ?>
                                <sup>đ</sup></span></p> -->
                              <?php }?>
                            <?php } else {
                             ?>
                           <!--  <p class="price-detail">
                                <span><?php echo 'GIÁ:'; ?> </span>
                                <?php echo 'Liên hệ'; ?>
                              </p> -->
                              <?php

                              $site_info = Yii::app()->siteinfo;
                              $phone = explode(',', $site_info['phone']);
                              $phone0 = isset($phone[0]) ? $phone[0] : '';
                              $phone1 = isset($phone[1]) ? $phone[1] : '';
                              ?>
                              <p class="price-detail">Liên hệ : <a href="tel:<?=$phone0?>">
                                <?php
                                $pos = 1;
                                while ($pos) {
                                  $pos = strrpos($phone0, ".");
                                  if ($pos) {
                                   $phone0 = substr_replace($phone0, '', $pos, 1);
                                 }
                               }
                               echo ($phone0);
                               ?>
                             </p>


                           <?php }?>


                           <!--Written by:  Viet-->
                           <div class="box-option">
                            <div class="option-color">
                                <!-- <?php
$configurableFilter = AttributeHelper::helper()->getConfiguableFilter($category['attribute_set_id'], $product);
if ($configurableFilter && count($configurableFilter)) {
	?>
                                    <?php
foreach ($configurableFilter as $config) {
		$countCf = count($config['configuable']);
		$cfValue = '';
		if (isset($config['configuable']) && $countCf) {
			?>
                                            <div class="product-info-conf product-attr"
                                                 attr-title="<?php echo $config['name']; ?>">
                                                <label><?php echo $config['name']; ?>
                                                    :</label>
                                                <div class="product-info-conf-list">
                                                    <?php
$n = 0;
			($config['configuable']);
			arsort($config['configuable']);
			foreach ($config['configuable'] as $cf) {

				?>
                                                        <div class="product-info-conf-item product-attr-item">
                                                            <a goto="<?php echo $n++ ?>"
                                                               priceprc="<?php echo $cf['price'] ?>"
                                                               cf_id="<?php echo $cf['id'] ?>"
                                                               href="#"
                                                                <?php echo ' data-input="' . $cf['value'] . '" '; ?>
                                                               title="<?php echo $cf['name']; ?>"
                                                               class="<?php if ($countCf == 1) {
					echo 'active';
				}
				?> select-cl">
                                                                <?php echo $cf['text']; ?>
                                                            </a>
                                                        </div>
                                                        <?php
}
			if ($countCf == 1) {
				$cfValue = $cf['value'];
			}

			?>
                                                </div>
                                                <?php
echo CHtml::hiddenField(ClaShoppingCart::PRODUCT_ATTRIBUTE_CONFIGURABLE_KEY . '[' . $config['id'] . ']', $cfValue, array('class' => 'attrConfig-input'));
			?>
                                            </div>
                                            <?php
}
	}
	?>
  <?php }?> -->

  <!-- doãn sửa ngày 1_8_2017 theo yêu cầu khách -->


</div>
</div>
<!--End-->


<div class="box-km-detail">
  <div class="title-km-detail">
    <h2>Khuyến mại</h2>
  </div>
  <div class="cont">
    <ul>
      <?php
      $subject = $product['product_sortdesc'];
      $khuyenmai = explode("\n", $subject);
      foreach ($khuyenmai as $each) {
       if (trim(strip_tags($each)) == null) {
        continue;
      }
      echo '<li>', $each, '</li>';
    }
    ?>

  </ul>
</div>
</div>

<?php
$promotion = $model->getPromotion();
if ($promotion && count($promotion)) {
	?>
  <div class="description-detail">
    <div class="title-km-support">
     <h2>Chính sách Hỗ Trợ</h2>
   </div>
   <ul>
    <?php
    $ps = array();
    $count = preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $promotion['description'], $matches);
    ?>
    <?php foreach ($matches[0] as $camket) {?>
      <li class="check-icon">
        <span><?php echo $camket ?></span></li>
      <?php }?>
    </ul>
  </div>
<?php }
?>



                             <!-- <div class="box-km-detail box-km-detail-1">
                                <div class="title-km-detail">
                                    <h2>Ghi chú</h2>
                                </div>
                                <div class="cont cont-1">
                                    <ul>
                                        <?php
$product_note = $model->product_note;
$khuyenmai_note = explode("\n", $product_note);
foreach ($khuyenmai_note as $each) {
	if (trim(strip_tags($each)) == null) {
		continue;
	}
	echo '<li>', $each, '</li>';
}
?>

                                    </ul>
                                </div>
                              </div>  -->
                              <div class="group-link-detail">
                                <a data-params="#product-detail-info"
                                href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>"
                                title="Mua ngay"
                                class="box-action buy-now" >
                                Mua ngay
                                <span> (Giao trong 1h hoặc nhận ngay tại showroom) </span>
                              </a>
                              <a data-params="#product-detail-info"
                              href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>"
                              title="Mua ngay"
                              class="box-action addtocart " >
                              Đặt hàng
                              <span> (Đặt để nhận ưu đãi) </span>
                            </a>
                            <a data-params="#product-detail-info"
                            href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>"
                            title="Mua ngay"
                            class="box-action buy-installment ex1">
                            Mua trả góp 0%
                            <span> (Thủ tục đơn giản) </span>
                          </a>
                        </div>



                      </div>

                      <!--Phụ kiện-->
                <!-- <div class="more-information">
                    <div class="laptop-accessories">
                        <h2>Phụ kiện</h2>
                        <div class="cont">
                            <?php
if (count($products_rel)) {
	$n = 0;
	foreach ($products_rel as $product_r) {
		if (++$n > 5) {
			continue;
		}

		$price = number_format(floatval($product_r['price']));
		if ($price == 0) {
			$price_label = Product::getProductPriceNullLabel();
		} else {
			$price_label = $price . '<sup>đ</sup>';
		}
		?>
                                    <div class="item-laptop-accessories clearfix">
                                        <div class="box-img img-laptop-accessories">
                                            <?php if ($product_r['avatar_path'] && $product_r['avatar_name']) {?>
                                                <img alt="<?php echo $product_r['name']; ?>"
                                                src="<?php echo ClaHost::getImageHost() . $product_r['avatar_path'] . 's100_100/' . $product_r['avatar_name'] ?>">
                                            <?php } else {?>
                                                <img src="<?=$themUrl?>/css/img/anh-nen-suzika.jpg"
                                                alt="<?php echo $product['name'] ?>">
                                            <?php }?>
                                        </div>
                                        <div class="box-info">
                                            <h4>
                                                <a href="<?php echo $product_r['link']; ?>">
                                                    <?php echo $product_r['name'] ?>
                                                </a>
                                            </h4>
                                            <p class="price-pk"><?php echo $price_label ?></p>
                                            <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product_r['id'])); ?>"
                                               title="mua" class="actice-pk">Mua</a>
                                           </div>
                                       </div>
                                       <?php
}
} else {
	echo 'Đang cập nhập..';
}
?>
                        </div>
                    </div>
                  </div> -->
                </div>
              </div>
            </div>
            <div class="cont-detail-product clearfix">

              <!-- End - Thông số kỹ thuật-->

              <!-- Hình ảnh 360-->
              <div class="box-widget2">
                <div class="col-right 22">
                  <div class="parameter">
                    <?php if ($attributesShow && count($attributesShow)) {
                     ?>
                     <h2 class="title-ts in">Thông số kỹ thuật</h2>
                     <div class="cont cont-ts">
                      <div class="thongso">
                        <ul class="parametdesc">
                          <?php
                          $attributesDynamic = AttributeHelper::helper()->getDynamicProduct($model, $attributesShow);
                          $dem1=0;
                          $dem2=0;
                          foreach ($attributesDynamic as $key => $item) {
                            if($dem1<13){
                              if (is_array($item['value']) && count($item['value'])) {
                               $item['value'] = implode(", ", $item['value']);
                             }
                             if ($item['value']) {
                               echo '<li><span>' . $item['name'] . '</span><strong>' . $item["value"] . '</strong></li>';
                               $dem1++;
                             }
                           }else{ if (is_array($item['value']) && count($item['value'])) {
                             $item['value'] = implode(", ", $item['value']);
                           }
                           if ($item['value']) {
                             echo '<li class="thongso-item hidden"><span>' . $item['name'] . '</span><strong>' . $item["value"] . '</strong></li>';
                             $dem2++;
                           }
                         }
                       }
                       if ($dem2>0) {?>
                        <div class="showall"><a href="javascript:void"><i class="fa fa-chevron-down" aria-hidden="true"></i></a></div>
                        <?php
                        $dem1=0;
                        $dem2=0;
                      }
                      ?>
                    </ul>
                  </div>
                </div>
              <?php }?>
            </div>
          </div>
          <div class="col-left">
            <div class="widget-product-detail">
              <div class="image360">
                <div class="cont">
                  <?php
                  if (count($options_360) > 0) {
                   echo '<div class="show">'
                   . '<ul>';
                   foreach ($options_360 as $option_exterior) {
                    $count_temp = $option_exterior['count'];
                    $url_temp = $option_exterior['default']['path'];
                    $imagePath_temp = substr($url_temp, 0, strrpos($url_temp, '/') + 1);
                    $prd_name_temp = substr($url_temp, strrpos($url_temp, '/') + 1);
                    $filePrefix_temp = substr($prd_name_temp, 0, strrpos($prd_name_temp, '_') + 1);
                    $ext_temp = substr($prd_name_temp, strrpos($prd_name_temp, '.'));
                    ?>
                    <li style="display: inline-block;border: 1px solid #ccc;border-radius: 5px;padding: 5px">
                      <a href=javascript:void(0)
                      onclick="hatv_360(<?php echo $count_temp ?>, '<?php echo $imagePath_temp ?>', '<?php echo $filePrefix_temp ?>', '<?php echo $ext_temp ?>')">
                      <?php // echo $option_exterior['name']            ?>
                      <img alt="<?php echo $option_exterior['default']['name'] ?>"
                      src="<?php echo $option_exterior['default']['path'] ?>"
                      height="40px;">
                    </a>
                  </li>
                  <?php
                }
                echo '</ul></div>';
              }
              ?>
              <?php if (count($options_360) > 0) {
               ?>
               <?php
               $n = 0;
               foreach ($options_360 as $option_exterior) {
                if ($n++ > 0) {
                 continue;
               }

               $count = $option_exterior['count'];
               $url = $option_exterior['default']['path'];
               $imagePath = substr($url, 0, strrpos($url, '/') + 1);
               $prd_name = substr($url, strrpos($url, '/') + 1);
               $filePrefix = substr($prd_name, 0, strrpos($prd_name, '_') + 1);
               $ext = substr($prd_name, strrpos($prd_name, '.'));
               ?>
               <div class="cont-360">
                <div class="threesixty car">
                  <div class="spinner">
                    <span>0%</span>
                  </div>
                  <ol class="threesixty_images">
                  </ol>
                </div>
                <div style="text-align: center">
                  <a class="btn btn-danger custom_previous"><i
                    class='icon'
                    data-icon="k"></i></a>
                    <a class="btn btn-inverse custom_play"><i
                      class='icon'
                      data-icon="m"></i>
                    Play</a>
                    <a class="btn btn-inverse custom_stop"><i
                      class='icon'
                      data-icon="l"></i>
                    Pause</a>
                    <a class="btn btn-danger custom_next"><i
                      class='icon'
                      data-icon="j"></i></a>
                    </div>
                  </div>
                  <script type="text/javascript">
                    function hatv_360(count, imagePath, filePrefix, ext) {
                      $('.threesixty_images').html('');
                      var car = $('.car').ThreeSixty({
                                                    totalFrames: count, // Total no. of image you have for 360 slider
                                                    endFrame: count, // end frame for the auto spin animation
                                                    currentFrame: 1, // This the start frame for auto spin
                                                    imgList: '.threesixty_images', // selector for image list
                                                    progress: '.spinner', // selector to show the loading progress
                                                    imagePath: imagePath + 's800_800/', // path of the image assets
                                                    filePrefix: filePrefix, // file prefix if any
                                                    ext: ext, // extention for the assets
                                                    height: 570,
                                                    // width: 790,
                                                    navigation: true,
                                                    playSpeed: (6000 / count),
                                                  });
                      $('.custom_previous').bind('click', function (e) {
                        car.previous();
                      });
                      $('.custom_next').bind('click', function (e) {
                        car.next();
                      });
                      $('.custom_play').bind('click', function (e) {
                        car.play();
                      });
                      $('.custom_stop').bind('click', function (e) {
                        car.stop();
                      });
                      car.play();
                    }

                    $(document).ready(function () {
                      car = $('.car').ThreeSixty({
                                                    totalFrames: <?php echo $count ?>, // Total no. of image you have for 360 slider
                                                    endFrame: <?php echo $count ?>, // end frame for the auto spin animation
                                                    currentFrame: 1, // This the start frame for auto spin
                                                    imgList: '.threesixty_images', // selector for image list
                                                    progress: '.spinner', // selector to show the loading progress
                                                    imagePath: '<?php echo $imagePath ?>' + '/s800_800/', // path of the image assets
                                                    filePrefix: '<?php echo $filePrefix ?>', // file prefix if any
                                                    ext: '<?php echo $ext; ?>', // extention for the assets
                                                    height: 570,
                                                    // width: 790,
                                                    navigation: true,
                                                    playSpeed: (6000 / <?php echo $count ?>),
                                                    onReady: function () {
                                                      car.play();
                                                    }
                                                  });
                      $('.custom_previous').bind('click', function (e) {
                        car.previous();
                      });
                      $('.custom_next').bind('click', function (e) {
                        car.next();
                      });
                      $('.custom_play').bind('click', function (e) {
                        car.play();
                      });
                      $('.custom_stop').bind('click', function (e) {
                        car.stop();
                      });
                    })
                  </script>
                <?php }
                ?>
                <?php
              } else {
               echo 'Sản phẩm này tạm thời chưa có hình 360.';
             }
             ?>
             <style>
              .cont-page-product-detail .active {
                color: #000
              }
            </style>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--End- Hình ảnh 360-->


  <!--Video-->
  <div class="box-widget4 ">
    <div class="col-right">
      <!--     Tin liên quan-->

    </div>
    <?php
    $videos = Product::getVideoByProductid($product['id']);
    if (isset($videos) && count($videos)) {
     ?>
     <div class="col-left">
      <div class="widget-product-detail">
        <div class="video-detail" style="margin-top: 10px;">
          <div class="cont clearfix">
            <h2 style=" margin-bottom: 21px;" class="title-box-2">video liên quan - <?php echo $product['code']; ?></h2>
            <div class="list-videos">
              
                <div class="cont">
                  <ul>
                    <?php
                    $i = 0;
                    foreach ($videos as $video) {
                      ++$i;
                      ?>
                      <li class="<?php echo ($i == 1) ? 'active' : ''; ?>">
                        <a onclick="changeVideo(this)"
                        name="<?php echo $video['video_embed']; ?>"
                        href="javascript:void(0)"
                        title="<?php echo $video['video_title']; ?>"
                        class="box-item-videos clearfix">
                        <div class="box-img img-box-item-videos">
                          <img
                          src="<?php echo ClaHost::getImageHost(), $video['avatar_path'], 's100_100/', $video['avatar_name']; ?>">
                        </div>
                        <div class="box-info">
                          <h5><?php echo $video['video_title']; ?></h5>
                        </div>
                      </a>
                    </li>
                    <?php
                  }
                  ?>
                </ul>
              </div>
            </div>
            <div class="box-videos">
              <iframe width="100%" height="100%" frameborder="0"
              src="<?php echo $videos[0]['video_embed']; ?>?autohide=1"
              allowfullscreen="1"
              allowtransparency="true"></iframe>
            </div>
          </div>
        </div>
        <style>
          .videoWrapper {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
            padding-top: 25px;
            height: 0;
          }

          .videoWrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
          }
        </style>
        <script type="text/javascript">
          function changeVideo(thistag) {
            $('.list-videos ul li').removeClass('active');
            $(thistag).parent().addClass('active');
            var embed = $(thistag).attr('name') + '?autohide=1';
            $('.box-videos iframe').attr('src', embed)
          }
        </script>

      </div>
    </div>
  <?php } else {?>
    <div class="col-left">
      <p style="text-align: center;">Sản phẩm này tạm thời chưa có Video</p>
    </div>
  <?php }?>
</div>
<!--Descrtip-->
<div class="box-widget5 box-widget1">
  <div class="col-right">
    <div class="compare">
      <h2 class="title-ss"> Các xe tương tự </h2>
      <div class="cont cont-ss">
        <?php
/**
 * Sản phẩm so sánh
 */
$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK3));
?>
</div>
</div>

<?php if (isset($news_rel) && count($news_rel)) {
	?>
  <div class="news-manual">
    <h2 class="title-ss">Tin liên quan</h2>
    <div class="cont cont-ss">
      <?php
      $i = 0;
      foreach ($news_rel as $rel) {
        ++$i;
        if ($i >= 1 && $i <= 5) {
         ?>
         <div class="item-compare clearfix">
          <div class="box-img img-item-compare">
            <a href="<?php echo $rel['link']; ?>"
             title="<?php echo $rel['news_title']; ?>">
             <img alt="<?php echo $rel['news_title']; ?>"
             src="<?php echo ClaHost::getImageHost() . $rel['image_path'] . 's300_300/' . $rel['image_name'] ?>"/>
           </a>
         </div>
         <div class="box-info">
          <div class="top-info clearfix">
            <h3 class="title-product">
              <a href="<?php echo $rel['link']; ?>"
               title="<?php echo $rel['news_title']; ?>"><?php echo $rel['news_title']; ?></a>
             </h3>
           </div>
         </div>
       </div>
       <?php
     }
   }
   ?>
   <a class="view-more-manual" title=""
   href="<?php echo Yii::app()->createUrl('/news/news/groupnewsrelation', array('id' => $product['id'])); ?>">
   Xem thêm tất cả tin liên quan
 </a>
</div>
</div>
<?php }?>
</div>
<div class="col-left left-height">
  <div class="widget-product-detail abcfix" style="position: relative; max-height: 560px;overflow: hidden;">
    <h2>Mô tả chi tiết</h2>
    <?php echo $product['product_desc']; ?>
    <span class="seemore-detail" style="">Đọc thêm <i class="fa fa-caret-down"></i></span>
  </div>
</div>
</div>
<script>
  $(function(){
    $('.seemore-detail').on('click',function(e){
      e.preventDefault();
      $('.widget-product-detail').css('max-height','unset');
      $(this).fadeOut();
    })
  })
</script>
<!--end-->
<div class="box-widget6 ">
                <!-- <div class="col-right">
                    <?php
$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK4));
?>
</div> -->
<div class="col-left left-height">
  <div class="widget-product-detail">
    <style>
      /*end lien he*/
      .page-detail-product .cont-detail-product .box-widget5 .col-right {
        width: calc(100% - 70% - 15px);
        float: right;
      }
      .page-detail-product .cont-detail-product .box-widget5 .col-left {

       width: 70%;
     }
     .modal-dialog {
      width: 300px;
      margin: auto;
      margin-top: 30px;
    }

    .modal-dialog .cont {
      padding: 15px;
    }

    .modal-content {
      position: relative;
    }

    .modal {
      z-index: 9999999;
    }

    #myModal-addcart .modal-dialog {
      width: 600px;
    }

    #myModal-addcart .panel-group {
      margin-bottom: 0px;
    }

    #myModal-addcart .panel-title {
      margin-top: 0;
      margin-bottom: 0;
      font-size: 16px;
      color: inherit;
      float: left;
      text-transform: uppercase;
    }

    .toggle-down {
      float: right;
    }

    #myModal-addcart .panel-default > .panel-heading {
      color: #333;
      background-color: #f5f5f5;
      border-color: #ddd;
      height: 40px;
      position: relative;
    }
  </style>

  <div id="rating-panel">
    <?php
    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK8));
    ?>
  </div>

  <div id="comment-panel">
    <?php
    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK1));
    ?>
  </div>
  <?php if(count($products_rel)!=0){
    ?> 
    <div id="accessories-panel">
      <div class="title">Phụ Kiện Giá Tốt</div>
      <div class="bottom-title">
        <?php  $category = array();         
        foreach ($products_rel as $product) {
         $model = ProductCategories::model()->findByPk($product["product_category_id"]);         
         array_push($category, $model["cat_name"]);       
       }  
       $category=array_unique($category);      
       foreach ($category as $item) {
         ?>
         <a class="category_item" rel="stylesheet" type="text/css" href="<?php  ClaHost::getImageHost()?>tim-kiem.html?q=<?php echo$item ?>">
           <?php echo $item ?></a>   
         <?php } ?>      
       </div>
       <div class="content">
         <? foreach ($products_rel as $products) {
          if($products['avatar_name']){
            ?>
            <div class="accessories-item">
              <a href="<?php echo $products["link"];?>">
               <div class="img">
                <img src="<?php echo ClaHost::getImageHost().$products['avatar_path'].$products['avatar_name']?>">
              </div>
              <div class="name">
                <?php echo $products["name"]; ?>
              </div>
              <div class="price">
                <?php if($products["price"]!=0) echo number_format($products['price'], 0, '', ','); 
                else echo "Giá LH :".Yii::app()->siteinfo["admin_phone"];
                ?>
              </div>
            </a>
          </div>
          <?php   
        }    
      }?>
    </div></div>

  <?php }?>

  <div id="shop_store_location">
    <?php
    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK5));
    ?>
  </div>

</div>
</div>
</div>
</div>
</div>
</div>
<!--js-->


<script>
  jQuery(document).ready(function () {
    $('.menu-active-product-detail').css("top", 160 + 'px');
    var pos_head = $('#header').height();
    var pos_top = $('.page-detail-product .top-detail-product').height() + 50;
    var pos_mid = $('.center-page-product-detail .description-detail').height();
    var pos_bot = $('.video-detail').height();
    var evaluate_height = $('.center-page-product-detail .evaluate').height();
    var image_height = $('.widget-product-detail').height();
    var banner_bottom = $('#owl-demo-banner').height();

    $(window).scroll(function (event) {
      var scroll = $(window).scrollTop();
      if (scroll < (pos_head + pos_top)) {
        $('.menu-active-product-detail ul li').removeClass('active');
        $('.menu-active-product-detail ul li.mn-mt').addClass('active');
      } else if (scroll < (pos_head + pos_top + pos_mid + pos_bot)) {
        $('.menu-active-product-detail ul li').removeClass('active');
        $('.menu-active-product-detail ul li.mn-pic').addClass('active');
      } else {
        $('.menu-active-product-detail ul li').removeClass('active');
        $('.menu-active-product-detail ul li.mn-cmt').addClass('active');
      }
      if (scroll <= (pos_head + pos_top + pos_bot + evaluate_height + image_height + 200) || scroll >= (pos_head + pos_top + pos_mid + image_height - banner_bottom)) {
        $('#fixed_pos_info').removeClass('fixed');
      } else {
        $('#fixed_pos_info').addClass('fixed');
      }
      $('.menu-active-product-detail').css("top", (scroll + 130) + 'px');
    });
    $(document).on('click', '.searchbychar', function (event) {
      event.preventDefault();
      var target = "." + this.getAttribute('data-target');
      $('html, body').animate({
        scrollTop: $(target).offset().top
      }, 800);
    });
        //        var content = $('.center-page-product-detail').offset().top
        //        );
      });
    </script>

    <script type="text/javascript">
      jQuery(document).ready(function () {
        jQuery(document).on('click', '.product-info-conf-list .product-info-conf-item a', function () {
          var a = $(this).attr('priceprc');
          $(this).closest('.product-info-conf').find('.product-info-conf-list .product-info-conf-item a').removeClass('active');
          $(this).addClass('active');
          var dataInput = $(this).attr('data-input');
          if (dataInput) {
            $(this).closest('.product-info-conf').find('.attrConfig-input').val(dataInput);
          }
          $('.price-products-detail .prd-price').text(a);
          return false;
        });
      });
    </script>
    <script src="<?php echo $themUrl ?>/js/home/js/slick.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('.big_albums').slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          fade: true,
          asNavFor: '.slider-nav',
        // autoplay:true,
        // autoplaySpeed:5000,
      });
        $('.small_albums').slick({
          slidesToShow: 3,
          slidesToScroll: 1,
          asNavFor: '.slider-for',
          dots: false,
          arrow:false,
          focusOnSelect: true,
          responsive: [
          {
            breakpoint: 1200,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
              infinite: true,

            }
          },
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
              infinite: true,

            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1
            }
          }

          ]
        });
        $("#accessories-panel .content").slick({
          dots: true,
          infinite: false,
          speed: 300,
          slidesToShow:8,
          slidesToScroll: 8,
          responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 6,
              slidesToScroll: 6,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 4
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3
            }
          }
          ]
        });
      });
    </script>

    <style type="text/css">
      .price-detail a{
        font-size: 24px;
        color: #fe0000;
        font-weight: bold;
        margin-bottom: 5px;
      }
      #accessories-panel{
        position: relative;
        border-left: solid 1px;
        border-color: #e6e5e5;
      }
      .bottom-title {
        width: 100%;
        height: 78px;
        padding-top: 25px;
        background-color: #e6e5e5;
      }
      #accessories-panel .title::before{
        content: "";
        position: absolute;
        left: 0;
        width: 100%;
        height: 2px;
        background: #e6e5e5;
        display: block;
        color: #e6e5e5;

      }
      #accessories-panel .title{

        margin: 0px;
        border: 0px;
        font-size: 35px;
      }
      #accessories-panel .accessories-item .name {
        padding-left: 20px;
        height: 75px;
      }
      #accessories-panel .accessories-item .price{
        padding-left: 20px;
        font-size: 12px;
        margin-top: 20px;
      }
      #accessories-panel .accessories-item{
        margin-bottom: 15px
      }
      .accessories-item {
        float: left;
        width: 20%;
      }
      div#shop_store_location {
        clear: both;
      }
      #accessories-panel .content .slick-slide img {
        height: 95px;
        margin-top: 10px;
      }
      @media(min-width: 1200px){
        .page-detail-product .top-detail-product .cont-top-product-detail{
          position: relative;
        }
        .page-detail-product .cont-top-product-detail .col-left-detail{
          margin-bottom: 200px;
        }
        .col-lg-6.col-md-12.box-info-detail.clearfix{
          position: absolute;
          top: 0;
          right: -140px;
        }
      }
      .showall {
        text-align: center;
        margin-top: 25px;
      }
      .hidden{
        display: none;
      }
      .showall a{
        color: #09090a;
    font-size: 20px;
    font-weight: 900;
      }
      .price-detail::before,.price-detail::after{
        content: "";
        position: absolute;
        left: 0px;
        width: 80%;
        top: 0px;
        background: #afadad;
        height: 1px;

      }
      .price-detail::after{
        content: "";
        position: absolute;
        left: 0px;
        top: 59px;
        width: 80%;
        height: 1px;
        background: #afadad;
      }
      .price-detail {
        border: 0 !important;
        position: relative;
      }
      body{
        overflow-x: hidden;
      }
      a.category_item {
        border-radius: 30%;
        padding: 12px 7px;
        margin-left: 8px;
        background: white;
        color: black;
      }
       .addres_shop .item_address:first-child {
        overflow-y: scroll;
        height: 659px;
    }
    .avatar-name-fword img,.user-cmt-avat img{
      margin: 0!important;
    }

    </style>

    <script type="text/javascript">
      $(document).ready(function () {
        if(screen.width>992){
            // console.log($(".box-widget5 .col-right").height());
            $(".box-widget5 .widget-product-detail").css("max-height",$(".box-widget5 .col-right").height());
          }

          $('.addtocart').click(function () {
            qty = parseInt($('#qty').val());
            if(qty > 0) {
             $(this).attr('href', '<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'], 'qty' => '')); ?>/'+qty);
           }
         });
          $(".showall").click(function(){
            $(this).addClass("hidden");
            $("li.hidden").each(function(){
              $(this).removeClass("hidden");
            })
          })
        });
      </script>
