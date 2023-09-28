<table style="border:#b7b7b7 solid 0px" cellspacing="0" cellpadding="5" border="0" align="center">
    <tbody>
    <tr>
        <td>
            <table cellspacing="0" cellpadding="0" border="0" align="center">
                <tbody>
                <tr>
                    <td width="250" valign="top"><img class="transition"
                                                      src="<?php echo Yii::app()->siteinfo['site_logo']; ?>"></td>
                    <td valign="top"><strong>CÔNG TY NỘI THẤT TNC</strong><br>Văn phòng Hà nội: Tầng 16, Tòa nhà HCMCC, 249A Thụy Khuê, Tây Hồ, Hà Nội<br>Tel: (84-4) 6 328 9096 - Fax: (84-4) 35539521 - Hotline: 0971 314 699<br>Email:
                        noithatvanphong247@gmail.com<br>Website: www.noithatvanphong247.com
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center">
            <table width="600" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                <tr>
                    <td height="30"><em><strong>Kính gửi :</strong></em> <strong><?= $model->name ?></strong></td>
                </tr>
                <tr>
                    <td valign="top" height="35"><strong><em>Công ty Nội thất TNC gửi tới Quý khách hàng lời chào
                                trân trọng!</em></strong></td>
                </tr>
                <tr>
                    <td style="padding:8px 8px 8px 20px; font-size:14px; text-transform:uppercase;" bgcolor="#eeeeee">
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
                    <td><?= ($model->reception) ? 'Có' : 'Không'?></td>
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
                    <td> <?= ($model->room_meeting) ? 'Có' : 'Không'?></td>
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
                    <td style="padding:8px 8px 8px 20px; font-size:14px; text-transform:uppercase;" bgcolor="#eeeeee">
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
                                            <td width="100" align="right"><strong><?= HtmlFormat::money_format($packagePrice) ?></strong></td>
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
                                            <td align="right"><strong><?= HtmlFormat::money_format($aryCost['package']['curtains']) ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>7</td>
                                            <td>Điện và chiếu sáng</td>
                                            <td align="right"><strong> <?= HtmlFormat::money_format($aryCost['package']['electricityAndLighting']) ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>8</td>
                                            <td>Hệ thống mạng và điện thoại</td>
                                            <td align="right"><strong> <?= HtmlFormat::money_format($aryCost['package']['networkAndTelephoneSystems']) ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>9</td>
                                            <td>Vách ngăn phòng họp và phòng lãnh đạo</td>
                                            <td align="right"><strong>  <?= HtmlFormat::money_format($aryCost['package']['partitionMeetingRoomAndLeadershipRoom']) ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>10</td>
                                            <td>Phòng họp vách kính</td>
                                            <td align="right"><strong><?= HtmlFormat::money_format($aryCost['package']['glassWall']) ?></strong></td>
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
                                            <td width="100" align="right"><strong><?= HtmlFormat::money_format($furniturePrice); ?></strong></td>
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
                                                    <?= HtmlFormat::money_format($aryCost['furniture']['receptionDesk']) ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>3</td>
                                            <td>Bàn và ghế làm việc</td>
                                            <td align="right"><strong><?= HtmlFormat::money_format($aryCost['furniture']['deskAndChair']) ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>4</td>
                                            <td>Bàn ghế lãnh đạo</td>
                                            <td align="right"><strong> <?= HtmlFormat::money_format($aryCost['furniture']['leaderChairs']) ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>5</td>
                                            <td>Bàn và ghế phòng họp</td>
                                            <td align="right"><strong><?= HtmlFormat::money_format($aryCost['furniture']['meetingRoomTableAndChairs']) ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>6</td>
                                            <td>Tủ đựng tài liệu</td>
                                            <td align="right"><strong> <?= HtmlFormat::money_format($aryCost['furniture']['fileCabinet']) ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>7</td>
                                            <td>Két sắt</td>
                                            <td align="right"><strong> <?= HtmlFormat::money_format($aryCost['furniture']['safe']) ?></strong></td>
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
                                            <td width="100" align="right"><strong><?= HtmlFormat::money_format($otherPrice); ?></strong></td>
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
                                            <td width="300">Chi phí khác (bảng hiệu, đèn, đèn trang trí…)</td>
                                            <td width="100" align="right"><strong><?= HtmlFormat::money_format($aryCost['other']['other']) ?></strong></td>
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
                                            <td align="right"><strong><?= HtmlFormat::money_format($aryCost['other']['designCosts']) ?></strong></td>
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
                                            <td width="350"><strong>TỔNG CỘNG (Chưa bao gồm VAT)</strong></td>
                                            <td width="10">&nbsp;</td>
                                            <td width="100" align="right"><strong> <?=
                                                    HtmlFormat::money_format($otherPrice + $furniturePrice + $packagePrice);
                                                    ?></strong></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <div style="padding-right:10px" align="justify"><br><em>Ghi chú: Khái toán hay dự
                                            toán sơ bộ của TNC giúp khách hàng có thể dễ dàng hình dung ra được
                                            tổng thể mức đầu tư cho một văn phòng. Chi phí chi tiết thực tế dự toán văn
                                            phòng có thể khác với khái toán trên phụ thuộc vào thiết kế kỹ thuật chi
                                            tiết, điều kiện và vị trí thi công, thời điểm báo giá, các yêu cầu khác. Chi
                                            phí trên chưa bao gồm chi phí điều hòa, PCCC, chi phí trang thiết bị văn
                                            phòng (máy tính, máy in, máy fax…). Thông tin khái toán chỉ có tác dụng tham
                                            khảo. <br>Gói nội thất được tính toán trên cơ sở bàn ghế của các nhà sản
                                            xuất Hòa Phát, Nội thất 190, Nội thất Fami (TNC là đại lý cấp 1 của
                                            các nhà sản xuất này). <br>Để được tư vấn chi tiết hơn nữa, xin Quý khách
                                            hàng liên hệ với email: noithatvanphong247@gmail.com hoặc số điện thoại Mr.
                                            Tuân Hà nội: 0909666389 hoặc Mr. Trần Anh 0932327588</em></div>
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
<table width="600" cellspacing="0" cellpadding="5" border="0" align="center">
    <tbody>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td style="padding:8px 8px 8px 0px; font-size:16px; text-transform:uppercase; color:#F00;"><strong><a
                        href="http://noithatvanphong247.com/tin-tuc/tin-tuc-van-phong.html" target="_blank"
                        style="color:#f00;">Xem tham khảo mẫu thiết kế Tin tức </a></strong></td>
    </tr>
    </tbody>
