<?php
/* @var $this NewsController */
/* @var $model News */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#affilliate-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<script>
    function copyText(tag) {
        var copyText = document.getElementById(tag);
        copyText.select();
        document.execCommand('copy');
    }

    function changelink() {
        vl = $('#vallink').val();
        if (vl.includes('?')) {
            $('#linkcopy3').val(vl + '&<?= ClaAff::KYE_GET_AFF . '=' . Yii::app()->user->id ?>');
        } else {
            $('#linkcopy3').val(vl + '?<?= ClaAff::KYE_GET_AFF . '=' . Yii::app()->user->id ?>');
        }
    }
</script>
<style>
    .box-getlink .textcopy {
        overflow-x: auto;
        border: 1px dashed #ccc;
        padding: 7px 15px;
        background: #ebebeb;
        width: 100%;
    }

    .box-getlink button {
        white-space: nowrap;
        background: #17a349;
        border: none;
        color: #fff;
        padding: 0px 20px;
    }

    .box-getlink {
        margin: 0 auto;
        background: #fff;
        padding: 15px;
        display: flex;
        position: relative;
    }

    .box-getlink p {
        width: 300px;
        margin-top: 10px;
    }

    .box-getlink .textcopy input {
        margin-bottom: 0px;
        white-space: nowrap;
        border: none;
        background: transparent;
        width: 100%;
    }
</style>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('affilliate', 'affilliate_link'); ?>
        </h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="box-getlink">
                <p>Link giới thiệu thành viên:
                <div class="textcopy">
                    <input id="linkcopy1" value="<?= $link_sp ?>">
                </div>
                <button onclick="copyText('linkcopy1')">Sao chép</button>
                </p>
            </div>
            <div class="box-getlink">
                <p>Link giới thiệu khách hàng:
                <div class="textcopy">
                    <input id="linkcopy2" value="<?= $link_sp ?>">
                </div>
                <button onclick="copyText('linkcopy2')">Sao chép</button>
                </p>
            </div>

            <div class="search-active-form" style="position: relative; margin-top: 10px;">
                <div style="padding: 8px 12px 0px;">
                    <p>Link giới thiệu khách hàng chi tiết:</p>
                    <div class="form-inline">
                        <input id="vallink" class="" placeholder="Nhập đường dẫn trên trang bạn muốn chia sẻ" style="width:300px" type="text">
                        <input onclick="changelink()" class="btn btn-sm" type="submit" value="Lấy đường dẫn giới thiệu">
                    </div>
                </div>
                <div class="box-getlink">
                    <p>Đường dẫn chia sẻ:
                    <div class="textcopy">
                        <input id="linkcopy3" value="">
                    </div>
                    <button onclick="copyText('linkcopy3')">Sao chép</button>
                    </p>
                </div>
            </div><!-- search-form -->
        </div>
    </div>
</div>