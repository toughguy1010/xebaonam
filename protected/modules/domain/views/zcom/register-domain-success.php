<style type="text/css">
	.regiterdomainscc .tilte {
		text-align: center;
		font-size: 26px;
		color: green;
	}
	.regiterdomainscc .tilte-small {
		font-size: 18px;
	}
	.regiterdomainscc table td:first-child {
		min-width: 200px;
	}
	.regiterdomainscc table {
		font-size: 16px;
	}
	.regiterdomainscc tr {
		border-bottom: 1px solid #ebebeb;
		padding: 2px;
	}
	.regiterdomainscc table {
		border:  1px solid #ebebeb;
		width: 100%;
	}
	.regiterdomainscc tr td{
		padding: 10px;
	}
</style>
<div>
    <hr/>
    <div class="container">
    	<div class="regiterdomainscc"  style="padding: 0px 0px 40px;">
	    	<p class="center tilte" style="text-align: center; ">
	            Bạn đã đăng ký thông tin thành công tên miền <b class="green"><?= $model->domainName.'.'.$model->tld ?></b>.
	        </p>
	        <div class="content">
	        	<p class="tilte-small">Thông tin đăng ký:</p>
	        	<table>
	        		<tr>
	        			<td>Tên miền:</td>
	        			<td><b><?= $model['domainName'].'.'.$model['tld'] ?></b></td>
	        		</tr>
	        		<tr>
	        			<td>Thời hạn:</td>
	        			<td><?= $model['quantity'].' Năm' ?></td>
	        		</tr>
	        		<tr>
	        			<td>Đơn vị đăng ký:</td>
	        			<td><?= $model['Role'] == 'R' ? 'Tổ chức' : 'Cá nhân' ?></td>
	        		</tr>
	        		<tr>
	        			<td>Họ tên người đăng ký:</td>
	        			<td><?= $model['FirstName'].' '.$model['LastName']  ?></td>
	        		</tr>
	        		<?php if($model['Organization']) { ?>
	        			<tr>
		        			<td>Tổ chức:</td>
		        			<td><?= $model['Organization']  ?></td>
		        		</tr>
						 </br/>
					<?php } ?>
	        		<tr>
	        			<td>Số điện thoại:</td>
	        			<td><?= $model['Phone'] ?></td>
	        		</tr>
	        		<tr>
	        			<td>Email:</td>
	        			<td><?= $model['Email'] ?></td>
	        		</tr>
	        		<tr>
	        			<td>Fax:</td>
	        			<td><?= $model['Fax'] ?></td>
	        		</tr>
	        		<tr>
	        			<td>Chứng minh thư</td>
	        			<td><?= $model['NationCode'] ?></td>
	        		</tr>
	        		<tr>
	        			<td>Giới tính:</td>
	        			<td><?= $model['Sex'] == 'M' ? 'Nam' : 'Nữ' ?></td>
	        		</tr>
	        		<tr>
	        			<td>Ngày sinh</td>
	        			<td><?= $model['Birthday'] ?></td>
	        		</tr>
	        		<tr>
	        			<td>Thành phố</td>
	        			<td><?= $model['City'] ?></td>
	        		</tr>
	        		<tr>
	        			<td>Địa chỉ:</td>
	        			<td><?= $model['Street1'] ?></td>
	        		</tr>
	        		<tr>
	        			<td>Địa chỉ bổ xung:</td>
	        			<td><?= $model['Street2'] ?></td>
	        		</tr>
	        		<tr>
	        			<td>Mã bưu điện:</td>
	        			<td><?= $model['PostalCode'] ?></td>
	        		</tr>
	        	</table>
	        	<p class="tilte-small">Thông tin thanh toán:</p>
	        	<i>Chúng tôi sẽ đang ký tên miền cho quý khách ngay sau khi nhận được xác nhận quý khách đã thanh toán chi chí đăng ký tên miền.</i>
	        	<table>
	        		<tr>
	        			<td>Phí đăng ký:</td>
	        			<td>
	        				<b><?= $model['Price'] ? number_format($model['Price'], 0, ',', '.').' + '.ApiZcom::getVAT().'% VAT = '.number_format(ApiZcom::getSumVAT($model['Price']), 0, ',', '.').' VND' : 'Liên hệ' ?></b>
	        				<span style="color: red"> - có thể thay đổi nếu quý khách không xác nhận thanh toán sớm.</span>
	        			</td>
	        		</tr>
	        		<tr>
	        			<td>Phương thức thanh toán</td>
	        			<td>Thanh toán qua chuyển khoản Ngân hàng hoặc Internet Banking . Quý khách có thể đến bất kì Phòng giao dịch ngân hàng, ATM hoặc sử dụng tính năng Internet Banking để chuyển tiền vào một trong các tài khoản sau:</td>
	        		</tr>
	        		<tr>
	        			<td>Tài khoản:</td>
	        			<td>
	        				<div>
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
	        				</div>
	        			</td>
	        		</tr>
	        	</table>
	            <br/>
	            <a href="<?= Yii::app()->createUrl('/domain/zcom/index'); ?>" class="btn btn-primary">Tìm kiếm tên miền khác</a>
	        </div>
        </div>
    </div>
</div>