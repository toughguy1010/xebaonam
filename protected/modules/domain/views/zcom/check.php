<link rel="stylesheet" type="text/css" href="<?= Yii::app()->theme->baseUrl ?>/css/fix.css">
<div>
    <div class="container" style="padding-bottom: 40px">
    	<h2 class="title" style="font-size: 20px;">Bạn đã sở hữu tên miền mang thương hiệu của riêng bạn. Hãy kiểm tra và mua ngay trước khi có ai đó mua.</h2>
        <div class="search">
            <form class="search_c general_search" >
                <input type="text" required name="domain" minlength=2 placeholder="Nhập tên miền bạn muốn đăng ký" value="<?= isset($_GET['domain']) ? $_GET['domain'] : '' ?>">
                <button>Kiểm tra</button>
            </form>
        </div>
        <div class="content">
            <?php  
            switch ($check ) {
                case '0': ?>
                    <div class="error-buy">
                        <p class="notifi">
                            <span class="t-1">Rất tiếc!</span>
                            <span class="t-2"><span>Tên miền <b><?= $domain ?></b></span> đã có chủ sở hữu.</span>
                        </p>
                        <p class="show-dom">
                            <i class="xsx"></i>
                            <?= $domain ?>
                            <span class="open-info-domain btn-right click" domain="<?= $domain ?>" id="domain-load-fisrt">Xem whois</span>
                        </p>
                    </div>
                   <?php break;
                case '1': ?>
                    <div class="success-buy">
                        <p class="notifi">
                            <span  class="t-1">Tuyệt vời! </span>
                            <span  class="t-2">Bạn có thể mua tên miền này. Hãy mua tên miền ngay trước khi người khác mua mất</span>
                        </p>
                        <p class="show-dom">
                            <i class="xsx"></i>
                            <?= $domain ?>
                            <span class="btn-center">
                                <?php 
                                	$price = ApiZcom::getWhoIsPrice($tld, 1);
                                	echo ($price !== false && isset($price['ResellerPrice'])) ? number_format($price['ResellerPrice'], 0, ',', '.').' VNĐ/năm' : 'Giá liên hệ';
                                ?>
                            </span>
                            <a href="<?= Yii::app()->createUrl('/domain/zcom/registerDomain',['domain' => $domain]); ?>">
                            	<span class="btn-right click">Đăng ký mua</span>
                            </a>
                        </p>
                    </div>
                   <?php break;
                default: ?>
                    <p class="notifi">
                        <span  class="t-1">Lỗi! </span>
                        <span  class="t-2">Có lỗi xảy ra trong quá trình kiểm tra. Vui lòng kiểm tra lại thông tin.</span>
                    </p>
            <?php }   ?>
        </div>  
        <div class="box-view-add" id="">
            <h2>Tham khảo các tên miền khác:</h2>
        </div>
        <div id="box-all-iadd">
        	<div class="center" >
                <img src="<?= Yii::app()->homeUrl ?>images/ajax-loader.gif" />
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                domain = '<?= $domain ?>';
                loadAjax('<?= Yii::app()->createUrl('/domain/zcom/getviewAdd'); ?>', {domain : domain, start : 0}, $('#box-all-iadd'));
            });
       </script>
    </div>
</div>
<div class="box-flex-info-whois">
    <div class="box-in">
        <span class="close-info-whois">x</span>
        <div class="box-info-whois"  id="info-whois">
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '.open-info-domain', function() {
        domain = $(this).attr('domain');
        if($(this).attr('load') != '1') {
            $('.open-info-domain').attr('load', '0');
            $(this).attr('load', '1');
            $('#info-whois').html('<img src="<?= Yii::app()->homeUrl ?>images/ajax-loader.gif" />');
            loadAjax('<?= Yii::app()->createUrl('/domain/zcom/getWhois'); ?>', {domain : domain}, $('#info-whois'));
        }
        $('.box-flex-info-whois').addClass('active');
    });
    $(document).on('click', '.close-info-whois', function() {
        $('.box-flex-info-whois').removeClass('active');
    });
    $(document).on('click', '#view-other', function () {
    	if($(this).attr('status') != '1') {
    		$(this).attr('status', '1');
	        domain = '<?= $domain ?>';
	        loadAjax('<?= Yii::app()->createUrl('/domain/zcom/getviewAddOther'); ?>', {domain : domain, start : 0}, $('#box-view-add-other'));
	    }
    });
</script>