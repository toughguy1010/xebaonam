<style type="text/css">
    .widget-header-large {
        height: 260px;
    }

    .invoice-box .col-xs-8 label {
        width: 150px;
    }

    .invoice-box .col-xs-8 select {
        width: 145px;
    }
</style>
<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="space-6">
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="widget-box transparent invoice-box">
                    <table style="border:#b7b7b7 solid 0px" cellspacing="0" cellpadding="5" border="0" align="center">
                        <tr>
                            <td align="center">
                                <table width="600" cellspacing="0" cellpadding="0" border="0">
                                    <tbody>
                                    <tr>
                                        <td height="30"><em><strong>Khách hàng :</strong></em>
                                            <strong><?= $model->name ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td height="30"><em><strong>Email :</strong></em>
                                            <strong><?= $model->email ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td height="30"><em><strong>Khách hàng :</strong></em>
                                            <strong><?= $model->phone ?></strong></td>
                                    </tr>

                                    <tr>
                                        <td style="padding:8px 8px 8px 20px; font-size:14px; text-transform:uppercase;"
                                            bgcolor="#eeeeee">
                                            <strong>Thông số ban đầu</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table width="550" cellspacing="0" cellpadding="5" border="0">
                                    <tbody>
                                    <tr>
                                        <td colspan="2" height="8"></td>
                                    </tr>
                                    <tr>
                                        <td width="250">- Chất lượng hoàn thiện</td>
                                        <td> <?= $qualities[$model->quality] ?></td>
                                    </tr>
                                    <tr>
                                        <td>- Diện tích văn phòng</td>
                                        <td><?php echo $model->area ?><sup>2</sup></td>
                                    </tr>
                                    <tr>
                                        <td>- Sàn dùng</td>
                                        <td><?= $floors[$model->floor] ?></td>
                                    </tr>
                                    <tr>
                                        <td>- Trần dùng</td>
                                        <td><?= $ceilings[$model->ceiling] ?></td>
                                    </tr>
                                    <tr>
                                        <td>- Quầy lễ tân</td>
                                        <td><?= ($model->reception) ? 'Có' : 'Không' ?></td>
                                    </tr>
                                    <tr>
                                        <td>- Số lượng nhân viên</td>
                                        <td><?php echo $model->staff ?></td>
                                    </tr>
                                    <tr>
                                        <td>- Bàn làm việc lãnh đạo</td>
                                        <td><?php echo $model->table_manager; ?></td>
                                    </tr>
                                    <tr>
                                        <td>- Phòng họp chung</td>
                                        <td> <?= ($model->room_meeting) ? 'Có' : 'Không' ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table width="600" cellspacing="0" cellpadding="0" border="0" align="center">
                                    <tbody>
                                    <tr>
                                        <td style="padding:8px 8px 8px 20px; font-size:14px; text-transform:uppercase;"
                                            bgcolor="#eeeeee">
                                            <strong>Dự toán sơ bộ</strong></td>
                                    </tr>
                                    <tr>
                                        <td height="8"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                <tr>
                                                    <td width="20" height="30">&nbsp;</td>
                                                    <td>
                                                        <table cellspacing="0" cellpadding="0" border="0">
                                                            <tbody>
                                                            <tr>
                                                                <?php
                                                                if (count($aryCost['package'])) {
                                                                    $packagePrice = 0;
                                                                    foreach ($aryCost['package'] as $value) {
                                                                        $packagePrice += (float)$value;
                                                                    }
                                                                }
                                                                ?>
                                                                <td width="350"><strong>I - Gói hoàn thiện</strong></td>
                                                                <td width="10">&nbsp;</td>
                                                                <td width="100" align="right">
                                                                    <strong><?= HtmlFormat::money_format($packagePrice) ?></strong>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <table cellspacing="0" cellpadding="5" border="0">
                                                            <tbody>
                                                            <tr>
                                                                <td width="10">&nbsp;</td>
                                                                <td width="15">1</td>
                                                                <td width="300">Sàn văn phòng</td>
                                                                <td width="100" align="right">
                                                                    <strong>
                                                                        <?= HtmlFormat::money_format($aryCost['package']['floorPrice']) ?>
                                                                    </strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>2</td>
                                                                <td>Trần</td>
                                                                <td align="right">
                                                                    <strong>
                                                                        <?= HtmlFormat::money_format($aryCost['package']['ceilingPrice']) ?>
                                                                    </strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>3</td>
                                                                <td>Sơn bã tường</td>
                                                                <td align="right">
                                                                    <strong>
                                                                        <?= HtmlFormat::money_format($aryCost['package']['wallPaint']) ?>
                                                                    </strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>4</td>
                                                                <td>Vách ngăn văn phòng</td>
                                                                <td align="right">
                                                                    <strong>
                                                                        <?= HtmlFormat::money_format($aryCost['package']['officePartition']) ?>
                                                                    </strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>5</td>
                                                                <td>Cửa đi và cửa sổ</td>
                                                                <td align="right">
                                                                    <strong>
                                                                        <?= HtmlFormat::money_format($aryCost['package']['doorsAndWindows']) ?>
                                                                    </strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>6</td>
                                                                <td>Rèm trong văn phòng</td>
                                                                <td align="right">
                                                                    <strong><?= HtmlFormat::money_format($aryCost['package']['curtains']) ?></strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>7</td>
                                                                <td>Điện và chiếu sáng</td>
                                                                <td align="right">
                                                                    <strong> <?= HtmlFormat::money_format($aryCost['package']['electricityAndLighting']) ?></strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>8</td>
                                                                <td>Hệ thống mạng và điện thoại</td>
                                                                <td align="right">
                                                                    <strong> <?= HtmlFormat::money_format($aryCost['package']['networkAndTelephoneSystems']) ?></strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>9</td>
                                                                <td>Vách ngăn phòng họp và phòng lãnh đạo</td>
                                                                <td align="right">
                                                                    <strong>  <?= HtmlFormat::money_format($aryCost['package']['partitionMeetingRoomAndLeadershipRoom']) ?></strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>10</td>
                                                                <td>Phòng họp vách kính</td>
                                                                <td align="right">
                                                                    <strong><?= HtmlFormat::money_format($aryCost['package']['glassWall']) ?></strong>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="30">&nbsp;</td>
                                                    <td>
                                                        <?php
                                                        if (count($aryCost['furniture'])) {
                                                            $furniturePrice = 0;
                                                            foreach ($aryCost['furniture'] as $value) {
                                                                $furniturePrice += (float)$value;
                                                            }
                                                        }
                                                        ?>
                                                        <table cellspacing="0" cellpadding="0" border="0">
                                                            <tbody>
                                                            <tr>
                                                                <td width="350"><strong>II - Gói nội thất</strong></td>
                                                                <td width="10">&nbsp;</td>
                                                                <td width="100" align="right">
                                                                    <strong><?= HtmlFormat::money_format($furniturePrice); ?></strong>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <table cellspacing="0" cellpadding="5" border="0">
                                                            <tbody>
                                                            <tr>
                                                                <td width="10">&nbsp;</td>
                                                                <td width="15">1</td>
                                                                <td width="300">Quầy lễ tân</td>
                                                                <td width="100" align="right"><strong>
                                                                        <?= HtmlFormat::money_format($aryCost['furniture']['reception']) ?>
                                                                    </strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>2</td>
                                                                <td>Bàn ghế tiếp khách tại lễ tân</td>
                                                                <td align="right"><strong>
                                                                        <?= HtmlFormat::money_format($aryCost['furniture']['receptionDesk']) ?></strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>3</td>
                                                                <td>Bàn và ghế làm việc</td>
                                                                <td align="right">
                                                                    <strong><?= HtmlFormat::money_format($aryCost['furniture']['deskAndChair']) ?></strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>4</td>
                                                                <td>Bàn ghế lãnh đạo</td>
                                                                <td align="right">
                                                                    <strong> <?= HtmlFormat::money_format($aryCost['furniture']['leaderChairs']) ?></strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>5</td>
                                                                <td>Bàn và ghế phòng họp</td>
                                                                <td align="right">
                                                                    <strong><?= HtmlFormat::money_format($aryCost['furniture']['meetingRoomTableAndChairs']) ?></strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>6</td>
                                                                <td>Tủ đựng tài liệu</td>
                                                                <td align="right">
                                                                    <strong> <?= HtmlFormat::money_format($aryCost['furniture']['fileCabinet']) ?></strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>7</td>
                                                                <td>Két sắt</td>
                                                                <td align="right">
                                                                    <strong> <?= HtmlFormat::money_format($aryCost['furniture']['safe']) ?></strong>
                                                                </td>
                                                            </tr>

                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="30">&nbsp;</td>
                                                    <td>
                                                        <?php
                                                        if (count($aryCost['other'])) {
                                                            $otherPrice = 0;
                                                            foreach ($aryCost['other'] as $value) {
                                                                $otherPrice += (float)$value;
                                                            }
                                                        }
                                                        ?>
                                                        <table cellspacing="0" cellpadding="0" border="0">
                                                            <tbody>
                                                            <tr>
                                                                <td width="350"><strong>III - Chi phí khác</strong></td>
                                                                <td width="10">&nbsp;</td>
                                                                <td width="100" align="right">
                                                                    <strong><?= HtmlFormat::money_format($otherPrice); ?></strong>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <table cellspacing="0" cellpadding="5" border="0">
                                                            <tbody>
                                                            <tr>
                                                                <td width="10">&nbsp;</td>
                                                                <td width="15">1</td>
                                                                <td width="300">Chi phí khác (bảng hiệu, đèn, đèn trang
                                                                    trí…)
                                                                </td>
                                                                <td width="100" align="right">
                                                                    <strong><?= HtmlFormat::money_format($aryCost['other']['other']) ?></strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>2</td>
                                                                <td>Chi phí vận chuyển</td>
                                                                <td align="right"><strong>
                                                                        <?= HtmlFormat::money_format($aryCost['other']['transportationCostsAndCleaningCosts']) ?>
                                                                    </strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>3</td>
                                                                <td>Chi phí thiết kế</td>
                                                                <td align="right">
                                                                    <strong><?= HtmlFormat::money_format($aryCost['other']['designCosts']) ?></strong>
                                                                </td>
                                                            </tr>

                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="30">&nbsp;</td>
                                                    <td>
                                                        <table cellspacing="0" cellpadding="0" border="0">
                                                            <tbody>
                                                            <tr>
                                                                <td width="350"><strong>TỔNG CỘNG (Chưa bao gồm
                                                                        VAT)</strong></td>
                                                                <td width="10">&nbsp;</td>
                                                                <td width="100" align="right"><strong> <?=
                                                                        HtmlFormat::money_format($otherPrice + $furniturePrice + $packagePrice);
                                                                        ?></strong></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div>