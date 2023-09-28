<?php
if (count($data)) {
    foreach ($data as $user) {
        ?>
        <div class="support-in">
            <div class="right-about">
                <img src="<?php echo ClaHost::getImageHost() . $user['avatar_path'] . 's150_150/' . $user['avatar_name'] ?>">
                <div class="tuvan"><?php echo $user['name'] ?></div>
                <div class="hotline2"><span><?php echo $user['phone'] ?></span></div>
                <ul class="clearfix">
                    <li><a href="tel:<?php echo $user['phone'] ?>"><i class="dienthoai"></i></a></li>
                    <li><a href="skype:<?php echo $user['skype'] ?>?chat"><i class="skype-in"></i></a></li>
                    <li><a href="ymsgr:<?php echo $user['yahoo'] ?>"><i class="ya-in"></i></a></li>
                </ul>
            </div>
        </div>
    <?php }
} ?>