
<?php
    $themUrl = Yii::app()->theme->baseUrl;
    ?>
<p id="bttop" class="scroll-top-btn" style="display: block;">
    <a style="cursor: pointer;" title="Về đầu trang">
        <span>
        </span>
    </a>
</p>
<?php
    $themUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    Yii::app()->clientScript->registerCoreScript('jquery');
    $vs = '1.1.8';
    ?>
<footer>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                     <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER_BLOCK1)); ?>
                    
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER_BLOCK3)); ?>
                    
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER_BLOCK2)); ?>
                    
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="item">
                        <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER_BLOCK7)); ?>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <style type="text/css">
        .addres_shop .item_address:first-child {
        overflow-y: scroll;
        height: 580px;
    }
    </style>
 <!-- Cắm popup  -->
  <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_QUESTION));
    ?>
 <?php $phone=explode(',',Yii::app()->siteinfo['phone']);?>
 <div class="callus_fix"><i class="i_phone"><span style="display:none;">.</span></i><a href="tel:<?= $phone[0];?>" 
    onclick="gtag_report_conversion('tel:<?=$phone[0];?>')">HOTLINE : <?= $phone[0];?></a></div>