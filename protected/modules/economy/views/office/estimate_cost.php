<div class="estimates-in-content">
    <div class="title-estimates">
        <h1>DỰ TOÁN NỘI THẤT VĂN PHÒNG </h1>
    </div>
    <div class="discription-estimate">
        Nhằm mang lại sự tiện lợi cho khách hàng, bằng nguồn dữ liệu đã thực hiện nhiều
        dự án, Chúng tôi đưa ra cách tính khái toán sơ bộ giúp khách hàng có thể dễ dàng
        hình dung ra được tổng thể mức đầu tư cho một văn phòng. Chi phí thực tế
    </div>
    <div class="content-estimates">
        <div class="from-estimates">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'user-model-form',
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'htmlOptions' => array(
                    'class' => 'form-esti',
                ),
            ));
            ?>
            <!---->
            <div class="form-group w3-form-group">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-lx-4">
                    <?php echo $form->labelEx($model, 'name', array('class' => '')); ?>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-lx-8">
                    <?php echo $form->textField($model, 'name', array('style' => 'width: 100%')); ?>
                    <?php echo $form->error($model, 'name'); ?>
                </div>
            </div>
            <!--            -->
            <div class="form-group w3-form-group">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-lx-4">
                    <?php echo $form->labelEx($model, 'email', array('class' => '')); ?>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-lx-8">
                    <?php echo $form->textField($model, 'email', array('style' => 'width: 100%')); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>
            </div>
            <div class="form-group w3-form-group">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-lx-4">
                    <?php echo $form->labelEx($model, 'phone', array('class' => '')); ?>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-lx-8">
                    <?php echo $form->textField($model, 'phone', array('style' => 'width: 100%')); ?>
                    <?php echo $form->error($model, 'phone'); ?>
                </div>
            </div>
            <div class="form-group w3-form-group">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-lx-4">
                    <?php echo $form->labelEx($model, 'cid', array('class' => '')); ?>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-lx-8">
                    <select name="OfficeEstimateCost[cid]">
                        <option value="" selected="selected">---Chọn---</option>
                        <?php foreach ($categories as $cid => $cname) { ?>
                            <option value="<?= $cid ?>"><?= $cname ?></option>
                        <?php } ?>
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group w3-form-group">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-lx-4">
                    <?php echo $form->labelEx($model, 'area', array('class' => '')); ?>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-lx-8">
                    <?php echo $form->textField($model, 'area', array()); ?>
                    <?php echo $form->error($model, 'area'); ?>
                    <span>m<sup>2</sup></span>
                </div>
            </div>
            <div class="form-group w3-form-group">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-lx-4">
                    <?php echo $form->labelEx($model, 'staff', array('class' => '')); ?>
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-lx-3">
                    <?php echo $form->textField($model, 'staff', array()); ?>
                    <?php echo $form->error($model, 'staff'); ?>
                </div>
            </div>
            <div class="form-group w3-form-group">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-lx-4">
                    <?php echo $form->labelEx($model, 'table_manager', array('class' => '')); ?>
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-lx-3">
                    <?php echo $form->textField($model, 'table_manager', array()); ?>
                    <?php echo $form->error($model, 'table_manager'); ?>
                </div>
            </div>
            <div class="form-group w3-form-group">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-lx-4">
                    <?php echo $form->labelEx($model, 'room_meeting', array('class' => '')); ?>
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-lx-3">
                    <input type="radio" name="OfficeEstimateCost[room_meeting]"
                           value="1" <?= ($model->room_meeting) ? 'checked' : '' ?> />Có
                    <input type="radio" name="OfficeEstimateCost[room_meeting]"
                           value="0" <?= (!$model->room_meeting) ? 'checked' : '' ?> />Không

                </div>
            </div>
            <div class="form-group w3-form-group">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-lx-4">
                    <?php echo $form->labelEx($model, 'reception', array('class' => '')); ?>
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-lx-3">
                    <input type="radio" name="OfficeEstimateCost[reception]"
                           value="1" <?= ($model->reception) ? 'checked' : '' ?>/>Có
                    <input type="radio" name="OfficeEstimateCost[reception]"
                           value="0" <?= (!$model->reception) ? 'checked' : '' ?>/> Không
                </div>
            </div>
            <div class="form-group w3-form-group">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-lx-4">
                    <?php echo $form->labelEx($model, 'floor', array('class' => '')); ?>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-lx-8">
                    <?php
                    $i = 0;
                    foreach ($floors as $fid => $fname) {
                        $i++;
                        ?>
                        <input type="radio" name="OfficeEstimateCost[floor]"
                               value="<?= $fid ?>" <?= $model->floor == $fid ? 'checked' : '' ?> /> <?= $fname ?>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="form-group w3-form-group">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-lx-4">
                    <?php echo $form->labelEx($model, 'ceiling', array('class' => '')); ?>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-lx-8">
                    <?php
                    $i = 0;
                    foreach ($ceilings as $ceilid => $ceilname) {
                        $i++;
                        ?>
                        <input type="radio" name="OfficeEstimateCost[ceiling]"
                               value="<?= $ceilid ?>" <?= $model->ceiling == $ceilid ? 'checked' : '' ?> /> <?= $ceilname ?>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="form-group w3-form-group">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-lx-4">
                    <?php echo $form->labelEx($model, 'quality', array('class' => '')); ?>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-lx-8">
                    <?php
                    $i = 0;
                    foreach ($qualities as $qid => $qname) {
                        $i++;
                        ?>
                        <input type="radio" name="OfficeEstimateCost[quality]"
                               value="<?= $qid ?>" <?= $model->quality == $qid ? 'checked' : '' ?> /> <?= $qname ?>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="form-group w3-form-group">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-lx-4">
                    <label></label>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-lx-8">
                    <input name="OfficeEstimateCost[view_product]" type="checkbox"
                           value="1" <?= ($model->view_product) ? 'checked' : '' ?>/>Xem hình ảnh sản phẩm tham khảo
                </div>
            </div>
            <div class="form-group w3-form-group">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-lx-4">
                    <label></label>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-lx-8">
                    <input name="OfficeEstimateCost[view_flat]" type="checkbox"
                           value="1" <?= ($model->view_flat) ? 'checked' : '' ?>/>Xem hình ảnh mặt bằng tham khảo
                </div>
            </div>
            <div class="form-group w3-form-group">
                <div class="offset-4 col-12 col-sm-12 col-md-4 col-lg-4 col-lx-4">
                    <?php echo CHtml::submitButton('Tính chi phí tham khảo', array('class' => 'button')); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <?php if (count($aryCost)) { ?>
        <!-- END CONTENT ESTIMATE -->
        <div class="content-result">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                <tr>
                    <td bgcolor="#eeeeee" style="padding:8px 8px 8px 20px; font-size:14px; text-transform:uppercase;">
                        <strong>Dự toán sơ bộ</strong>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top:6px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td width="20" height="30">&nbsp;</td>
                                <td>
                                    <table width="450" border="0" cellspacing="0" cellpadding="4">
                                        <tbody>
                                        <tr>
                                            <td class="goi"><strong>I - Gói hoàn thiện</strong></td>
                                            <?php
                                            if (count($aryCost['package'])) {
                                                $packagePrice = 0;
                                                foreach ($aryCost['package'] as $value) {
                                                    $packagePrice += (float)$value;
                                                }
                                            }
                                            ?>
                                            <td align="right" class="goi">
                                                <strong><?= HtmlFormat::money_format($packagePrice) ?></strong></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <!--                        -->
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <table width="450" border="0" cellspacing="0" cellpadding="4">
                                        <tbody>
                                        <tr>
                                            <td width="10">&nbsp;</td>
                                            <td width="15" height="27">1</td>
                                            <td width="260">Sàn văn phòng</td>
                                            <td width="130" align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['package']['floorPrice']) ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">2</td>
                                            <td>Trần</td>
                                            <td align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['package']['ceilingPrice']) ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">3</td>
                                            <td>Sơn bã tường</td>
                                            <td align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['package']['wallPaint']) ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">4</td>
                                            <td>Vách ngăn văn phòng</td>
                                            <td align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['package']['officePartition']) ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">5</td>
                                            <td>Cửa đi và cửa sổ</td>
                                            <td align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['package']['doorsAndWindows']) ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">6</td>
                                            <td>Rèm trong văn phòng</td>
                                            <td align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['package']['curtains']) ?>

                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">7</td>
                                            <td>Điện và chiếu sáng</td>
                                            <td align="right"><strong>
                                                    <?= HtmlFormat::money_format($aryCost['package']['electricityAndLighting']) ?>

                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">8</td>
                                            <td>Hệ thống mạng và điện thoại</td>
                                            <td align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['package']['networkAndTelephoneSystems']) ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">9</td>
                                            <td>Vách ngăn phòng họp và phòng lãnh đạo</td>
                                            <td align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['package']['partitionMeetingRoomAndLeadershipRoom']) ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">10</td>
                                            <td>Phòng họp vách kính</td>
                                            <td align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['package']['glassWall']) ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="30">&nbsp;</td>
                                <td>
                                    <table width="450" border="0" cellspacing="0" cellpadding="4">
                                        <tbody>
                                        <tr>
                                            <td class="goi"><strong>II - Gói nội thất</strong></td>
                                            <?php
                                            if (count($aryCost['furniture'])) {
                                                $furniturePrice = 0;
                                                foreach ($aryCost['furniture'] as $value) {
                                                    $furniturePrice += (float)$value;
                                                }
                                            }
                                            ?>
                                            <td align="right" class="goi">
                                                <strong>
                                                    <?= HtmlFormat::money_format($furniturePrice); ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <table width="450" border="0" cellspacing="0" cellpadding="5">
                                        <tbody>
                                        <tr>
                                            <td width="10">&nbsp;</td>
                                            <td width="15" height="27">1</td>
                                            <td width="260">Quầy lễ tân</td>
                                            <td width="130" align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['furniture']['reception']) ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">2</td>
                                            <td>Bàn ghế tiếp khách tại lễ tân</td>
                                            <td align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['furniture']['receptionDesk']) ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">3</td>
                                            <td>Bàn và ghế làm việc</td>
                                            <td align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['furniture']['deskAndChair']) ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">4</td>
                                            <td>Bàn ghế lãnh đạo</td>
                                            <td align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['furniture']['leaderChairs']) ?>
                                                </strong></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">5</td>
                                            <td>Bàn và ghế phòng họp</td>
                                            <td align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['furniture']['meetingRoomTableAndChairs']) ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">6</td>
                                            <td>Tủ đựng tài liệu</td>
                                            <td align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['furniture']['fileCabinet']) ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">7</td>
                                            <td>Két sắt</td>
                                            <td align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['furniture']['safe']) ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="30">&nbsp;</td>
                                <td>
                                    <table width="450" border="0" cellspacing="0" cellpadding="4">
                                        <tbody>
                                        <tr>
                                            <td class="goi"><strong>III - Chi phí khác</strong></td>
                                            <?php
                                            if (count($aryCost['other'])) {
                                                $otherPrice = 0;
                                                foreach ($aryCost['other'] as $value) {
                                                    $otherPrice += (float)$value;
                                                }
                                            }
                                            ?>
                                            <td align="right" class="goi">
                                                <strong>
                                                    <?= HtmlFormat::money_format($otherPrice); ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <table width="450" border="0" cellspacing="0" cellpadding="4">
                                        <tbody>
                                        <tr>
                                            <td width="10">&nbsp;</td>
                                            <td width="15" height="20">1</td>
                                            <td width="260">Chi phí khác (bảng hiệu, đèn, đèn trang trí…)</td>
                                            <td width="130" align="right"><strong>
                                                    <?= HtmlFormat::money_format($aryCost['other']['other']) ?>
                                                </strong></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">2</td>
                                            <td>Chi phí vận chuyển</td>
                                            <td align="right"><strong>
                                                    <?= HtmlFormat::money_format($aryCost['other']['transportationCostsAndCleaningCosts']) ?>
                                                </strong></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30">3</td>
                                            <td>Chi phí thiết kế</td>
                                            <td align="right">
                                                <strong>
                                                    <?= HtmlFormat::money_format($aryCost['other']['designCosts']) ?></strong>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="30">&nbsp;</td>
                                <td>
                                    <table width="450" border="0" cellspacing="0" cellpadding="4">
                                        <tbody>
                                        <tr>
                                            <td class="goi"><strong>TỔNG CỘNG (Chưa bao gồm VAT)</strong></td>
                                            <td align="right" class="goi"><strong>
                                                    <?=
                                                    HtmlFormat::money_format($otherPrice + $furniturePrice + $packagePrice);
                                                    ?>
                                                </strong></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <div align="justify" style="padding-right:10px">
                                        <br>
                                        <em>Ghi chú: Khái toán hay dự toán sơ bộ của QualiDecor giúp khách hàng có thể
                                            dễ
                                            dàng hình dung ra được tổng thể mức đầu tư cho một văn phòng. Chi phí chi
                                            tiết
                                            thực tế dự toán văn phòng có thể khác với khái toán trên phụ thuộc vào thiết
                                            kế
                                            kỹ thuật chi tiết, điều kiện và vị trí thi công, thời điểm báo giá, các yêu
                                            cầu
                                            khác. Chi phí trên chưa bao gồm chi phí điều hòa, PCCC, chi phí trang thiết
                                            bị
                                            văn phòng (máy tính, máy in, máy fax…). Thông tin khái toán chỉ có tác dụng
                                            tham
                                            khảo. <br>Gói nội thất được tính toán trên cơ sở bàn ghế của các nhà sản
                                            xuất
                                            Hòa Phát, Nội thất 190, Nội thất Fami (QualiDecor là đại lý cấp 1 của các
                                            nhà
                                            sản xuất này). <br>Để được tư vấn chi tiết hơn nữa, xin Quý khách hàng liên
                                            hệ
                                            với email: noithatvanphong247@gmail.com hoặc số điện thoại Mr. Tuân Hà nội:
                                            0909666389 hoặc Mr. Trần Anh 0932327588</em>
                                    </div>
                                </td>
                            </tr>
                            <?php if (count($product_images)) { ?>
                                <tr>
                                    <td height="40" valign="bottom">&nbsp;</td>
                                    <td valign="bottom">
                                        <?php
                                        foreach ($product_images as $item) {
                                            ?>
                                            <table width="600" cellspacing="0" cellpadding="3" border="0"
                                                   align="center">
                                                <tbody>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td align="center"><img
                                                                src="<?= $item['src'] ?>"
                                                                width="600" border="0"></td>
                                                </tr>
                                                <tr>
                                                    <td width="600" align="center"><?= $item['description'] ?>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?php
                                        } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <?php
                            if (count($flat_images)) { ?>
                                <tr>
                                    <td height="40" valign="bottom">&nbsp;</td>
                                    <td valign="bottom">

                                        <table width="600" cellspacing="0" cellpadding="5" border="0" align="center">
                                            <tbody>
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:8px 8px 8px 20px; font-size:14px; text-transform:uppercase;"
                                                    width="600" height="20"
                                                    bgcolor="#eeeeee" align="left"><strong>Diện tích mặt bằng có tính
                                                        chất
                                                        tương tự</strong></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <?php
                                        foreach ($flat_images as $item) {
                                            ?>
                                            <table width="600" cellspacing="0" cellpadding="3" border="0"
                                                   align="center">
                                                <tbody>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td align="center"><img
                                                                src="<?= $item['src'] ?>"
                                                                width="600" border="0"></td>
                                                </tr>
                                                <tr>
                                                    <td width="600" align="center"><?= $item['description'] ?>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?php
                                        } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>