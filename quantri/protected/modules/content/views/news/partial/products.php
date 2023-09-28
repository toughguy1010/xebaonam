<?php if ($model->isNewRecord) { ?>
    <a id="addProduct" href="javascript:void(0);" class="btn btn-sm btn-light"
       onclick="alert('<?php echo Yii::t('product', 'product_group_addproduct_disable_help'); ?>');">
        <?php echo Yii::t('product', 'product_group_addproduct'); ?>
    </a>
<?php } else { ?>
    <a id="login" onClick="login()" href="javascript:void(0)" class="btn btn-primary btn-sm">
        Chọn tệp
    </a>
    <div class="loading-shoppingcart" style="background: #c55ee7;
    height: 40px;
    width: 200px;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    text-align: center;
    margin: auto;
    font-weight: bold;">
        <span>Vui lòng chờ</span>
    </div>
<?php } ?>

<script type="text/javascript">
    function modal() {
        var modal = document.getElementById('myModal');

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        //btn.onclick = function() {
        modal.style.display = "block";
        //}

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if ( event.target == login || event.target == modal) {
                modal.style.display = "none";
            }
        }

    }

    function login() {
        var login = document.getElementById('myLogin');
        // Get the button that opens the modal
        var btn = document.getElementById("login");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[2];

        // When the user clicks the button, open the modal

        login.style.display = "block";


        // When the user clicks on <span> (x), close the modal

        $("span.close").click(function () {
            $('#myLogin').hide();
        });

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == login || event.target == modal) {
                login.style.display = "none";

            }
        }
    }

    function parseJsonErrors($_errors, specialobject) {
        var errors = $.parseJSON($_errors);
        if (specialobject) {
            specialobject.find('.errorMessage').hide();
            $.each(errors, function (key, val) {
                specialobject.find("#" + key + "_em_").text(val);
                specialobject.find("#" + key + "_em_").show();
            });
        } else {
            jQuery('.errorMessage').hide();
            $.each(errors, function (key, val) {
                jQuery("#" + key + "_em_").text(val);
                jQuery("#" + key + "_em_").show();
            });
        }
    }

    jQuery(document).ready(function () {
        jQuery('#btn-create').on('click', function () {
            var _this = jQuery(this);
            if (_this.hasClass('disable'))
                return false;
            _this.addClass('disable');
            var link = _this.attr('validate');
            if (link) {
                jQuery.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: link,
                    data: jQuery('#form-create-file').serialize(),
                    success: function (res) {
                        if (res.code == 200) {
                            location.reload();
                        } else {
                            if (res.errors) {
                                parseJsonErrors(res.errors, jQuery('#form-create-file'));
                            }
                        }
                        _this.removeClass('disable');
                    },
                    error: function () {
                        _this.removeClass('disable');
                        return false;
                    }
                });
            }
            return false;
        });
    });
</script>

