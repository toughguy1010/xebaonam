<?php if (count($videos)) { ?>
<div class="video_main_mobile">
	<div class="title_list_car">
		<h2>
			<a href="https://xebaonam.com/video-hot">
				<span>Video</span>
			</a>
		</h2>
	</div>
	<div class="video_mbile">
		<?php foreach ($videos as $video) { ?>
		<iframe width="100%" height="315" src="<?php echo $video['video_embed']; ?>?autohide=1" frameborder="0" allowfullscreen="">
		</iframe>
		<div class="text">
			<a><h2><?php echo $video['video_title']; ?></h2></a>
		</div>
		<?php break;} ?>
	</div>
	<div class="list-video-mobile clear-float">
		<?php 	$i=0; 
				foreach ($videos as $video) 
				{$i++;if ($i>1) 
					{?>
						<div class="item-video " data_src="<?php echo $video['video_embed']; ?>">
							<div class="video-scroll" >
								<img src="<?php echo ClaHost::getImageHost() . $video['avatar_path'] . 's280_280/' . $video['avatar_name'] ?>" alt="">
							</div>
							<div class="title-video-scroll" data_src="<?php echo $video['video_embed']; ?>">
								<a href="#"><h2><?php echo $video['video_title']; ?></h2></a>
							</div>
						</div>
			<?php } } ?>
		<div class="clear"></div>
	</div>
</div>
<?php } ?>

<script type="text/javascript">
	$(document).ready(function(){
		$(".list-video-mobile .item-video").each(function(){
			$(this).click(function(){
				$(".video_mbile iframe").attr("src",$(this).attr("data_src"));
				return false;
			});
		});
	});
</script>



