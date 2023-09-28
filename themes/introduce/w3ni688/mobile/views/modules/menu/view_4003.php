<?php if (isset($data) && count($data)) { ?>
	<ul>
		<?php $i=0; foreach ($data as $menu_id => $menu) { $i++; ?>
			<li class="<?=($i==1) ? "active" : "";?>">
				<a data-id="<?=$menu['description']?>" href="javascript:void(0);"><?=$menu['menu_title']?></a>
			</li>

		<?php } ?>
	</ul>
<?php } ?>