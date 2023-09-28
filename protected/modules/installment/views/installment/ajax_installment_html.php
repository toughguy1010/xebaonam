<?php
$count_price_market = $product->price_market; //Giá thị trường
$count_price = $product->price; //Giá niêm yết
$arr_month = ClaInstallment::AllMonth(); //Mảng chứa các tháng 6,9,12,15,18...
$count_pre = ClaInstallment::COUNT_PRE_DEFAULT; // Trả trước mặc định 30%
$number_month = $arr_month[0];
if (isset($month_) && $month_) {
    $number_month = $month_;
}
if (isset($pre_) && $pre_) {
    $count_pre = $pre_;
}

$papers = ClaInstallment::getPapers(); //Hồ sơ cần có
$every_month = ClaInstallment::getEveryMonth($number_month, $count_pre, $count_price); // Góp mỗi tháng
$array_interes_home = [
    'number_month' => $number_month,
    'count_price' => $count_price,
    'count_pre' => $count_pre,
];

$arr_pre = ClaInstallment::getPrePrice();
$arr_company = ClaInstallment::getCompanyBank();
foreach ($arr_company as $key_ => $company_) {
    $count_insurrance = $company_['insurrance'] / 100;
    if (!$bhkv_) {
        $count_insurrance = 0; // Bảo hiểm khoản vay %
    }
    $interes_home_cre = ClaInstallment::getInteresBank($every_month, $count_insurrance, $company_['interes'] / 100, $company_['collection_fee'], $array_interes_home);
    $count_insurrance_price = ClaInstallment::getInsurrance($every_month, $count_insurrance); //Giá bảo hiểm khoản vay
    $arr_company[$key_]['interes_home'] = $interes_home_cre['interes']; // Lãi suất
    $arr_company[$key_]['every_month_home'] = $interes_home_cre['every_month']; //Góp mỗi tháng
    $arr_company[$key_]['total_home'] = $interes_home_cre['total']; //Tổng tiền phải trả trong {month} tháng
    $arr_company[$key_]['insurrance_price'] = $count_insurrance_price; //Giá bảo hiểm khoản vay
}
?>

<ul class="table">
    <li>
        <aside>Công ty</aside>
        <?php foreach ($arr_company as $key => $company) { ?>
            <aside class="comlogo"><img
                        src="<?php echo ClaHost::getImageHost() . $company['image_path'] . 's150_150/' . $company['image_name'] ?>"
                        alt="<?= $company['name'] ?>"></aside>
        <?php } ?>
    </li>
    <li>
        <aside>Giá sản phẩm</aside>
        <?php foreach ($arr_company as $key => $company) { ?>
            <aside>
                <?= number_format($count_price_market, 0, '', '.') . '₫' ?>
            </aside>
        <?php } ?>
    </li>
    <li>
        <aside>Giá mua trả góp</aside>
        <?php foreach ($arr_company as $key => $company) { ?>
            <aside>
                <?= number_format($count_price, 0, '', '.') . '₫' ?>
            </aside>
        <?php } ?>
    </li>
    <li>
        <aside>
            Trả trước
            <div class="trtruoc" id="prepaid">Chọn</div>
            <div id="div-prepaid">
                <div class="infopopup percent" id="listpercent">
                    <div class="barpop">Chọn tiền trả trước</div>
                    <ul class="infolist">
                        <li>
                            <aside><b>% trả trước</b></aside>
                            <aside><b>Thành tiền</b></aside>
                        </li>
                        <?php foreach ($arr_pre as $key => $value) { ?>
                            <li data-value="<?= $value ?>"
                                class="ac <?= ($count_pre == $value) ? 'actived' : '' ?>">
                                <aside><?= $value * 100 ?>%</aside>
                                <aside><?= number_format($count_price * $value, 0, '', '.') . '₫' ?></aside>
                            </li>
                        <?php } ?>

                    </ul>
                    <div class="close"><i class="icontg-close"></i></div>
                </div>
            </div>
        </aside>
        <?php foreach ($arr_company as $key => $company) { ?>
            <aside><?= number_format($count_price * $count_pre, 0, '', '.') . '₫' ?>
                (<?= $count_pre * 100 ?>
                %)
            </aside>
        <?php } ?>
    </li>
    <li>
        <aside>Lãi suất</aside>
        <?php foreach ($arr_company as $key => $company) { ?>
            <aside>
                           <span class="special-percent">
                           <?= $company['interes'] . '%' ?>
                           </span>
            </aside>
        <?php } ?>
    </li>
    <li>
        <aside>Giấy tờ cần có</aside>
        <?php foreach ($arr_company as $key => $company) { ?>
            <aside>
                <?= $papers ?>
            </aside>
        <?php } ?>
    </li>
    <li>
        <div class="subtable">
            <aside>
                Góp mỗi tháng
                <div class="gop">
                    Chi tiết
                </div>
            </aside>
            <?php foreach ($arr_company as $key => $company) {
                ?>
                <aside data-ppm="<?= $company['every_month_home'] ?>">
                    <?= number_format($company['every_month_home'], 0, '', '.') . '₫' ?>
                </aside>
            <?php } ?>
        </div>
        <div class="infodetail">
            <div class="row">
                <aside>Gốc + lãi</aside>
                <?php foreach ($arr_company as $key => $company) {
                    ?>
                    <aside><?= number_format($every_month + $company['interes'], 0, '', '.') . '₫' ?></aside>
                <?php } ?>
            </div>
            <div class="row">
                <aside>Phí thu hộ</aside>
                <?php foreach ($arr_company as $key => $company) {
                    ?>
                    <aside><?= number_format($company['collection_fee'], 0, '', '.') . '₫' ?>/tháng
                    </aside>
                <?php } ?>
            </div>
            <div class="row">
                <aside class="bhkv <?= (isset($bhkv_) && $bhkv_) ? 'checked' : '' ?>" data-bh="<?= (isset($bhkv_) && $bhkv_) ? '1' : '0' ?>">
                    <i class="icontg-checkbox"></i>Bảo hiểm khoản vay
                    <div class="explain">
                        <i class="icontg-i"></i>
                        <p class="define">
                            <span>Để phòng trường hợp bất khả kháng như: tai nạn, bệnh tật mất sức lao động... quý khách không thể tiếp tục trả góp hàng góp, thì có công ty bảo hiểm trả góp dùm bạn.</span>
                        </p>
                    </div>
                </aside>
                <?php foreach ($arr_company as $key => $company) {
                    ?>
                    <aside><?= number_format($company['insurrance_price'], 0, '', '.') . '₫' ?>/tháng
                    </aside>
                <?php } ?>
            </div>
        </div>
    </li>
    <li>
        <aside>
            Tổng tiền phải trả
        </aside>
        <?php foreach ($arr_company as $key => $company) {
            ?>
            <aside>
                <label><?= number_format($company['total_home'], 0, '', '.') . '₫' ?></label>
            </aside>
        <?php } ?>
    </li>
    <li>
        <aside>
            Chênh lệch với mua trả thẳng
            <div class="explain">
                <i class="icontg-i"></i>
                <p class="define">
                    <span>Tiền chênh lệch đã bao gồm tiền lãi + phí đóng tiền hàng tháng + gói bảo hiểm vay (nếu có).</span>
                </p>
            </div>
        </aside>
        <?php foreach ($arr_company as $key => $company) {
            ?>
            <aside><?= number_format(ClaInstallment::getDifference($company['total_home'], $count_price, $count_pre), 0, '', '.') . '₫' ?></aside>
        <?php } ?>
    </li>
    <li>
        <aside></aside>
        <?php foreach ($arr_company as $key => $company) {
            ?>
            <aside class="hcBtn">
                <a href="javascript:void(0)" class="mua" data-id="<?= $company['id'] ?>">
                    Đặt mua
                    <span class="hcTxt">Duyệt trong 1 phút</span>
                </a>
            </aside>
        <?php } ?>
    </li>