</table>
<table width="600" cellspacing="0" cellpadding="5" border="0" align="center">
    <tbody>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td style="padding:8px 8px 8px 20px; font-size:14px; text-transform:uppercase;" width="600" height="20"
            bgcolor="#eeeeee" align="left"><strong>Sản phẩm tham khảo</strong></td>
    </tr>
    </tbody>
</table>
<table width="600" cellspacing="0" cellpadding="3" border="0" align="center">
    <tbody>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="center"><img src="images/Dutoan/quay-le-tan-loai-lon-1-95504160792T76955405VR2B2SRE4Z02.jpg"
                                width="600" border="0"></td>
    </tr>
    <tr>
        <td width="600" align="center">Hình ảnh tham khảo 1: Không gian quầy lễ tân lớn nơi tạo sự sang trọng cho doanh
            nghiệp. Khu vực cũng là nơi chờ tạm của khách
        </td>
    </tr>
    </tbody>
</table>
<table width="600" cellspacing="0" cellpadding="3" border="0" align="center">
    <tbody>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="center"><img src="images/Dutoan/ban-lam-viec-cua-lanh-dao-7-MY777KTLSK1NG1F8ZK36BXI4PK8421SF.jpg"
                                width="600" border="0"></td>
    </tr>
    <tr>
        <td width="600" align="center">Hình ảnh tham khảo 7: Một mẫu bàn làm việc của cấp trưởng phòng hoặc lãnh đạo
        </td>
    </tr>
    </tbody>
