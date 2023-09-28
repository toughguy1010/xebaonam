<div class="gift-card-page-3">
    <div class="gift-card-step-3">
        <div class="ctn-gift-card-step-3">
            <div class="img-gift-step-3">
                <a href="javascript:void(0)">
                    <img src="<?php echo $card['src'] ?>">
                </a>
            </div>
            <div class="ctn-gift-step-3">
                <a href="javascript:void(0)" class="img-step-3">
                    <img src="<?php echo $card['src'] ?>">
                </a>
                <h2><a href="">Lee Spa Nails e-Gift Card!</a></h2>
            </div>
            <div class="qr-step-3">
                <ul>
                    <li>
                        <p><span>Number:</span>AKXKGBC9U7BV-F</p>
                        <p><span>Owner:</span>nguyen</p>
                        <p><span>Value:</span>20.00 USD   <spam>NOT PAID</spam>  </p>
                    <p><span>Balance:</span>$20.00</p>
                    <p><span>Expires On:</span>March 7, 2018</p>  
                    </li>
                </ul>
                <div class="qr-img">
                    <a href="javascript:void(0)">
                        <img src="<?php
                        $this->widget('common.extensions.qrcode.QRCodeGenerator', array(
                            'data' => $model->id,
                            'filename' => $model->id . ".png",
                            'subfolderVar' => false,
                            'matrixPointSize' => 5,
                            'displayImage' => false,
                            'errorCorrectionLevel' => 'L',
                            'matrixPointSize' => 4, // 1 to 10 only
                            'filePath' => realpath(Yii::app()->getBasePath() . '/../uploads')
                        ));
                        ?>" />
                    </a>
                </div>
            </div>
            <div class="qr-note">
                <p>With years of experience in the industry, we are proud of offering our customers with excellent services at affordable prices.</p>
            </div>
        </div>
    </div>
</div>