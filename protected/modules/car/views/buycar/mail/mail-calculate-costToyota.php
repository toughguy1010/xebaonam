<?php
	$totalPrice = $car['price'];
	//
	$idsExist = [];
	if (isset($accessoriesIds) && $accessoriesIds) {
	    $idsExist = json_decode($accessoriesIds, true);
	}
	if (isset($idsExist) && $idsExist) {
	    $accessoriesExist = CarAccessories::getAccessoriesByIds($idsExist);
	}
	//
	$registration_fee = ($car['price'] / 100) * $car['registration_fee'];
	//
	if (isset($accessoriesExist) && $accessoriesExist) {
	    foreach ($accessoriesExist as $item) {
	        $totalPrice += $item['price'];
	    }
	}
	?>
	<?php
	$totalPrice = array_sum([
	    $totalPrice,
	    $car['number_plate_fee'],
	    $registration_fee,
	    $car['inspection_fee'],
	    $car['road_toll'],
	    $car['insurance_fee']
	]);
?>
<h1><span style="color:#eb0a1e;font-size:20px"><?= Yii::app()->siteinfo['site_title']; ?></span></h1>
<p>Kính chào Quý khách!</p>
<div style="border-bottom:3px solid #eb0a1e;font-size:14px;padding-bottom:3px"><span style="font-family:tahoma;font-size:14px"></span></div>
<p>Cảm ơn Quý khách đã sử dụng dịch vụ của chúng tôi.</p>
<p>Căn cứ vào yêu cầu của Quý khách, chúng tôi xin gửi lại nội dung dự đoán chi phí như sau:</p>
<p>&nbsp;</p>
<?php 
	$tg = explode('.', $model->car_color);
	$car_color_code = $tg[0];
	$car_color_name = isset($tg[1]) ? $tg[1] : '';
?>
<?php if($car['avatar2_name']) { ?><p><img style="max-width: 600px;" src="<?= ClaHost::getImageHost(), $car['avatar2_path'], $car['avatar2_name'] ?>"></p><?php } ?>
<p><b>Tên xe: </b> <?= $car['name'] ?></p>
<p><b>Giá xe: </b> <?= number_format($car['price'], 0, ',', '.') ?></p>
<?php
    if (isset($colorSet) && $colorSet) { ?>
    	<p><b>Màu xe: </b> <?= isset($clor['name']) ? $clor['name'] : $firstColor['name'] ?></p>
    <?php }
?>

<p><b style="text-transform: uppercase;">Chi phí đăng ký</b></p>
<p><b>Đăng ký (chưa bao gồm phí dịch vụ): </b> <?= number_format($car['number_plate_fee'], 0, ',', '.') ?></p>
<?php
	$registration_fee = ($car['price'] / 100) * $car['registration_fee'];
?>
<p><b>Lệ phí trước bạ: </b> <?= $car['registration_fee'] ?>% (<?= number_format($registration_fee, 0, ',', '.') ?>)</p>
<p><b>Phí kiểm định: </b> <?= number_format($car['inspection_fee'], 0, ',', '.') ?></p>
<p><b>Phí sử dụng đường bộ/Năm: </b> <?= number_format($car['inspection_fee'], 0, ',', '.') ?></p>
<p><b>Bảo hiểm trách nhiệm dân sự/Năm: </b> <?= number_format($car['insurance_fee'], 0, ',', '.') ?></p>
<p><b>Nơi đăng ký trước bạ</b> <?= $regionModel['name'] ?></p>

<p><b style="text-transform: uppercase;">Phụ kiện</b></p>
<?php
    if (isset($accessoriesExist) && $accessoriesExist) {
        foreach ($accessoriesExist as $item) { ?>
        	<p><b><?= $item['name'] ?></b> <?= number_format($item['price'], 0, ',', '.') ?></p>
		<?php }
    }
?>
<p><b style="text-transform: uppercase;">Tổng chi phí</b> <?= number_format($totalPrice, 0, ',', '.') ?></p>

<p>Xin trân trọng cảm ơn!</p>
<div style="border-top:1px solid #ddd;padding-top:10px;margin-top:15px">
<p><strong>TRỤ SỞ CHÍNH: </strong><br />
<hr/>
<?= Yii::app()->siteinfo['address']; ?></p>

<p>Điện thoại:&nbsp;<?= Yii::app()->siteinfo['phone']; ?></p>

<p>Email:&nbsp;<a href="mailto:<?= Yii::app()->siteinfo['email']; ?>" target="_blank">tbd@toyota.binhduong.vn</a></p>

<p>Website:&nbsp;<a  href="songlam.toyota.com">songlam.toyota.com.<wbr />vn</a></p>
