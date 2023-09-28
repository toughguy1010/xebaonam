<div id="footer">
    <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER_BLOCK5)); ?>
    <?php //$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK14)); ?>
    <?php //$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK15)); ?>
    <footer style="margin-bottom: 90px;">
            <div class="hot_line_mobile">
                <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK20)); ?>
               
            </div>
            <div class="hot_line_mobile_center">
                <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK19)); ?>
                
            </div>
            <div class="address_mobile">
                 <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK17)); ?>
                
            </div>
        </footer>
    
  <!--   <div class="box-nav">
        <div class="subother clearfix">
            <?php //$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER_BLOCK7)); ?>
        </div>
    </div> -->
    <!--    <a href="#" title="#" class=""><span>Về đầu trang</span></a>-->
</div>
<div class="callus echbay-alo-phone phonering-alo-phone phonering-alo-green style-for-position-bl">
    <a class="hotline_text1" href="tel:<?=Yii::app()->siteinfo['admin_phone']?>" onclick="gtag_report_conversion('tel:<?=Yii::app()->siteinfo["admin_phone"]?>')">
        <div class="phonering-alo-ph-circle"></div> 
        <div class="phonering-alo-ph-circle-fill"></div> 
        <div class="phonering-alo-ph-img-circle">
        </div> 

    </a>
</div>
 <?php $phone=explode(',',Yii::app()->siteinfo['phone']);?>
<div class="fixed-footer">
    <ul>
        <li>
            <a href="tel:<?=Yii::app()->siteinfo['admin_phone']?>" onclick="gtag_report_conversion('tel:<?=$phone[0];?>')"><?=Yii::app()->siteinfo['admin_phone']?></a>
        </li>
        <li>
            <a href="<?=Yii::app()->createUrl('site/site/contact')?>">Đăng ký ngay</a>
        </li>
    </ul>
</div>
<!-- Cắm popup  -->
<?php
$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_QUESTION));
?>

<div class="chat">
    <div class="phone_call">
         <a href="tel:<?=$phone[0];?>" target='_blank' onclick="gtag_report_conversion('tel:<?=$phone[0];?>')"><span></span></a>
        <span>Gọi nữa</span>
    </div>
    <div class="fb_f">
        <a href="https://www.facebook.com/xebaonam/" target='_blank'><span></span></a>
        <span>Messenger</span>
    </div>
    <div class="zalo_f">
        <a href="https://zalo.me/0979662288" target='_blank'><span></span></a>
        <span>Zalo</span>
    </div>
</div>
