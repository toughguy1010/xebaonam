<?php
$fee_by_card = [];
foreach ($infobank->paymentMethods as $bank) {
    if ($card == $bank->paymentMethod) {
        $fee_by_card = $bank->periods;
    }
}
krsort($fee_by_card);
?>


<div class="infocard VPBANK" style="">
    <div class="barcard">
        Trả góp qua thẻ <b id="bcard"><?= $card ?></b>, ngân hàng <b id="bbank"><?= $infobank->bankCode ?></b>
    </div>
    <div class="paymentMethod" id="div-<?= $infobank->bankCode . $card ?>">
        <div class="alepay-firstcol">
            <aside>Số tháng trả góp</aside>
            <aside>Giá mua trả góp</aside>
            <aside>Lãi suất</aside>
            <aside>Góp mỗi tháng</aside>
            <aside>Tổng tiền trả góp</aside>
            <aside>Chênh lệch với mua trả thẳng</aside>
            <?php if (isset($price_old) && $price_old) { ?>
                <aside>Số tiền thanh toán khi nhận máy</aside>
            <?php } ?>
            <aside id="divbutton"></aside>
        </div>
        <div id="div-result">
            <?php foreach ($fee_by_card as $fee) {
                ?>
                <div class="alepay-item" id="alepay-item-<?= $fee->month ?>" data-month="<?= $fee->month ?>">
                    <aside>
                        <b><?= $fee->month ?> tháng <a class="rechoose-month" id="rechoosemonth-<?= $fee->month ?>"
                                                       href="javascript:void(0)"
                                                       onclick="ReChooseMonth(); return false;"> Chọn
                                lại</a></b>
                    </aside>
                    <aside><label><?= number_format($price, 0, '', '.') . '₫' ?></label></aside>
                    <aside>
                        <label><?= $fee->payerPercentFee . '%' ?></label>
                    </aside>
                    <aside>
                        <label><?= number_format($fee->amountByMonth, 0, '', '.') . '₫' ?></label>
                    </aside>
                    <aside>
                        <label><?= number_format($fee->amountFinal, 0, '', '.') . '₫' ?></label>
                    </aside>
                    <aside>
                        <?= number_format($fee->amountFee, 0, '', '.') . '₫' ?>
                    </aside>
                    <?php if (isset($price_old) && $price_old) { ?>
                        <aside>
                            <label><?= number_format($price_old - $price, 0, '', '.') . '₫' ?></label>
                        </aside>
                    <?php } ?>
                    <aside id="div-btn">
                        <a class="cart-btt small" data-month="<?= $fee->month ?>" data-fee="<?=$fee->payerPercentFee?>" data-feemonth="<?=$fee->amountByMonth?>" data-difference="<?=$fee->amountFee?>" data-total="<?=$fee->amountFinal?>"
                           onclick="ChooseAlepayPackage(this)">Chọn mua</a>
                    </aside>
                </div>
            <?php } ?>
        </div>
    </div>
</div>