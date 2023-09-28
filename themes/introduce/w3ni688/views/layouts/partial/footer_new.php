<?php
	$themUrl = Yii::app()->theme->baseUrl;
	$cs = Yii::app()->getClientScript();
	Yii::app()->clientScript->registerCoreScript('jquery');
	$vs = '1.1.8';
	?>
<footer>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<div class="item">
						<h2>Xebaonam.com</h2>
						<div class="list_car">
							<a>Xe Bảo Nam</a>
							<a>Xe Bảo Nam</a>
							<a>Xe Bảo Nam</a>
							<a>Xe Bảo Nam</a>
							<a>Xe Bảo Nam</a>
						</div>
						<div class="call_phone">
							<p>Gọi mua xe:</p>
							<p>Hà Nội:09779.66.22.88 - 0977.66.33.11</p>
							<p>Tp.Hồ Chí Minh :0339.66.22.88</p>
							<p>Email: Xebaonam@gmail.com</p>
							<p>Bank: Ngân hàng Techcombank - CN Hà Tây - Tp. Hà Nội</p>
							<p>Chủ tài khoản: Trần Văn Phái</p>
							<p>Số tài khoản: 19032755520012</p>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<div class="item">
						<h3>Hỗ trợ khách hàng</h3>
						<div class="list_car list_carv">
							<a>Chính sách bảo hành - đổi trả</a>
							<a>Hướng dẫn thanh toán mua hàng</a>
							<a>Hướng dẫn đăng ký xe điện </a>
							<a>Tháo dây hạn chế tốc độ xe điện</a>
							<a>Hướng dẫn sử dụng xe điện </a>
							<a>Các câu hỏi thường gặp</a>
							<a>Chính sách bảo mật thông tin </a>
						</div>
						<div class="ms">
							<p>MST: 0107707955</p>
							<p>Ngày cấp: 0107707955</p>
							<p>Nơi cấp: 0107707955</p>
							<p>Kinh doanh - Sở Kế hoạch và đầu tư Tp. Hà Nội</p>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<div class="item">
						<h3>Đăng kí nhận tin khuyến mãi</h3>
						<form>
							<input type="text" name="" placeholder="Email">
							<button type="submit">Đăng ký</button>
						</form>
						<h3>Đăng kí nhận tin khuyến mãi</h3>
						<div class="list_img">
							<a href=""> <img src="<?php echo $themUrl ?>/css/home/images/dk.png"></a>
							<a href=""> <img src="<?php echo $themUrl ?>/css/home/images/bm.png"></a>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<div class="item">
						<img src="<?php echo $themUrl ?>/css/home/images/img.png">
						<img src="<?php echo $themUrl ?>/css/home/images/img1.png">
						
					</div>
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