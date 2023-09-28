<table>
	<thead>
		<th></th>
		<th>1 năm</th>
		<th>3 năm</th>
		<th>5 năm</th>
		<th>10 năm</th>
	</thead>
	<tbody>
		<?php foreach ($data as $item) {
            if($item['ProductPriceList']) { 
            	$pr1 = $item['ProductPriceList'][0]['ResellerPrice'];
            	$sl1 = $item['ProductPriceList'][0]['UnitPrice'];
            	$pr3 = $item['ProductPriceList'][2]['ResellerPrice'];
            	$sl3 = $item['ProductPriceList'][2]['UnitPrice'];
            	$pr5 = $item['ProductPriceList'][4]['ResellerPrice'];
            	$sl5 = $item['ProductPriceList'][4]['UnitPrice'];
            	$pr10 = $item['ProductPriceList'][9]['ResellerPrice'];
            	$sl10= $item['ProductPriceList'][9]['UnitPrice'];
            	?>
		<tr>
			<td><?=$item['ProductName'] ?></td>
			<td>
				<div class="price"><?= $pr1 ? number_format($pr1, 0, ',', '.').' VND' : 'Liên hệ';?></div>
				<div class="preprice"><?= $sl1 ? number_format($sl1, 0, ',', '.').' VND' : 'Liên hệ';?></div>
			</td>
			<td>
				<div class="price"><?= $pr3 ? number_format($pr3, 0, ',', '.').' VND' : 'Liên hệ';?></div>
				<div class="preprice"><?= $sl3 ? number_format($sl3, 0, ',', '.').' VND' : 'Liên hệ';?></div>
			</td>
			<td>
				<div class="price"><?= $pr5 ? number_format($pr5, 0, ',', '.').' VND' : 'Liên hệ';?></div>
				<div class="preprice"><?= $sl5 ? number_format($sl5, 0, ',', '.').' VND' : 'Liên hệ';?></div>
			</td>
			<td>
				<div class="price"><?= $pr10 ? number_format($pr10, 0, ',', '.').' VND' : 'Liên hệ';?></div>
				<div class="preprice"><?= $sl10 ? number_format($sl10, 0, ',', '.').' VND' : 'Liên hệ';?></div>
			</td>
		</tr>
			<?php }
		} ?>
	</tbody>
</table>