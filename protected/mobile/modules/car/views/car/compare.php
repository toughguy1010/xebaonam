<?php 
    $count = count($data);
?>
<style type="text/css">
    .compare .item-car .img {
        max-width: 200px;
    }
    .cl-red {
        color: red;
    }
    .list-car {
        text-align: right;
    }
    .item-car {
        display: inline-block;
        padding: 0px 10px;
    }
    .col-compare-3 {
        width: 30%;
        text-align: center;
    }
    .col-compare-2 {
        width: 45%;
        text-align: center;
    }
    .box_tabs .tabs-fixed-width .tab {
        min-width: inherit;
    }
    .box_tabs .tabs .tab {
        height: auto;
        line-height: normal;
        text-transform: none!important;
        margin-right: 5px;
        float: left;
        -webkit-box-sizing: border-box!important;
        box-sizing: border-box!important;
    }
    .tabs.tabs-fixed-width .tab {
        -webkit-box-flex: 1;
        -webkit-flex-grow: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
    }
    .tabs .tab {
        display: inline-block;
        text-align: center;
        line-height: 48px;
        height: 48px;
        padding: 0;
        margin: 0;
        text-transform: uppercase;
    }
    ul:not(.browser-default) li {
        list-style-type: none;
    }
    .box_tabs .tabs {
        background: none;
        border-bottom: 0px;
        padding-bottom: 1rem;
        height: auto!important;
        -webkit-margin-before: 0em;
        -webkit-margin-after: 0em;
        -webkit-padding-start: 0px;
    }
    .tabs.tabs-fixed-width {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
    }
    ul:not(.browser-default) {
        padding-left: 0;
        list-style-type: none;
    }
    .tabs {
        position: relative;
        overflow-x: auto;
        overflow-y: hidden;
        height: 48px;
        width: 100%;
        background-color: #fff;
        margin: 0 auto;
        white-space: nowrap;
    }
    .box_tabs .tabs a {
        background: #eee;
    }
    .box_tabs .tabs .tab a.active {
        background-color: #c8102e!important;
        color: #fff!important;
    }
    .box_tabs .tabs-fixed-width .tab a {
        min-width: inherit;
    }
    .box_tabs .tabs .tab a {
        padding-top: 0.8em;
        padding-bottom: 0.9em;
        text-align: center;
        color: #000;
        display: block;
        width: inherit;
    }
    .tabs .tab a.active, .tabs .tab a:hover {
        background-color: #ee6e73;
        color: #fff;
    }
    .tabs .tab a {
        color: rgba(238,110,115,.7);
        display: block;
        width: 100%;
        height: 100%;
        padding: 0 24px;
        font-size: 14px;
        text-overflow: ellipsis;
        overflow: hidden;
        -webkit-transition: color .28s ease;
        transition: color .28s ease;
    }
   /* .compare tbody>tr>td:nth-of-type(2) {
        max-width: 200px;
    }*/
   /* .compare table>tbody>tr:nth-child(2n) {
        background-color: #E0E0E0;
    }*/
    .compare tr td {
        border: 0;
        padding: 0.8rem 1rem;
        position: relative;
    }
    .compare table table td {
        text-align: center;
    }
    body .compare table td {
        font-size: 14px;
        padding: 0px 15px;
    }
    .label-compare {
        font-weight: bold;
        padding: 10px 15px !important;
        background: #ccc;
    }
    .label-compare-child {
        background: #ddd;
    }
    .compare .box_tabs {
        margin-top: 20px;
    }
    .compare .tab-content {
        margin-bottom: 40px;
    }
    .compare .content h3 {
        font-size: 14px;
        font-weight: bold;
        text-transform: none;
    }
    .compare .content {
        text-align: left;
    }
    .box_tabs .tabs .tab.active a {
        background-color: #c8102e!important;
        color: #fff!important;
    }
    .compare a {
        cursor: pointer;
    }
</style>
<style type="text/css">
    .box_tabs>ul {
        width: 100%;
        overflow: auto;
    }
    .label-compare , .label-compare-child, .detail-compare{
        width: 100% !important;
        display: block;
    }
</style>
<script type="text/javascript">
    $('.compare .with12-5').each(function(e){
        $(this).height($(this).width()*8/12);
    })
