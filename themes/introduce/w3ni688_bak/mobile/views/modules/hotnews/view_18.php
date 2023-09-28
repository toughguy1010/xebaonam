<div class="hot-new">

	<?php if ($show_widget_title) { ?>
	<div class="title_list_car">
		<h2>
			<a href="https://xebaonam.com/tin-tong-hop-nc,6622">
				<span><?php echo $widget_title ?></span>
			</a>
		</h2>
	</div>
	<?php } ?>
	<div class="container clear-float">
		<?php foreach ($hotnews as $news) { ?>
		<div class="item_customer_mobile">
			<div class="img">
				<a href="<?php echo $news['link']; ?>" title="<?php echo $news['news_title']; ?>">
					<img src="<?php echo ClaHost::getImageHost() . $news['image_path'] . 's400_400/' . $news['image_name']; ?>" alt="<?php echo $news['news_title']; ?>" />
				</a>
			</div>
			<div class="text">
				<a href="<?php echo $news['link'] ?>" title="<?php echo $news['news_title']; ?>">
					<h2> <?php echo $news['news_title']; ?> </h2>
				</a>
			</div>
		</div>
		<?php break;} ?>
		<?php $i=0; foreach ($hotnews as $news)  {$i++; if($i>1) { ?>
		<div class="list-hot-new">
			<div class="short-info">
				<h3><a href="<?php echo $news['link']; ?>"><?php echo $news['news_title']; ?></a></h3>
				<div class="time">
					<span> <?= date('y-m-d h:i:s', $news['publicdate']) ?></span>
					<span>
						<a href=""> Tin tức </a>
					</span>
				</div>
			</div>
			<div class="img">
				<a href="<?php echo $news['link']; ?>" title="<?php echo $news['news_title']; ?>">
					<img src="<?php echo ClaHost::getImageHost() . $news['image_path'] . 's100_100/' . $news['image_name']; ?>" alt="<?php echo $news['news_title']; ?>" />
				</a>
			</div>
		</div>
		<?php } } ?>
		<div class="clear">

		</div>
	</div>
</div>