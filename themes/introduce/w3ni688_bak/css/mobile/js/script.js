$(".search_icon_show").click(function() {
	$(".search_box").addClass("open");
});
$(".close_search").click(function() {
	$(".search_box").removeClass("open");
});
$(".shadow-open-menu").click(function () {
	$('.menu-bar-mobile').fadeOut();
	$(".shadow-open-menu").fadeOut();
	$(".menu-btn-show").toggleClass("active");
});
$(".menu-btn-show").click(function () {
	$(this).toggleClass("active");
	$('.menu-bar-mobile').fadeToggle(500);
	$(".shadow-open-menu").fadeToggle(500);
});
 $(".menu-bar-lv-1").each(function(){
   	$(this).find(".span-lv-1").click(function(){
   		$(this).toggleClass('rotate-menu');
   		$(this).parent().find(".menu-bar-lv-2").toggle(500);
   	});

   });
   $(".menu-bar-lv-2").each(function(){
   	$(this).find(".span-lv-2").click(function(){
   		$(this).toggleClass('rotate-menu');
   		$(this).parent().find(".menu-bar-lv-3").toggle(500);
   	});
   });