</script>
<div class="compare" id="compare">
    <div class="heading_dt" data-text="02">
        <p class="txt1" data-text="Phiên bản xe đã chọn">Phiên bản xe đã chọn</p>
    </div>
    <div class="list-car">
        <div class="kc"></div>
        <?php foreach ($data as $car) { ?>
            <div class="item-car col-compare-<?= $count ?>">
                <div class="img">
                    <div class="img with12-5">
                        <img src="<?= ClaUrl::getImageUrl($car['avatar_path'], $car['avatar_name'], array('width' => 250, 'height' => 250)); ?>">
                    </div>
                    <div class="content">
                        <h3>
                            <a href="<?php echo $car['link']; ?>" title="<?php echo $car['name']; ?>"><?= $car['name']; ?></a>
                        </h3>
                        <span class="price">
                            Giá từ: <span><?= $car['price'] > 0 ?  number_format($car['price'], 0) : 'Liên hệ'; ?></span> <sup>VND</sup>
                        </span>
                        <br/>
                        <a href="#" class="cl-red">Dự toán</a>
                    </div>
                </div>
            </div>    
        <?php } ?>
    </div>
    <div class="box-detail-compare">
        <div class="box_tabs" id="box_tabs">
            <ul class="nav nav-tabs tabs tabs-fixed-width spec_cmp">
                <?php 
                $i = 0;
                foreach ($components as $key => $value) { ?>
                    <li class="nav-item tab ng-scope <?= $i==0 ? 'active' : '' ?>" >
                        <a href="#tab_compare_<?= $key ?>" data-toggle="tab"><?= $value ?></a>
                    </li>
                <?php $i++;} ?>
            </ul>
        </div> 
        <div class="tab-content" id="myTabContent">
            <div id="tab_compare_0" class="content-tab tab-pane fade active in" role="tabpanel">
                <div class="inner res_block">
                    <table class="tbltk striped">
                        <tbody id="tbodyTongQuan">
                            <tr>
                                <td class="label-compare">
                                    Số chỗ ngồi
                                </td>
                                <td class="label-compare-child"></td>
                                <td class="detail-compare">
                                    <table><tbody><tr class="tqtablelst0"><td style="font-weight: normal">5 chỗ</td><td style="font-weight: normal">5 chỗ</td><td style="font-weight: normal">7 chỗ</td></tr></tbody></table>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-compare">
                                    Số chỗ ngồi
                                </td>
                                <td class="label-compare-child"></td>
                                <td class="detail-compare">
                                    <table><tbody><tr class="tqtablelst0"><td style="font-weight: normal">5 chỗ</td><td style="font-weight: normal">5 chỗ</td><td style="font-weight: normal">7 chỗ</td></tr></tbody></table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="tab_compare_1" class="content-tab tab-pane fade" role="tabpanel">
                <div class="inner res_block">
                    <table class="tbltk striped">
                        <tbody id="tbodyTongQuan">
                            <tr>
                                <td class="label-compare">
                                    Kích thước
                                </td>
                                <td class="label-compare-child">Kích thước tổng thể bên ngoài (D x R x C) (mm x mm x mm)</td>
                                <td class="detail-compare">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <!-- ngRepeat: value in item2.values --><td ng-repeat="value in item2.values" style="font-weight: normal" class="ng-binding ng-scope">3660 x 1600 x 1520</td><!-- end ngRepeat: value in item2.values --><td ng-repeat="value in item2.values" style="font-weight: normal" class="ng-binding ng-scope">3660 x 1600 x 1520</td><!-- end ngRepeat: value in item2.values --><td ng-repeat="value in item2.values" style="font-weight: normal" class="ng-binding ng-scope">4190 x 1660 x 1695</td><!-- end ngRepeat: value in item2.values -->
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-compare">
                                    Kích thước
                                </td>
                                <td class="label-compare-child">Kích thước tổng thể bên ngoài (D x R x C) (mm x mm x mm)</td>
                                <td class="detail-compare">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <!-- ngRepeat: value in item2.values --><td ng-repeat="value in item2.values" style="font-weight: normal" class="ng-binding ng-scope">3660 x 1600 x 1520</td><!-- end ngRepeat: value in item2.values --><td ng-repeat="value in item2.values" style="font-weight: normal" class="ng-binding ng-scope">3660 x 1600 x 1520</td><!-- end ngRepeat: value in item2.values --><td ng-repeat="value in item2.values" style="font-weight: normal" class="ng-binding ng-scope">4190 x 1660 x 1695</td><!-- end ngRepeat: value in item2.values -->
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<p class="compare-mobile li-select-car-tg">
    <a>Chọn xe</a>
</p>
