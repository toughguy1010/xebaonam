<div class="order-sale-page float-full pad-70-0">
    <div class="container">
        <div class="order-sale_s3 float-full">
            <div class="title-1 center">
                <h2><span>Chọn dịch vụ phiên dịch</span></h2>
                <div class="desc">
                    <p>Bước 3: Chọn loại dịch vụ</p>
                </div>
            </div>
            <div class="content-order-sale-s3 float-full">
                <form action="<?= Yii::app()->createUrl('economy/interpretation/checkout', array('option' => 1)) ?>">
                    <div class="list-price-pack">

                        <ul>
                            <li>
                                <div class="img-title-pack">
                                    <div class="img-pack">
                                        <img src="<?php echo Yii::app()->theme->baseUrl . '/demo/images/price-1.png' ?>"
                                             class="img-responsive" alt="Image">
                                    </div>
                                    <div class="title-pack">
                                        <h4>Escort & Negotiation Inter.
                                        </h4>
                                    </div>
                                </div>
                                <div class="desc-pack">
                                    <p>Cấp độ người dịch: Tiêu chuẩn.</p>
                                    <p>Áp dụng cho: </p>
                                    <div class="select-pack">
                                        <button value="3" type="submit" style="width: 100%;
display: inline-block;
vertical-align: top;
background-color: #eaeaea;
height: 48px;
line-height: 48px;
color: #656c71;
font-weight: 600;
border-radius: 5px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;">
                                            Chọn dịch vụ
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="img-title-pack">
                                    <div class="img-pack">
                                        <img src="<?php echo Yii::app()->theme->baseUrl . '/demo/images/price-2.png' ?>"
                                             class="img-responsive" alt="Image">
                                    </div>
                                    <div class="title-pack">
                                        <h4>Consecutive Inter </h4>
                                    </div>
                                </div>
                                <div class="desc-pack">
                                    <p>Cấp độ người dịch: Chính xác.</p>
                                    <p>Áp dụng cho: </p>
                                    <div class="select-pack">
                                        <button value="3" type="submit" style="width: 100%;
display: inline-block;
vertical-align: top;
background-color: #eaeaea;
height: 48px;
line-height: 48px;
color: #656c71;
font-weight: 600;
border-radius: 5px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;">
                                            Chọn dịch vụ
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="img-title-pack">
                                    <div class="img-pack">
                                        <img src="<?php echo Yii::app()->theme->baseUrl . '/demo/images/price-3.png' ?>"
                                             class="img-responsive" alt="Image">
                                    </div>
                                    <div class="title-pack">
                                        <h4>Simultaneous Inter. </h4>
                                    </div>
                                </div>
                                <div class="desc-pack">
                                    <p>Cấp độ người dịch: Cao cấp.</p>
                                    <p>Áp dụng cho: </p>
                                    <div class="select-pack">
                                        <button value="3" type="submit" style="width: 100%;
display: inline-block;
vertical-align: top;
background-color: #eaeaea;
height: 48px;
line-height: 48px;
color: #656c71;
font-weight: 600;
border-radius: 5px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;">
                                            Chọn dịch vụ
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </form>
                <div class="bottom-order-sale">
                    <div class="button-1">
                        <a href="<?= Yii::app()->createUrl('economy/interpretation/selectLang') ?>">
                            <button>Trở lại</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

	