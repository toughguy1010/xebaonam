<?php 
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
<p style="text-transform: uppercase;">Email xác nhận đăng ký tên miền thành công</p>
Ngày gửi: <?= date('d/m/Y H:i', time()) ?><br />
*************************************************************************<br />
Kính gửi quý khách<br />
Chúng tôi đã đăng ký thành công tên miền <b><?= $model['domainName'].'.'.$model['tld'] ?></b>. Xin cám ơn quý khách đã đăng ký tên miền tại nanoweb.vn<br />
<br/>
Thông tin đăng ký:<br />
<br/>
Tên miền: <b><?= $model['domainName'].'.'.$model['tld'] ?></b><br />
Thời hạn: <?= $model['quantity'].' Năm' ?><br />
Ngày hết hạn: <?= date('d-m-Y H:i', $model['date_exp']) ?><br />
Đơn vị đăng ký: <?= $model['Role'] == 'R' ? 'Tổ chức' : 'Cá nhân' ?><br />
Họ tên người đăng ký: <?= $model['FirstName'].' '.$model['LastName']  ?><br />
<?php if($model['Organization']) { ?>
Tổ chức: <?= $model['Organization']  ?></br/>
<?php } ?>
Số điện thoại: <?= $model['Phone'] ?><br/>
Email: <?= $model['Email'] ?><br/>
Fax: <?= $model['Fax'] ?><br/>
Chứng minh thư: <?= $model['NationCode'] ?><br/>
Giới tính: <?= $model['Sex'] == 'M' ? 'Nam' : 'Nữ' ?><br/>
Ngày sinh: <?= $model['Birthday'] ?><br/>
Địa chỉ: <?= $model['Street1'] ?><br/>
Địa chỉ bổ xung: <?= $model['Street2'] ?><br/>
Mã bưu điện: <?= $model['PostalCode'] ?><br/>
<br />
Thông tin tài khoản đăng nhập quản lý:<br />
<br/>
<br />
Cắm ơn quý khách đã sử dụng dịch vụ của chúng tôi.
<br />
*************************************************************************<br />
<a href="http://nanoweb.vn/">NANOWEB.VN</a><br />
Địa chỉ: Phòng B2T10 - 335 Cầu giấy Cầu giấy – Hà Nội<br />
Số điện thoại: 0948 854 888 - 0462.598.127<br />
Email: <a href="mailto:support@nanoweb.vn">support@nanoweb.vn</a><br />
website: <a href="http://nanoweb.vn/">nanoweb.vn</a></p>