<style>
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 99999999999999999; /* Sit on top */
        padding-top: 40px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0, 0, 0); /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        position: relative;
        background-color: #fefefe;
        margin: auto;
        border: 1px solid #888;
        width: 774px;
        animation-name: animatetop;
        animation-duration: 0.4s
    }

    /* The Close Button */
    .close {
        color: #fff;
        float: right;
        font-size: 16px;
        font-weight: bold;
        opacity: 1;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    @keyframes animatetop {
        from {
            top: -300px;
            opacity: 0
        }
        to {
            top: 0;
            opacity: 1
        }
    }

    .title-modal {
        background: #428bca;
        padding: 15px 20px 35px 20px;
        font-size: 16px;
        color: #fff;
    }

    .title-modal span:first-child {
        float: left;

    }

    .form-modal form {
        padding: 20px 15px 0px 15px;
    }

    .form-modal form p {
        margin-bottom: 3px;
        margin-top: 0px;
    }

    .form-modal form input {
        font-family: 'Roboto', sans-serif;
        width: 100%;
        padding: 15px;
        border: 1px solid #cacaca;
        border-radius: 3px;
        font-size: 12px;
    }

    .form-modal form select {
        font-family: 'Roboto', sans-serif;
        width: 100%;
        padding: 15px;
        border: 1px solid #cacaca;
        border-radius: 3px;
        font-size: 12px;
    }

    .form-modal form .name-ct, .form-modal form .address, .form-modal form .names, .form-modal form .phone, .form-modal form .email, .form-modal form .dv {
        width: 50%;
        padding: 10px 15px;
        float: left;
    }

    .form-modal form .note {
        width: 100%;
        padding: 10px 15px;
        float: left;
    }

    .form-modal form textarea {
        width: 100%;
        padding: 10px 15px;
    }

    .sm {
        padding: 10px 15px 40px 15px;
        float: left;
    }

    .form-modal form input[type="submit"] {

        border: none;
        outline: none;
        background: #428bca;
        padding: 15px;
        color: white;

        border-radius: 3px;
    }

    .form-modal form select {
        padding: 18px;
    }

    .form-modal form b {
        color: red;
    }

    .form-modal input[type="text"]::-webkit-input-placeholder, .form-modal input[type="email"]::-webkit-input-placeholder, .form-modal textarea::-webkit-input-placeholder, .form-modal input[type="password"]::-webkit-input-placeholder {
        color: #cacaca;
        font-family: 'Roboto', sans-serif;
        font-size: 12px;
    }

    .form-modal select {
        color: black;
        font-family: 'Roboto', sans-serif;
        font-weight: 300;
    }

    #mydathang .sm-login {
        width: 120px;
    }

    @media (max-width: 792px) {
        .modal-content {
            width: 500px;
        }
    }

    @media (max-width: 575px) {
        .modal-content {
            width: 100%;
        }

        .form-modal form .name-ct, .form-modal form .address, .form-modal form .names, .form-modal form .phone, .form-modal form .email, .form-modal form .dv {
            width: 100%;
        }
    }
    .nav-tabs>li.active>a {
        z-index: 0;
    }
    #login {
        cursor: pointer;
    }

    #myLogin {
        display: none;
        padding-top: 100px;

    }

    #myLogin .modal-content {
        max-width: 95%;
        width: 400px;
    }

    .name-dn, .email-dn, .sm-login {
        padding: 0px 15px;
        /*margin: 20px 0px;*/
    }

    .link-quen {
        margin: 0;
        padding: 0px 15px;
    }

    #myLogin .form-modal .sm-dk input[type="submit"] {
        width: 100%;
        cursor: pointer;
    }

    #myLogin .form-modal form {
        padding: 15px 15px 40px 15px;
        font-size: 12px;
    }

    #myLogin .form-modal p {
        font-size: 14px;
    }

    #myLogin .link-quen a {
        color: #0cc134;
    }

    #dk {
        cursor: pointer;
    }

    #mydk {
        display: none;
        padding-top: 30px;

    }

    #mydk .modal-content {
        max-width: 95%;
        width: 400px;

    }

    #mydk .name-dk, .email-dk, .matkhau-dk, .matkhau-dk, .sm-dk, .link-login {
        padding: 0px 15px;
        margin: 20px 0px;
    }

    .link-login {
        margin: 20px 0px 0px 0px;
        padding: 0px 15px;
    }

    #mydk .form-modal .sm-dk input[type="submit"] {
        width: 100%;
        cursor: pointer;
    }

    #mydk .form-modal form {
        padding: 15px 15px 30px 15px;
        font-size: 12px;
    }

    #mydk .form-modal p {
        font-size: 14px;
    }

    #mydk .link-login a {
        color: #0cc134;
    }

    @media (max-width: 575px) {
        .name-dh, .phone-dh, .email-dh, .sp-dh, .qc-sp, .sm-login {
            width: 100%;
        }
    }

    label {
        display: inline-block;
        margin-bottom: .5rem;
        font-size: 14px;
    }

    .sm-dk #btn-register, .sm-login #btn-login {
        color: #fff;
        background: #428bca;
        font-size: 13px;
        border: none;
        padding: 7px 15px;
    }
    .name-dn {
        margin-bottom: 0;
    }
</style>
