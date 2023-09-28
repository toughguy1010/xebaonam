<?php foreach ($bank_arr as $key => $bank) {
    $count_interest_home = $bank['interes']; //Lãi suất home credit %
    $count_insurrance = $bank['insurrance']; // Bảo hiểm khoản vay %
    $collection_fee = $bank['collection_fee']; //Phí thu hộ
    $count_insurrance_price = ClaInstallment::getInsurrance($every_month, $count_insurrance); //Giá bảo hiểm khoản vay

    $interes_home_cre = ClaInstallment::getInteresBank($every_month, $count_insurrance, $count_interest_home, $collection_fee, $array_interes_home);
    $interes_home = $interes_home_cre['interes']; // Lãi suất home cre
    $every_month_home = $interes_home_cre['every_month']; //Góp mỗi tháng Home cre
    $total_home = $interes_home_cre['total']; //Tổng tiền phải trả trong {month} tháng Home cre
    $arr_pre = ClaInstallment::getPrePrice();
    ?>

    <aside>
        <?= number_format($count_price_market, 0, '', '.') . '₫' ?>
    </aside>

<?php } ?>