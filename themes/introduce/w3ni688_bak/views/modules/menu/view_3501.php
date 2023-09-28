


<ul> 
	<?php foreach ($data as $key => $menu) { ?>
	<li>
		  <a  href="<?= $menu['menu_link'] ?>" <?= $menu['target'] ?>><?= $menu['menu_title'] ?></a>
		<?php if ($menu['items'] && count($menu['items'])) { ?>
		<ul>
			<?php foreach ($menu['items'] as $key => $menu2) { ?>
			<li>
				<a href="<?= $menu2['menu_link'] ?>" <?= $menu2['target'] ?>>
				  <?php if ($menu2['items'] && count($menu2['items'])) { ?>
				<ul>
					<?php foreach ($menu2['items'] as $key => $menu3) { ?>
					<li><a href="<?= $menu3['menu_link'] ?>"><?= $menu3['menu_title'] ?></a></li>
					<?php } ?>
				</ul>
				<?php } ?>
			</li>
			<?php } ?>
			
		</ul>
		<?php }?>
	</li>
	<?php }?>
	
</ul>