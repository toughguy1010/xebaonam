<div class="col-md-3 box-tm-left">
    <h3>
        Tên miền phổ biến
    </h3>
    <div id="box-domain-hot">
        <ul class="box-hot">
            <?php
                if($checks) foreach ($checks as $check) {
                    $tld_check = $check['tld'];
                    if($tld_check != $tld) {
                        $domain_check = $domain.'.'.$tld_check;
                        switch ($check['status']) {
                            case '0': ?>
                                <li class="buyed">
                                    <a class="open-info-domain click" domain="<?= $domain_check ?>">
                                        <i class="xsx"></i> 
                                        <?= $domain_check ?>
                                    </a>
                                </li>
                               <?php break;
                            case '1': ?>
                               <li class="buy">
                                    <a href="<?= Yii::app()->createUrl('/domain/zcom/registerDomain',['domain' => $domain_check]); ?>" domain="<?= $domain_check ?>">
                                        <i class="xsx"></i> 
                                        <?= $domain_check ?>
                                    </a>
                                </li>
                               <?php break;
                        }
                    }
                } 
            ?>
        </ul>     
    </div>
</div>
<div class="col-md-9 box-tm-right">
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#home">Tên miền có thể mua</a>
        </li>
        <li>
            <a id="view-other" data-toggle="tab" href="#menu1">Tên miền khác</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <div id="box-view-add">
                <?php
                    if($checks) foreach ($checks as $check) {
                        $tld_check = $check['tld'];
                        if($tld_check != $tld) {
                            $domain_check = $domain.'.'.$tld_check;
                            if ($check['status']  == 1) { ?>
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
                            <?php }
                        }
                    } 
                ?>
            </div>
        </div>
        <div id="menu1" class="tab-pane fade">
            <div id="box-view-add-other">
                <div class="center">
                    <img src="<?= Yii::app()->homeUrl ?>images/ajax-loader.gif" />
                </div>
            </div>
        </div>
    </div>
</div>