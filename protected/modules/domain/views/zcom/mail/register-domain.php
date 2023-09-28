<p style="text-transform: uppercase;">Email xác nhận đăng ký tên miền</p>
Ngày gửi: <?= date('d/m/Y H:i', time()) ?><br />
*************************************************************************<br />
Kính gửi quý khách<br />
Xin cám ơn quý khách đã đăng ký tên miền tại nanoweb.vn<br />
<br/>
Thông tin đăng ký:<br />
<br/>
Tên miền: <b><?= $model['domainName'].'.'.$model['tld'] ?></b><br />
Thời hạn: <?= $model['quantity'].' Năm' ?><br />
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
Chúng tôi sẽ đang ký tên miền cho quý khách ngay sau khi nhận được xác nhận quý khách đã thanh toán chi chí đăng ký tên miền <b><?= $model['domainName'].'.'.$model['tld'] ?></b> là: <?= $model['Price'] ? number_format($model['Price'], 0, ',', '.').' + '.ApiZcom::getVAT().'% VAT = '.number_format(ApiZcom::getSumVAT($model['Price']), 0, ',', '.').' VND' : 'Liên hệ' ?>.
<br />
<span style="color: red">Lưu ý: Chi phí có thể thay đổi nếu quý khách không xác nhận sớm vì 1 vài lý do như hết thời gian khuyến mãi... Chúng tôi sẽ liên hệ và xác nhận lại nếu có sự thay đổi này.</span>
<br/>
<br/>
Phương thức thanh toán
Thanh toán qua chuyển khoản Ngân hàng hoặc Internet Banking
Quý khách có thể đến bất kì Phòng giao dịch ngân hàng, ATM hoặc sử
dụng tính năng Internet Banking để chuyển tiền vào một trong các tài
khoản sau:<br/>
<br/>
NGÂN HÀNG TECHCOMBANK<br/>
<br/>
Chi nhánh : Hà Nội<br/>
Tên chủ khoản : Bùi Thanh Dũng<br/>
STK : 1902 036 376 2011<br/>
<br/>
NGÂN HÀNG VIETCOMBANK<br/>
<br/>
TK 1:<br/>
Tên chủ khoản : Bùi Thanh Dũng<br/>
STK : 0021 0012 79 779<br/>
 Chi nhánh : Hoàng Mai - Hà Nội<br/>
<br/>
TK2:<br/>
Tên chủ khoản : Công ty CP Sản Xuất và Dịch Vụ Thương Mại Đức Minh<br/>
Số tài khoản: 054-1000-242-080<br/>
Chi nhánh Chương Dương – Hà Nội<br/>
<br />
Cắm ơn quý khách đã sử dụng dịch vụ của chúng tôi.
<br />
*************************************************************************<br />
<a href="http://nanoweb.vn/">NANOWEB.VN</a><br />
Địa chỉ: Phòng B2T10 - 335 Cầu giấy Cầu giấy – Hà Nội<br />
Số điện thoại: 0948 854 888 - 0462.598.127<br />
Email: <a href="mailto:support@nanoweb.vn">support@nanoweb.vn</a><br />
website: <a href="http://nanoweb.vn/">nanoweb.vn</a></p>
