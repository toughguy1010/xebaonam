<?php
$hotel_group = TourHotelsList::getAll();
$hotels_list = json_decode($tourInfo->data_hotels_list, true);
if (count($hotels_list) && count($hotel_group)) {
    ?>
    <div class="form-group no-margin-left well well-lg clearfix">
        <div class="controls col-sm-12">
            <div id="showday">
                <div class="top-content">
                    <div class="controls col-sm-2" style="padding: 0;"><strong>Nhóm khách sạn</strong>
                    </div>
                    <div class="controls col-sm-10">
                        <div class="controls col-sm-4" style="padding: 0;margin-left: 5px"><strong>Địa điểm</strong>
                        </div>
                        <div class="controls col-sm-4"><strong>Khách sạn</strong></div>
                    </div>
                    <hr>
                </div>
                <?php
                foreach ($hotels_list as $key => $list) {
                    $hotel = TourHotelsList::model()->findByPk($key) ;
                    ?>
                    <div class="form-group no-margin-left">
                        <div class="controls col-sm-2"><strong><?= $hotel->name ?></strong>
                        </div>
                        <div class="controls col-sm-10" style="padding-left: 30px;"
                             id="state-hotel-<?= $key ?>">
                            <?php
                            foreach ($list as $key3 => $val) {
                                ?>
                                <div class="ct">
                                    <input style="margin-left: 20px;" class="span12 col-sm-4"
                                           name="TourHotelsListField[<?= $key ?>][place][]"
                                           value="<?php echo $val['place'] ?>"
                                           id="TourHotelsListField_place" type="text" placeholder="Địa điểm">
                                    <input style="margin-left: 10px;" class="span12 col-sm-4"
                                           name="TourHotelsListField[<?= $key ?>][hotel][]"
                                           value="<?php echo $val['hotel'] ?>"
                                           id="TourHotelsListField_hotel" type="text" placeholder="Khách sạn">
                                    <div class="col-sm-3">
                                        <button style="margin-bottom: 10px;"
                                                class="btn btn-sm btn-danger col-sm-6"
                                                type="button"
                                                onclick="removeState(this)">Xóa
                                        </button>
                                    </div>
                                </div>
                            <?php } ?>
                            <button style="margin-left: 20px;" class="btn btn-sm btn-info"
                                    onclick="add_state3(<?= $key ?>)"
                                    type="button"><?= Yii::t('translate', 'create') ?>
                            </button>
                        </div>
                        <hr>
                    </div>
                <?php } ?>
            </div>
        </div>
        <hr>
    </div>
<?php } else {
    if (count($hotel_group)) {
        ?>
        <div class="form-group no-margin-left well well-lg clearfix">
            <div class="controls col-sm-12">
                <div id="showday">
                    <div class="top-content">
                        <div class="controls col-sm-2" style="padding: 0;"><strong>Nhóm khách sạn</strong>
                        </div>
                        <div class="controls col-sm-10" style="padding-left: 30px;">
                            <div class="controls col-sm-4" style="padding: 0;margin-left: 5px"><strong>Địa điểm</strong>
                            </div>
                            <div class="controls col-sm-4"><strong>Khách sạn</strong></div>
                        </div>
                        <hr>
                    </div>

                    <?php
                    foreach ($hotel_group as $key => $group) {
                        $key = $group['id'];
                        ?>
                        <div class="form-group no-margin-left">
                            <div class="controls col-sm-2"><strong><?= $group['name'] ?></strong>
                            </div>
                            <div class="controls col-sm-10" id="state-hotel-<?= $key ?>">
                                <button style="margin-left: 20px;" class="btn btn-sm btn-info"
                                        onclick="add_state3(<?= $key ?>)"
                                        type="button"><?= Yii::t('translate', 'create') ?>
                                </button>
                            </div>
                            <hr>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <hr>
        </div>
    <?php }
}

?>
<style>
    .form-group.well hr {
        margin-top: 20px;
        margin-bottom: 20px;
        border: 0;
        border-top: 1px solid #eee;
        float: left;
        width: 100%;
    }
</style>

<script>

    function add_state3(id) {
        $('#state-hotel-' + id).append(' <div class="ct">' +
            '<input style="margin-left: 20px;" class="span12 col-sm-4" name="TourHotelsListField[' + id + '][place][] value=" id="TourHotelsListField_place" type="text" placeholder="Địa điểm">' +
            '<input style="margin-left: 10px;" class="span12 col-sm-4" name="TourHotelsListField[' + id + '][hotel][]" value="" id="TourHotelsListField_hotel" type="text" placeholder="Khách sạn">' +
            '<div class="col-sm-3">' +
            '<button style="margin-bottom: 10px; border-right: 1px solid #fff;" class="btn btn-sm btn-danger col-sm-6" type="button" onclick="removeState(this)">Xóa' +
            '</button>' +
            '</div>' +
            '</div>'
        );

    }

    function removeState(ev) {
        if (confirm('Bạn có chắc chắn muốn xóa?')) {
            $(ev).parent().parent().remove();
        } else {
            return false;
        }

    }

</script>