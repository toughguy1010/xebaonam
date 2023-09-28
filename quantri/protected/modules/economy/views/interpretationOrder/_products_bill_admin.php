<table style="margin-top: 40px" class="table table-hover table-bordered">
    <thead>
    <tr>
        <th class="col-1">Ngôn ngữ gốc</th>
        <th class="col-2">Ngôn ngữ cần dịch sang</th>
        <th class="col-3">Loại phiên dịch</th>
        <th class="col-3">Số ngày</th>
        <th class="col-3">Số tiền thuê (USD/ngày)</th>
        <th class="col-3">Tổng tiền</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($items) {
        $totalPrice = 0;
        foreach ($items as $key => $value) {
            $model2 = TranslateInterpretation::model()->findByPk($value['interpretation_id']);
            ?>
            <tr>
                <td class="file-name">
                    <h4><?= ClaLanguage::getCountryName($model2->from_lang) ?></h4>
                </td>
                <td class="file-name">
                    <h4><?= ClaLanguage::getCountryName($model2->to_lang) ?></h4>
                </td>
                <td class="file-name">
                    <h4>
                        <?php if ($params['options'] == 1) {
                            $txt = 'Escort Negotiation';
                        } else if ($params['options'] == 2) {
                            $txt = 'Consecutive Inter';
                        } else {
                            $txt = 'Simultaneous Inter';
                        }
                        echo $txt;
                        ?>
                    </h4>
                </td>
                <td class="file-name">
                    <h4><?= $model['day'] ?></h4>
                </td>
                <td class="file-name">
                    <h4>
                        <?php if ($params['option'] == 1) {
                            $price = $model2->escort_negotiation_inter_price;
                        } else if ($params['option'] == 2) {
                            $price = $model2->consecutive_inter_price;
                        } else {
                            $price = $model2->simultaneous_inter_price;
                        }
                        echo HtmlFormat::money_format($price);
                        ?>
                    </h4>
                </td>
                <td class="file-name">
                    <h4><?= HtmlFormat::money_format($value['price']) . ' ' . $value['currency'] ?></h4>
                </td>
            </tr>
            <?php
            $totalPrice += $model['day'] * $price;
        } ?>
        <tr>
            <td colspan="4"></td>
            <td><b>Tổng tiền</b></td>
            <td>  <?php echo ($model->total_price != '0.00') ? (HtmlFormat::money_format($model->total_price) . ' ' . $model->currency) : 'Liên hệ' ?></td>
        </tr>
    <?php } ?>

    </tbody>
</table>