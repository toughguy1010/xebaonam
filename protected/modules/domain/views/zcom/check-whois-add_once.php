<?php if($start <= count($list)) { 
	$start_check = $start+1;
	if($domain) {
		while ($start_check > $start && $start < count($list)) { 
			$tld_check = $list[$start++];
			if($tld_check != $tld) {
				$tld_check = substr($tld_check, 0, 1) == '.' ? substr($tld_check, 1) : $tld_check;
				$domain_check = $domain.'.'.$tld_check;
		        $check = ApiPavietnam::checkWhoIs($domain_check);
		        switch ($check ) {
		            case '0': ?>
		                <div class="error-buy">
		                    <p class="show-dom">
		                        <i class="xsx">x</i>
		                        <?= $domain_check ?>
		                        <span class="open-info-domain btn-right click" domain="<?= $domain_check ?>" >Xem whois</span>
		                    </p>
		                </div>
		               <?php break;
		            case '1': ?>
		                <div class="success-buy">
		                    <p class="show-dom">
		                        <i class="xsx">v</i>
		                        <?= $domain_check ?>
		                        
		                        <a class="btn-price" href="<?= Yii::app()->createUrl('/domain/zcom/registerDomain',['domain' => $domain_check]); ?>">
                                	<span class="btn-right click">Đăng ký mua</span>
                                </a>
                                <span class="btn-center">
		                            <?php 
                                    	$price =0; // ApiZcom::getWhoIsPrice('.'.$tld_check, 1);
                                    	echo ($price !== false && isset($price['ResellerPrice'])) ? number_format($price['ResellerPrice'], 0, ',', '.').' VNĐ/năm' : 'Giá liên hệ';
                                    ?>
		                        </span>
		                        <?php if(isset($price['UnitPrice']) && isset($price['ResellerPrice']) && ($price['UnitPrice'] > $price['ResellerPrice'])) { ?>
			                        <span class="btn-center sale-before">
			                            <?php 
	                                    	echo number_format($price['UnitPrice'], 0, ',', '.');
	                                    ?>
			                        </span>
			                    <?php } ?>
		                    </p>
		                </div>
		               <?php break;
		       }
		    }
	    } ?>
		<script type="text/javascript">
	        $(document).ready(function () {
	            loadAjaxAppend('<?= Yii::app()->createUrl('/domain/zcom/getviewAdd'); ?>', {domain : '<?= $domain.'.'.$tld ?>', start : '<?= $start > $start_check ? $start : $start_check ?>'}, $('#box-view-add'));
	        });
	    </script>
	<?php }
} else { ?>
	<script type="text/javascript">
		$(document).ready(function () {
	        $('#waiting-load-add').html('');
	    });
    </script>
<?php } ?>