<?php if (isset($data) && count($data)) {?>
	<div class="related_sport">
		<?php if ($show_widget_title) { ?>
            <h2><?php echo $widget_title ?></h2>
        <?php } ?>
		<div class="grid_flex_teck wow fadeInUp">
			<?php foreach ($data as $menu_id => $menu) {$m_link = $menu['menu_link'];?>
				<div class="item_related">
					<div class="img">
						<a href="<?= $m_link?>"><img src="<?php echo ClaHost::getImageHost() . $menu['background_path'] . 's400_400/' . $menu['background_name']; ?>" alt=" <?php echo $menu['menu_title']; ?>" /></a>
					</div>
					<div class="content">
						<a href="<?= $m_link?>"><h3> <?php echo $menu['menu_title']; ?></h3></a>
						 <?php echo $menu['description']; ?>
					</div>
				</div>
			<?php }?>
		</div>
	</div>
</div>
<?php }?>