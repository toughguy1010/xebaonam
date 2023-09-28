<?php
$images_panorama = Product::getAllImagesPanorama($model->id);
$panorama_options = Product::getPanoramaOptions($model->id);
$interior_options = array();
$exterior_options = array();
foreach ($panorama_options as $option) {
    if ($option['type'] == 'product360') {
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
<div class="">
    <h4 class="blue"><?php echo Yii::t('product', 'product_panorama_360'); ?></h4>

    <div class="wrap_options_interior">
        <p style='font-size: 12px;color: #0000FF;font-weight: bold'>Lưu ý:- Yêu cầu nhập tên ảnh <span style="color: red;">CHUẨN </span> theo theo cấu trúc <span style="color: red;">[Tên ảnh]_[Số thứ tự]</span>.
            <br/><span style="color: red;">[Tên ảnh]</span> - Không dấu, giống nhau, không chứa khoảng trắng " ".
            <br/><span style="color: red;">[Số thứ tự]</span> - Số tự nhiên tăng dần, bắt đầu từ 1.
            <br/>(Chỉ chập nhận các ảnh có đuôi "jpg", "png", "gif", "bmp". Dung lượng từng ảnh phải nhỏ hơn 2mb).
            <br/>
            VD: ten_anh_1.png, ten_anh_2.png, ten_anh_3.png, ...,ten_anh_32.png</p>
        <?php
        if (count($interior_options)) {
            foreach ($interior_options as $option) {
                ?>
                <div class="options col-xs-12">

                    <div class="col-xs-3">
                        <label style="display: block">Tiêu đề(*): </label> 
                        <input type="text" name="ObjectPanoramaOptions[product360][name][<?php echo $option['folder'] ?>]" value="<?php echo $option['name'] ?>" />
                    </div>
                    <div class="col-xs-3">
                        <label>Ảnh icon: </label>
                        <img style="width: 40px;margin: 0 0 0 20px;" src="<?php echo $option['path'] ?>" />
                        <input type="hidden" name="options_id[product360][]" value="<?php echo $option['id'], '-', $option['folder'] ?>" />
                        <input type="file" value="" name="options_src[product360][<?php echo $option['folder'] ?>]">
                    </div>
                    <div class="col-xs-3">
                        <label>Các file ảnh 360: </label>
                        <input type="file" id="file" name="files[product360][<?php echo $option['folder'] ?>][]" multiple="multiple" accept="image/*" />
                    </div>
                    <?php if (count($images_panorama)) { ?>
                        <div class="col-xs-12">
                            <label class="control-label bolder blue">Chọn ảnh đại diện 360</label>
                            <div class="clearfix">
                                <?php
                                foreach ($images_panorama as $item) {
                                    if ($item['option_id'] == $option['id']) {
                                        ?>
                                        <div class="radio col-xs-3">
                                            <label>
                                                <input value="<?php echo $item['id']; ?>" name="is_default[product360][<?php echo $option['id'] ?>]" <?php echo $item['is_default'] ? 'checked' : ''; ?> type="radio" class="ace">
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
                    <button type="button" onclick="removeColor('product360', <?php echo $option['folder'] ?>, <?php echo $option['id'] ?>, this)" class="btn btn-app btn-danger btn-xs">
                        <?php echo yii::t('common', 'delete') ?>
                    </button>
                </div>

                <?php
            }
        } else {
            ?>
            <div class="options col-xs-12">
                <div class="col-xs-3">
                    <label style="display: block">Phiên bản( Màu,..): </label> 
                    <input type="text" name="ObjectPanoramaOptions[product360][name][1]" value="" />
                </div>
                <div class="col-xs-3">
                    <label>Ảnh icon: </label>
                    <input type="file" value="" name="options_src[product360][1]">
                </div>
                <div class="col-xs-3">
                    <label>Các file ảnh 360: </label>
                    <input type="file" id="file" name="files[product360][1][]" multiple="multiple" accept="image/*" />
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="col-xs-12">
        <button type="button" class="btn btn-success add_option_interior" onclick="addhtml()"><?php echo Yii::t('car', 'create') ?></button>
    </div>
</div>



<script type = "text/javascript">
    function removeColor(type_image, folder, option_id, thistag) {
        if (confirm('Bạn có chắc muốn xóa?')) {
            var pid = '<?php echo $model->id ?>';
            var url = '<?php echo $this->createUrl('removeOption') ?>';
            $.ajax({
                url: url,
                data: {pid: pid, type_image: type_image, folder: folder, option_id: option_id},
                type: 'get',
                dataType: 'json',
                success: function (data) {
                    if (data.code === 200) {
                        $(thistag).parent('.options').remove();
                    }
                }
            });
        }
    }
    var count_tag = $('.wrap_options_interior').children('.options').length;
    function addhtml() {
        count_tag++;
        var html = "<div class='options col-xs-12'><div class='col-xs-3'><label style='display: block'>Màu: </label> ";
        html += "<input type='text' name='ObjectPanoramaOptions[product360][name][" + count_tag + "]' value='' />";
        html += "</div><div class='col-xs-3'><label>Ảnh icon màu: </label>";
        html += "<input type='file' value='' name='options_src[product360][" + count_tag + "]'></div>";
        html += "<div class='col-xs-3'><label>Các file ảnh 360: </label>";
        html += "<input type='file' id='file' name='files[product360][" + count_tag + "][]' multiple='multiple' accept='image/*' /></div>";
        $('.wrap_options_interior').append(html);
    }
</script>