<?php
    if($checks) foreach ($checks as $check) {
        $tld_check = $check['tld'];
        if($tld_check != $tld) {
            $domain_check = $domain.'.'.$tld_check;
            switch ($check['status']) {
                case '0': ?>
                    <div class="error-buy">
                        <p class="show-dom">
                            <i class="xsx"></i>
                            <?= $domain_check ?>
                            <span class="open-info-domain btn-right click" domain="<?= $domain_check ?>" >Xem whois</span>
                        </p>
                    </div>
                   <?php break;
                case '1': ?>
                    <div class="success-buy">
                        <p class="show-dom">
                            <i class="xsx"></i>
                            <?= $domain_check ?>
                            
                            <a class="btn-price" href="<?= Yii::app()->createUrl('/domain/zcom/registerDomain',['domain' => $domain_check]); ?>">
                                <span class="btn-right click">Đăng ký mua</span>
                            </a>
                            <span class="btn-center">
                                <?php 
                                    $price = ApiZcom::getPriceMultil($prices, '.'.$tld_check);
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
    } 
?>