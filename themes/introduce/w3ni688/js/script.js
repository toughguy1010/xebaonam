function loadMoreItem2(){
	$(".itemba").removeClass("Achide");
	$(".itemba").addClass("Acshow");
	$(".p-item-bound-tet").remove();
}
function seefull(idclass){
		$('.'+idclass).css('height','100%');
		$('.showfull').html('');
		$('.ovlarticle').css('display','none');
	}	
function write360(id,title,path,prefix,number){
	var str2 = '';
	var str ='';
	for (var i = 1; i <= number; i++) {
		var str = '<img alt="'+title+'" src="'+path+''+prefix+''+i+'.jpg" />';
		str2 += str;
	}
	$('#product').append(str2);
}

$(function(){$(document).on('click','.order-product',function(e){var productId=$(this).attr("data-id");var typePopup=$(this).attr("data-type");e.preventDefault();var productvariantId=$(this).attr("data-variantid");var source=getURLParameter('source');var campaignId=$(this).attr("data-cam");var money=$(this).attr("data-money");if(typeof campaignId==="undefined")campaignId=0;if(typeof source==="null")source="";if(money==="undefined")money=0;$.post("/ajax/showPop.php",{productId:productId,campaignID:campaignId,money:money,source:source,promotionId:'',promotionName:'',typePopup:typePopup},function(data){$('.id-popup-order').html(data);$('.id-popup-order').bPopup({speed:450,width:725,height:554,transition:'slideDown',positionStyle:'fixed'});if($(window).width()<750){$('.id-popup-order').css('left','0');}}).complete(function(){e.preventDefault();if(typeof(productvariantId)!="undefined"){$("#productVariantIdOrder").val(productvariantId);}$("#order-submit").submit(function(e){e.preventDefault();$('.ppu_rbnt_submit').hide();$.post("/ajax/AddOrder.php",$('#order-submit').serialize(),function(data){$('.id-popup-order').html(data);}).complete(function(){$('.id-popup-order').bPopup({speed:450,transition:'slideDown'});});});});});})
$(function(){$(document).on('click','.span1',function(e){var id=$(this).attr("data-id");$.post("/ajax/da-videos.php",{id:id},function(data){$('.id-popup-order').html(data);$('.id-popup-order').bPopup({speed:200,width:700,height:554,transition:'slideDown',positionStyle:'fixed'});if($(window).width()<750){$('.id-popup-order').css('left','0');}}).complete(function(){e.preventDefault();if(typeof(productvariantId)!="undefined"){$("#productVariantIdOrder").val(productvariantId);}});});})
$(function(){$(document).on('click','.span0',function(e){var id=$(this).attr("data-id");$.post("/ajax/da-images.php",{id:id},function(data){$('.id-popup-order').html(data);$('.id-popup-order').bPopup({speed:200,width:1280,height:654,transition:'slideDown',positionStyle:'fixed'});if($(window).width()<750){$('.id-popup-order').css('left','0');}}).complete(function(){e.preventDefault();if(typeof(productvariantId)!="undefined"){$("#productVariantIdOrder").val(productvariantId);}});});})
$(function(){$(document).on('click','.span2',function(e){var id=$(this).attr("data-id");$.post("/ajax/da-images360.php",{id:id},function(data){$('.id-popup-order').html(data);$('.id-popup-order').bPopup({speed:200,width:1024,height:554,transition:'slideDown',positionStyle:'fixed'});if($(window).width()<750){$('.id-popup-order').css('left','0');}}).complete(function(){e.preventDefault();if(typeof(productvariantId)!="undefined"){$("#productVariantIdOrder").val(productvariantId);}});});})
function getFullSpec(){$('#normal').addClass('fixparameter');$('#scroollid').attr('style','display:block');$('.fullparameter').attr('style','display:block');}
$(document).ready(function(){setTimeout(function(){$("#adv_onlinefriday").show(800);$(".close_onlinefriday").click(function(){$("#adv_onlinefriday").hide(800);});},5000);});
$(document).ready(function(){$("#owl-demo").owlCarousel({slideSpeed:300,paginationSpeed:400,singleItem:true,autoPlay:3000,stopOnHover:true,});$("#owl-demo3").owlCarousel({pagination:true,navigationText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],autoPlay:false,items:1,navigation:true,pagination:true,itemsDesktop:[1199,1],itemsDesktopSmall:[979,1]});$("#owl-demo2").owlCarousel({autoPlay:3000,items:4,pagination:true,itemsDesktop:[1199,3],itemsDesktopSmall:[979,3]});});$(function(){$(window).scroll(function(){if($(this).scrollTop()!=0){$('#bttop').fadeIn();}else{$('#bttop').fadeOut();}});$('#bttop').click(function(){$('body,html').animate({scrollTop:0},200);});});function showComment(n){$("#form_"+n).toggle()}
function showinfo(){
	$("#btnDescrMore").click(function(){
		"Xem thêm đặc điểm nổi bật ▼"==$(this).html()?($(this).html("Thu gọn đặc điểm nổi bật "),
		$(".product-single .content-descr").addClass("expand")):($(this).html("Xem thêm đặc điểm nổi bật ▼"),
		$(".product-single .content-descr").removeClass("expand"),
		$("body,html").animate({scrollTop:$(".product-single .content-descr").offset().top},800)
		)}
	)}

// $(function(){
	// $('#btnDescrMore2').click(function(){
		// $str = $(this).html();
		// if($str == "Xem thêm đặc điểm nổi bật ▼"){
			// $('#btnDescrMore2').html("Thu gọn đặc điểm nổi bật");
			// $(".moreinfo").addClass("expand");
		// }else{
			// $('#btnDescrMore2').html("Xem thêm đặc điểm nổi bật ▼");
			// $(".moreinfo").removeClass("expand");
			// $("body,html").animate({scrollTop:$(".moreinfo").offset().top},800)
		// }

	// })
// })

	function fotorama(){
	  $(function () {
		  // $('.fotorama').css("display", "block");
		var fotorama = $('.fotorama')
		  .fotorama({
				width: 500,
				ratio: 3/2,
				maxWidth: '1024px',
				allowFullScreen: true,
				fit: 'scaledown',
			})
		  .data('fotorama');
		fotorama.requestFullScreen();
	  });
	}
	function loadMoreInfo(id,number,url,start){
		$str = $('#btnDescrMore2').html();
		if($str == "Xem thêm đặc điểm nổi bật ▼"){
			var array = [];
			var str2 = '';
			var str ='';
			for (var i = start; i <= number; i++) {
				var str = '<li class="liappend"><img src="'+url+''+i+'.jpg" style="width:100%;height:100%;"></li>';
				str2 += str;
			}
			$('.ulitemda').append(str2);
			$('#btnDescrMore2').html("Thu gọn đặc điểm nổi bật");
			$(".moreinfo").addClass("expand");
		}else{
			$('#btnDescrMore2').html("Xem thêm đặc điểm nổi bật ▼");
			$(".moreinfo").removeClass("expand");
			$(".liappend").html("");
			$("body,html").animate({scrollTop:$(".moreinfo").offset().top},800)
		}
	}


