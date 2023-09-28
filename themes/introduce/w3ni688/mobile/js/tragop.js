$('.tab-book-ticket ul li a').click(function() {
	var getTabId = $(this).attr('id');
	$('.tab-book-ticket ul li a,.tab-book-ticket ul li').removeClass('active');
	$(this).addClass('active');
	$(this).parent().addClass('active');
});
function thousands_separators(num)
{
	var num_parts = num.toString().split(".");
	num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	return num_parts.join(",");
}
function thousands_separatorss(num)
{
	var num_parts = num.toString().split(",");
	num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	return num_parts.join(".,");
}
$('.content .math-installment .prepaid-amount label.price1').text(thousands_separators(0))
$('.content .math-installment .total input').keyup(function(event) {
		// skip for arrow keys
		if(event.which >= 37 && event.which <= 40) return;
  		// format number
  		$(this).val(function(index, value) {
  			return value
  			.replace(/\D/g, "")
  			.replace(/\B(?=(\d{3})+(?!\d))/g, ".")
  			;
  		});
  	});
$('.content .math-installment .prepay input').keyup(function(event) {
		// skip for arrow keys
		if(event.which >= 37 && event.which <= 40) return;
  		// format number
  		$(this).val(function(index, value) {
  			return value
  			.replace(/\D/g, "")
  			.replace(/\B(?=(\d{3})+(?!\d))/g, ".")
  			;
  		});
  	});
function installment_payment() {
	$('.error').remove();
	var interes_rate_price = $('.installment .content .tab-book-ticket ul li.active a').attr('data-id');
	var total_price = $('.content .math-installment .total input').val().replace(/[^0-9\s]/gi, '');
	var prepay_price = $('.content .math-installment .prepay input').val();
	if (total_price < 3000000) {
		$('.installment table tbody').html('<tr><td class="item" colspan="4" height="50"><div class="error">Giá trị vây phải từ 3 triệu trở lên </div></td></tr>');
		$('.tab-read').show();

	}
	else if (prepay_price < 20 || prepay_price >70) {
		$('.installment table tbody').html('<tr><td class="item" colspan="4" height="50"><div class="error">% trả trước từ 20% đến 70%</div></td></tr>');
		$('.tab-read').show();
	}
	else {
		var month_3, month_6, month_9, month_12, month_18, interes;
		var day_3, day_6, day_9, day_12, day_18;
		var interes = total_price*prepay_price/100;
		var interes_rate = (total_price - interes)*interes_rate_price/100;
		$('.content .math-installment .prepaid-amount label.price1').html(thousands_separators(interes));
		var month_3 = thousands_separatorss(((total_price - interes)/3+interes_rate).toFixed(0));
		var month_6 = thousands_separatorss(((total_price - interes)/6+interes_rate).toFixed(0));
		var month_9 = thousands_separatorss(((total_price - interes)/9+interes_rate).toFixed(0));
		var month_12 = thousands_separatorss(((total_price - interes)/12+interes_rate).toFixed(0));
		var month_18 = thousands_separatorss(((total_price - interes)/18+interes_rate).toFixed(0));
		var day_3 = thousands_separatorss((((total_price - interes)/3+interes_rate)/30).toFixed(0));
		var day_6 = thousands_separatorss((((total_price - interes)/6+interes_rate)/30).toFixed(0));
		var day_9 = thousands_separatorss((((total_price - interes)/9+interes_rate)/30).toFixed(0));
		var day_12 = thousands_separatorss((((total_price - interes)/12+interes_rate)/30).toFixed(0));
		var day_18 = thousands_separatorss((((total_price - interes)/18+interes_rate)/30).toFixed(0));
		$('.installment table tbody').html('<tr id="nth-3">'+
			'<td class="month">3 tháng</td>'+
			'<td class="ratio">'+prepay_price+'%</td>'+
			'<td class="in-month">'+month_3+'</td>'+
			'<td class="in-day">'+day_3+'</td>'+
			'</tr>'+
			'<tr id="nth-6">'+
			'<td class="month">6 tháng</td>'+
			'<td class="ratio">'+prepay_price+'%</td>'+
			'<td class="in-month">'+month_6+'</td>'+
			'<td class="in-day">'+day_6+'</td>'+
			'</tr>'+
			'<tr  id="nth-9">'+
			'<td class="month">9 tháng</td>'+
			'<td class="ratio">'+prepay_price+'%</td>'+
			'<td class="in-month">'+month_9+'</td>'+
			'<td class="in-day">'+day_9+'</td>'+
			'</tr>'+
			'<tr  id="nth-12">'+
			'<td class="month">12 tháng</td>'+
			'<td class="ratio">'+prepay_price+'%</td>'+
			'<td class="in-month">'+month_12+'</td>'+
			'<td class="in-day">'+day_12+'</td>'+
			'</tr>'+
			'<tr  id="nth-18">'+
			'<td class="month">18 tháng</td>'+
			'<td class="ratio">'+prepay_price+'%</td>'+
			'<td class="in-month">'+month_18+'</td>'+
			'<td class="in-day">'+day_18+'</td>'+
			'</tr>');
		$('.tab-read').show();
	}
}