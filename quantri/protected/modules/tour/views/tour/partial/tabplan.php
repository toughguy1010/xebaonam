<script>
    jQuery(document).ready(function () {
        $('.ck-check').on("click", function () {
            console.log($(this).attr('data-id'));
            if (this.checked) {
                CKEDITOR.replace('TourPlanDynamicField_content' + $(this).attr('data-id'), {
                    height: 400,
                    language: '<?php echo Yii::app()->language ?>'
                });
            } else {
                var a = CKEDITOR.instances['TourPlanDynamicField_content' + $(this).attr('data-id')];
                if (a) {
                    a.destroy(true);
                }

            }
        });
    });

    function add_op_review1() {
        var min = 1;
        var max = 100;
        var random = Math.floor(Math.random() * (+max - +min)) + +min;
        $("#showday4").append('<div class="form-group no-margin-left">  ' +
            '<input class="span12 col-sm-2" name="TourPlanDynamicField[name][]" placeholder="Tên" value="" id="TourPlanDynamicField_name" type="text">' +
            '<input style="margin-left: 10px;" class="span12 col-sm-2" name="TourPlanDynamicField[length][]" value="" placeholder="Độ dài(km)" id="TourPlanDynamicField_length" type="text">' +
            '<div style="margin-left: 10px;" class="span12 col-sm-6">' +
            '<input class="ck-check" name="us-ck" type="checkbox" id="ck-check' + random + '" data-id="' + random + '" value="" style="">' +
            '<label for="ck-check' + random + '" style="font-size: 12px;color: blue;pointer:cursor">Sử dụng trình soạn thảo</label>' +
            '<textarea style="float: left;width: 100%;" name="TourPlanDynamicField[content][]" id="TourPlanDynamicField_content' + random + '"><?php echo strip_tags($val['content']) ?></textarea>' +
            '</div>' +
            '<div class="col-sm-1">           ' +
            ' <button class="btn btn-sm btn-danger" type="button" onclick="removeFrom(this)">Xóa</button> ' +
            '</div>' +
            '</div>');
        $('.ck-check').on("click", function () {
            console.log($(this).attr('data-id'));
            if (this.checked) {
                CKEDITOR.replace('TourPlanDynamicField_content' + $(this).attr('data-id'), {
                    height: 400,
                    language: '<?php echo Yii::app()->language ?>'
                });
            } else {
                var a = CKEDITOR.instances['TourPlanDynamicField_content' + $(this).attr('data-id')];
                if (a) {
                    a.destroy(true);
                }

            }
        });

    }

    function removePlan(ev) {
        if (confirm('Bạn có chắc chắn muốn xóa?')) {
            $(ev).parent().parent().remove();
        } else {
            return false;
        }

    }
</script>
<style>
    .top-content, .top-content hr {
        float: left;
        width: 100%;
    }
</style>
<div class="form-group no-margin-left well well-lg clearfix">
    <div class="controls col-sm-12">
        <div id="showday4">
            <button class="btn btn-sm btn-info" onclick="add_op_review1()"
                    type="button"><?= Yii::t('translate', 'create') ?>
            </button>
            <hr>
            <div class="top-content">
                <div class="controls col-sm-2" style="padding: 0;margin-left: 5px"><strong>Tên</strong></div>
                <div class="controls col-sm-2" style="padding: 0;margin-left: 5px"><strong>Độ dài(km)</strong></div>
                <div class="controls col-sm-6"><strong>Nội dung</strong></div>
                <hr>
            </div>
            <?php
            $itinerary = json_decode($tourInfo->tour_plan, true);
            if (count($itinerary)) { ?>
                <?php foreach ($itinerary as $key => $val) { ?>
                    <div class="form-group no-margin-left">
                        <input class="span12 col-sm-2" name="TourPlanDynamicField[name][]"
                               value="<?php echo $val['name'] ?>"
                               id="TourPlanDynamicField_name" type="text">
                        <input style="margin-left: 10px;" class="span12 col-sm-2" name="TourPlanDynamicField[length][]"
                               value="<?php echo $val['length'] ?>"
                               id="TourPlanDynamicField_length" type="text" placeholder="Độ dài(km)">
                        <div style="margin-left: 10px;" class="span12 col-sm-6">
                            <input class="ck-check" name="us-ck" type="checkbox" id="ck-check<?= $key ?>"
                                   data-id="<?= $key ?>" value="" style="">
                            <label for="ck-check<?= $key ?>" style="font-size: 12px;color: blue;pointer:cursor">Sử dụng
                                trình soạn thảo</label>
                            <textarea style="float: left;width: 100%;" name="TourPlanDynamicField[content][]"
                                      id="TourPlanDynamicField_content<?= $key ?>"><?php echo strip_tags($val['content']) ?></textarea>
                        </div>
                        <div class="col-sm-1">
                            <button class="btn btn-sm btn-danger" type="button" onclick="removePlan(this)">Xóa
                            </button>
                        </div>
                    </div>
                <?php } ?>
                <hr>
            <?php } ?>
        </div>
    </div>
