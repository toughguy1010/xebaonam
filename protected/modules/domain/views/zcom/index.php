<link rel="stylesheet" type="text/css" href="<?= Yii::app()->theme->baseUrl ?>/css/fix.css">
<style type="text/css">
</style>
<div class="domain-check" style="padding-bottom: 40px">
	<h2 class="title" style="font-size: 20px;">Bạn đã sở hữu tên miền mang thương hiệu của riêng bạn. Hãy kiểm tra và mua ngay trước khi có ai đó mua.</h2>
    <div class="search">
        <form class="search_c general_search" >
            <input type="text" required name="domain" minlength=2 placeholder="Nhập tên miền bạn muốn đăng ký">
            <button>Kiểm tra</button>
        </form>
    </div>
	<div class="list-domain-price">
		<div class="box-list">
			<?php if($list_sale) foreach ($list_sale as $tld) { 
				$prar = ApiZcom::getWhoIsPrice($tld, 1);
				if(isset($prar['UnitPrice']) && $prar['UnitPrice'] > $prar['ResellerPrice']) {
					$price = round($prar['ResellerPrice']/1000);
					$sale = round($prar['UnitPrice']/1000);
    				?>
	    			<div class="item">
	    				<span class="dmn">.<?= $tld ?></span>
	    				<div class="prb">
	    					<span class="prd"><?= number_format($price, 0, ',', '.') ?>k</span>
	    					<span class="dmu">VND</span>
	    				</div>
	    				<div class="prs">
	    					&ensp;
	    					<span class="prd"><?= number_format($sale, 0, ',', '.') ?>k</span>
	    					<span class="dmu">VND</span>
	    					&ensp;
	    				</div>
	    			</div>
				<?php }
			} ?>
		</div>
	</div>
	<div class="image-view" style="margin-top: 40px;">
		<img src="https://domain.z.com/vn/wp-content/themes/zcom_domain_v.1.0/vn_page/images/top_banner/freessl_update.png">
	</div>
	<div class="price-all">
		<h2 class="title">Bảng giá tên miền</h2>
		<div  id="load-price-all">
			<div class="center" >
                <img src="<?= Yii::app()->homeUrl ?>images/ajax-loader.gif" />
            </div>
			<script type="text/javascript">
				$(document).ready(function () {
					loadAjax('<?= Yii::app()->createUrl('/domain/zcom/loadPriceAll'); ?>', {}, $('#load-price-all'));
				});
			</script>
		</div>
	</div>
	<div class="search">
        <form class="search_c general_search" >
            <input type="text" required name="domain" minlength=2 placeholder="Nhập tên miền bạn muốn đăng ký">
            <button>Kiểm tra</button>
        </form>
    </div>
</div>
