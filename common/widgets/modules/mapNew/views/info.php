<div class="map-info">
    <h3 class="map-info-name"><?php echo $map['name']; ?></h3>
    <p class="map-info-more">
        <?php
        $more = array();
        array_push($more, $map['address']);
        if ($map['email'])
            array_push($more, $map['email']);
        if ($map['phone'])
            array_push($more, $map['phone']);
        echo implode(' &nbsp;&nbsp;|&nbsp;&nbsp; ', $more);
        ?>
    </p>
</div>