</ul>
<?php if (isset($bhkv_)) { ?>
    <style>
        .infodetail {
            /*display: block !important;*/
        }
    </style>
<?php } ?>
<script>

    $(document).ready(function () {
        $('.gop').click(function () {
            $(this).remove();
            $('.infodetail').show();
        })
        $('#prepaid').click(function () {
            $('#listpercent').toggle();
            $('body').toggleClass('fixscroll');
        })

        $('.infopopup .close').click(function () {
            $('#listpercent').hide();
            $('body').removeClass('fixscroll');
        })

        $('.listmonths li').click(function () {
            $('.listmonths li').removeClass('actived');
            $(this).addClass('actived');
        })

        $('.infolist li.ac').click(function () {
            $('.infodetail').addClass('hide');
            $('.infolist li').removeClass('actived');
            $(this).addClass('actived');
        })

        $('.bhkv').click(function () {
            $(this).attr('data-bh', ($(this).attr('data-bh') == 0) ? 1 : 0);
        })
        $('.infolist li.ac, .bhkv').on('click', function () {
            var month = $('.listmonths li.actived').attr('data-month');
            var pre = $('.infolist li.actived').attr('data-value');
            var bhkv = $('.bhkv').attr('data-bh');
            $('.loading-cart').show();
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: "<?=Yii::app()->createUrl('installment/installment/countInstallment')?>",
                data: {month: month, pre: pre, bhkv: bhkv, id:<?=$product->id?>},
                success: function (data) {
                    if (data.html) {
                        $('.tablecontent').html(data.html);
                        $('.loading-cart').hide();
                        $(this).toggleClass('checked');
                        $('body').removeClass('fixscroll');
                    }
                },
                error: function () {
                }
            });
        });
        $('.table li .mua').click(function () {
            var id = $(this).attr('data-id');
            var month = $('.listmonths li.actived').attr('data-month');
            var pre = $('.infolist li.actived').attr('data-value');
            var bhkv = $('.bhkv').attr('data-bh');
            var object = '<?=$product->id?>';
            window.location.href = "<?=Yii::app()->createUrl('installment/installment/orderInstallment')?>?id="+object+','+id+','+month+','+pre+','+bhkv;
        })

    });
</script>