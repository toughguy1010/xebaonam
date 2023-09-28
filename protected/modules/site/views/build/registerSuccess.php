<div class="build-success text-center ">
    <p class="cong-text">CHÚC MỪNG BẠN</p>
    <p class="cong-text-success">ĐÃ ĐĂNG KÝ WEBSITE THÀNH CÔNG</p>
    <p class="cong-text-send">
        Chúng tôi sẽ gửi thông tin đăng ký và tài khoản quản trị tới mail: <span class="build-mail"><?php echo $user->email; ?></span>
    </p>
    <p class="build-text-help">
        Bấm vào nút bên dưới để truy cập website của bạn và bắt đầu sử dụng
    </p>
    <div class="build-button">
        <a class="btn btn-primary" href="<?php echo $admin_link; ?>">
            Truy cập trang quản trị
        </a>
        <a class="btn btn-warning" href="<?php echo $website; ?>" target="_blank">
            Truy cập website của bạn
        </a>
    </div>
    <p class="build-text-help">Bạn sẽ được chuyển đến trang quản trị website trong <span id="build-time"><?php echo $time; ?></span>s...</p>
</div>
<script>
    setInterval(function() {
        jQuery('#build-time').html(eval(jQuery('#build-time').html()) - 1);
    }, 1000);
</script>