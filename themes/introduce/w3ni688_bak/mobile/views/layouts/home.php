<?php
$this->beginContent('//layouts/main');
?>
<style type="text/css">
	#main{
		padding-top: 0px;
	}
</style>
<!-- main -->
        <div class="main">

            
            <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_HEADER_BOTTOM)); ?>
            
        </div>
    <!-- <div id="tin-tuc">
        <?php //$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_HEADER_BOTTOM)); ?>
    </div>

<div class="menu-bottom-main">
    <ul class="clearfix">
        <?php //$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK6)); ?>
    </ul>
</div>
<div class="menu-bottom-main menu-bottom-main1">
    <ul class="clearfix">
        <?php //$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK11)); ?>
    </ul>
</div> -->
<?php
echo $content;
$this->endContent();
