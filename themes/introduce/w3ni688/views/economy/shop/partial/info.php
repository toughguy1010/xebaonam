<div class="map-info">
    <h3 class="map-info-name"><?php echo $map['name']; ?></h3>
    <p class="map-info-more">
        <img src="<?php echo ClaHost::getImageHost(), $map['avatar_path'], 's100_100/', $map['avatar_name']; ?>">
    </p>
    <p>
        <?php
        $more = array();
        array_push($more, $map['address']);
        if ($map['email'])
            array_push($more, $map['email']);
        if ($map['phone'])
            array_push($more, $map['hotline']);
        echo implode(' &nbsp;&nbsp;|&nbsp;&nbsp; ', $more);
        ?>
    </p>
</div>