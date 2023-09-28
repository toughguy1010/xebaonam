<?php $themUrl = Yii::app()->theme->baseUrl; ?>
<link rel="stylesheet" type="text/css" href="<?=$themUrl?>/css/tragop.css">
<?php
echo $model->content;
?>
<div class="content">
	<div class="tool-book-ticket">
		<div class="tab-book-ticket">
			<?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK4));?>
		</div>
		<div class="title-i">
			<h3>Bảng tính lãi suất trả góp</h3>
		</div>
		<?php $price=(isset($_GET['price']))? number_format($_GET['price'], 0, '', '.'):'10.000.000'?>
		<div class="math-installment">
			<div class="item total">
				<p>Tổng giá trị xe: <input type="text" placeholder="10.000.000" value="<?= $price;?>"> VNĐ</p>
			</div>
			<div class="item prepay">
				<span>% trả trước</span> 
				<input type="text" placeholder="20%" minlength="1" maxlength="2" value="20">
				<button onclick="installment_payment()" class="math-now">Tính</button>
			</div>
			<div class="item prepaid-amount">
				<p>Số tiền trả trước: <label class="price1"></label><label>đ</label></p>
			</div>
			<div class="error"></div>
		</div>
		<div class="tab-read tab-read-1">
			<table>
				<thead>
					<tr>
						<th>Thời gian trả chậm</th>
						<th>% thanh toán trước</th>
						<th>Số tiền trả hàng tháng</th>
						<th>Số tiền để dành/ngày</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<div class="title-i">
			<h3>TƯ VẤN TRẢ GÓP: 0979.66.22.88 - 0977.66.33.11</h3>
			<div class="mxh">
				<div class="fb">
					<a href="">
						<img src="<?=$themUrl?>/images/fb.gif">
					</a>
				</div>
				<div class="zalo">
					<a href="">
						<img src="<?=$themUrl?>/images/zl.gif">
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?=$themUrl?>/js/tragop.js"></script>
<script>
	var queryString = window.location.href ? window.location.href.split('?')[1] : window.location.search.slice(1);
	if(queryString.split('=')[0]=='price'){
		  jQuery('.math-now').click();
	}

</script>