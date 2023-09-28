<div class="guide-success" style="text-align: center;">
    <h2 style="color: #CC0000;font-size: 24px;font-weight: bold;line-height: 24px;margin: 10px 0px;">Hướng dẫn thanh toán</h2>    
    <iframe width="1000" scrolling="auto" height="600" frameborder="0" src="<?php echo $guide; ?>" id="iframe-guide-bk"></iframe>
    <div class="note">
        <p>Chúng tôi đã lưu đơn hàng của quý khách trên hệ thống. Quý khách có thể xem đơn hàng <a href="<?php echo $link_order;?>" title="Đơn hàng" target="_blank">tại đây</a></p> 
        <p>Sau khi hoàn thành chuyển tiền theo hướng dẫn trên, <b><?php echo ucfirst($_SERVER['SERVER_NAME']);?></b> sẽ tự động ghi nhận thanh toán thành công và gửi email thông báo cho bạn.</p>
<!--        <p>Lưu ý: Email này có thể đến trễ trong vòng 24 giờ do quá trình xác nhận thông tin thanh toán giữa ngân hàng và người bán.</p>-->
    </div>
</div>

