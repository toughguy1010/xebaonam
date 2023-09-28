<div class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <div class="block-title">
                        Thông tin            
                    </div>
                </div>
                <div class="block-content">
                    <form action="" method="post" id="form_gen">
                        <div class="form-group">
                            <label>URL ảnh banner (<a href="http://imgur.com/" target="_blank">Upload</a>)</label>
                            <input type="text" name="imgsrc" id="aimgsrc" class="form-control">
                            <div class="help-block">Kích thước tối ưu: 720x280</div>
                        </div>
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input type="text" name="title" id="atitle" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Mô tả ngắn</label>
                            <textarea name="desc" class="form-control" id="adesc" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label>URL sản phẩm hoặc URL danh mục sản phẩm</label>
                            <input type="text" name="link" id="alink" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="css-input css-checkbox css-checkbox-primary">
                                <input type="checkbox" name="gen_aff_link" id="gen_aff_link" value="1" checked=""><span></span> Tự động tạo Link phân phối từ URL
                            </label>
                            <div class="help-block" id="aff_link_gen"></div>
                        </div>
                        <div class="form-group">
                            <input type="button" name="submit_preview" class="btn btn-default" value="Xem trước" onclick="preview_banner();return false;">
                            <input type="button" name="submit_copy" class="btn btn-success" value="Tạo" onclick="create_banner();return false;">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <div class="block-title">
                        Xem trước            </div>
                </div>
                <div class="block-content">
                    <div id="preview_content">
                        <div style="border:1px solid #eeeeee;max-width:720px;">
                            <div>
                                <a href="#" class="alink1" target="_blank"><img src="<?= Yii::app()->homeUrl ?>images/cover_de.png" class="affbanner1" style="width:100%;"></a>
                            </div>
                            <div style="padding:15px;">
                                <div style="font-size:15px;font-weight:bold;">
                                    <a href="#" class="alink1" target="_blank"><span class="afftitle1">Tiêu đề</span></a>
                                </div>
                                <div class="affdesc1" style="font-size:13px;color:#868686;">Mô tả ngắn</div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <textarea class="form-control" rows="6" id="txt_code" placeholder="Hãy nhập các thông tin cần thiết rồi ấn nút Xem trước..." onclick="this.select();"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default" onclick="copy_linkgen();"><i class="fa fa-copy"></i> Copy
                            HTML
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function create_banner() {
        // Banner Src
        var src = $('#aimgsrc').val();
        if (src == '') {
            alert('Bạn phải nhập URL ảnh Banner');
            return false;
        }
        $('.affbanner1').attr('src', src);
        // Tiêu đề
        var atitle = $('#atitle').val();
        $('.afftitle1').text(atitle);
        // Mô tả ngắn
        var adesc = $('#adesc').val();
        $('.affdesc1').text(adesc);
        // Link sản phẩm hoặc danh mục
        var alink = $('#alink').val();
        $('.alink1').attr('href', alink);
        // Content Html
        var content = $('#preview_content').html();
        $('#txt_code').val(content);
        // check generate affiliate link
        if ($('#gen_aff_link').is(':checked')) {
            $.getJSON(
                    '<?= Yii::app()->createUrl('affiliate/affiliateLink/createBannerLink') ?>',
                    {alink: alink},
                    function (data) {
                        if (data.code == 200) {
                            alert(data.msg);
                        }
                    }
            );
        }
    }
    
    function preview_banner() {
        // Banner Src
        var src = $('#aimgsrc').val();
        if (src == '') {
            alert('Bạn phải nhập URL ảnh Banner');
            return false;
        }
        $('.affbanner1').attr('src', src);
        // Tiêu đề
        var atitle = $('#atitle').val();
        $('.afftitle1').text(atitle);
        // Mô tả ngắn
        var adesc = $('#adesc').val();
        $('.affdesc1').text(adesc);
        // Link sản phẩm hoặc danh mục
        var alink = $('#alink').val();
        $('.alink1').attr('href', alink);
        // Content Html
        var content = $('#preview_content').html();
        $('#txt_code').val(content);
        // check generate affiliate link
    }

    function copy_linkgen() {
        var copyText = document.getElementById("txt_code");
        copyText.select();
        document.execCommand("Copy");
    }
</script>