</div>


<?php
$seasons = TourSeason::getAllSeason();
$stars = TourSeason::optionStar();
$season_tours = json_decode($tourInfo->data_season_price, true);
if (count($season_tours)) {
    ?>
    <div class="form-group no-margin-left well well-lg clearfix">
        <?php
        foreach ($seasons as $value) {
            $key_of = $value['id'];
            ?>
            <div class="controls col-sm-12">
                <h4 class="blue"><?= $value['name'] ?></h4>
                <div id="showday<?= $key_of ?>">
                    <hr>
                    <div class="top-content">
                        <div class="controls col-sm-2" style="padding: 0;"><strong>Hạng sao</strong>
                        </div>
                        <div class="controls col-sm-10">
                            <div class="controls col-sm-4" style="padding: 0;margin-left: 5px"><strong>Season
                                    Tour</strong>
                            </div>
                            <div class="controls col-sm-4"><strong>Giá</strong></div>
                        </div>
                        <hr>
                    </div>

                    <?php
                    foreach ($stars as $key => $star) {
                        ?>
                        <div class="form-group no-margin-left">
                            <div class="controls col-sm-2"><strong><?= $star ?></strong>
                            </div>
                            <div class="controls col-sm-10" style="padding-left: 30px;" id="state-price-<?= $key_of ?>-<?= $key ?>">
                                <?php
                                foreach ($season_tours[$key_of][$key] as $key3 => $val) {
                                    ?>
                                    <div class="ct">
                                        <input style="margin-left: 20px;" class="span12 col-sm-4"
                                               name="TourSeasonField[<?= $key_of ?>][<?= $key ?>][stage][]"
                                               value="<?php echo $val['stage'] ?>"
                                               id="TourSeasonField_stage" type="text" placeholder="Giai đoạn">
                                        <input style="margin-left: 10px;" class="span12 col-sm-4"
                                               name="TourSeasonField[<?= $key_of ?>][<?= $key ?>][price][]"
                                               value="<?php echo $val['price'] ?>"
                                               id="TourSeasonField_price" type="text" placeholder="Giá">
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
                                        onclick="add_state(<?= $key_of ?>, <?= $key ?>)"
                                        type="button"><?= Yii::t('translate', 'create') ?>
                                </button>
                            </div>
                            <hr>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <hr>
            <?php
        } ?>
    </div>
<?php } else {
    if (count($seasons)) {
        ?>
        <div class="form-group no-margin-left well well-lg clearfix">
            <?php foreach ($seasons as $season) {
                $key = $season['id'];
                ?>
                <div class="controls col-sm-12">
                    <h4 class="blue"><?= $season['name'] ?></h4>
                    <div id="showday<?= $key ?>">
                        <hr>
                        <div class="top-content">
                            <div class="controls col-sm-2" style="padding: 0;"><strong>Hạng sao</strong>
                            </div>
                            <div class="controls col-sm-10" style="padding-left: 30px;">
                                <div class="controls col-sm-4" style="padding: 0;margin-left: 5px"><strong>Season
                                        Tour</strong>
                                </div>
                                <div class="controls col-sm-4"><strong>Giá</strong></div>
                            </div>
                            <hr>
                        </div>

                        <?php
                        foreach ($stars as $key2 => $seas) {
                            ?>
                            <div class="form-group no-margin-left">
                                <div class="controls col-sm-2"><strong><?= $seas ?></strong>
                                </div>
                                <div class="controls col-sm-10" id="state-price-<?= $key ?>-<?= $key2 ?>">
                                    <button style="margin-left: 20px;" class="btn btn-sm btn-info"
                                            onclick="add_state(<?= $key ?>, <?= $key2 ?>)"
                                            type="button"><?= Yii::t('translate', 'create') ?>
                                    </button>
                                </div>
                                <hr>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <hr>
            <?php } ?>
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

    function add_state(id, id2) {
        $('#state-price-' + id + '-' + id2).append(' <div class="ct">' +
            '<input style="margin-left: 20px;" class="span12 col-sm-4" name="TourSeasonField[' + id + '][' + id2 + '][stage][] value=" id="TourSeasonField_stage" type="text" placeholder="Giai đoạn">' +
            '<input style="margin-left: 10px;" class="span12 col-sm-4" name="TourSeasonField[' + id + '][' + id2 + '][price][]" value="" id="TourSeasonField_price" type="text" placeholder="Giá">' +
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