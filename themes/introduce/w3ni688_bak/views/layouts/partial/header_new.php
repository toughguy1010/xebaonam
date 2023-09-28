<?php 
$site_info = Yii::app()->siteinfo;
?>
<!--  POS_TOP POS_BANNER_MAIN_MOBILE POS_RATING_MOBILE --POS_SEARCH_BOX_MOBILE_V1-- POS_MENU_MAIN_MOBILE -->
	<!-- header -->
	<header>
		<div class="container container_header">
			<div class="header_top">
				<div class="logo">
					<!-- Cắm html -->
					  <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_TOP)); ?>
					
					
				</div>
				<div class="search_box">
					<?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_SEARCH_BOX_MOBILE)); ?>
					
				</div>
				<div class="menu_pc menu_main">
					<?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_MENU_MAIN_MOBILE)); ?>
					
				</div>
			</div>
		</div>
	</header>