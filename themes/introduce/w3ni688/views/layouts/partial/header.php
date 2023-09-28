<?php
$site_info = Yii::app()->siteinfo;
?>

<header class="header_v2">
    <div class="container">
        <div class="logo">
            <a href="<?= Yii::app()->homeUrl; ?>" title="<?= $site_info['site_title'] ?>">
                <img src="<?= $site_info['site_logo'] ?>" atl="<?= $site_info['site_title'] ?>">
            </a>
        </div>
        <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_MENU_MAIN_MOBILE)); ?>

        <div class="right_header_v2">
            <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_SEARCH_BOX_MOBILE)); ?>
            <div class="hotline_header_v2">
                <ul>
                    <h3 class="h3_hotline">
                        <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_HEADER_LEFT)); ?>
                    </h3>
                    <div class="clr"></div>
                </ul>

                <div class="clr"></div>
            </div>
            <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_HEADER_RIGHT)); ?>
            <div class="clr"></div>
        </div>
        <div class="clr"></div>
    </div>
    <div class="clr"></div>
</header>
<style>
    .header_v2 {
        background: #ed2024;
        padding: 10px 0;
        height: auto;
        margin-bottom: 15px;
    }

    .header_v2 .container {
        position: relative;
        max-inline-size: 1230px;
    }

    .header_v2 .logo {
        float: left;
        padding-top: 15px;
    }

    .header_v2 .logo img {
        width: auto;
        /* height: 70px; */
        margin-top: 15px;
        margin: 0;
        max-width: 312px;
    }

    .header_v2 .menu_top {
        position: absolute;
        top: 0;
        right: 0;
    }

    .header_v2 .menu_top > a {
        color: #fff;
        font-size: 15px;
        display: none;
    }

    .header_v2 .cur {
        cursor: pointer;
    }

    .header_v2 .menu_top > a i {
        margin-right: 4px;
    }

    .header_v2 .menu_top > ul {
        display: inline-block;
        float: left;
        line-height: 30px;
    }

    .header_v2 .menu_top ul li {
        list-style: none;
        padding-left: 14px;
        float: left;
    }

    .header_v2 .menu_top ul li a {
        color: #fff;
        font-size: 15px;
        text-transform: capitalize;
        transition: color .33s cubic-bezier(.33, 0, .2, 1) 0s, fill .33s cubic-bezier(.33, 0, .2, 1) 0s, background .33s cubic-bezier(.33, 0, .2, 1) 0s;
        -moz-transition: color .33s cubic-bezier(.33, 0, .2, 1) 0s, fill .33s cubic-bezier(.33, 0, .2, 1) 0s, background .33s cubic-bezier(.33, 0, .2, 1) 0s;
    }

    .header_v2 .menu_top ul li a:hover {
        color: #ff0;
    }

    .header_v2 .menu_top ul li img {
        height: 14px;
        float: left;
        margin-right: 5px;
        position: relative;
        top: 8px;
        max-width: 20px;
        margin-top: 0;
        margin-bottom: 0;
    }

    .header_v2 .menu_top > li i {
        margin-right: 2px;
    }

    .header_v2 .menu_top > li a {
        font-size: 14px;
        font-weight: 500;
        color: #fff;
    }

    .header_v2 .menu_top > li {
        display: inline-block;
        list-style: none;
        margin-left: 10px;
        color: #fff;
        line-height: 30px;
    }

    .header_v2 .clr {
        clear: both;
    }

    .header_v2 .right_header_v2 {
        position: relative;
        float: right;
        top: auto;
        margin-top: 40px;
        right: 0;
    }

    .header_v2 .timkiem_top {
        float: left;
        margin-right: 20px;
        background: #f5a623;
        border-radius: 4px;
    }

    .header_v2 .timkiem_top.no_box {
        margin: 15px 35px 0 0;
    }

    .header_v2 .search a {
        width: 55px;
        height: 45px;
        text-indent: -10000px;
        background: url(https://thegioixedien.com.vn/images/icon-search.png) no-repeat center center;
        float: right;
        border-left: 0px;
        transition: all 0.3s ease-in-out;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        border-radius: 0 4px 4px 0;
    }

    .header_v2 .search a {
        width: 50px;
        height: 38px;
    }

    .header_v2 .input_search {
        padding: 0px 15px;
        line-height: 38px;
        font-size: 15px;
        width: 310px;
        float: right;
        color: #666;
        border: none;
        background: #ffffff;
        border-radius: 4px;
        outline: none;
        font-family: "Helvetica", "Roboto", "Roboto Condensed", "sans-serif", "Arial" !important;
    }

    .header_v2 .input_search {
    }

    .header_v2 .hotline_header_v2 {
        float: left;
    }

    .header_v2 .hotline_header_v2 ul {
        float: left;
        padding-right: 20px;
        color: #fff;
        margin-right: 20px;
        border-right: dashed #FFF 1px;
    }

    .header_v2 .hotline_header_v2 ul {
        margin-left: 30px;
        margin-right: 30px;
        padding-right: 30px;
    }

    .header_v2 .hotline_header_v2 ul h3 {
        color: #fff;
        float: left;
        font-weight: normal;
        font-size: 20px;
        text-transform: uppercase;
        line-height: 25px;
        font-family: 'Open Sans Condensed', Arial, Helvetica, Tahoma, sans-serif;
        margin: 0;
    }

    .header_v2 .hotline_header_v2 ul h3 span {
        display: block;
        color: #fff;
        font-weight: normal;
        line-height: 20px;
        font-size: 14px;
        letter-spacing: 0.7px;
        font-family: 'Roboto Condensed', Arial, Helvetica, Tahoma, sans-serif;
        text-transform: capitalize;
    }

    .header_v2 .hotline_header_v2 ul h3 span u {
        text-decoration: none;
    }

    .header_v2 .hotline_header_v2 ul h3 span {
        display: block;
        padding: 2px 0;
        font-weight: 600;
        color: #f5a623;
    }

    .header_v2 .hotline_header_v2 ul h3 span i {
        margin-right: 4px;
    }

    .header_v2 .hotline_header_v2 ul h3 a {
        color: #fff;
    }

    .header_v2 .hotline_header_v2 ul h3 span a {
        color: #fff;
        font-weight: 600;
    }

    .header_v2 .giohang_top {
        float: left;
        position: relative;
        text-align: center;
    }

    .header_v2 .giohang_top {
        margin-top: 8px;
    }

    .header_v2 .giohang_top i {
        font-size: 23px;
        color: #fff;
    }

    .header_v2 .giohang_top h3 {
        font-size: 14px;
        color: #fff;
        font-weight: normal;
        text-transform: capitalize;
        line-height: 22px;
    }

    .header_v2 .giohang_top h3 span {
        font-size: 14px;
        color: #fff;
        background: #f5a623;
        height: 20px;
        width: 20px;
        padding: 4px;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
        position: absolute;
        top: -7px;
        right: -2px;
        line-height: 12px;
        transition: color .33s cubic-bezier(.33, 0, .2, 1) 0s, fill .33s cubic-bezier(.33, 0, .2, 1) 0s, background .33s cubic-bezier(.33, 0, .2, 1) 0s;
        -moz-transition: color .33s cubic-bezier(.33, 0, .2, 1) 0s, fill .33s cubic-bezier(.33, 0, .2, 1) 0s, background .33s cubic-bezier(.33, 0, .2, 1) 0s;
    }

    @media only screen and (max-width: 991px) {
        .header_v2 {
            padding: 10px 0;
            height: auto;
            padding-bottom: 0;
        }

        .header_v2 .logo {
            padding-top: 0px;
            position: relative;
            width: 100%;
            text-align: center;
            height: 65px;
            float: left;
        }

        .header_v2 .logo img {
            height: 50px;
            width: auto;
            max-width: 100%;
        }

        .header_v2 .menu_top {
            position: absolute;
            right: 10px;
            top: -5px;
            float: right;
        }

        .header_v2 .menu_top > a {
            display: inline-block;
        }

        .header_v2 ul.ul_js_to {
            right: 85px;
            border-radius: 5px;
            padding: 10px 5px;
            box-shadow: 3px 3px 7px #6d6d6d;
            width: 200px;
            position: absolute;
            z-index: 99999;
            display: none;
            float: left;
            background: #fff;
        }

        .header_v2 ul.ul_js_to li {
            width: 100%;
        }

        .header_v2 .menu_top ul.ul_js_to a {
            color: #333;
        }

        .header_v2 ul.ul_js_to a:hover {
            color: #d0011b;
        }

        .header_v2 ul.ul_js_to img {
            display: none;
        }

        .header_v2 .right_header_v2 {
            width: calc(100% - 0px);
            position: relative;
            margin-top: 0;
            right: 0;
            top: 0;
            float: right;
        }

        .header_v2 .timkiem_top.no_box {
            position: relative;
            top: auto;
            bottom: 0;
            right: 0px;
            width: 100%;
            max-width: 100%;
            float: right;
            margin-right: 0;
            background: none;
            margin: 3px 0;
        }

        .header_v2 .timkiem_top.no_box .search {
            margin-bottom: 0;
            max-width: 85%;
            margin: 0 auto;
            margin-top: 10px;
            background: #333;
            border-radius: 5px;
            position: relative;
            width: 100%;
        }

        .header_v2 .search a {
            height: 38px;
            width: 45px;
            position: absolute;
            right: -2px;
            z-index: 9999;
            background-color: #d0011b;
        }

        .header_v2 .hotline_header_v2 {
            margin: 10px 0 10px;
            margin-bottom: 40px;
            float: right;
        }

        .header_v2 .hotline_header_v2 ul {
            margin-right: 0;
            margin-left: 0;
            text-align: center;
            float: left;
            padding-right: 0;
            color: #fff;
            border-right: none;
        }

        .header_v2 .hotline_header_v2 ul h3 {
            text-transform: none;
            font-size: 15px;
            line-height: 22px;
            display: flex;
        }

        .header_v2 .hotline_header_v2 ul h3 span {
            display: inline-block !important;
            margin-left: 10px;
        }

        .header_v2 .hotline_header_v2 ul h3 u {
            display: none;
        }

        .header_v2 .giohang_top {
            right: 10px;
            float: left;
            position: absolute;
            margin: 0;
            bottom: 2px;
            line-height: 18px;
        }

        .header_v2 .giohang_top i {
            font-size: 20px;
            top: 1px;
            position: relative;
            display: inline-block;
            margin-right: 6px;
        }

        .header_v2 .giohang_top h3 {
            font-weight: 600;
            font-size: 13px;
            display: inline-block;
        }

        .header_v2 .giohang_top h3 span {
            right: -6px;
            top: 8px;
            padding: 3px 0px;
            text-align: center;
            font-size: 13px;
            height: 18px;
            line-height: 12px;
            width: 18px;
        }

        .header_v2 .input_search {
            width: 100%;
        }

        .header_v2 .container {
            padding-right: 10px;
            padding-left: 10px;
        }
    }

</style>
