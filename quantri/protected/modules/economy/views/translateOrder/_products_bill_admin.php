<table style="margin-top: 40px" class="table table-hover table-bordered">
    <thead>
    <tr>
        <th class="col-3">Dịch từ</th>
        <th class="col-1">Tên file</th>
        <th class="col-3">Loại</th>
        <th class="col-3">Số lượng</th>
        <th class="col-3">Thành tiền</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($items) {

        ?>
        <?php foreach ($items as $key => $value) { ?>
            <tr>

                <td class="count-char"><?= ClaLocation::getCountryName($value['from']) . ' -> ' . ClaLocation::getCountryName($value['to']); ?> </td>
                <td class="file-name">
                    <?php
                    $files = json_decode($value['file']);
                    foreach ($files as $key => $file) {
                        $api = new ClaAPI();
                        $respon = $api->createUrl(array(
                            'basepath' => 'economy/shoppingcartTranslate/downloadfile',
                            'params' => json_encode(array('id' => $key)),
                            'absolute' => 'true',
                        ));
                        echo '<p><a target="_blank" href="' . $respon['url'] . '">' . $file->display_name . '</a></p>';
                    }
                    ?>
                </td>
                <td class="count-char"><?= TranslateLanguage::getOptionsName($value['option']); ?>  </td>
                <td class="count-char"><?= $value['words']; ?>  </td>
                <td class="count-char"><?= ($value['price'] != '0.00') ? HtmlFormat::money_format($value['price']) . ' ' . $value['currency'] : 'Liên hệ'; ?>  </td>
            </tr>
        <?php } ?>

    <?php } ?>
    </tbody>
</table>