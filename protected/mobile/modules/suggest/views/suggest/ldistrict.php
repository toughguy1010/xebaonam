<?php
foreach ($listdistrict as $district) {
    ?>
    <option value="<?php echo $district['district_id'] ?>" latlng="<?php echo $district['latlng']; ?>"><?php echo $district['name']; ?></option>
<?php } ?>
