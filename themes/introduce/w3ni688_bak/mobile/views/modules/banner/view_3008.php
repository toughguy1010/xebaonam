<?php if (count($banners)) {?>
	<div class="popup_banner active">
		<?php foreach ($banners as $banner) {?>
			<div class="content_popup">
				<div class="centert">
					<i class="fa fa-times close_poup" aria-hidden="true"></i>
					<a href="<?php echo $banner['banner_link'] ?>"><img src="<?php echo $banner['banner_src'] ?>" alt="" /></a>
				</div>
				
			</div>
		<?php } ?>
	</div>
	
<?php } ?>
<style type="text/css">
	.popup_banner{
		position: fixed;
		width: 100%;
		height: 100%;
		z-index: -1;
		display: none;
		background: red;
		top: 0;
		left: 0;
		background: #dad6d67d;
	}
	.popup_banner.active{
		z-index: 999999;
		display: block;
	}
	.popup_banner .content_popup{
		display: flex;
		align-items: center;

		height: 100%
	}
	.popup_banner .centert{
		position: relative;
		width: 560px;
		max-width: 90%;
		margin: 0 auto;
	}
	.popup_banner .centert i{
		position: absolute;
		right: -13px;
		top: -19px;
		font-size: 30px;
		cursor: pointer;
		color: red;

	}
	.popup_banner .centert img{
		width: 100%;

	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$(".close_poup").click(function(){
			$('.popup_banner').removeClass('active');
		});
	});
</script>