function loadMoreCom(id,number){
					$(document).on("click","#loadMoreCom",function(t){
					$('#loadMoreCom').attr('class','').html('<img class="imgload" src="style/img/loading_win10.gif" style="width:35px;height:35px;">');
						var html='';
						$.ajax({
							type:'GET',
							dataType:'json',
							url:'/ajax/dataloadmoreCom.php',
							data : {
									"id" : id,
									"start" : number
									},
							success:function(result){
							$.each(result,function(key,obj){
									html+='		<li style="display: list-item;"><div class="comment-item">';
									html+='				<div class="avatar"><img src="/style/img/avatar.jpg" style="width:100%"></div>';
									html+='				<div class="content">';
									html+='					<p class="intro">';
									html+='						<strong class="name">'+obj.fullname+'</strong>';
									html+='						<span>- '+obj.log+'</span>';
									html+='					</p>';
									html+='					<div class="comment-details"><p>'+obj.messenger+'</p></div>';
									html+='				<div class="child-contaier">';
									html+='				<div class="comment-item">';
									html+='							<div class="avatar"><img src="/style/img/logo-admin.jpg" style="width:100%"></div>';
									html+='								<div class="content" style="width:605px;">';
									html+='								<p class="intro"><strong class="name admin">Admin</strong> <i>(Quản trị viên)</i><span>- '+obj.log+'</span></p>';
									html+='								<div class="comment-details">'+obj.reply+'';
									html+='								<p class="tools"><a href="javascript:;" onclick="showComment('+obj.id+');" class="showComment">';
									html+='								<span>Trả lời</span> ';
									html+='								<i class="fa fa-comments"></i>';
									html+='								</a>';
									html+='								<a data-id="175445" href="javascript:;" class="like"><span class="text">Thích</span> ';
									html+='								<i class="fa fa-thumbs-o-up"></i> <span>0</span></a></p>';
									html+='									<div class="comment-child-form" id=form_'+obj.id+' style="">';
									html+='									<form class="postComment">';
									html+='										<input type="hidden" value="product" id=typeProduct'+obj.id+'>';
									html+='										<input type="hidden" value="'+obj.id+'" id=pardenid'+obj.id+'>';
									html+='										<input type="hidden" value="" id=idproductc'+obj.id+'>';
									html+='										<input type="hidden" value="" id=txtimagec'+obj.id+'>';
									html+='										<input type="hidden" value='+obj.title+' id=txttitlec'+obj.id+'>';
									html+='										<input type="hidden" name=pt'+obj.id+' value='+obj.id+'>';
									html+='										<input id=txtnamecc'+obj.id+' class="textComment userFullname" name="UserFullname" placeholder="Họ tên của bạn">';
									html+='										<input id=txtemailcc'+obj.id+' class="textComment userEmail" name="UserEmail" placeholder="Email của bạn">';
									html+='										<textarea spellcheck="false" id=Contentc'+obj.id+' placeholder="Mời bạn nhập câu hỏi hoặc đánh giá cho sản phẩm." name="c"></textarea>';
									html+='										<input class="input-nxdg btn-hover" id="submit" type="button" style="float:left;" value="Bình luận" onclick="comment2('+obj.id+',1,'+obj.id+');">';
									html+='									</form>';
									html+='									<div class="info" id=ketqua'+obj.id+' style="padding-top: 5px; margin-left: 0px !important"></div>';
									html+='								</div>';
									html+='							</div>';
									html+='						</div>';
									html+='				</div>';
									html+='				</div>';
									html+='			</div>';
									html+='		</li>';

									
									
								})
								number = number+8;
								var string = '<button onclick="loadMoreCom('+id+','+number+');" id="loadMoreCom">Xem thêm bình luận khác...</button>';
								$('#myList').append(html);
								$('#centerId').html('');
								$('#centerId').append(string);
							}
						
						// $('#icoload').attr('class','fa fa-play').html('');
						// $('#loadMoreItem').remove();}})
					});
					})
				}	
		
function appendimg(id){$('.imgmenu').hover(function(){var img=$(this).attr('data-img');$('#img-menu'+id).attr('src',img);})}function loadMoreinfo(){size_li=$("#boxspecification li").size();x=10;$('#boxspecification li:lt('+x+')').show();$('#dropdown').click(function(){x=(x+5<=size_li)?x+5:size_li;$('#boxspecification li:lt('+x+')').show();});$('#showLess').click(function(){x=(x-5<0)?3:x-5;$('#boxspecification li').not(':lt('+x+')').hide();});}function loadMoreComment(){size_li=$("#myList li").size();x=3;$('#myList li:lt('+x+')').show();$('#loadMore').click(function(){x=(x+5<=size_li)?x+5:size_li;$('#myList li:lt('+x+')').show();});$('#showLess').click(function(){x=(x-5<0)?3:x-5;$('#myList li').not(':lt('+x+')').hide();});}
function showVideo(id){url=$('.liVideos'+id).data("linkvideo");
url=url+='?autoplay=1';$('#video').attr('src',url);$('#videop').attr('src',url);$('.list-video li').attr('id','');$('.list-video .liVideos'+id).attr('id','active');}function goToByScroll(id){id=id.replace("link","");$('html,body').animate({scrollTop:$("#"+id).offset().top},'slow');}$("#sidebar > ul > li > a").click(function(e){e.preventDefault();goToByScroll($(this).attr("id"));});function comment2(){var base_url='https://xedien.com.vn/ajax/comment-child.php';var idproduct=$('#idproductc').val();var txtnamec=$('#txtnamecc').val();var txtemailc=$('#txtemailcc').val();var content=$('#Contentc').val();var idparent=$('#idparent').val();var pardenid=$('#pardenid').val();var title=$('#txttitlec').val();var image='';var postdata='name='+txtnamec+'&email='+txtemailc+'&content='+content+'&idproduct='+idproduct+'&title='+title+'&image='+image+'&pardenid='+pardenid;document.getElementById('ketqua2').innerHTML='<img src=/style/img/loading.gif />';$.ajax({type:"POST",url:base_url,data:postdata,success:function(data){if(data==1){$('#txtnamecc').attr('value','');$('#txtemailcc').attr('value','');$('#Contentc').attr('value','');document.getElementById('ketqua2').innerHTML="<p style='margin-top:10px;color:red;'>Cảm ơn bạn đã gửi ý kiến ! </p>";setTimeout(function(){$(".comment-child-form").hide();},2000);}else{alert('Lá»—i2 !');}},error:function(){alert('Lá»—i !');}});}function hoidap(){var base_url='https://xedien.com.vn/ajax/hoidap.php';var idproduct=$('#idproduct').val();var txtnamec=$('#txtnamec').val();var txtemailc=$('#txtemailc').val();var title=$('#txttitle').val();var image=$('#txtimage').val();var content=$("div.nicEdit-main").html();if(txtnamec==""&&txtemailc==""){$('.cm_form_send_with_name').show('fast');}else{var postdata='name='+txtnamec+'&email='+txtemailc+'&content='+content+'&idproduct='+idproduct+'&title='+title+'&image='+image;document.getElementById('ketqua').innerHTML='<img src=/style/img/loading.gif />';$.ajax({type:"POST",url:base_url,data:postdata,success:function(data){if(data==1){$('#txtnamec').attr('value','');$('#txtemailc').attr('value','');$('#Content').attr('value','');document.getElementById('ketqua').innerHTML="<p style='margin-top:10px;color:red;'>Cáº£m Æ¡n báº¡n Ä‘Ã£ gá»­i Ã½ kiáº¿n, quáº£n trá»‹ viÃªn sáº½ tráº£ lá»i cÃ¢u há»i cá»§a báº¡n sá»›m nháº¥t cÃ³ thá»ƒ ! </p>";setTimeout(function(){$(".cm_form_send_with_name").hide();},2000);}else{alert('Lá»—i2 !');}},error:function(){alert('Lá»—i !');}});}}function comment(type){var base_url='https://xedien.com.vn/ajax/comment.php';var idproduct=$('#idproduct').val();var txtnamec=$('#txtnamec').val();var txtemailc=$('#txtemailc').val();var content=$('#Content').val();var title=$('#txttitle').val();var image=$('#txtimage').val();if(txtnamec==""&&txtemailc==""){$('.cm_form_send_with_name').show('fast');}else{var postdata='name='+txtnamec+'&email='+txtemailc+'&content='+content+'&idproduct='+idproduct+'&title='+title+'&image='+image+'&type='+type;document.getElementById('ketqua').innerHTML='<img src=/style/img/loading.gif />';$.ajax({type:"POST",url:base_url,data:postdata,success:function(data){if(data==1){strnew='<li><div class="comment-item">';strnew+='<div class="avatar"><img src="/style/img/avatar.jpg" style="width:100%"></div>';strnew+='<div class="content">';strnew+='		<p class="intro">';strnew+='		<strong class="name">'+txtnamec+'</strong>';strnew+='		<span>- Vừa xong</span>';strnew+='		</p>';strnew+='	<div class="comment-details"><p>'+content+'</p></div>';strnew+='		<p class="tools"><a href="javascript:;" onclick="showComment();" class="showComment">';strnew+='				<span>Tráº£ lá»i</span> ';strnew+='				<i class="fa fa-comments"></i>';strnew+='				</a>';strnew+='					<a data-id="175445" href="javascript:;" class="like"><span class="text">ThÃ­ch</span> ';strnew+='					<i class="fa fa-thumbs-o-up"></i> <span>0</span></a></p>';strnew+='	<div class="child-contaier">';strnew+='	</div>';strnew+='	</div>';strnew+='</li>';$('#ShopCommentForm input[type=text], textarea').val('');$('#myList li:first').append(strnew);document.getElementById('ketqua').innerHTML="<p style='margin-top:10px;color:red;'>Cảm ơn bạn đã gửi ý kiến đóng góp, quản trị viên sẽ trả lời cầu hỏi của bạn sớm nhất có thể ! </p>";setTimeout(function(){$(".cm_form_send_with_name").hide();},2000);}else{alert('Lá»—i2 !');}},error:function(){alert('Lá»—i !');}});}}function filter_home(){var a=$('#txtCode').val();if(a==''){alert('Báº¡n chÆ°a nháº­p mÃ£ báº£o hÃ nh');$('#txtCode').focus();return false;}else{window.location.href='/kiem-tra-bao-hanh_'+a+'.html';}}$(function(){$('.thumimg').hover(function(){var img=$(this).attr('title');$('#view-img').attr('src',img);});});

