<div class="width-form-hd">
    <div class="page-detail-video">
        <div class="detail-video">
            <div class="container">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-hd">
                        <div class="logo-form-hd">
                            <div class="img-form-hd">
                                <img width="220px"
                                     src="http://www.expertrans.vn/Cms_Data/Contents/Expertrans/Media/Img/expertrans-logo-resize.png">
                            </div>
                            <!--                            -->
                            <div class="des-form-hd">
                                <h2 style="text-transform: uppercase">Expertrans</h2>
                                <p>Địa chỉ văn phòng: Số 62 ngõ 19 Phố Trần Quang Diệu, Quận Đống Đa, Hà Nội</p>
                                <p>Mã sô thuê: _____________</p>
                            </div>
                        </div>
                        <div class="ctn-form-hd">
                            <h2 style="text-transform: uppercase">Hóa đơn biên dịch</h2>
                            <form>

                                <div class="form-item-hd width-50  border-tab ">
                                    <label>Tên khách hàng: </label>
                                    <p><?php echo $model['name'] ?></p>
                                </div>
                                <div class="form-item-hd width-50 ">
                                    <label>Điện thoại: </label>
                                    <p><?php echo $model['tell'] ?></p>
                                </div>
                                <div class="form-item-hd width-50 ">
                                    <label>Email: </label>
                                    <p><?php echo $model['email'] ?></p>
                                </div>
                                <div class="form-item-hd width-50 ">
                                    <label>Địa chỉ: </label>
                                    <p> <?php echo $model['address'] ?></p>
                                </div>
                                <div class="form-item-hd">
                                    <label>Phương thức thanh toán: </label>
                                    <p> <?php echo $model['payment_method'] ?></p>
                                </div>
                                <div class="table-responsive">
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
                                                            echo '<p>' . $file->display_name . '</p>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="count-char"><?= TranslateLanguage::getOptionsName($value['option']); ?>  </td>
                                                    <td class="count-char"><?= $value['words']; ?>  </td>
                                                    <td class="count-char"><?= ($value['price'] != '0.00') ? HtmlFormat::money_format($value['price']) . ' ' . $value['currency'] : 'Liên hệ'; ?>  </td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td><b>Tổng tiền</b></td>
                                                <td>  <?php echo ($model->total_price != '0.00') ? $model->total_price . ' ' . $model->currency : 'Liên hệ' ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="note-form-hd">
                                    <div class="note-item">
                                        <p>
                                            Nhân viên <span>(Ký, ghi rõ họ tên)</span>
                                        </p>
                                        <p>EXPERTRANS</p>
                                    </div>
                                    <div class="note-item">
                                        <p></p>
                                    </div>
                                    <div class="note-item">
                                        <p></p>
                                    </div>
                                    <div class="note-item">
                                        <p>
                                            Xác nhận của khách hàng <span>(Ký, ghi rõ họ tên)</span>
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <style type="text/css">
                        label {
                            font-weight: bold;
                        }

                        .width-form-hd {
                            margin: 0 auto;
                            width: 1000px;
                        }

                        .form-hd {
                            padding: 4%;
                            float: left;
                            width: 100%;
                            background: #fff;
                        }

                        .table-responsive {
                            margin-top: 25px;
                        }

                        .logo-form-hd {
                            float: left;
                            width: 100%;
                            margin-bottom: 30px;
                            background: #cfcfcf;
                            height: 100px;
                        }

                        .img-form-hd {
                            float: left;
                            width: 240px;
                            height: 100px;
                            margin: auto;
                            position: relative;
                            display: inline-block;
                        }

                        .img-form-hd img {
                            position: absolute;
                            top: 0;
                            bottom: 0;
                            position: absolute;
                            left: 0;
                            right: 0;
                            margin: auto;
                        }

                        .des-form-hd h2 {
                            font-weight: 600;
                            font-size: 16px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                            margin-bottom: 6px;
                            margin-top: 0px;
                        }

                        .des-form-hd {
                            margin-top: 15px;
                        }

                        .des-form-hd p {
                            font-size: 14px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                            margin: 0px;
                            margin-bottom: 6px;
                        }

                        .ctn-form-hd {
                            float: left;
                            width: 100%;
                        }

                        .ctn-form-hd h2 {
                            font-weight: 900;
                            font-size: 19px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                            text-align: center;
                            margin-top: 20px;
                            margin-bottom: 30px;
                        }

                        .form-item-hd {
                            float: left;
                            width: 100%;
                            margin-bottom: 10px;
                            display: flex;
                            overflow: hidden;
                            box-sizing: border-box;
                        }

                        .border-tab {
                            border-right: 20px solid #fff;
                        }

                        .form-item-hd label {
                            float: left;
                            margin-right: 10px;
                            font-size: 15px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                            white-space: nowrap;
                        }

                        .form-item-hd p {
                            float: left;
                            font-weight: 400;
                            font-size: 15px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                            margin: 0px;
                        }

                        .width-50 {
                            width: 50%;
                            float: left;
                        }

                        .table-responsive {
                            min-height: .01%;
                            overflow-x: auto;
                            float: left;
                            width: 100%;
                            font-size: 14px;
                            text-align: center;
                        }

                        .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
                            border-bottom-width: 2px;
                            text-align: center;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                        }

                        .span-b {
                            font-weight: 600;
                            font-size: 15px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                        }

                        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                            padding: 8px;
                            line-height: 1.42857143;
                            vertical-align: top;
                            border-top: 1px solid #ddd;
                        }

                        .table > thead > tr > th {
                            vertical-align: bottom;
                            border-bottom: 2px solid #ddd;
                        }

                        .table > caption + thead > tr:first-child > td, .table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table > thead:first-child > tr:first-child > th {
                            border-top: 0;
                        }

                        .table-bordered {
                            border: 1px solid #4a4646;
                        }

                        .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
                            border: 1px solid #4a4646;
                        }

                        .note-form-hd {
                            float: left;
                            width: 100%;
                            margin-top: 20px;
                            margin-bottom: 30px;
                        }

                        .note-item {
                            float: left;
                            width: 25%;
                            text-align: center;
                        }

                        .note-item p {
                            display: block;
                            font-weight: 600;
                            font-style: italic;
                            font-size: 15px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                        }

                        .note-item p span {
                            display: block;
                            font-weight: 300;
                            font-size: 15px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                        }

                        .table {
                            text-align: center;
                            width: 100%;
                            max-width: 100%;
                            margin-bottom: 20px;
                            font-weight: 300;
                            font-size: 15px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                        }

                        .table a {
                            font-weight: 300;
                            font-size: 15px;
                            font-family: 'Roboto', 'Roboto Light', sans-serif;
                            color: #333;
                            text-decoration: none;
                        }

                        table {
                            border-spacing: 0;
                            border-collapse: collapse
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    w.print();
    w.close();
</script>
