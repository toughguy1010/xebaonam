$(document).ready(function(){
	$("#icon_search").click(function(){
		$(".box-search-show").toggleClass("open");
		return false;
	});
	$(".box-search-show .close").click(function(){
		$(".box-search-show").toggleClass("open");
	});
	 setTimeout(function(){ $('.list_process .item').each(function(index){
		var pt=($(this).attr('value'))*($(this).width())/100;
		$(this).find('span').css('width',pt);
		$(this).find('span').addClass('run');
		$(this).siblings('span').css('left',pt);
		$(this).siblings('span').text($(this).attr('value')+'%');
	});});
	$('.list_page a').each(function(index){
		$(this).click(function(){
			$('.list_page a').each(function(index){
				$(this).removeClass("active");
			});
			$(this).addClass("active");
			$('.list_tab .tab').each(function(indexs){
				$(this).removeClass("active");
				$(this).slideUp();
				if(index==indexs){
					$(this).addClass("active");
					$(this).slideDown();
				}
			});
			return false;
		});
	});
	$('.list_chose .item').each(function(index){
		$(this).find('.number').text(pad2(index+1))
	})
	function pad2(number) {
		return (number < 10 ? '0' : '') + number;
	}
	$('.item-feedback.nav').on('click',function(e){
		var nav = $(this).data('nav');
		$('.owl-caption-feedback').trigger('to.owl.carousel', nav-1);
		$('.owl-img-feedback').trigger('to.owl.carousel', nav-1);
		$('.text_').trigger('to.owl.carousel', nav-1);
	})
	$(".list_faq .item_f").each(function(){
		$(this).find("h4").click(function(){
			$(this).parent().toggleClass("active");
			$(this).siblings(".content").slideToggle();
		});
	})
});