$(function(){$('.thumimg2').hover(function(){
	var r=$(this).closest(".lii1");
	var a1=$('.lii1').find('.callout_right2').attr('src','');
	var a=r.find('.callout_right2').attr('src','/style/img/callout-right.gif');
	var img=$(this).attr('title');
	var title=$(this).data('title');
	var img_maps=$(this).attr('data-img');
	$('#view-img2').attr('src',img);
	// $(this).attr('src','/style/img/callout-right.gif');
	$('#textId').html(title);
	$('#view-map').addClass('active');
	});
});
	
$(function(){$('a.cl').click(function(){alert('fsafsa');});});$(function(){$('.btch .close').click(function(){$('.btch').hide();});});function removePrice(str){var str=str.replace(".","");var str=str.replace(".","");var str=str.replace(".","");var str=str.replace(".","");var str=str.replace(".","");return str;}
function loadMoreItem(id){$('#icoload').attr('class','').html('<img class="imgload" src="style/img/loading_win10.gif">');
var html='',urlItem;$.ajax({
	type:'GET',dataType:'json',url:'/ajax/dataloadmore.php',data:{id:id},success:function(result){$.each(result,function(key,obj){
		var phantram=0,giam = 0;
		if(obj.promotion!=''){
			tPrice=removePrice(obj.price);
			tPromotion=removePrice(obj.promotion);
		phantram=Math.ceil((1-tPrice/tPromotion)*100);
		giam =(tPromotion - tPrice)/1000000;
	}
	
		if(obj.urlitem1!=""){urlItem=obj.urlitem1;}else{urlItem=obj.urlitem;}html+='<li class="productmain product pbodermain pboder">';
		html+='			<div class="more-infomain">';html+='				<div class="mproduct product">';
		html+='					<input type="hidden" value="'+obj.id+'" name="dataid" class="dataid">';
		html+='					<div class="product1 " id="productss">';
		html+='						<a href="/'+urlItem+'.html" title="'+obj.title+'">';
		html+='							<div class="product-image">';
		html+='								<span class="product-gif"><span class="giam">'+giam+'</span><span><img src="/style/img/gif33.gif"></span></span>';
		html+='								<span class="product-gift">';
		html+='								<i class="iclass"></i>';
		html+='								</span>';html+='								<div class="image" id="imagess">';html+='									<img src="/'+obj.avatar+'" alt="'+obj.title+'">';html+='								</div>';html+='							</div>';html+='						</a>';html+='						<div class="product-info">';html+='							<h6 class="name wrap"><a class="name" href="/'+urlItem+'.html" title="'+obj.title+'">'+obj.title+'</a></h6>';html+='									<div class="priceInfo conPrice">';html+='										<span class="pri1 left old-price">'+obj.promotion+' đ</span>';html+='										<span class="pri2 phantram right"> -'+phantram+'% </span>';html+='										<span class="pri1 left price">'+obj.price+'<span class="symbol">đ</span><!--span class="ckm"> +khuyến mại</span--></span>';html+='									</div>';html+='							<div class="priceInfo">';html+='								<span style="padding-top:5px;padding-left:10px;float:left;"><span style="color:#2DCC70;">Còn hàng</span></span>';html+='							</div>';html+='						</div>';html+='					</div>';html+='				</div>';html+='				<div class="texthome text-left gif">';html+='					<table class="">';html+='						<tbody><tr>';html+='							</tr><tr>';html+='								<td><i class="fa fa-gift"></i></td>';
		html+='								<td><span><span>-Tặng mũ bảo hiểm trị giá 220.000 đ.</span><span style="">- Mua trả góp lãi xuất 0%</span></span></td>';
		html+='							</tr>';html+='					</table>';html+='				</div>				';html+='				<div class="num_view"><label>Hơn '+obj.view+' lượt xem tuần qua</label></div>				';html+='						<div class="sspro1 text-right">';html+='					    	<button id="sspro" href="#" rel="nofollow" class="append text-right">Chọn so sánh </button>	';html+='				     	</div>	';html+='				<div class="moreinfokt">';html+='					<a href="/'+urlItem+'.html">		';html+='						<span><i class="fa fa-check" aria-hidden="true"></i> <span> '+obj.loai_acquy+'</span></span>	';html+='						<span><i class="fa fa-check" aria-hidden="true"></i> Xuất xứ: <span> '+obj.xuat_xu+'</span></span>	';html+='						<span><i class="fa fa-check" aria-hidden="true"></i> Công suất: <span> '+obj.cong_xuat+'</span></span>	';html+='			</div>';html+='		</div>';html+='	</li>';});
		var Lid=id+23;if(Lid<40){html+='<li class="" id="loadMoreItem" onclick="loadMoreItem('+Lid+');">';
		html+='<div class="p-item-bound">';html+='<a class="p-more" data-current="15">';html+='<span>';
		html+='	<i id="icoload" class="fa fa-play"></i>';html+='	<label>Xem thêm <strong>12</strong> sản phẩm</label>';html+='</span>';html+='</a>';html+='</div>';html+='<div class="botMore">';html+='<span><img src="upimages/articles/avatar/xe-dien-xman-5-yadea-2016.png" style="width:85px;"></span><span><img src="upimages/articles/xmen/2015/xe-may-dien-xmen-yadea-5-do-ava.png" style="width:85px;"></span><span><img src="upimages/articles/honda/printz/xe-dien-honda-prinz-av.png" style="width:85px;"></span><span><img src="upimages/articles/giant/Lyva/xe-dien-lavy-avatar.png" style="width:85px;"></span><span><img src="upimages/articles/avatar/xe-dien-gogolo-dibao.png" style="width:85px;"></span><span><img src="upimages/articles/giant/GIANTM133S%2B/giants001(1).png" style="width:85px;"></span><span><img src="upimages/articles/giant/m133s/xe-dien-giant-m133s-nhap-khau.png" style="width:85px;"></span>											<span><strong class="strong2">.....</strong></span>';html+='</div>';html+=' </li>';}$('#mainItem').append(html);$('#icoload').attr('class','fa fa-play').html('');$('#loadMoreItem').remove();}})}function loadMap(){}function regiterPromotionEmail(){$(document).on("click","#btnFMailSubmit",function(t){var email=$('#txtFMailAddress').val();if(email==''){alert('Vui lòng nhập Email của bạn !');$('#txtFMailAddress').focus();return;}else{var postdata='email='+email;$.ajax({type:"POST",url:'/ajax/insertemail.php',data:postdata,success:function(data){if(data==1){$('#txtFMailAddress').val('');$(".toast-container").show(1000);document.getElementById('toast').innerHTML='<div class="toast-item-wrapper"><div class="toast-item toast-type-warning"><div class="toast-item-image toast-item-image-success"></div><div class="toast-item-close"></div><p>Hệ thống đã tiếp nhận thông tin đăng ký của bạn, Thế Giới Xe Điện sẽ gửi thông tin qua email cho bạn mỗi khi có chương trình khuyến mãi.</p></div></div>';setTimeout(function(){$(".toast-container").hide(1000);},5000);}else if(data==2){$('#txtFMailAddress').val('');$(".toast-container").show(1000);document.getElementById('toast').innerHTML='<div class="warning toast-item-wrapper"><div class="toast-item toast-type-warning"><div class="toast-item-image toast-item-image-warning"></div><div class="toast-item-close"></div><p>Email này đã tồn tại trong hệ thống đăng ký nhận tin khuyến mại.</p></div></div>';setTimeout(function(){$(".toast-container").hide(1000);},5000);}else{alert('Lỗi !');}}})}})}function addProductCompare(id){var img=$('#pare'+id).attr('data-img');var price=$('#pare'+id).attr('data-price');var title=$('#pare'+id).attr('data-title');var href=$('#pare'+id).attr('data-href');var v=$('#pare'+id).attr('data-v');var q=$('#pare'+id).attr('data-q');var a=$('#pare'+id).attr('data-a');var textApp='';textApp+='<div class ="cp-item-image">';textApp+='<a href="'+id+'" target="_blank">'
textApp+='<img class="lazy" data-original="'+img+'" src="/'+img+'" title="'+title+'" alt="'+title+'" style="display: inline;">';textApp+='</a>';textApp+='</div>';textApp+='<h3 class="cp-item-name">';textApp+='<a href="/'+href+'.html" target="_blank">'+title+'</a>';textApp+='</h3>';textApp+='<span class="cp-item-price">';textApp+='<span class="current-price"><strong>'+price+'</strong>đ</span>';textApp+='</span>';textApp+='<div class="cp-item-promotion">';textApp+='</div>';textApp+='';var textTskt='';textTskt+='		<div class="cp-content">';textTskt+='			<ul>';textTskt+='				<li>Acquy: '+a+'</li>';textTskt+='				<li>Quãng đường đi được: '+q+'</li>';textTskt+='				<li>Vận tốc: '+v+'</li>';textTskt+='			</ul>';textTskt+='						</div>';textTskt+='';var linkss;linkss=$('#butss').attr('href');linkss+='-vs-';linkss+=id;$('#butss').attr('href',linkss);$('.cp-table>li').attr('style','width:17% !important');$('#addCompare').html('');$('#Mtskt').html('');$('#Mtskt').append(textTskt);$('#addCompare').append(textApp);}$(document).on("click","#sspro",function(t){var i,j,str,qPr;j=$(".comparebox .comparelist ul li.apped").size();if(j==0){qPr='qPr1';str='<li id="qPr2" class="nodata comlist compareitem" data-id="" data-cate=""><form action="javascript:void(0)"><input class="compare-search" type="search" name="" onkeyup="qcp_SuggestCompare(this,event)"  placeholder="So sánh xe này với ..." ><button type="submit"><i class="icontgdd-scomp"></i></button></form><div class="atc-resultCom"></div></li>';str+='<li id="qPr3" class="nodata comlist compareitem" data-id="" data-cate=""><form action="javascript:void(0)"><input class="compare-searchhome1"  type="search" name="" onkeyup="qcp_SuggestCompare(this,event)"  placeholder="So sánh xe với..." ><button type="submit"><i class="icontgdd-scomp"></i></button></form><div class="atc-resultCom"></div></li>';}else if(j==1){qPr='qPr2';$(".comparebox .comparelist ul li.comlist").remove();str='<li id="qPr3" class="nodata comlist compareitem" data-id="" data-cate=""><form action="javascript:void(0)"><input class="compare-search" type="search" name="" onkeyup="qcp_SuggestCompare(this,event)"  placeholder="So sánh..." ><button type="submit"><i class="icontgdd-scomp"></i></button></form><div class="atc-resultCom"></div></li>';}else if(j==2){qPr='qPr3';$(".comparebox .comparelist ul li.comlist").remove();str="";}if(j>2){alert('So sánh tối đa 3 sản phẩm');}else{var r=$(this).closest(".product"),u=r.find(".name").text(),view=r.find(".num_view").text(),e=r.find(".price").html(),o=r.find(".image").html(),id=r.find(".dataid").val(),s=r.find(".wrap > a").attr("href"),f=$(this).data("type"),h='<li id="'+qPr+'" class="apped homeApp compareitem" data-id="'+id+'" data-type="'+f+'" data-ascii="'+$(this).data("ascii")+'"><a title="'+u+'" href="'+s+'"><div class="image">'+o+'<\/div><div class="info"><h3 class="name">'+u+'<\/h3><div class="price">'+e+'<\/div><div class="view">hơn '+view+' lượt xem tuần qua<\/div><\/div><\/a><a onclick= "n();" class="cl close" href="javascript:void(0)">Remove<\/a><\/li>';if(i=$(".comparebox .comparelist ul"),i.find('li[data-id="'+id+'"]').size()>0){alert('Đã tòn tại sản phẩm này trong danh sách chọn');}else{$(".comparebox .comparelist ul").append(h).append(str);$(".comparebox").show();}$(".comparebox .submit").click(function(){if($(".comparelist li.compareitem").size()>0){var n="";$(".comparelist li.compareitem").each(function(){if($(this).data("id")!=""){n+=n==""?$(this).data("id"):"-vs-"+$(this).data("id");}});window.location.href="/so-sanh-san-pham_"+n}else $().toastmessage("showWarningToast","Báº¡n cáº§n sáº£n pháº©m Ä‘á»ƒ so sÃ¡nh.")})}})
function qcp_SuggestCompare(n,t){var u=0,i,r;qcp_currID=$(n).parent().parent().attr("id");u==""&&(u=42);var e=u,o=$(n).val().replace(/:|;|!|@@|#|\$|%|\^|&|\*|'|"|>|<|,|\.|\?|\/|`|~|\+|=|_|\(|\)|{|}|\[|\]|\\|\|/gi,""),f=o.trim().toLowerCase();if(f.length<2){$(".wrapper-compare .search-suggestion-list").hide();$(".popAddProd").css("height","250px");return}if(i=".search-suggestion-list li",t.which==13?$(i+".selected").find("a").click():t.which!=40&&t.which!=38&&$.ajax({url:"/ajax/getProCom.php",type:"GET",dataType:'json',data:{sKeyword:f},cache:!0,success:function(result){$.each(result,function(key,obj){id=obj.id;title=obj.title;price=obj.price;urlitem='/'+obj.urlitem+'.html';avatar=obj.avatar;view=obj.view;html='<div data-id="'+id+'" class="Pare" onclick="addComPaHome('+id+')"><a id = "pare'+id+'" data-parent = "'+qcp_currID+'"data-title = "'+title+'" data-img="'+avatar+'" data-view="'+view+'"  data-price="'+price+'" data-href="'+urlitem+'">'+title+'</a></div>';$('#'+qcp_currID+' .atc-resultCom').append(html);})
$('#'+qcp_currID+' .atc-resultCom').show();}}),t.which==40){$(i+".selected").length==0?($(i+":first").addClass("selected"),$(".sp #inputproduct").val($(i+":first").text())):$(i+".selected").text()==$(i+":last").text()?($(i+".selected").removeClass("selected"),$(i+":first").addClass("selected"),$(".sp #inputproduct").val($(i+":first").text())):(r=$(i+".selected").next(),$(i+".selected").removeClass("selected"),r.addClass("selected"),$(".sp #inputproduct").val(r.text()));return}if(t.which==38){$(i+".selected").length==0?($(i+":last").addClass("selected"),$(".sp #inputproduct").val($(i+":last").text())):$(i+".selected").text()==$(i+":first").text()?($(i+".selected").removeClass("selected"),$(i+":last").addClass("selected"),$(".sp #inputproduct").val($(i+":last").text())):(r=$(i+".selected").prev(),$(i+".selected").removeClass("selected"),r.addClass("selected"),$(".sp #inputproduct").val(r.text()));return}}function addComPaHome(id){if(i=$(".comparebox .comparelist ul"),i.find('li[data-id="'+id+'"]').size()>0){alert('Đã tồn tại sản phẩm này trong danh sách chọn');}else{var parenId='#'+$('#pare'+id).attr('data-parent');var img=$('#pare'+id).attr('data-img');var view=$('#pare'+id).attr('data-view');var price=$('#pare'+id).attr('data-price');var title=$('#pare'+id).attr('data-title');var href=$('#pare'+id).attr('data-href');var v=$('#pare'+id).attr('data-v');var q=$('#pare'+id).attr('data-q');var a=$('#pare'+id).attr('data-a');var textApp='';textApp+='<a title="'+title+'" href="'+href+'"><div class="image">';textApp+='<img src="'+img+'" alt="'+title+'">';textApp+='</div><div class="info"><h3 class="name">'+title+'</h3><div class="price">'+price+'<span class="symbol">đ</span></div><div class="view">Hơn  '+view+' lượt xem trong tuần qua</div></div></a><a onclick="n();" class="cl close" href="javascript:void(0)">Remove</a>';$(parenId).html('').removeClass('comlist xoa');$(parenId).append(textApp).attr('data-id',id).addClass('apped');}}function qcp_on_off(){$('.item-compare-product li').remove();$('.compareboxfixed').hide();}$(document).ready(function(){var curr_text="";var count_select=0;var curr_element="";$(".compare-search").keyup(function(b){if(b.keyCode!=38&&b.keyCode!=40){inputString=$(this).val();if(inputString.trim()!=''){$(".atc-result-hoidap").show();$(".atc-result-hoidap").load("/ajax/get_product_list_hoidap.php?template=header&q="+encodeURIComponent(inputString));}else{$(".autocomplete-suggestions").hide();count_select=0;}}if(b.keyCode==40){count_select++;curr_element=$(".autocomplete-suggestion:nth-child("+count_select+")");curr_text=curr_element.find(".suggest_link").text();$("#key").val(curr_text);$(".autocomplete-suggestion").removeClass("selected");$(curr_element).addClass("selected");}if(b.keyCode==38&&count_select>1){count_select--;curr_element=$(".autocomplete-suggestion:nth-child("+count_select+")");curr_text=curr_element.find(".suggest_link").text();$("#key").val(curr_text);$(".autocomplete-suggestion").removeClass("selected");$(curr_element).addClass("selected");}$('.atc-result-hoidap').css({"background":'#fff',"border":'1px solid #ddd'});});});$(document).ready(function(){$(".item-compare-product").on('click','.close',function(){id='#'+$(this).parent().attr('id');$(this).parents('li').html('');$(id).attr("data-id","");str='<form action="javascript:void(0)"><input class="compare-search" type="search" name="" onkeyup="qcp_SuggestCompare(this,event)"  placeholder="So sánh với ..." ><button type="submit"><i class="icontgdd-scomp"></i></button></form><div class="atc-resultCom"></div>';$(id).append(str).addClass('comlist xoa').removeClass('apped');if(i=$(".comparebox .comparelist ul li.apped").size()==0){$(".comparebox li").remove();$(".comparebox").hide();}});});function n(){$(".comparebox .comparelist ul").carouFredSel({auto:!1,prev:".comparebox .comparelist .prev",next:".comparebox .comparelist .next"});$(".comparebox .compareitem .close").unbind("click");$(".comparebox .compareitem .close").click(function(t){t.preventDefault();var i=$(this).closest("li"),r=i.find("h6.name").text();i.remove();$(".item-compare-product li").size()==0&&$(".comparebox").hide();alert('ÄÃ£ xÃ³a '+r+' khá»i danh sÃ¡ch so sÃ¡nh sáº£n pháº©m.');n()})}$window=$(window);var lastScrollTop=0;$window.scroll(function(){var st=$(this).scrollTop();if(st>lastScrollTop){if($window.scrollTop()>600){$('.navtop').css({'position':'fixed','z-index':'990','top':'0px','display':'block','width':'100%','box-shadow':'0px 2px 3px #ddd','background':'#F7F4F4',});$('.navtopcenter').css({'position':'relative','z-index':'990','margin-left':'auto','margin-right':'auto',});$('.homehsx').addClass('newlogo');$('.logoxedien').show('200');}else{$('.navtop').css({'position':'inherit','box-shadow':'none','background':'none'});$('.logoxedien').hide();$('.homehsx').removeClass('newlogo');}}});$(document).ready(function(){var curr_text="";var count_select=0;var curr_element="";$("#key").keyup(function(b){if(b.keyCode!=38&&b.keyCode!=40){inputString=$(this).val();if(inputString.trim()!=''){$(".autocomplete-suggestions").show();$(".autocomplete-suggestions").load("/ajax/get_product_list.php?template=header&q="+encodeURIComponent(inputString));}else{$(".autocomplete-suggestions").hide();count_select=0;}}if(b.keyCode==40){count_select++;curr_element=$(".autocomplete-suggestion:nth-child("+count_select+")");curr_text=curr_element.find(".suggest_link").text();$("#key").val(curr_text);$(".autocomplete-suggestion").removeClass("selected");$(curr_element).addClass("selected");}if(b.keyCode==38&&count_select>1){count_select--;curr_element=$(".autocomplete-suggestion:nth-child("+count_select+")");curr_text=curr_element.find(".suggest_link").text();$("#key").val(curr_text);$(".autocomplete-suggestion").removeClass("selected");$(curr_element).addClass("selected");}});});$(document).ready(function(){var curr_text="";var count_select=0;var curr_element="";$(".compare-search").keyup(function(b){if(b.keyCode!=38&&b.keyCode!=40){inputString=$(this).val();if(inputString.trim()!=''){$(".atc-result").show();$(".atc-result").load("/ajax/get_product_list2.php?template=header&q="+encodeURIComponent(inputString));}else{$(".autocomplete-suggestions").hide();count_select=0;}}if(b.keyCode==40){count_select++;curr_element=$(".autocomplete-suggestion:nth-child("+count_select+")");curr_text=curr_element.find(".suggest_link").text();$("#key").val(curr_text);$(".autocomplete-suggestion").removeClass("selected");$(curr_element).addClass("selected");}if(b.keyCode==38&&count_select>1){count_select--;curr_element=$(".autocomplete-suggestion:nth-child("+count_select+")");curr_text=curr_element.find(".suggest_link").text();$("#key").val(curr_text);$(".autocomplete-suggestion").removeClass("selected");$(curr_element).addClass("selected");}});});$(document).ready(function(){var curr_text="";var count_select=0;var curr_element="";$(".compare-search2").keyup(function(b){if(b.keyCode!=38&&b.keyCode!=40){inputString=$(this).val();var datalink=$(this).attr('data-link');if(inputString.trim()!=''){$(".atc-result").show();$(".atc-result").load("/ajax/getProductSS.php?template=header&link="+datalink+"&q="+encodeURIComponent(inputString));}else{$(".autocomplete-suggestions").hide();count_select=0;}}if(b.keyCode==40){count_select++;curr_element=$(".autocomplete-suggestion:nth-child("+count_select+")");curr_text=curr_element.find(".suggest_link").text();$("#key").val(curr_text);$(".autocomplete-suggestion").removeClass("selected");$(curr_element).addClass("selected");}if(b.keyCode==38&&count_select>1){count_select--;curr_element=$(".autocomplete-suggestion:nth-child("+count_select+")");curr_text=curr_element.find(".suggest_link").text();$("#key").val(curr_text);$(".autocomplete-suggestion").removeClass("selected");$(curr_element).addClass("selected");}});});function comment2vd(id,type,idresult){var base_url='https://xedien.com.vn/ajax/comment-child.php';var idproduct=$('#idproductc'+idresult).val();var txtnamec=$('#txtnamecc'+idresult).val();var txtemailc=$('#txtemailcc'+idresult).val();var content=$('#Contentc'+idresult).val();var idparent=$('#idparent'+idresult).val();var pardenid=$('#pardenid'+idresult).val();var title=$('#txttitlec'+idresult).val();var image='';var postdata='name='+txtnamec+'&email='+txtemailc+'&content='+content+'&idproduct='+id+'&title='+title+'&image='+image+'&pardenid='+pardenid+'&type='+type;document.getElementById('ketqua'+idresult).innerHTML='<img src=/style/img/loading.gif />';$.ajax({type:"POST",url:base_url,data:postdata,success:function(data){if(data==1){$('#txtnamecc'+idresult).attr('value','');$('#txtemailcc'+idresult).attr('value','');$('#Contentc'+idresult).attr('value','');document.getElementById('ketqua'+idresult).innerHTML="<p style='margin-top:10px;color:red;'Cảm ơn bạn đã gửi ý kiến đánh giá, quản trị viên sẽ hồ đáp câu hỏi của bạn sớm nhất có thể ! </p>";setTimeout(function(){$(".comment-child-form").hide();},4000);}else{alert('Lá»—i2 !');}},error:function(){alert('Lá»—i !');}});}function viewDetail(id,fied,divApp){var base_url='https://xedien.com.vn/ajax/getFiedById.php';var a=$('#'+divApp).text().length;if(a==1){$.ajax({type:'GET',dataType:'json',url:base_url,data:{id:id},success:function(result){$.each(result,function(key,obj){$('#'+divApp).append(obj.content);})}})}else{$('#'+divApp).append('Lá»—i!');}$('#detail').css("display","block");$('#ajxarticle').css("display","block");}function addProductHoidap(id){var img=$('#pare'+id).attr('data-img');var price=$('#pare'+id).attr('data-price');var title=$('#pare'+id).attr('data-title');var href=$('#pare'+id).attr('data-href');var v=$('#pare'+id).attr('data-v');var q=$('#pare'+id).attr('data-q');var a=$('#pare'+id).attr('data-a');var textApp='<li>';textApp+='<div class="fr-product-item col-md-5ths col-sm-3 col-xs-6">';textApp+='	<div class="fr-product-item-image">';textApp+='			<a href="/'+href+'.html">';textApp+='				<img src="/'+img+'" title="'+title+'">';textApp+='			</a>';textApp+='	</div>';textApp+='	<div class="fr-product-item-content">'
textApp+='		<h3><a href="/'+href+'.html">'+title+'</a>';textApp+='		</h3>';textApp+='		<span class="fr-product-question-quantity">7 câu hỏi</span>';textApp+='	</div>';textApp+='</div>';textApp+='</li>';$('.question').append(textApp);$('.atc-result-hoidap').hide();$('.atc-result-hoidap').css({"background":'none',"border":'none'});$('.compare-search').val('');}function bodauTiengViet(str){str=str.toLowerCase();str=str.replace(/Ã |Ã¡|áº¡|áº£|Ã£|Ã¢|áº§|áº¥|áº­|áº©|áº«|Äƒ|áº±|áº¯|áº·|áº³|áºµ/g,"a");str=str.replace(/Ã¨|Ã©|áº¹|áº»|áº½|Ãª|á»|áº¿|á»‡|á»ƒ|á»…/g,"e");str=str.replace(/Ã¬|Ã­|á»‹|á»‰|Ä©/g,"i");str=str.replace(/Ã²|Ã³|á»|á»|Ãµ|Ã´|á»“|á»‘|á»™|á»•|á»—|Æ¡|á»|á»›|á»£|á»Ÿ|á»¡/g,"o");str=str.replace(/Ã¹|Ãº|á»¥|á»§|Å©|Æ°|á»«|á»©|á»±|á»­|á»¯/g,"u");str=str.replace(/á»³|Ã½|á»µ|á»·|á»¹/g,"y");str=str.replace(/Ä‘/g,"d");return str;}function postQues(){var a=$('#txt-search-forum').val();if(a==''){alert('Nhập từ khóa tìm kiếm .');$('#txt-search-forum').focus();return false;}else{a=bodauTiengViet(a);a=a.replace(" ","_");a=a.replace(" ","_");a=a.replace(" ","_");a=a.replace(" ","_");a=a.replace(" ","_");a=a.replace(" ","_");a=a.replace(" ","_");a=a.replace(" ","_");a=a.replace(" ","_");a=a.replace(" ","_");window.location.href='/hoi-dap/tim-kiem_'+a+'.html';}}function closeDetail(){$('#detail').css("display","none");$('#ajxarticle').css("display","none");}
	$(document).ready(function(){
			$('.closebtn').click(function(){
			$('#normal').removeClass('fixparameter');
			$('#scroollid').attr('style','display:none');
			$('.fullparameter').attr('style','display:none');});
	
			})
			$(document).ready(function(){

			$('#normal').click(function(){
			$('#normal').removeClass('fixparameter');
			$('#scroollid').attr('style','display:none');
			$('.fullparameter').attr('style','display:none');});
			
			
			})
	function init(number,imagePath,filePrefix,play,idac){
		$('.ulcolor li').removeClass("selected");
		$('.li'+idac).addClass("selected");
		$('.threesixty_images').html('');
		$('.control360').remove();
		var tgxd360;
		tgxd360=$('.thegioixedien').ThreeSixty({
		totalFrames:number,
		endFrame:number,
		currentFrame:1,
		imgList:'.threesixty_images',
		progress:'.spinner',
		imagePath:imagePath,
		filePrefix:filePrefix,
		ext:'.jpg',
		height:690,
		width:960,
		autoplayDirection:0,
		autoplay:1,
		navigation:true
		});
		if(play == 1){
			tgxd360.play();
		}
			$('.custom_previous').bind('click',function(e){tgxd360.previous();});
			$('.custom_next').bind('click',function(e){tgxd360.next();});
			$('.custom_play').bind('click',function(e){tgxd360.play();});
			$('.custom_stop').bind('click',function(e){tgxd360.stop();});}
		function op360(number, imagePath, filePrefix,ext,idac) {
				$('.ulcolor2 li').removeClass("selected");
				$('.ulcolor2 .li'+idac).addClass("selected");
				$('.threesixty_images2').html('');
				$('.control360').remove();
				var tgxd360;
					tgxd360=$('.thegioixedien2').ThreeSixty({
					totalFrames:number,
					endFrame:number,
					currentFrame:1,
					imgList:'.threesixty_images2',
					progress:'.spinner',
					imagePath:imagePath,
					filePrefix:filePrefix,
					ext:'.jpg',
					height:720,
					width:960,
					autoplayDirection:0,
					autoplay:1,
					navigation:true
				});
			$('.custom_previous').bind('click',function(e){tgxd360.previous();});
			$('.custom_next').bind('click',function(e){tgxd360.next();});
			$('.custom_play').bind('click',function(e){
				tgxd360.play();
				});
			$('.custom_stop').bind('click',function(e){
				tgxd360.stop();
				});
			}			
			(function(n){"use strict";n.ThreeSixty=function(t,i){var u=this,r,f=[];u.$el=n(t);u.el=t;u.$el.data("ThreeSixty",u);u.init=function(){r=n.extend({},n.ThreeSixty.defaultOptions,i);r.disableSpin&&(r.currentFrame=1,r.endFrame=1);
			u.initProgress();u.loadImages();u.$el.on("mousedown touchstart",function(){u.stop()});
			u.$el.on("mouseup touchend",function(){u.play()})};u.resize=function(){};u.initProgress=function(){u.$el.css({width:r.width+"px",height:r.height+"px","background-image":"none !important"});r.styles&&u.$el.css(r.styles);u.responsive();u.$el.find(r.progress).css({marginTop:r.height/2-15+"px"});u.$el.find(r.progress).fadeIn("slow");u.$el.find(r.imgList).show("slow")};u.loadImages=function(){var t,e,i,o;t=document.createElement("li");o=r.zeroBased?0:1;e=r.imgArray?r.imgArray[r.loadedImages]:r.domain+r.imagePath+r.filePrefix+u.zeroPad(r.loadedImages+o)+r.ext+(u.browser.isIE()?"?"+(new Date).getTime():"");i=n("<img>").attr("src",e).addClass("previous-image").appendTo(t);f.push(i);u.$el.find(r.imgList).append(t);n(i).load(function(){u.imageLoaded()})};u.imageLoaded=function(){r.loadedImages+=1;n(r.progress+" span").text(Math.floor(r.loadedImages/r.totalFrames*100)+"%");r.loadedImages>=r.totalFrames?(r.disableSpin&&f[0].removeClass("previous-image").addClass("current-image"),n(r.progress).fadeOut("slow",function(){n(this).hide();u.showImages();u.showNavigation()})):u.loadImages()};u.showImages=function(){u.$el.find(".txtC").fadeIn();u.$el.find(r.imgList).fadeIn();u.ready=!0;r.ready=!0;r.drag&&u.initEvents();u.refresh();u.initPlugins();r.onReady();setTimeout(function(){u.responsive()},50)};u.initPlugins=function(){n.each(r.plugins,function(t,i){if(typeof n[i]=="function")n[i].call(u,u.$el,r);else throw new Error(i+" not available.");})};u.showNavigation=function(){if(r.navigation&&!r.navigation_init){
				var t,g,i,f,e;t=n("<div/>").attr("class","control360");
				i=n("<a/>").attr({href:"#","class":"btn btn-danger custom_next hide"}).html("");
				f=n("<a/>").attr({href:"#","class":"custom_previous btn btn-danger hide"}).html("");
				g=n("<a/>").attr({href:"#","class":"custom_stop btn btn-inverse"}).html("<i class='fa fa-pause'></i> Pause");
				e=n("<a/>").attr({href:"#","class":"btn btn-inverse custom_play"}).html("<i class='fa fa-play'></i>Play");
				t.append(f);t.append(g);t.append(e);t.append(i);
				u.$el.prepend(t);
				f.bind("mousedown touchstart",u.next);i.bind("mousedown touchstart",u.previous);e.bind("mousedown touchstart",u.play_stop);r.navigation_init=!0}};u.play_stop=function(t){t.preventDefault();r.autoplay?(r.autoplay=!1,n(t.currentTarget).removeClass("nav_bar_stop").addClass("nav_bar_play"),clearInterval(r.play),r.play=null):(r.autoplay=!0,r.play=setInterval(u.moveToNextFrame,r.playSpeed),n(t.currentTarget).removeClass("nav_bar_play").addClass("nav_bar_stop"))};u.next=function(n){n&&n.preventDefault();r.endFrame-=5;u.refresh()};u.previous=function(n){n&&n.preventDefault();r.endFrame+=5;u.refresh()};u.play=function(n){var t=n||r.playSpeed;r.autoplay||(r.autoplay=!0,r.play=setInterval(u.moveToNextFrame,t))};u.stop=function(){r.autoplay&&(r.autoplay=!1,clearInterval(r.play),r.play=null)};u.moveToNextFrame=function(){r.autoplayDirection===1?r.endFrame-=1:r.endFrame+=1;u.refresh()};u.gotoAndPlay=function(n){var i;if(r.disableWrap)r.endFrame=n,u.refresh();else{i=Math.ceil(r.endFrame/r.totalFrames);i===0&&(i=1);var t=i>1?r.endFrame-(i-1)*r.totalFrames:r.endFrame,f=r.totalFrames-t,e=0;e=n-t>0?n-t<t+(r.totalFrames-n)?r.endFrame+(n-t):r.endFrame-(t+(r.totalFrames-n)):t-n<f+n?r.endFrame-(t-n):r.endFrame+(f+n);t!==n&&(r.endFrame=e,u.refresh())}};u.initEvents=function(){u.$el.bind("mousedown touchstart touchmove touchend mousemove click",function(n){n.preventDefault();n.type==="mousedown"&&n.which===1||n.type==="touchstart"?(r.pointerStartPosX=u.getPointerEvent(n).pageX,r.dragging=!0):n.type==="touchmove"?u.trackPointer(n):n.type==="touchend"&&(r.dragging=!1)});n(document).bind("mouseup",function(){r.dragging=!1;n(this).css("cursor","none")});n(window).bind("resize",function(){u.responsive()});n(document).bind("mousemove",function(n){r.dragging?(n.preventDefault(),!u.browser.isIE&&r.showCursor&&u.$el.css("cursor","url(assets/images/hand_closed.png), auto")):!u.browser.isIE&&r.showCursor&&u.$el.css("cursor","url(assets/images/hand_open.png), auto");u.trackPointer(n)});n(window).bind("resize",function(){u.resize()})};u.getPointerEvent=function(n){return n.originalEvent.targetTouches?n.originalEvent.targetTouches[0]:n};u.trackPointer=function(n){r.ready&&r.dragging&&(r.pointerEndPosX=u.getPointerEvent(n).pageX,r.monitorStartTime<(new Date).getTime()-r.monitorInt&&(r.pointerDistance=r.pointerEndPosX-r.pointerStartPosX,r.endFrame=r.pointerDistance>0?r.currentFrame-Math.ceil((r.totalFrames-1)*r.speedMultiplier*(r.pointerDistance/u.$el.width())):r.currentFrame-Math.floor((r.totalFrames-1)*r.speedMultiplier*(r.pointerDistance/u.$el.width())),r.disableWrap&&(r.endFrame=Math.min(r.totalFrames-(r.zeroBased?1:0),r.endFrame),r.endFrame=Math.max(r.zeroBased?0:1,r.endFrame)),u.refresh(),r.monitorStartTime=(new Date).getTime(),r.pointerStartPosX=u.getPointerEvent(n).pageX))};u.refresh=function(){r.ticker===0&&(r.ticker=setInterval(u.render,Math.round(1e3/r.framerate)))};u.render=function(){var n;r.currentFrame!==r.endFrame?(n=r.endFrame<r.currentFrame?Math.floor((r.endFrame-r.currentFrame)*.1):Math.ceil((r.endFrame-r.currentFrame)*.1),u.hidePreviousFrame(),r.currentFrame+=n,u.showCurrentFrame(),u.$el.trigger("frameIndexChanged",[u.getNormalizedCurrentFrame(),r.totalFrames])):(window.clearInterval(r.ticker),r.ticker=0)};u.hidePreviousFrame=function(){f[u.getNormalizedCurrentFrame()].removeClass("current-image").addClass("previous-image")};u.showCurrentFrame=function(){f[u.getNormalizedCurrentFrame()].removeClass("previous-image").addClass("current-image")};u.getNormalizedCurrentFrame=function(){var n,t;return r.disableWrap?(n=Math.min(r.currentFrame,r.totalFrames-(r.zeroBased?1:0)),t=Math.min(r.endFrame,r.totalFrames-(r.zeroBased?1:0)),n=Math.max(n,r.zeroBased?0:1),t=Math.max(t,r.zeroBased?0:1),r.currentFrame=n,r.endFrame=t):(n=Math.ceil(r.currentFrame%r.totalFrames),n<0&&(n+=r.totalFrames-(r.zeroBased?1:0))),n};u.getCurrentFrame=function(){return r.currentFrame};u.responsive=function(){r.responsive&&u.$el.css({height:u.$el.find(".current-image").first().css("height"),width:"100%"})};u.zeroPad=function(n){function i(n,t){var i=n.toString();if(r.zeroPadding)while(i.length<t)i="0"+i;return i}var u=Math.log(r.totalFrames)/Math.LN10,t=1e3,f=Math.round(u*t)/t,e=Math.floor(f)+1;return i(n,e)};u.browser={};u.browser.isIE=function(){var n=-1,t,i;return navigator.appName==="Microsoft Internet Explorer"&&(t=navigator.userAgent,i=new RegExp("MSIE ([0-9]{1,}[\\.0-9]{0,})"),i.exec(t)!==null&&(n=parseFloat(RegExp.$1))),n!==-1};u.getConfig=function(){return r};n.ThreeSixty.defaultOptions={dragging:!1,ready:!1,pointerStartPosX:0,pointerEndPosX:0,pointerDistance:0,monitorStartTime:0,monitorInt:10,ticker:0,speedMultiplier:10,totalFrames:180,currentFrame:0,endFrame:0,loadedImages:0,framerate:60,domains:null,domain:"",parallel:!1,queueAmount:8,idle:0,filePrefix:"",ext:"jpg",height:960,width:700,styles:{},navigation:!1,autoplay:!1,autoplayDirection:1,disableSpin:!1,disableWrap:!1,responsive:!1,zeroPadding:!1,zeroBased:!1,plugins:[],showCursor:!1,drag:!0,onReady:function(){},imgList:".threesixty_images",imgArray:null,playSpeed:280};u.init()};n.fn.ThreeSixty=function(t){return Object.create(new n.ThreeSixty(this,t))}})(jQuery);typeof Object.create&&(Object.create=function(a){"use strict";function b(){}return b.prototype=a,new b});var xhr;var nameCookieJsScript='cookieReffer';
			
			