</table>
<table width="600" cellspacing="0" cellpadding="3" border="0" align="center">
    <tbody>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="center"><img src="images/Dutoan/quay-le-tan-loai-nho-2-FG96KKU96L1V34RNG4553899B48DA6L5.jpg"
                                width="600" border="0"></td>
    </tr>
    <tr>
        <td width="600" align="center">Hình ảnh tham khảo 2: Quầy lễ tân loại nhỏ dành cho các văn phòng ít người</td>
    </tr>
    </tbody>
</table>
<table width="600" cellspacing="0" cellpadding="3" border="0" align="center">
    <tbody>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="center"><img src="images/Dutoan/modun-lam-viec-3-8HT95WES07L2A5Y6472122513006MJVF.jpg" width="600"
                                border="0"></td>
    </tr>
    <tr>
        <td width="600" align="center">Hình ảnh tham khảo 3: Mẫu bàn làm việc của nhân viên</td>
    </tr>
    </tbody>
</table>
<table width="600" cellspacing="0" cellpadding="3" border="0" align="center">
    <tbody>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="center"><img src="images/Dutoan/modun-lam-viec-4-7K8NC92L4014KO2084U4C876L90UH874.jpg" width="600"
                                border="0"></td>
    </tr>
    <tr>
        <td width="600" align="center">Hình ảnh tham khảo 4: Mẫu modun làm việc lớn</td>
    </tr>
    </tbody>
</table>
<table width="600" cellspacing="0" cellpadding="3" border="0" align="center">
    <tbody>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="center"><img src="images/Dutoan/ban-hop-loai-nho-5-95275J676LF2SQL1426CQJ72KMQ49E87.jpg" width="600"
                                border="0"></td>
    </tr>
    <tr>
        <td width="600" align="center">Hình ảnh tham khảo 5: Mẫu bàn họp, dùng cho các phòng họp loại nhỏ (6-8 người)
        </td>
    </tr>
    </tbody>
</table>
<table width="600" cellspacing="0" cellpadding="3" border="0" align="center">
    <tbody>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="center"><img src="images/Dutoan/ban-hop-ghep-theo-dang-modun-3962O695VW7DNN240N532WT10W5FB52Y.jpg"
                                width="600" border="0"></td>
    </tr>
    <tr>
        <td width="600" align="center">Hình ảnh tham khảo 6: Mẫu bàn họp theo dạng modun, có thể mở rộng và ghép cho các
            phòng họp lớn cỡ trung
        </td>
    </tr>
    </tbody>
</table>
<table width="600" cellspacing="0" cellpadding="3" border="0" align="center">
    <tbody>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="center"><img
                    src="images/Dutoan/hinh-anh-cac-tu-dung-trong-van-phong-R3V61X4BH1S9372P0OVPM57T3QUO93E1.jpg"
                    width="600" border="0"></td>
    </tr>
    <tr>
        <td width="600" align="center">Hình ảnh tham khảo 8: Mẫu tủ tài liệu trong văn phòng</td>
    </tr>
    </tbody>
</table>
<table width="600" cellspacing="0" cellpadding="5" border="0" align="center">
    <tbody>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td style="padding:8px 8px 8px 20px; font-size:14px; text-transform:uppercase;" width="600" height="20"
            bgcolor="#eeeeee" align="left"><strong>Diện tích mặt bằng có tính chất tương tự</strong></td>
    </tr>
    </tbody>
</table>
<table width="600" cellspacing="0" cellpadding="3" border="0" align="center">
    <tbody>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="center"><img src="images/Matbang/noi-that-van-phong-hanam-5-A4657EB1964NH5QIGEQ869S4D010R2PY.jpg"
                                width="600" border="0"></td>
    </tr>
    <tr>
        <td width="600" align="center">Phối cảnh văn phòng<br>
            <a href="http://noithatvanphong247.com/duan/33/thiet-ke-noi-that-van-phong-cong-ty-nam-ha-tai-toa-nha-cmc.html?l=vn">Dự
                án Thiết kế nội thất văn phòng công ty Nam Ha tại tòa nhà CMC</a></td>
    </tr>
    </tbody>
</table>
<script>
    window.print();
</script>

