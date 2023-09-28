<?php
if (isset($stores) && count($stores)) {
    foreach ($stores as $store) {
        ?>
        <div class="box-store clearfix">
            <div class="box-img-store">
                <img src="<?php echo ClaHost::getImageHost(), $store['avatar_path'], 's560_560/' , $store['avatar_name']; ?>">
            </div>
            <div class="box-info-store">
                <div class="address">
                    <p><?php echo $store['name'] ?><br>
                        <?php echo $store['address'] ?><br>
                        <?php echo implode(' - ', array($store['ward_name'], $store['district_name'], $store['province_name'])); ?>
                    </p>
                </div>
                <div class="contact-in">
                    <h2>CONTACT</h2>
                    <p>HOLINE:<?php echo $store['hotline'] ?></p>
                    <p><?php echo $store['email'] ?></p>
                </div>
                <div class="hours-in">
                    <h2>HOURS</h2>
                    <p><?php echo nl2br($store['hours']); ?></p>
                </div>
            </div>
        </div>
        <?php
    }
}