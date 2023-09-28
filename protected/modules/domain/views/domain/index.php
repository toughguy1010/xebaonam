<div>
    <hr/>
    <div class="container" style="padding: 40px 0px;">
        <div class="search">
            <form class="search_c general_search" >
                <input type="text" name="domain" placeholder="Nhập tên miền" value="<?= isset($_GET['domain']) ? $_GET['domain'] : 'chiencong.com' ?>">
                <button>Tìm kiếm</button>
            </form>
        </div>
        <div class="content">
            <?php
            if($domain) {
                switch ($check ) {
                    case '0': ?>
                        <div class="error-buy">
                            <p class="notifi">
                                <span class="t-1">Rất tiếc!</span>
                                <span class="t-2"><span>Tên miền <b><?= $domain ?></b></span> đã có chủ sở hữu.</span>
                            </p>
                            <p class="show-dom">
                                <i class="xsx">x</i>
                                <?= $domain ?>
                                <span class="open-info-domain btn-right click" domain="<?= $domain ?>" id="domain-load-fisrt">Xem whois</span>
                            </p>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                domain = $('#domain-load-fisrt').attr('domain');
                                $('#domain-load-fisrt').attr('load', '1');
                                loadAjax('<?= Yii::app()->createUrl('/domain/domain/getWhois'); ?>', {domain : domain, first : true}, $('#info-whois'));
                            });
                        </script>
                       <?php break;
                    case '1': ?>
                        <div class="success-buy">
                            <p class="notifi">
                                <span  class="t-1">Tuyệt vời! </span>
                                <span  class="t-2">Bạn có thể mua tên miền này. Hãy mua tên miền ngay trước khi người khác mua mất</span>
                            </p>
                            <p class="show-dom">
                                <i class="xsx">v</i>
                                <?= $domain ?>
                                <span class="btn-center">
                                    750.000 VNĐ/năm
                                </span>
                                <span class="btn-right click">Đăng ký mua</span>
                            </p>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                domain = $('#domain-load-fisrt').attr('domain');
                                loadAjaxAppend('<?= Yii::app()->createUrl('/domain/domain/getviewAdd'); ?>', {domain : domain, start : '<?= $start ?>'}, $('#box-view-add'));
                            });
                        </script>
                       <?php break;
               }
            } ?>
        </div>  
        <div class="box-view-add" id="box-view-add">
            <h2>Tham khảo các tên miền khác:</h2>
        </div>
        <div class="center" id="waiting-load-add">
        </div>
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
            loadAjax('<?= Yii::app()->createUrl('/domain/domain/getWhois'); ?>', {domain : domain}, $('#info-whois'));
        }
        $('.box-flex-info-whois').addClass('active');
    });
    $(document).on('click', '.close-info-whois', function() {
        $('.box-flex-info-whois').removeClass('active');
    });
</script>
<style type="text/css">
	.box-info-whois > img {
		margin-top: 20px;
	}
	.loadAjax {
		display: none !important;
	}
	.box-flex-info-whois {
	    position: fixed;
	    z-index: 1;
	    width: 80%;
	    max-width: 800px;
	    height: 80vh;
	    top: 20px;
	    right: 0px;
	    left: 0px;
	    margin: auto;
	    background: #fff;
	    border: 1px solid #ebebeb;
	    display: none;
	}
	.box-flex-info-whois.active {
	    display: block;
	}
	.box-in {
	    position: relative;
	    height: 100%;
	    background: #ebebeb14;
	}
	.box-info-whois{
	    height: 100%;
	    overflow: auto;
	    padding: 0px 20px;
	    /*width: calc(100% + 20px);*/
	}
	.close-info-whois {
	    cursor: pointer;
	    position: absolute;
	    display: inline-block;
	    right: -1px;
	    top: -1px;
	    padding: 5px 13px;
	    font-size: 22px;
	    border: 1px solid #ebebeb;
	    color: red;
	    font-weight: bold;
	    background: #fff;
	}
	.box-info-whois h2 {
	    font-size: 22px;
	}
	.box-info-whois table{
	    margin-top: 20px;
	}
	.box-info-whois td:first-child {
	    width: 200px;
	}
	.box-info-whois td {
	    height: 32px;
	}
	ul.info-whois li{
	    list-style: none;
	    min-height: 32px;
	}
	ul.info-whois li span {
	    display: inline-block;
	    height: 100%;
	}
	ul.info-whois li span.title {
	    width: 400px;
	    float: left;
	}
	.click {
		cursor: pointer;
	}
	form.search_c.general_search {
		margin-top: 20px;
	}
	form.search_c.general_search input {
	    height: 45px;
	    border: 1px solid #EBEBEB;
	    padding-left: 15px;
	    font-size: 14px;
	    color: #9A9A9A;
	    width: 60%;
	    float: left;
	}

	form.search_c button {
	    height: 45px;
	    line-height: 45px;
	    width: 100px;
	    margin-left: 10px;
	    top: 0px;
	    background: #E53935;
	    text-align: center;
	    font-weight: normal;
	    line-height: normal;
	    font-size: 18px;
	    border: none;
	    color: #FFFFFF;
	}
	.notifi {
		margin-top: 20px;
		font-size: 18px;
	}
	.show-dom {
		padding: 20px 5px;
	    font-size: 23px;
	    border: 1px solid #ebebeb;
	}
	.show-dom .btn-right {
		padding: 8px 18px;
	    font-size: 14px;
	    text-transform: uppercase;
	    border: 1px solid #ebebeb;
	    float: right;
	    margin-right: 10px;
	}
	.t-1 {
		font-weight: bold;
	}
	.error-buy .show-dom, .error-buy .t-1{
		color: red;
	}

	.success-buy .show-dom, .success-buy .t-1{
		color: green;
	}
	.error-buy .btn-right {
	    background: #bbb;
		color: #fff;
	}
	.show-dom > i{
		border: 1px solid;
	    border-radius: 50%;
	    font-style: normal;
	}
	.error-buy .show-dom > i{
	    padding: 0px 6px 2px 7px;
	    font-size: 20px;
	}
	.success-buy .show-dom > i{
	    padding: 0px 6px 2px 7px;
	    font-size: 20px;
	}

	.success-buy .btn-right {
		background: green;
		color: #fff;
	}
	.success-buy .btn-center{
		float: right;
	    margin-left: 15px;
	    font-size: 20px;
	    margin-top: 8px;
	    margin-right: 15px;
	    text-transform: uppercase;
	    color: #000;
	}
	.box-view-add h2{
		font-size: 20px;
	}
</style>