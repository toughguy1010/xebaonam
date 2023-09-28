<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'sc-checkout-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'htmlOptions' => array('class' => 'form-horizontal widget-form'),
        ));
?>
<div class="sc checkout checkout-st2">

    <h2 class="sc-title"><?php echo Yii::t('shoppingcart', 'checkoutandorder'); ?></h2>
    <div class="sc-ck-info">
        <div class="row">
            <div class="col-xs-6 billing">
                <h3 class="sc-billing-text"><?php echo Yii::t('shoppingcart', 'billing-text') ?></h3>
                <div class="form-group">
                    <?php echo $form->label($billing, 'name', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo $form->textField($billing, 'name', array('class' => 'form-control', 'style' => 'width: 100%;')); ?>
                        <?php echo $form->error($billing, 'name'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->label($billing, 'email', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo $form->textField($billing, 'email', array('class' => 'form-control', 'style' => 'width: 100%;')); ?>
                        <?php echo $form->error($billing, 'email'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->label($billing, 'phone', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo $form->textField($billing, 'phone', array('class' => 'form-control', 'style' => 'width: 100%;')); ?>
                        <?php echo $form->error($billing, 'phone'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->label($billing, 'address', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo $form->textField($billing, 'address', array('class' => 'form-control', 'style' => 'width: 100%;')); ?>
                        <?php echo $form->error($billing, 'address'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->label($billing, 'city', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo $form->dropDownList($billing, 'city', LibProvinces::getListProvinceArr(), array('class' => 'form-control')); ?>
                        <?php echo $form->error($billing, 'city'); ?>
                    </div>
                </div>
                <div class="checkbox cs-check" style="padding-top: 0px;">
                    <input id="ytbilltoship" type="hidden" name="Billing[billtoship]" value="0">
                    <label>
                        <input type="checkbox" name="Billing[billtoship]" id="billtoship" <?php if ($billing->billtoship) echo 'checked="checked"'; ?> value="1" /> <?php echo Yii::t('shoppingcart', 'shippingaddress'); ?> 
                    </label>
                </div>
            </div>
            <div class="col-xs-6 shipping <?php if ($billing->billtoship) echo 'hidden'; ?>" id="shipping">
                <h3 class="sc-shipping-text"><?php echo Yii::t('shoppingcart', 'shipping-text') ?></h3>
                <div class="form-group">
                    <?php echo $form->label($shipping, 'name', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo $form->textField($shipping, 'name', array('class' => 'form-control', 'style' => 'width: 100%;')); ?>
                        <?php echo $form->error($shipping, 'name'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->label($shipping, 'phone', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo $form->textField($shipping, 'phone', array('class' => 'form-control', 'style' => 'width: 100%;')); ?>
                        <?php echo $form->error($shipping, 'phone'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->label($shipping, 'address', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo $form->textField($shipping, 'address', array('class' => 'form-control', 'style' => 'width: 100%;')); ?>
                        <?php echo $form->error($shipping, 'address'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->label($shipping, 'city', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo $form->dropDownList($shipping, 'city', LibProvinces::getListProvinceArr(), array('class' => 'form-control')); ?>
                        <?php echo $form->error($shipping, 'city'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row ps">
        <div class="col-xs-6 payment">
            <h3 class="sr-method-text"><?php echo Yii::t('shoppingcart', 'payment_method'); ?></h3>
            <?php
            $paymentmethod = Orders::getPaymentMethod();
            if ($paymentmethod) {
                foreach ($paymentmethod as $pk => $plabel) {
                    ?>
                    <div class="radio pm_parent">
                        <label>
                            <input type="radio" name="Orders[payment_method]" value="<?php echo $pk; ?>" <?php if ($order->payment_method == $pk) echo 'checked="checked"' ?> />
                            <?php echo $plabel; ?>
                        </label>
                        <?php
                        if($pk == Orders::PAYMENT_METHOD_ONLINE){
                            $this->renderPartial('partial/payment_baokim',array('order'=>$order));
                        }
                        ?>
                    </div>
                    <?php
                }
            }
            ?>
            <?php echo $form->error($order, 'payment_method'); ?>
        </div>
        <div class="col-xs-6 transport">
            <h3 class="sr-method-text"><?php echo Yii::t('shoppingcart', 'transport_method'); ?></h3>
            <?php
            $transportmethod = Orders::getTranportMethod();
            if ($transportmethod) {
                foreach ($transportmethod as $tk => $tinfo) {
                    ?>
                    <div class="radio">
                        <label>
                            <input type="radio" name="Orders[transport_method]" value="<?php echo $tk; ?>" <?php if ($order->transport_method == $tk) echo 'checked="checked"' ?>/>
                            <?php
                            $time = (($tinfo['time']) ? $tinfo['time'] : '');
                            echo $tinfo['name'] . $time . ' - ' . $tinfo['price'];
                            ?>
                        </label>
                    </div>
                    <?php
                }
            }
            ?>
            <?php echo $form->error($order, 'transport_method'); ?>
        </div>
    </div>
     <div class="form-group w3-form-group">
        <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK7)); ?>
       <!--  <div class="note-payment">

            <p class="note-top">* Khách hàng khi mua sắm tại website 21six.vn phải thực hiện các thao tác đặt hàng và nhận hàng theo trình tự sau:</p>
            <p>
                <strong>Cách 1: Thanh toán trước online qua thẻ tín dụng (Visa, Master card..) hoặc thẻ ATM:</strong><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bước 1: Khách hàng đặt hàng, cung cấp thông tin đầy đủ, xác thực.<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bước 2: Khách hàng thanh toán trước.<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bước 3: 21SIX kiểm tra, xác nhận đơn hàng và chuyển hàng.<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bước 4: Khách hàng kiểm tra và nhận hàng.
            </p>
            <p>
                <strong>Cách 2: Thanh toán sau:</strong><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bước 1: Khách hàng đặt hàng, cung cấp thông tin đầy đủ, xác thực.<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bước 2: Khách hàng thanh toán trước.<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bước 3: 21SIX kiểm tra, xác nhận đơn hàng và chuyển hàng.<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bước 4: Khách hàng kiểm tra và nhận hàng.
            </p>
            <p>
                Trong các trường hợp, khách hàng có thể tra cứu thông tin giao dịch qua email gửi vào hộp thư khách hàng đã đăng ký với khi mua hàng tại website XE BẢO NAM.vn hoặc gọi điện đến số hotline 0968.266.266 để giải đáp những thắc mắc.
            </p>
            <p><i>Chúng tôi chịu trách nhiệm về nội dung thông tin cung cấp trên website 21six.vn, thực hiện quy định của Pháp Luật về giao kết hợp đồng, đặt hàng, thanh toán.</i></p>
            <div class="policy-payment">
                <h3><b>CHÍNH SÁCH ĐỔI TRẢ HÀNG CỦA XE BẢO NAM</b></h3>
                <p>
                    <strong>1. Chính sách trả hàng:</strong><br>
                    <span> - XE BẢO NAM không chấp nhận việc trả hàng để lấy tiền (CẢ TIỀN MẶT HAY TIỀN TRỪ VÀO THẺ TÍN DỤNG)</span>
                </p>
                <p>
                    <strong>2. Chính sách đổi hàng:</strong><br>
                    <span> - Trong bất kỳ tình huống nào, XE BẢO NAM chỉ chấp nhận việc đổi hàng còn mới, chưa sửa chữa, chưa qua sử dụng, trong vòng 03 ngày kể từ ngày mua hàng ;</span><br>
                    <span> - Hàng được đổi vì lý do kỹ thuật phải có sự đồng ý và xác nhận của XE BẢO NAM;</span><br>
                    <span> - Hàng đổi phải còn mới và giữ nguyên tình trạng ban đầu, còn nguyên tem, nhãn mác;</span><br>
                    <span> - Hàng chưa qua sử dụng, chưa giặt và không bị hư hại. Hàng không bị bẩn, không dính các vết mỹ phẩm, không nhiễm mùi như nước hoa, kem cạo râu, chất khử mùi cơ thể hay khói thuốc lá, v.v…;</span><br>
                    <span> - Hàng bán trong thời gian khuyến mãi, hoặc hàng đã được đổi một lần trước đó sẽ không áp dụng chính sách đổi trả hàng, trừ trường hợp do lỗi kỹ thuật;</span><br>
                    <span> - Giá trị đổi hàng tính theo giá bán thực tế tại thời điểm mua hàng, nhưng phải bằng hoặc cao hơn sản phẩm muốn đổi;</span><br>
                    <span> - Nếu quý khách không chọn được sản phẩm nào ưng ý tại thời điểm đổi hàng hoặc sản phẩm mới đổi thấp hơn sản phẩm cũ, XE BẢO NAM sẽ ghi số tiền chênh lệch này thành số tiền đặt cọc của Quý Khách trong lần mua tới (Phiếu đặt cọc có giá trị trong vòng 5 tháng).</span>
                </p>
                <p>
                    <strong>3. Chính sách hủy đơn hàng:</strong><br>
                    <span>Chúng tôi chấp nhận cho Quý khách thực hiện hủy đơn hàng trong vòng 24h kể từ thời điểm Quý khách thanh toán thành công.  Quý khách vui lòng liên hệ với Chúng tôi theo số điện thoại <b>0989.500.066</b>.và gửi email về địa chỉ <b>trieunhat@gmail.com</b>.để được hỗ trợ hủy đơn hàng.</span><br>
                    <span> - Nếu quý khách hủy đơn hàng trước khi hàng được vận chuyển, thông thường là trong vòng 1 giờ kể từ lúc nhân viên bán hàng liên hệ xác nhận đặt hàng, Chúng tôi sẽ hoàn trả 100% tiền cho những quý khách đã thanh toán.</span><br>
                    <span> - Nếu quý khách hủy đơn hàng sau khi hàng đã được vận chuyển, Chúng tôi sẽ KHÔNG chấp nhận việc hủy đơn hàng với bất kỳ lý do nào.</span><br>
                    <span>Để biết tình trạng hiện tại của đơn hàng, quý khách vui lòng xem trong mục Quản lý đơn hàng trên website XE BẢO NAM.vn. Hoặc liên hệ theo số điện thoại <b>0989.500.066</b>. Địa chỉ email <b>trieunhat@gmail.com</b>.</span><br>
                    <span>Quá thời gian qui định trên, mọi yêu cầu hủy đơn hàng của Quý khách sẽ không được chấp nhận.</span><br>
                    <span>Mọi thắc mắc về thủ tục đổi hàng, hủy đơn hàng xin vui lòng liên hệ theo thông tin sau: Hotline: <b>0989.500.066</b></span>
                </p>
                <p>
                    <strong>4. Chính sách riêng: </strong><br>
                    <span>Ngoài các chính sách chung, mỗi hình thức mua hàng còn áp dụng thêm các chính sách như sau:</span><br>
                    <strong>Đối với mua hàng trực tuyến</strong><br>
                    <span> - Khách hàng liên hệ với bộ phận bán hàng Online để xác nhận đơn hàng muốn đổi và được hướng dẫn đổi hàng (không quá 3 ngày kể từ ngày nhận được sản phẩm);</span><br>
                    <span> - Hàng chỉ đổi lại khi lỗi do nhà sản xuất, sai màu, sai cỡ như khách hàng yêu cầu;</span><br>
                    <span> - Khi quý khách muốn đổi lại hàng trong trường hợp không phải do lỗi của XE BẢO NAM, xin vui lòng thanh toán phí vận chuyển.</span><br>
                    <strong>Đối với mua hàng tại cửa hàng</strong><br>
                    <span> - Quý khách vui lòng xuất trình hóa đơn mua hàng khi có yêu cầu đổi hàng;</span><br>
                    <span> - Với mỗi đơn hàng chỉ được đổi tối đa 01 lần (trừ những trường hợp đặc biệt).</span><br>
                </p>
            </div>
            <div class="policy-payment">
                <h3><b>CHÍNH SÁCH VẬN CHUYỂN</b></h3>
                <p>
                    <strong>XE BẢO NAM cung cấp dịch vụ giao hàng miễn phí (hàng mua mới và hàng sửa chữa lần đầu) cho tất cả các khách hàng sau:</strong><br>
                    <span> - Khách hàng VIP;</span><br>
                    <span> - Khách hàng nằm trong khu vực bán kính dưới 15km tính từ địa chỉ Cửa hàng gần nhất;</span><br>
                    <span> - Khách hàng có tổng đơn hàng từ … triệu đồng trở lên.</span><br>
                    <strong>Thời gian giao hàng(*):</strong><br>
                    <span> - Khu vực nội thành Hà Nội, TP. Hồ Chí Minh và các thành phố lớn: 1-2 ngày kể từ khi xác nhận đơn hàng;</span><br>
                    <span> - Khu vực ngoại thành Hà Nội, TP. Hồ Chí Minh và các thành phố lớn: 3-4 ngày kể từ khi xác nhận đơn hàng;</span><br>
                    <span> - Các khu vực khác: 4-5 ngày kể từ ngày xác nhận đơn hàng.</span><br>
                    <span>(*)Trong trường hợp khẩn cấp, khách hàng có thể liên hệ với NVBH tại cửa hàng hoặc Bộ phận Sale Online để thay đổi thời gian gửi hàng. </span><br>
                    <span>(*)Với các yêu cầu giao hàng đặc biệt, Quý khách vui lòng thanh toán phí vận chuyển cho bên thứ 3 cung cấp dịch vụ.</span>
                </p>
            </div>
        </div> -->
    </div>
     <div class="form-group w3-form-group">
        <div class="checkbox" style="margin-bottom: 30px;float: right; margin-right: 15px;">
            <label>
                <input name="agree" id="agree" type="checkbox" class="ace">
                <span class="lbl" style="font-weight: bold;"> Đồng Ý Các Điều Khoản Thanh Toán</span>
            </label>
        </div>
    </div>
    <div class="sc">
        <div class="accordion-inner">
            <?php
            $this->renderPartial('pack', array(
                'shoppingCart' => $shoppingCart,
                'update' => false,
            ));
            ?>
        </div>
    </div>
    <?php if ($order->note) { ?>
        <div class="sc-node" style="padding-bottom: 20px;">
            <?php echo $form->label($order, 'note', array('class' => 'control-label')); ?>
            <div class="sc-note">
                <?php echo $form->textArea($order, 'note', array('class' => 'form-control', 'style' => 'width: 100%;')); ?>
                <?php echo $form->error($order, 'note'); ?>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-xs-12">
            <?php echo CHtml::submitButton(Yii::t('shoppingcart', 'confirm_button'), array('class' => 'btn btn-sm btn-primary pull-right', 'id' => 'submitcheckout','onclick' => 'validorder(event);')); ?>
            <?php echo CHtml::Button(Yii::t('shoppingcart', 'back_button'), array('class' => 'btn btn-sm btn-primary pull-right', 'onclick' => 'history.go(-1);', 'style'=>'margin-right: 20px;')); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $themUrl = Yii::app()->theme->baseUrl; ?>
<link href='<?php echo $themUrl ?>/css/jquery.alert.css' rel='stylesheet' type='text/css' />
<script type="text/javascript" src="<?= $themUrl ?>/js/jquery.alert.js"></script> 
<script>    
    var payment = {is_payment_online:<?php echo (int)SitePayment::model()->checkPaymentOnline();?>,payment_method_online:<?php echo Orders::PAYMENT_METHOD_ONLINE;?>,method:0,method_child:0};
    jQuery(document).ready(function() {
        $("#popup_ok").click(function(){
                $("#popup_container").css("display","none");
        });
        jQuery('#billtoship').on('click', function() {
            if (jQuery(this).prop("checked"))
                jQuery('#shipping').addClass('hidden');
            else
                jQuery('#shipping').removeClass('hidden');
        });
        //payment online
        if(payment.is_payment_online){
            jQuery('.pm_parent > label > input[type=radio]').on('click',function(){
                payment.method = jQuery(this).val();               
                if(payment.method==payment.payment_method_online){                
                    jQuery('#submitcheckout').val('Thanh toán');                
                }else{
                    jQuery('#submitcheckout').val('Xác nhận và gửi đơn hàng');
                    payment.method_child = 0;
                }
                jQuery('.pm_list_children.active').removeClass('active').slideUp('fast');            
                jQuery(this).parents('.pm_parent').children('.pm_list_children').addClass('active').slideDown('fast'); 
            });
            jQuery('#sc-checkout-form').on('submit',function(){
                if(payment.method==payment.payment_method_online && payment.method_child == 0){
                    alert("Bạn chưa chọn Ngân hàng bạn muốn sử dụng thanh toán");
                    return false;
                }
            });
        }
    });    
    function validorder(event) {
        
        var checkBox = document.getElementById("agree");
         if (checkBox.checked == false){
             $("#popup_container").css("display","block");
            
         }
         else{
            return true;
         }
        event.preventDefault();
       
       
        // if (agree.checked == false) {
        //     error_flg = true;
        //     error_message.push("Bạn Cần Đồng Ý Các Điều Khoản Thanh Toán");
             
        // }
        // if (error_flg == false) {
        //     document.forms['sc-checkout-form'].submit();
        //     return true;
        // } else {
        //     var error_str = error_message.join("\n");
        //     jAlert(error_str, "21 Six");
        // }
       
       
    }
</script>

<div id="popup_container" class="ui-draggable" style="position: fixed; z-index: 99999; padding: 0px; margin: 0px; min-width: 348px; max-width: 348px; top: 149px; left: 617.5px; display: none"><h1 id="popup_title" class="ui-draggable-handle" style="cursor: move;">XE BẢO NAM</h1><div id="popup_content" class="alert"><div id="popup_message">Bạn Cần Đồng Ý Các Điều Khoản Thanh Toán</div><div id="popup_panel"><input type="button" value="&nbsp;OK&nbsp;" id="popup_ok"></div></div></div>