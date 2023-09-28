 <form name="search" id="nsearch" method="<?= $method; ?>" action="<?= $action; ?>" onsubmit="checkHeaderQuickSearch(); return false;">
	 <input type="text" autocomplete="off" placeholder="<?= $placeHolder; ?>" value="<?= $keyWord; ?>" name="<?php echo $keyName; ?>" class="search-field"  id="key" >
	 <button type="submit"class="search-button" id="searchbutton"><i class="fa fa-search" aria-hidden="true"></i></button>
</form>
<script type="text/javascript">
	$('#nsearch').submit(function(){
		var key = $('#key').val();
		if(key == '' || key == "Tìm kiếm...")
		{
			alert('Mời bạn nhập vào từ khóa tìm kiếm');
			$('#key').focus();
			return false
		}
		window.location.href = base_url +'tim-kiem/'+encodeURIComponent(key);
		return false;
	});
</script>