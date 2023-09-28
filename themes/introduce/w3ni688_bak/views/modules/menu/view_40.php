



<div class="menu_left">
	<h3><i class="fa fa-bars" aria-hidden="true"></i><span>Danh mục sản phẩm</span><i class="fa fa-sort-desc" aria-hidden="true"></i></h3>
	<ul>
		<?php foreach ($data as $menu_id => $menu) {?>
			<li>
				<a href="<?= $menu['menu_link'] ?>">
					<img src="<?= ClaHost::getImageHost() . $menu['icon_path'] . $menu['icon_name'] ?>"><?= $menu['menu_title']; ?>  <i class="fa fa-caret-right" aria-hidden="true"></i></a>
					<?php if ($menu['items']) { ?>
						
						<div class="list_menu_v2">
							<?php foreach ($menu['items'] as $menu_child) {?>
								<div class="item_v1">
									<a href="<?= $menu_child['menu_link'] ?>"><h4><?= $menu_child['menu_title'];?>
									</h4></a>
										<?php if ($menu_child['items']) { ?>
											<ul>
												<?php foreach ($menu_child['items'] as $menu_child1) {?>
													<li><a href="<?= $menu_child1['menu_link'] ?>"><?= $menu_child1['menu_title']; ?></a></li>
												<?php }?>
											</ul>
										<?php }?>
									</div>
								<?php }?>
							</div>
							
						<?php }?>
					</li>
				<?php }?>

			</ul>
		</div>