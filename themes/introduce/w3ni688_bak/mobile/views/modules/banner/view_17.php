<?php if (count($banners)) { ?>
     <div id="footer_popup_left">
          <div class="footer_popup_left_close">
               <button type="button" class="close_popup_left"><span aria-hidden="true">&times;</span></button>
               <!--<h4 class="modal-title" id="myModalLabel"></h4>-->
          </div>
          <div class="banner-cont">
               <?php
               foreach ($banners as $banner) {
                    $height = $banner['banner_height'];
                    $width = $banner['banner_width'];
                    $src = $banner['banner_src'];
                    $link = $banner['banner_link'];
                    if ($banner['banner_type'] == Banners::BANNER_TYPE_IMAGE) {
                         ?>
                         <a href="<?php echo $link ?>" title="<?php echo $banner['banner_name']; ?>" target="_blank">
                              <img src="<?php echo $src; ?>" <?php if ($height) { ?> height="<?php echo $height ?>" <?php } if ($width) { ?> width="<?php echo $width; ?>" <?php } ?> alt="<?php echo $banner['banner_name']; ?>"/>
                         </a>
                         <?php
                    }
               }
               ?>
          </div>
     </div>
     <script>
         function setCookie(key, value) {
             var expires = new Date();
             expires.setTime(expires.getTime() + (1 * 1 * 30 * 60 * 1000));
             document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
         }

         function getCookie(key) {
             var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
             return keyValue ? keyValue[2] : null;
         }
         $('document').ready(function () {
             var has_cookie_popup = getCookie('popup');
             if (has_cookie_popup) {
                 $('#footer #footer_popup_left').modal('hide');
             } else {
                 setCookie('popup', 1);
                 $('#footer #footer_popup_left').modal('show');
             }
             ;
             $("#footer #footer_popup_left .footer_popup_left_close .close_popup_left").on("click", function () {
                 $("#footer #footer_popup_left").hide();
             });
         });
     </script>
     <?php
} 