<div class="otp-wrap">
    <div class="row">
        <label for="otp" class="required"><em>*</em>Mã xác thực OTP</label><br>
        <input size="60" maxlength="50" class="input-text1" name="otp" id="e_s_otp" type="text"/>                            
    </div>
    <div id="submit_opt" style="float:left;margin-left: -20px;">
        <input type="button" onclick="confirmOTP();" value="Xác thực OTP"/>
    </div>
    <div id="submit_opt_latter" style="float:left;margin-left:20px;">
        <input type="button" onclick="confirmOTPLatter();" value="Xác thực sau"/>
    </div>
</div>
<script type="text/javascript">
    function confirmOTP(){
        <?php
            echo CHtml::ajax(array(
                'url' => '',
                'data' => "js:$('#checkout-form').serialize()",
                'type' => 'post',
                'dataType'=>'json',
                'success' => "function(data)
                {
                    if(data.error==0){
                        window.location='';
                    }else if(data.error==1){                        
                        window.location='';
                    }else if(data.error==2){
                        
                    }
                }",
            ));
        ?>;
        return false; 
    }
    function confirmOTPLatter(){
        window.location='';
    }
</script>