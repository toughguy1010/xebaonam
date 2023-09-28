<link href="<?php echo Yii::app()->request->baseUrl; ?>/installment/css/tragop.css" rel="stylesheet"/>
<div class="container">
    <div class="installment_index">
        <?php $this->renderPartial('tragop', ['product' => $product]) ?>
        <div class="notemoney">
            <b>Lưu ý:</b> Số tiền thực tế có thể chênh lệch đến 10.000đ/tháng
        </div>
        <div class="note-hc">
            Tham khảo <a target="_blank" title="Bảng giá gói bảo hiểm rơi vỡ khi tham gia trả góp Home Credit">
                Bảng giá gói bảo hiểm rơi vỡ khi tham gia trả góp Home Credit</a>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/installment/js/main.js"></script>