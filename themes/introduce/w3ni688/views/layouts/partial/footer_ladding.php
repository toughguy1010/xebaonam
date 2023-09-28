<footer>
	<div class="footer_top">
		<div class="container">
			<div class="row">
				<?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_MAIN_CONTENT)); ?>
			</div>
		</div>
	</div>
	<div class="footer_center">
		<div class="container">
			<div class="row">
				<?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_RATING)); ?>
			</div>
		</div>
	</div>
</footer>
<style>
    .title_you {
        position: absolute;
        top: 10px;
        left: 15px;
        color: #fff;
        font-size: 20px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
        overflow: hidden;
        text-shadow: 0 0 9px black;
    }
    .img_youtube {
        position: relative;
    }
    .img_youtube img {
        width: 100%;
        margin: 0;
    }

    .img_youtube:hover .ytp-large-play-button-bg {
        -moz-transition: fill .1s cubic-bezier(0.0, 0.0, 0.2, 1), fill-opacity .1s cubic-bezier(0.0, 0.0, 0.2, 1);
        -webkit-transition: fill .1s cubic-bezier(0.0, 0.0, 0.2, 1), fill-opacity .1s cubic-bezier(0.0, 0.0, 0.2, 1);
        transition: fill .1s cubic-bezier(0.0, 0.0, 0.2, 1), fill-opacity .1s cubic-bezier(0.0, 0.0, 0.2, 1);
        fill: #f00;
        fill-opacity: 1;
    }

    .img_youtube svg {
        position: absolute;
        width: 65px;
        left: 0;
        z-index: 9999;
        height: 48px;
        top: 40%;
        right: 0;
        margin: 0 auto;
        cursor: pointer;
    }
</style>


<script>
    $('.img_youtube').click(function () {
        var link_vd = $(this).attr('data-link');
        var height = $(this).attr('data-height');
        if (link_vd) {
            $(this).html('<iframe src="' + link_vd + '?&autoplay=1" width="100%" height="' + height + '" frameborder="0" style="border:0" allowfullscreen></iframe>');
            return false;
        }
    });
    $(function () {
        $('.img-lazyy').lazy();
    });
</script>