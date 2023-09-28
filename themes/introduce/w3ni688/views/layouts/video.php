<?php $this->beginContent('//layouts/main'); ?>
     <div class="page-video">
          <div class="box-banner-video">
               <div class="container clearfix">
                    <?php
                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_LEFT_OUT));
                    ?>
               </div>
               <div class="box-content-video clearfix">
                    <div class="container">
                         <div class="cont-main video-content">
                              <?php
                              echo  $content;
                              $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER));
                              ?>
                         </div>
                    </div>
               </div>
          </div>
     </div>
<style>
    .col-video img {
        width: 100%;
        margin: 0;
    }
    .content-lv .row-lv .col-lv-2 {
        margin-bottom: 25px;
    }
    .col-video {
        height: 140px;
    }
    ul.W3NPager {
        margin-top: 0;
        margin-bottom: 30px;
        float: left;
    }
</style>
<?php $this->endContent(); ?>
