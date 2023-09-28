<?php
if (count($shopstore)) {
    ?>
    <div class="col-xs-6">
        <div  class="list-showroom ">
            <ul>
                <?php
                foreach ($shopstore as $each_shopstore) {
                    ?>
                    <li><a href="/cua-hang" rel_img='<?php echo 'img' . $each_shopstore['id'] ?>'><?php echo $each_shopstore['name'] ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="img-showroom ">
            <?php
            foreach ($shopstore as $each_shopstore1) {
                ?>
                <div class="<?php echo 'img', $each_shopstore1['id'] ?>" latlng="<?php echo $each_shopstore1['latlng'] ?>" >
                    <img src="<?php echo ClaHost::getImageHost() . $each_shopstore1['avatar_path'] . 's400_400/' . $each_shopstore1['avatar_name']; ?>" />
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- <script>
        $(document).ready(function () {
            var id = $('.gm-style div').attr('id');
            var mapOptions = {
                zoom: <?php echo count($maps) ? 13 : 16; ?>,
                center: defaultLatLng
            };
            map = new google.maps.Map(document.getElementById('<?php echo $id; ?>'), mapOptions);
            $('.img-showroom div img').hide().first().show();
            $('.list-showroom ul li a').on('mouseover', function () {
                var target = $(this).attr('rel_img');
                var latlng = $(this).attr('latlng');

                console.log(id);
                $('.img-showroom div img').hide();
                $('.' + target + ' img').show();
                placeMarker(latlng, map);
            });
        });
        function placeMarker(position, map, id) {
            var marker = new google.maps.Marker({
                position: position,
                draggable: false,
                map: map
            });
            google.maps.event.addListener(marker, 'click', function (e) {
                infowindow[id].open(map, marker);
            });
            google.maps.event.tsrigger(marker, 'click');
        }
    </script> -->
<?php } ?>