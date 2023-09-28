<?php
if (count($shopstore)) {
    ?>
    <div class="col-xs-4">
        <div  class="list-showroom">
            <ul>
                <?php
                foreach ($shopstore as $each_shopstore) {
                    ?>
                    <li><a href="<?php echo $each_shopstore['link'] ?>" rel_img='<?php echo 'img' . $each_shopstore['id'] ?>'><?php echo $each_shopstore['name'] ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="img-showroom">
            <?php
            foreach ($shopstore as $each_shopstore1) {
                ?>
                <div class="<?php echo 'img', $each_shopstore1['id'] ?>" >
                    <img src="<?php echo ClaHost::getImageHost() . $each_shopstore1['avatar_path'] . 's350_350/' . $each_shopstore1['avatar_name']; ?>" />
                </div>
            <?php } ?>
        </div>
    </div>
    <script>
        $(document).ready(function () {
              $('.img-showroom div img').hide().first().show();
            $('.list-showroom ul li a').on('mouseover', function () {
                var target = $(this).attr('rel_img');
                $('.img-showroom div img').hide();
                $('.' + target + ' img').show();
            })
        })
    </script>
<?php } ?>