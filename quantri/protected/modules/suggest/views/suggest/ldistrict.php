<?php
function build_sorter($key) {
    return function ($a, $b) use ($key) {
        return strnatcmp($a[$key], $b[$key]);
    };
}
usort($listdistrict, build_sorter('name'));
foreach ($listdistrict as $district) {
    ?>
    <option value="<?php echo $district['district_id'] ?>" latlng="<?php echo $district['latlng']; ?>"><?php echo $district['name']; ?></option>
<?php } ?>
