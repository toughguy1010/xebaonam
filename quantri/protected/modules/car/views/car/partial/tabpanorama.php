<?php
$images_panorama = Car::getAllImagesPanorama($model->id);
$panorama_options = Car::getPanoramaOptions($model->id);
$interior_options = array();
$exterior_options = array();
foreach ($panorama_options as $option) {
    if ($option['type'] == 'interior') {
        $interior_options[] = $option;
    } else {
        $exterior_options[] = $option;
    }
}
?>
<style type="text/css">
    .options{
        margin-bottom: 30px;
        border: 1px solid #e3e3e3;
        padding: 20px;
        box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
    }
</style>
<div class="well well-lg clearfix">
    <h4 class="blue"><?php echo Yii::t('car', 'interior'); ?></h4>

    <div class="wrap_options_interior">
        <?php
        if (count($interior_options)) {
            foreach ($interior_options as $option) {
                ?>
                <div class="options col-xs-12" data-fid="<?php echo ($option['folder']) ? $option['folder'] : 1 ?>">
                    <div class="col-xs-3">
                        <label style="display: block">Màu: </label>
                        <input type="text" name="CarPanoramaOptions[interior][name][<?php echo $option['folder'] ?>]" value="<?php echo $option['name'] ?>" />
                    </div>
                    <div class="col-xs-3">
                        <label>Ảnh icon màu: </label>
                        <img style="width: 40px;margin: 0 0 0 20px;" src="<?php echo $option['path'] ?>" />
                        <input type="hidden" name="options_id[interior][]" value="<?php echo $option['id'], '-', $option['folder'] ?>" />
                        <input type="file" value="" name="options_src[interior][<?php echo $option['folder'] ?>]">
                    </div>
                    <div class="col-xs-3">
                        <label>Các file ảnh 360: </label>
                        <input type="file" id="file" name="files[interior][<?php echo $option['folder'] ?>][]" multiple="multiple" accept="image/*" />
                    </div>
                    <?php if (count($images_panorama)) { ?>
                        <div class="col-xs-12">
                            <label class="control-label bolder blue">Chọn ảnh đại diện 360</label>
                            <div class="clearfix">
                                <?php
                                foreach ($images_panorama as $item) {
                                    if ($item['option_id'] == $option['id']) {
                                        ?>
                                        <div class="radio col-xs-2">
                                            <label>
                                                <input value="<?php echo $item['id']; ?>" name="is_default[interior][<?php echo $option['id'] ?>]" <?php echo $item['is_default'] ? 'checked' : ''; ?> type="radio" class="ace">
                                                <span class="lbl"> <?php echo $item['image_name'] ?></span>
                                            </label>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <button type="button" onclick="removeColor('interior', <?php echo $option['folder'] ?>, <?php echo $option['id'] ?>, this)" class="btn btn-app btn-danger btn-xs">
                        Delete
                    </button>
                </div>

                <?php
            }
        } else {
            ?>
            <div class="options col-xs-12"  data-fid="1">
                <div class="col-xs-3">
                    <label style="display: block">Màu: </label>
                    <input type="text" name="CarPanoramaOptions[interior][name][1]" value="" />
                </div>
                <div class="col-xs-3">
                    <label>Ảnh icon màu: </label>
                    <input type="file" value="" name="options_src[interior][1]">
                </div>
                <div class="col-xs-3">
                    <label>Các file ảnh 360: </label>
                    <input type="file" id="file" name="files[interior][1][]" multiple="multiple" accept="image/*" />
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="col-xs-12">
        <button type="button" class="btn btn-success add_option_interior" onclick="addhtml()"><?php echo Yii::t('car', 'create') ?></button>
    </div>

</div>

<hr>

<div class="well well-lg clearfix">
    <h4 class="blue"><?php echo Yii::t('car', 'exterior'); ?></h4>
    <div class="wrap_options_exterior">
        <?php
        if (count($exterior_options)) {
            foreach ($exterior_options as $option_exterior) {
                ?>
                <div class="options col-xs-12" data-fid="<?php echo $option_exterior['folder'] ?>">
                    <div class="col-xs-3">
                        <label style="display: block">Màu: </label>
                        <input type="text" name="CarPanoramaOptions[exterior][name][<?php echo $option_exterior['folder'] ?>]" value="<?php echo $option_exterior['name'] ?>" />
                    </div>
                    <div class="col-xs-3">
                        <label>Ảnh icon màu: </label>
                        <img style="width: 40px;margin: 0 0 0 20px;" src="<?php echo $option_exterior['path'] ?>" />
                        <input type="hidden" name="options_id[exterior][]" value="<?php echo $option_exterior['id'], '-', $option_exterior['folder'] ?>" />
                        <input type="file" value="" name="options_src[exterior][<?php echo $option_exterior['folder'] ?>]">
                    </div>
                    <div class="col-xs-3">
                        <label>Các file ảnh 360: </label>
                        <input type="file" id="file" name="files[exterior][<?php echo $option_exterior['folder'] ?>][]" multiple="multiple" accept="image/*" />
                    </div>
                    <?php if (count($images_panorama)) { ?>
                        <div class="col-xs-12">
                            <label class="control-label bolder blue">Chọn ảnh đại diện 360</label>
                            <div class="clearfix">
                                <?php
                                foreach ($images_panorama as $item) {
                                    if ($item['option_id'] == $option_exterior['id']) {
                                        ?>
                                        <div class="radio col-xs-2">
                                            <label>
                                                <input value="<?php echo $item['id']; ?>" name="is_default[exterior][<?php echo $option_exterior['id'] ?>]" <?php echo $item['is_default'] ? 'checked' : ''; ?> type="radio" class="ace">
                                                <span class="lbl"> <?php echo $item['image_name'] ?></span>
                                            </label>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <button type="button" onclick="removeColor('exterior', <?php echo $option_exterior['folder'] ?>, <?php echo $option_exterior['id'] ?>, this)" class="btn btn-app btn-danger btn-xs">
                        Delete
                    </button>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="options col-xs-12" data-fid="1">
                <div class="col-xs-3">
                    <label style="display: block">Màu: </label>
                    <input type="text" name="CarPanoramaOptions[exterior][name][1]" value="" />
                </div>
                <div class="col-xs-3">
                    <label>Ảnh icon màu: </label>
                    <input type="file" value="" name="options_src[exterior][1]">
                </div>
                <div class="col-xs-3">
                    <label>Các file ảnh 360: </label>
                    <input type="file" id="file" name="files[exterior][1][]" multiple="multiple" accept="image/*" />
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="col-xs-12">
        <button type="button" class="btn btn-success add_option_exterior" onclick="addhtmlExterior()"><?php echo Yii::t('car', 'create') ?></button>
    </div>
</div>


<script type = "text/javascript">

    function removeColor(type_image, folder, option_id, thistag) {
        if (confirm('Bạn có chắc muốn xóa?')) {
            var car_id = '<?php echo $model->id ?>';
            var url = '<?php echo $this->createUrl('removeOption') ?>';
            $.ajax({
                url: url,
                data: {car_id: car_id, type_image: type_image, folder: folder, option_id: option_id},
                type: 'get',
                dataType: 'json',
                success: function (data) {
                    if (data.code == 200) {
                        $(thistag).parent('.options').remove();
                    }
                }
            });
        }
    }


//    var count_tag = $('.wrap_options_interior').children('.options').length;
    var count_tag = $('.wrap_options_interior .options:last-child').attr('data-fid');
    function addhtml() {
        count_tag++;
        var html = "<div class='options col-xs-12' data-fid='" + count_tag + "'>";
        html += "<div class='col-xs-3'><label style='display: block'>Màu: </label> ";
        html += "<input type='text' name='CarPanoramaOptions[interior][name][" + count_tag + "]' value='' />";
        html += "</div><div class='col-xs-3'><label>Ảnh icon màu: </label>";
        html += "<input type='file' value='' name='options_src[interior][" + count_tag + "]'></div>";
        html += "<div class='col-xs-3'><label>Các file ảnh 360: </label>";
        html += "<input type='file' id='file' name='files[interior][" + count_tag + "][]' multiple='multiple' accept='image/*' /></div>";

        $('.wrap_options_interior').append(html);
    }

    var count_tag_exterior  = $('.wrap_options_exterior .options:last-child').attr('data-fid');
//    var count_tag_exterior = $('.wrap_options_exterior').children('.options').length;
    function addhtmlExterior() {
        count_tag_exterior++;
        var html = "<div class='options col-xs-12'  data-fid='"+ count_tag_exterior +"'><div class='col-xs-3'><label style='display: block'>Màu: </label> ";
        html += "<input type='text' name='CarPanoramaOptions[exterior][name][" + count_tag_exterior + "]' value='' />";
        html += "</div><div class='col-xs-3'><label>Ảnh icon màu: </label>";
        html += "<input type='file' value='' name='options_src[exterior][" + count_tag_exterior + "]'></div>";
        html += "<div class='col-xs-3'><label>Các file ảnh 360: </label>";
        html += "<input type='file' id='file' name='files[exterior][" + count_tag_exterior + "][]' multiple='multiple' accept='image/*' /></div>";

        $('.wrap_options_exterior').append(html);
    }
</script>