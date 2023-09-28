<?php 
	$countCompare = count($data);
	$col = 2 + $countCompare;
	// return {'gfdgfdgfdg'};
?>
<h1><span style="color:#eb0a1e;font-size:20px"><?= Yii::app()->siteinfo['site_title']; ?></span></h1>
<p>Kính chào Quý khách!</p>
<div style="border-bottom:3px solid #eb0a1e;font-size:14px;padding-bottom:3px"><span style="font-family:tahoma;font-size:14px"></span></div>
<p>Cảm ơn Quý khách đã gửi yêu cầu hỗ trợ tài chính cho chúng tôi.</p>
<p>Căn cứ vào yêu cầu của Quý khách, chúng tôi xin gửi lại nội dung hỗ trợ tài chính như sau:</p>
<p>&nbsp;</p>
<?php 
	$tg = explode('.', $model->car_color);
	$car_color_code = $tg[0];
	$car_color_name = isset($tg[1]) ? $tg[1] : '';
?>
<?php if($model->car_avatar) { ?><p><img style="max-width: 600px;" src="<?= $model->car_avatar ?>"></p><?php } ?>
<p><b>Tên xe: <?= $model->car_name ?></b> </p>
<p><b>Màu xe: </b> <?= $car_color_name ?></p>
<p><b>Giá xe + giá phụ kiện - Tiền trả trước:</b> </p>
<p> = <?= number_format($model['car_price'], 0, ',', '.') ?> + <?= number_format($model['car_component_price'], 0, ',', '.') ?> - <?= number_format($model['car_earnest'], 0, ',', '.') ?> =  <?= number_format($model['car_price'] + $model['car_component_price'] - $model['car_earnest'], 0, ',', '.') ?> VNĐ</p>
<p><b>Lãi xuất ngân hàng:</b> <?= $model->interest ?> %</p>
<?= $html ?>
<p>Xin trân trọng cảm ơn!</p>
<div style="border-top:1px solid #ddd;padding-top:10px;margin-top:15px">
<p><strong>TRỤ SỞ CHÍNH: </strong><br />
<hr/>
<?= Yii::app()->siteinfo['address']; ?></p>

<p>Điện thoại:&nbsp;<?= Yii::app()->siteinfo['phone']; ?></p>

<p>Email:&nbsp;<a href="mailto:<?= Yii::app()->siteinfo['email']; ?>" target="_blank">tbd@toyota.binhduong.vn</a></p>

<p>Website:&nbsp;<a  href="songlam.toyota.com">songlam.toyota.com.<wbr />vn</a></p>
