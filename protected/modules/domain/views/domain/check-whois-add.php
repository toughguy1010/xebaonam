<?php if($start <= count($list)) { 
	$start_check = $start+1;
	if($domain) {
		while ($start_check >= $start && $start < count($list)) { 
			$ext_check = $list[$start++];
			if($ext_check != $ext) {
				$domain_check = $domain.'.'.$ext_check;
		        $check = ApiPavietnam::checkWhoIs($domain_check);
		        switch ($check ) {
		            case '0': ?>
		                <div class="error-buy">
		                    <p class="show-dom">
		                        <i class="xsx">x</i>
		                        <?= $domain_check ?>
		                        <span class="open-info-domain btn-right click" domain="<?= $domain_check ?>" id="domain-load-fisrt">Xem whois</span>
		                    </p>
		                </div>
		               <?php break;
		            case '1': ?>
		                <div class="success-buy">
		                    <p class="show-dom">
		                        <i class="xsx">v</i>
		                        <?= $domain_check ?>
		                        <span class="btn-center">
		                            750.000 VNĐ/năm
		                        </span>
		                        <span class="btn-right click">Đăng ký mua</span>
		                    </p>
		                </div>
		               <?php break;
		       }
		    }
	    } ?>
		<script type="text/javascript">
	        $(document).ready(function () {
	            loadAjaxAppend('<?= Yii::app()->createUrl('/domain/domain/getviewAdd'); ?>', {domain : '<?= $domain ?>', start : '<?= $start ?>'}, $('#box-view-add'));
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