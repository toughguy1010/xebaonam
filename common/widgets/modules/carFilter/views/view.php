<!-- 
ajax form chuyền thêm biến get view_show_ajax=[tên file trả về - mặc định là index-ajax ]
-->
<?php 
    $cats = $data['categories'];
    $prices = $data['prices'];
    $fuels = $data['fuels'];
    $seats = $data['seats'];
    $styles = $data['styles'];
    $mades = $data['madeins'];
    $getFuels = isset($_GET['fuel']) ? $_GET['fuel'] : [];
    $getPrices = isset($_GET['price']) ? $_GET['price'] : [];
    $getSeats = isset($_GET['seat']) ? $_GET['seat'] : [];
    $getStyles = isset($_GET['style']) ? $_GET['style'] : [];
    $getMadeins = isset($_GET['madein']) ? $_GET['madein'] : [];
    $getCats = isset($_GET['car_category_id']) ? $_GET['car_category_id'] : [];
?>
<?php 
    function writePrice($price)
    {
        $tl_price = 1000000000;
        if(!$price)  return 0;
        if($price < $tl_price) {
            return $price*1000/$tl_price.' triệu';
        } else {
            return $price/$tl_price.' tỉ';
        }
    }
?>
<script type="text/javascript">
    kt =1;
    $(document).on('click', '.price-car-fill', function () {
        $(this).removeClass('price-car-fill');
        $('.price-car-fill').removeAttr('checked');
        $(this).addClass('price-car-fill');
    });
    $(document).on('click', '.list_filter li input', function () {
        if($('#box-car-index').attr('loading') == 0) {
            $('#box-car-index').attr('loading', '1');
            loadCar();
        } else if($('#box-car-index').attr('loading') == 1){
            $('#box-car-index').attr('loading', '2');
            setTimeout(function(){ 
                $('#box-car-index').attr('loading', '0');
                loadCar();
            }, 500);
        }
    });
    $(document).on('change', '#order-car', function () {
        loadCar();
    });
    function loadCar() {
        $('#box-car-index').html('');
        history.pushState({}, null, '<?= Yii::app()->createUrl('/car/car') ?>?'+$('#form-car-index').serialize());
        $.ajax({
            url: '<?= $data['link_filter'] ?>',
            data: $('#form-car-index').serialize(),
            success: function(result){
                $('#box-car-index').html(result);
            }
        });
    }
</script>
<form id="form-car-index" action="<?= Yii::app()->createUrl('car/car/indexajax') ?>">
    <input type="hidden" name="view_show_ajax" value="index-ajax">
    <div class="box-filter">
        <div class="list_filter">
            <h3>Mẫu xe <i class="fa fa-angle-down" aria-hidden="true"></i></h3>
            <ul>
                <?php foreach ($cats as $key => $value) { ?>
                <li><label class="containers"><?= $value ?><input <?= in_array($key, $getCats) ? 'checked' : '' ?> name="car_category_id[]" value="<?= $key ?>" type="checkbox" ><span class="checkmark"></span></label></li>
                <?php } ?>
            </ul>
        </div>
        <div class="list_filter">
            <h3>Giá <i class="fa fa-angle-down" aria-hidden="true"></i></h3>
            <ul>
                <?php for ($i=0; $i < count($prices); $i++) {  ?>
                <li><label class="containers"><?= isset($prices[$i+1]) ? writePrice($prices[$i]).'-'.writePrice($prices[$i+1]) : 'Trên '.writePrice($prices[$i]) ?><input <?= isset($prices[$i+1]) ? (($prices[$i].','.$prices[$i+1] == $getPrices) ? 'checked' : '') : (($prices[$i] == $getPrices) ? 'checked' : '') ?> name="price" value="<?= isset($prices[$i+1]) ? $prices[$i].','.$prices[$i+1] : $prices[$i] ?>" type="checkbox" class="price-car-fill" ><span class="checkmark"></span></label></li>
                <?php } ?>
            </ul>
        </div>
        <div class="list_filter">
            <h3>Nhiên liệu <i class="fa fa-angle-down" aria-hidden="true"></i></h3>
            <ul>
                <?php foreach ($fuels as $key => $value) { ?>
                <li><label class="containers"><?= $value ?><input <?= in_array($key, $getFuels) ? 'checked' : '' ?>  name="fuel[]" value="<?= $key ?>" type="checkbox" ><span class="checkmark"></span></label></li>
                <?php } ?>
            </ul>
        </div>
        <div class="list_filter">
            <h3>Số chỗ ngồi <i class="fa fa-angle-down" aria-hidden="true"></i></h3>
            <ul>
                <?php foreach ($seats as $key => $value) { ?>
                <li><label class="containers"><?= $value ?><input <?= in_array($key, $getSeats) ? 'checked' : '' ?> name="seat[]" value="<?= $key ?>"  type="checkbox" ><span class="checkmark"></span></label></li>
                <?php } ?>
            </ul>
        </div>
        <div class="list_filter">
            <h3>Kiểu dáng<i class="fa fa-angle-down" aria-hidden="true"></i></h3>
            <ul>
                <?php foreach ($styles as $key => $value) { ?>
                <li><label class="containers"><?= $value ?><input <?= in_array($key, $getStyles) ? 'checked' : '' ?> name="style[]" value="<?= $key ?>" type="checkbox" ><span class="checkmark"></span></label></li>
                <?php } ?>
            </ul>
        </div>
        <div class="list_filter">
            <h3>Xuất xứ<i class="fa fa-angle-down" aria-hidden="true"></i></h3>
            <ul>
                <?php foreach ($mades as $key => $value) { ?>
                <li><label class="containers"><?= $value ?><input <?= in_array($key, $getMadeins) ? 'checked' : '' ?> name="madein[]" value="<?= $key ?>" type="checkbox" ><span class="checkmark"></span></label></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</form>