<div class="option-item-gear">
    <div class="weather-item-gear">
        <div id="weather">
            <?php if ($temp_select) { ?>
                <div class="now-day-weather">
                    <div class="now-day-deg">
                        <p class="hot">
                            <?php
                            $time = strtotime($temp_select->date);
                            echo $temp_select->low . ' - ' . $temp_select->high ?>
                            <span><i class="icon-<?php echo $temp_select->code ?>"></i></span>
                            <?php
                            ?>
                        </p>
                        <p>
                            <?php echo dateconvert(date('D', $time)) ?> <span><?php echo date('d/m/Y', $time) ?></span>
                        </p>
                    </div>
                </div>
                <div class="list-weather-day">
                    <div class="item-weather-day">
                        <?php
                        $j = 0;
                        for ($i = ($date_op + 1); $i < 10; $i++) {
                            if (++$j > 5) {
                                continue;
                            }
                            ?>
                            <p>
                                <?php echo HtmlFormat::dateconvert($json_weather->forecast[$i]->day) ?>
                                <span>
<!--                                <i class="--><?php //echo setWeatherIcon($json_weather->forecast[$i]->code) ?><!--"></i>-->
                                <i class="icon-<?php echo $json_weather->forecast[$i]->code ?>"></i>
                                    <?php echo ($json_weather->forecast[$i]->low) . '-' . ($json_weather->forecast[$i]->high) ?>
                            </span>
                            </p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            <?php } else {
                ?>
                <div class="list-weather-day">
                    <p>
                        Không có dữ liệu
                    </p>
                </div>
                <?php
            } ?>
        </div>
    </div>
    <div class="tool-item-gear">
        <?php if (count($products)) { ?>
            <?php foreach ($products as $product) { ?>
                <div class="tool-item">
                    <div class="img-tool-item">
                        <a target="_blank" href="<?php echo $product['link']; ?>">
                            <img src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's150_150/' . $product['avatar_name'] ?>">
                        </a>
                    </div>
                    <div class="title-tool-item">
                        <h2><a target="_blank"
                               href="<?php echo $product['link']; ?>"><?php echo $product['name']; ?></a></h2>
                    </div>
                </div>
            <?php } ?>
        <?php } else {
            echo 'Không có sản phẩm nào phù hợp';
        } ?>
        <div class="link-tool">
            <ul>
                <li>
                    <a href="">Bài viết chia sẻ kinh nghiệm</a>
                </li>
                <li>
                    <a href="tel:0979800588"><i class="fa fa-phone"></i>Tư vấn trực tiếp <span>0979 800 588</span> </a>
                </li>
                <li>
                    <a href="#checklist-popup" class="open-popup-link">Xem checklist <i class="fa fa-eye"></i></a>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    //    $(document).ready(function{
    $('.open-popup-link').magnificPopup({
        type: 'inline',
        midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
    });
    //    });
</script>
<div id="checklist-popup" class="white-popup mfp-hide">
    <div class="box-account">
        <div class="modal-header">
            <div class="item-location-checklist">
                <ul>
                    <li>
                        <p><span>Địa điểm:</span>
                            <spam><?php echo $province ?></spam>
                        </p>
                    </li>
                    <?php if (count($check_attribute)) {
                        foreach ($check_attribute as $key => $attribute) {
                            ?>
                            <li>
                                <p><span><?php echo $key ?></span>
                                    <spam><?php echo $attribute ?></spam>
                                </p>
                            </li>
                        <?php }
                    } ?>
                </ul>
            </div>
            <span class="mfp-close"></span>
            <!--            <a href="" class="dowload-checklist">Tải về<i class="fa fa-download" aria-hidden="true"></i></a>-->
        </div>
        <div class="bg-pop-white">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="list-item-checker">
                    <?php if (count($products)) { ?>
                        <?php foreach ($products as $product) { ?>
                            <div class="item-checker-tool">
                                <div class="squaredFour">
                                    <input type="checkbox" value="None" id="ticket1" name="check">
                                    <label for="ticket1"></label>
                                </div>
                                <div class="title-item-checker">
                                    <p><?php echo $product['name']; ?></p>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
function dateconvert($d)
{
    switch ($d) {
        case 'Mon':
            return 'Thứ 2';
        case 'Tue':
            return 'Thứ 3';
        case 'Wed':
            return 'Thứ 4';
        case 'Thu':
            return 'Thứ 5';
        case 'Fri':
            return 'Thứ 6';
        case 'Sat':
            return 'Thứ 7';
        case 'Sun':
            return 'Chủ nhật';
    }
}

function setWeatherIcon($condid)
{
    $icon = '';
    switch ($condid) {
        case '0':
            $icon = 'wi-tornado';
            break;
        case '1':
            $icon = 'wi-storm-showers';
            break;
        case '2':
            $icon = 'wi-tornado';
            break;
        case '3':
            $icon = 'wi-thunderstorm';
            break;
        case '4':
            $icon = 'wi-thunderstorm';
            break;
        case '5':
            $icon = 'wi-snow';
            break;
        case '6':
            $icon = 'wi-rain-mix';
            break;
        case '7':
            $icon = 'wi-rain-mix';
            break;
        case '8':
            $icon = 'wi-sprinkle';
            break;
        case '9':
            $icon = 'wi-sprinkle';
            break;
        case '10':
            $icon = 'wi-hail';
            break;
        case '11':
            $icon = 'wi-showers';
            break;
        case '12':
            $icon = 'wi-showers';
            break;
        case '13':
            $icon = 'wi-snow';
            break;
        case '14':
            $icon = 'wi-storm-showers';
            break;
        case '15':
            $icon = 'wi-snow';
            break;
        case '16':
            $icon = 'wi-snow';
            break;
        case '17':
            $icon = 'wi-hail';
            break;
        case '18':
            $icon = 'wi-hail';
            break;
        case '19':
            $icon = 'wi-cloudy-gusts';
            break;
        case '20':
            $icon = 'wi-fog';
            break;
        case '21':
            $icon = 'wi-fog';
            break;
        case '22':
            $icon = 'wi-fog';
            break;
        case '23':
            $icon = 'wi-cloudy-gusts';
            break;
        case '24':
            $icon = 'wi-cloudy-windy';
            break;
        case '25':
            $icon = 'wi-thermometer';
            break;
        case '26':
            $icon = 'wi-cloudy';
            break;
        case '27':
            $icon = 'wi-night-cloudy';
            break;
        case '28':
            $icon = 'wi-day-cloudy';
            break;
        case '29':
            $icon = 'wi-night-cloudy';
            break;
        case '30':
            $icon = 'wi-day-cloudy';
            break;
        case '31':
            $icon = 'wi-night-clear';
            break;
        case '32':
            $icon = 'wi-day-sunny';
            break;
        case '33':
            $icon = 'wi-night-clear';
            break;
        case '34':
            $icon = 'wi-day-sunny-overcast';
            break;
        case '35':
            $icon = 'wi-hail';
            break;
        case '36':
            $icon = 'wi-day-sunny';
            break;
        case '37':
            $icon = 'wi-thunderstorm';
            break;
        case '38':
            $icon = 'wi-thunderstorm';
            break;
        case '39':
            $icon = 'wi-thunderstorm';
            break;
        case '40':
            $icon = 'wi-storm-showers';
            break;
        case '41':
            $icon = 'wi-snow';
            break;
        case '42':
            $icon = 'wi-snow';
            break;
        case '43':
            $icon = 'wi-snow';
            break;
        case '44':
            $icon = 'wi-cloudy';
            break;
        case '45':
            $icon = 'wi-lightning';
            break;
        case '46':
            $icon = 'wi-snow';
            break;
        case '47':
            $icon = 'wi-thunderstorm';
            break;
        case '3200':
            $icon = 'wi-cloud';
            break;
        default:
            $icon = 'wi-cloud';
            break;
    }
    return 'wi ' . $icon;
}

?>

