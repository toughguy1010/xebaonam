<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:output method="html" version="5.0" encoding="utf-8" indent="yes"/>

  <xsl:template match="/">
    <xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html></xsl:text>
    <html lang="en">
      <head>
        <meta charset="utf-8"></meta>
        <title>sitemap-stylesheet</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"></meta>
        <meta name="description" content="a google sitemap that was converted to HTML"></meta>
        <meta name="author" content="http://github.com/automatonic"></meta>
        <style type="text/css">
/*!
 * Bootstrap v2.1.1
 *
 * Copyright 2012 Twitter, Inc
 * Licensed under the Apache License v2.0
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Designed and built with all the love in the world @twitter by @mdo and @fat.
 */
.clearfix{*zoom:1;}.clearfix:before,.clearfix:after{display:table;content:"";line-height:0;}
.clearfix:after{clear:both;}
.hide-text{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0;}
.input-block-level{display:block;width:100%;min-height:30px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
article,aside,details,figcaption,figure,footer,header,hgroup,nav,section{display:block;}
audio,canvas,video{display:inline-block;*display:inline;*zoom:1;}
audio:not([controls]){display:none;}
html{font-size:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;}
a:focus{outline:thin dotted #333;outline:5px auto -webkit-focus-ring-color;outline-offset:-2px;}
a:hover,a:active{outline:0;}
sub,sup{position:relative;font-size:75%;line-height:0;vertical-align:baseline;}
sup{top:-0.5em;}
sub{bottom:-0.25em;}
img{max-width:100%;width:auto\9;height:auto;vertical-align:middle;border:0;-ms-interpolation-mode:bicubic;}
#map_canvas img{max-width:none;}
button,input,select,textarea{margin:0;font-size:100%;vertical-align:middle;}
button,input{*overflow:visible;line-height:normal;}
button::-moz-focus-inner,input::-moz-focus-inner{padding:0;border:0;}
button,input[type="button"],input[type="reset"],input[type="submit"]{cursor:pointer;-webkit-appearance:button;}
input[type="search"]{-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;-webkit-appearance:textfield;}
input[type="search"]::-webkit-search-decoration,input[type="search"]::-webkit-search-cancel-button{-webkit-appearance:none;}
textarea{overflow:auto;vertical-align:top;}
body{margin:0;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:20px;color:#333333;background-color:#ffffff;}
a{color:#0088cc;text-decoration:none;}
a:hover{color:#005580;text-decoration:underline;}
.img-rounded{-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;}
.img-polaroid{padding:4px;background-color:#fff;border:1px solid #ccc;border:1px solid rgba(0, 0, 0, 0.2);-webkit-box-shadow:0 1px 3px rgba(0, 0, 0, 0.1);-moz-box-shadow:0 1px 3px rgba(0, 0, 0, 0.1);box-shadow:0 1px 3px rgba(0, 0, 0, 0.1);}
.img-circle{-webkit-border-radius:500px;-moz-border-radius:500px;border-radius:500px;}
.container{margin-right:auto;margin-left:auto;*zoom:1;}.container:before,.container:after{display:table;content:"";line-height:0;}
.container:after{clear:both;}
.container-fluid{padding-right:20px;padding-left:20px;*zoom:1;}.container-fluid:before,.container-fluid:after{display:table;content:"";line-height:0;}
.container-fluid:after{clear:both;}
p{margin:0 0 10px;}
.lead{margin-bottom:20px;font-size:21px;font-weight:200;line-height:30px;}
small{font-size:85%;}
strong{font-weight:bold;}
em{font-style:italic;}
cite{font-style:normal;}
.muted{color:#999999;}
.text-warning{color:#c09853;}
.text-error{color:#b94a48;}
.text-info{color:#3a87ad;}
.text-success{color:#468847;}
h1,h2,h3,h4,h5,h6{margin:10px 0;font-family:inherit;font-weight:bold;line-height:1;color:inherit;text-rendering:optimizelegibility;}h1 small,h2 small,h3 small,h4 small,h5 small,h6 small{font-weight:normal;line-height:1;color:#999999;}
h1{font-size:36px;line-height:40px;}
h2{font-size:30px;line-height:40px;}
h3{font-size:24px;line-height:40px;}
h4{font-size:18px;line-height:20px;}
h5{font-size:14px;line-height:20px;}
h6{font-size:12px;line-height:20px;}
h1 small{font-size:24px;}
h2 small{font-size:18px;}
h3 small{font-size:14px;}
h4 small{font-size:14px;}
.page-header{padding-bottom:9px;margin:20px 0 30px;border-bottom:1px solid #eeeeee;}
ul,ol{padding:0;margin:0 0 10px 25px;}
ul ul,ul ol,ol ol,ol ul{margin-bottom:0;}
li{line-height:20px;}
ul.unstyled,ol.unstyled{margin-left:0;list-style:none;}
dl{margin-bottom:20px;}
dt,dd{line-height:20px;}
dt{font-weight:bold;}
dd{margin-left:10px;}
.dl-horizontal{*zoom:1;}.dl-horizontal:before,.dl-horizontal:after{display:table;content:"";line-height:0;}
.dl-horizontal:after{clear:both;}
.dl-horizontal dt{float:left;width:160px;clear:left;text-align:right;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
.dl-horizontal dd{margin-left:180px;}
hr{margin:20px 0;border:0;border-top:1px solid #eeeeee;border-bottom:1px solid #ffffff;}
abbr[title]{cursor:help;border-bottom:1px dotted #999999;}
abbr.initialism{font-size:90%;text-transform:uppercase;}
blockquote{padding:0 0 0 15px;margin:0 0 20px;border-left:5px solid #eeeeee;}blockquote p{margin-bottom:0;font-size:16px;font-weight:300;line-height:25px;}
blockquote small{display:block;line-height:20px;color:#999999;}blockquote small:before{content:'\2014 \00A0';}
blockquote.pull-right{float:right;padding-right:15px;padding-left:0;border-right:5px solid #eeeeee;border-left:0;}blockquote.pull-right p,blockquote.pull-right small{text-align:right;}
blockquote.pull-right small:before{content:'';}
blockquote.pull-right small:after{content:'\00A0 \2014';}
q:before,q:after,blockquote:before,blockquote:after{content:"";}
address{display:block;margin-bottom:20px;font-style:normal;line-height:20px;}
table{max-width:100%;background-color:transparent;border-collapse:collapse;border-spacing:0;}
.table{width:100%;margin-bottom:20px;}.table th,.table td{padding:8px;line-height:20px;text-align:left;vertical-align:top;border-top:1px solid #dddddd;}
.table th{font-weight:bold;}
.table thead th{vertical-align:bottom;}
.table caption+thead tr:first-child th,.table caption+thead tr:first-child td,.table colgroup+thead tr:first-child th,.table colgroup+thead tr:first-child td,.table thead:first-child tr:first-child th,.table thead:first-child tr:first-child td{border-top:0;}
.table tbody+tbody{border-top:2px solid #dddddd;}
.table-condensed th,.table-condensed td{padding:4px 5px;}
.table-bordered{border:1px solid #dddddd;border-collapse:separate;*border-collapse:collapse;border-left:0;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}.table-bordered th,.table-bordered td{border-left:1px solid #dddddd;}
.table-bordered caption+thead tr:first-child th,.table-bordered caption+tbody tr:first-child th,.table-bordered caption+tbody tr:first-child td,.table-bordered colgroup+thead tr:first-child th,.table-bordered colgroup+tbody tr:first-child th,.table-bordered colgroup+tbody tr:first-child td,.table-bordered thead:first-child tr:first-child th,.table-bordered tbody:first-child tr:first-child th,.table-bordered tbody:first-child tr:first-child td{border-top:0;}
.table-bordered thead:first-child tr:first-child th:first-child,.table-bordered tbody:first-child tr:first-child td:first-child{-webkit-border-top-left-radius:4px;border-top-left-radius:4px;-moz-border-radius-topleft:4px;}
.table-bordered thead:first-child tr:first-child th:last-child,.table-bordered tbody:first-child tr:first-child td:last-child{-webkit-border-top-right-radius:4px;border-top-right-radius:4px;-moz-border-radius-topright:4px;}
.table-bordered thead:last-child tr:last-child th:first-child,.table-bordered tbody:last-child tr:last-child td:first-child,.table-bordered tfoot:last-child tr:last-child td:first-child{-webkit-border-radius:0 0 0 4px;-moz-border-radius:0 0 0 4px;border-radius:0 0 0 4px;-webkit-border-bottom-left-radius:4px;border-bottom-left-radius:4px;-moz-border-radius-bottomleft:4px;}
.table-bordered thead:last-child tr:last-child th:last-child,.table-bordered tbody:last-child tr:last-child td:last-child,.table-bordered tfoot:last-child tr:last-child td:last-child{-webkit-border-bottom-right-radius:4px;border-bottom-right-radius:4px;-moz-border-radius-bottomright:4px;}
.table-bordered caption+thead tr:first-child th:first-child,.table-bordered caption+tbody tr:first-child td:first-child,.table-bordered colgroup+thead tr:first-child th:first-child,.table-bordered colgroup+tbody tr:first-child td:first-child{-webkit-border-top-left-radius:4px;border-top-left-radius:4px;-moz-border-radius-topleft:4px;}
.table-bordered caption+thead tr:first-child th:last-child,.table-bordered caption+tbody tr:first-child td:last-child,.table-bordered colgroup+thead tr:first-child th:last-child,.table-bordered colgroup+tbody tr:first-child td:last-child{-webkit-border-top-right-radius:4px;border-top-right-radius:4px;-moz-border-radius-topleft:4px;}
.table-striped tbody tr:nth-child(odd) td,.table-striped tbody tr:nth-child(odd) th{background-color:#f9f9f9;}
.table-hover tbody tr:hover td,.table-hover tbody tr:hover th{background-color:#f5f5f5;}
table [class*=span],.row-fluid table [class*=span]{display:table-cell;float:none;margin-left:0;}
.table .span1{float:none;width:44px;margin-left:0;}
.table .span2{float:none;width:124px;margin-left:0;}
.table .span3{float:none;width:204px;margin-left:0;}
.table .span4{float:none;width:284px;margin-left:0;}
.table .span5{float:none;width:364px;margin-left:0;}
.table .span6{float:none;width:444px;margin-left:0;}
.table .span7{float:none;width:524px;margin-left:0;}
.table .span8{float:none;width:604px;margin-left:0;}
.table .span9{float:none;width:684px;margin-left:0;}
.table .span10{float:none;width:764px;margin-left:0;}
.table .span11{float:none;width:844px;margin-left:0;}
.table .span12{float:none;width:924px;margin-left:0;}
.table .span13{float:none;width:1004px;margin-left:0;}
.table .span14{float:none;width:1084px;margin-left:0;}
.table .span15{float:none;width:1164px;margin-left:0;}
.table .span16{float:none;width:1244px;margin-left:0;}
.table .span17{float:none;width:1324px;margin-left:0;}
.table .span18{float:none;width:1404px;margin-left:0;}
.table .span19{float:none;width:1484px;margin-left:0;}
.table .span20{float:none;width:1564px;margin-left:0;}
.table .span21{float:none;width:1644px;margin-left:0;}
.table .span22{float:none;width:1724px;margin-left:0;}
.table .span23{float:none;width:1804px;margin-left:0;}
.table .span24{float:none;width:1884px;margin-left:0;}
.table tbody tr.success td{background-color:#dff0d8;}
.table tbody tr.error td{background-color:#f2dede;}
.table tbody tr.warning td{background-color:#fcf8e3;}
.table tbody tr.info td{background-color:#d9edf7;}
.table-hover tbody tr.success:hover td{background-color:#d0e9c6;}
.table-hover tbody tr.error:hover td{background-color:#ebcccc;}
.table-hover tbody tr.warning:hover td{background-color:#faf2cc;}
.table-hover tbody tr.info:hover td{background-color:#c4e3f3;}
.hero-unit{padding:60px;margin-bottom:30px;background-color:#eeeeee;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;}.hero-unit h1{margin-bottom:0;font-size:60px;line-height:1;color:inherit;letter-spacing:-1px;}
.hero-unit p{font-size:18px;font-weight:200;line-height:30px;color:inherit;}
.hidden{display:none;visibility:hidden;}
.visible-phone{display:none !important;}
.visible-tablet{display:none !important;}
.hidden-desktop{display:none !important;}
.visible-desktop{display:inherit !important;}
@media (min-width:768px) and (max-width:979px){.hidden-desktop{display:inherit !important;} .visible-desktop{display:none !important ;} .visible-tablet{display:inherit !important;} .hidden-tablet{display:none !important;}}@media (max-width:767px){.hidden-desktop{display:inherit !important;} .visible-desktop{display:none !important;} .visible-phone{display:inherit !important;} .hidden-phone{display:none !important;}}@media (max-width:767px){body{padding-left:20px;padding-right:20px;} .navbar-fixed-top,.navbar-fixed-bottom,.navbar-static-top{margin-left:-20px;margin-right:-20px;} .container-fluid{padding:0;} .dl-horizontal dt{float:none;clear:none;width:auto;text-align:left;} .dl-horizontal dd{margin-left:0;} .container{width:auto;} .row-fluid{width:100%;} .row,.thumbnails{margin-left:0;} .thumbnails>li{float:none;margin-left:0;} [class*="span"],.row-fluid [class*="span"]{float:none;display:block;width:100%;margin-left:0;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;} .span12,.row-fluid .span12{width:100%;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;} .input-large,.input-xlarge,.input-xxlarge,input[class*="span"],select[class*="span"],textarea[class*="span"],.uneditable-input{display:block;width:100%;min-height:30px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;} .input-prepend input,.input-append input,.input-prepend input[class*="span"],.input-append input[class*="span"]{display:inline-block;width:auto;} .controls-row [class*="span"]+[class*="span"]{margin-left:0;} .modal{position:fixed;top:20px;left:20px;right:20px;width:auto;margin:0;}.modal.fade.in{top:auto;}}@media (max-width:480px){.nav-collapse{-webkit-transform:translate3d(0, 0, 0);} .page-header h1 small{display:block;line-height:20px;} input[type="checkbox"],input[type="radio"]{border:1px solid #ccc;} .form-horizontal .control-label{float:none;width:auto;padding-top:0;text-align:left;} .form-horizontal .controls{margin-left:0;} .form-horizontal .control-list{padding-top:0;} .form-horizontal .form-actions{padding-left:10px;padding-right:10px;} .modal{top:10px;left:10px;right:10px;} .modal-header .close{padding:10px;margin:-10px;} .carousel-caption{position:static;}}@media (min-width:768px) and (max-width:979px){.row{margin-left:-20px;*zoom:1;}.row:before,.row:after{display:table;content:"";line-height:0;} .row:after{clear:both;} [class*="span"]{float:left;min-height:1px;margin-left:20px;} .container,.navbar-static-top .container,.navbar-fixed-top .container,.navbar-fixed-bottom .container{width:724px;} .span12{width:724px;} .span11{width:662px;} .span10{width:600px;} .span9{width:538px;} .span8{width:476px;} .span7{width:414px;} .span6{width:352px;} .span5{width:290px;} .span4{width:228px;} .span3{width:166px;} .span2{width:104px;} .span1{width:42px;} .offset12{margin-left:764px;} .offset11{margin-left:702px;} .offset10{margin-left:640px;} .offset9{margin-left:578px;} .offset8{margin-left:516px;} .offset7{margin-left:454px;} .offset6{margin-left:392px;} .offset5{margin-left:330px;} .offset4{margin-left:268px;} .offset3{margin-left:206px;} .offset2{margin-left:144px;} .offset1{margin-left:82px;} .row-fluid{width:100%;*zoom:1;}.row-fluid:before,.row-fluid:after{display:table;content:"";line-height:0;} .row-fluid:after{clear:both;} .row-fluid [class*="span"]{display:block;width:100%;min-height:30px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;float:left;margin-left:2.7624309392265194%;*margin-left:2.709239449864817%;} .row-fluid [class*="span"]:first-child{margin-left:0;} .row-fluid .span12{width:100%;*width:99.94680851063829%;} .row-fluid .span11{width:91.43646408839778%;*width:91.38327259903608%;} .row-fluid .span10{width:82.87292817679558%;*width:82.81973668743387%;} .row-fluid .span9{width:74.30939226519337%;*width:74.25620077583166%;} .row-fluid .span8{width:65.74585635359117%;*width:65.69266486422946%;} .row-fluid .span7{width:57.18232044198895%;*width:57.12912895262725%;} .row-fluid .span6{width:48.61878453038674%;*width:48.56559304102504%;} .row-fluid .span5{width:40.05524861878453%;*width:40.00205712942283%;} .row-fluid .span4{width:31.491712707182323%;*width:31.43852121782062%;} .row-fluid .span3{width:22.92817679558011%;*width:22.87498530621841%;} .row-fluid .span2{width:14.3646408839779%;*width:14.311449394616199%;} .row-fluid .span1{width:5.801104972375691%;*width:5.747913483013988%;} .row-fluid .offset12{margin-left:105.52486187845304%;*margin-left:105.41847889972962%;} .row-fluid .offset12:first-child{margin-left:102.76243093922652%;*margin-left:102.6560479605031%;} .row-fluid .offset11{margin-left:96.96132596685082%;*margin-left:96.8549429881274%;} .row-fluid .offset11:first-child{margin-left:94.1988950276243%;*margin-left:94.09251204890089%;} .row-fluid .offset10{margin-left:88.39779005524862%;*margin-left:88.2914070765252%;} .row-fluid .offset10:first-child{margin-left:85.6353591160221%;*margin-left:85.52897613729868%;} .row-fluid .offset9{margin-left:79.8342541436464%;*margin-left:79.72787116492299%;} .row-fluid .offset9:first-child{margin-left:77.07182320441989%;*margin-left:76.96544022569647%;} .row-fluid .offset8{margin-left:71.2707182320442%;*margin-left:71.16433525332079%;} .row-fluid .offset8:first-child{margin-left:68.50828729281768%;*margin-left:68.40190431409427%;} .row-fluid .offset7{margin-left:62.70718232044199%;*margin-left:62.600799341718584%;} .row-fluid .offset7:first-child{margin-left:59.94475138121547%;*margin-left:59.838368402492065%;} .row-fluid .offset6{margin-left:54.14364640883978%;*margin-left:54.037263430116376%;} .row-fluid .offset6:first-child{margin-left:51.38121546961326%;*margin-left:51.27483249088986%;} .row-fluid .offset5{margin-left:45.58011049723757%;*margin-left:45.47372751851417%;} .row-fluid .offset5:first-child{margin-left:42.81767955801105%;*margin-left:42.71129657928765%;} .row-fluid .offset4{margin-left:37.01657458563536%;*margin-left:36.91019160691196%;} .row-fluid .offset4:first-child{margin-left:34.25414364640884%;*margin-left:34.14776066768544%;} .row-fluid .offset3{margin-left:28.45303867403315%;*margin-left:28.346655695309746%;} .row-fluid .offset3:first-child{margin-left:25.69060773480663%;*margin-left:25.584224756083227%;} .row-fluid .offset2{margin-left:19.88950276243094%;*margin-left:19.783119783707537%;} .row-fluid .offset2:first-child{margin-left:17.12707182320442%;*margin-left:17.02068884448102%;} .row-fluid .offset1{margin-left:11.32596685082873%;*margin-left:11.219583872105325%;} .row-fluid .offset1:first-child{margin-left:8.56353591160221%;*margin-left:8.457152932878806%;} input,textarea,.uneditable-input{margin-left:0;} .controls-row [class*="span"]+[class*="span"]{margin-left:20px;} input.span12, textarea.span12, .uneditable-input.span12{width:710px;} input.span11, textarea.span11, .uneditable-input.span11{width:648px;} input.span10, textarea.span10, .uneditable-input.span10{width:586px;} input.span9, textarea.span9, .uneditable-input.span9{width:524px;} input.span8, textarea.span8, .uneditable-input.span8{width:462px;} input.span7, textarea.span7, .uneditable-input.span7{width:400px;} input.span6, textarea.span6, .uneditable-input.span6{width:338px;} input.span5, textarea.span5, .uneditable-input.span5{width:276px;} input.span4, textarea.span4, .uneditable-input.span4{width:214px;} input.span3, textarea.span3, .uneditable-input.span3{width:152px;} input.span2, textarea.span2, .uneditable-input.span2{width:90px;} input.span1, textarea.span1, .uneditable-input.span1{width:28px;}}@media (min-width:1200px){.row{margin-left:-30px;*zoom:1;}.row:before,.row:after{display:table;content:"";line-height:0;} .row:after{clear:both;} [class*="span"]{float:left;min-height:1px;margin-left:30px;} .container,.navbar-static-top .container,.navbar-fixed-top .container,.navbar-fixed-bottom .container{width:1170px;} .span12{width:1170px;} .span11{width:1070px;} .span10{width:970px;} .span9{width:870px;} .span8{width:770px;} .span7{width:670px;} .span6{width:570px;} .span5{width:470px;} .span4{width:370px;} .span3{width:270px;} .span2{width:170px;} .span1{width:70px;} .offset12{margin-left:1230px;} .offset11{margin-left:1130px;} .offset10{margin-left:1030px;} .offset9{margin-left:930px;} .offset8{margin-left:830px;} .offset7{margin-left:730px;} .offset6{margin-left:630px;} .offset5{margin-left:530px;} .offset4{margin-left:430px;} .offset3{margin-left:330px;} .offset2{margin-left:230px;} .offset1{margin-left:130px;} .row-fluid{width:100%;*zoom:1;}.row-fluid:before,.row-fluid:after{display:table;content:"";line-height:0;} .row-fluid:after{clear:both;} .row-fluid [class*="span"]{display:block;width:100%;min-height:30px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;float:left;margin-left:2.564102564102564%;*margin-left:2.5109110747408616%;} .row-fluid [class*="span"]:first-child{margin-left:0;} .row-fluid .span12{width:100%;*width:99.94680851063829%;} .row-fluid .span11{width:91.45299145299145%;*width:91.39979996362975%;} .row-fluid .span10{width:82.90598290598291%;*width:82.8527914166212%;} .row-fluid .span9{width:74.35897435897436%;*width:74.30578286961266%;} .row-fluid .span8{width:65.81196581196582%;*width:65.75877432260411%;} .row-fluid .span7{width:57.26495726495726%;*width:57.21176577559556%;} .row-fluid .span6{width:48.717948717948715%;*width:48.664757228587014%;} .row-fluid .span5{width:40.17094017094017%;*width:40.11774868157847%;} .row-fluid .span4{width:31.623931623931625%;*width:31.570740134569924%;} .row-fluid .span3{width:23.076923076923077%;*width:23.023731587561375%;} .row-fluid .span2{width:14.52991452991453%;*width:14.476723040552828%;} .row-fluid .span1{width:5.982905982905983%;*width:5.929714493544281%;} .row-fluid .offset12{margin-left:105.12820512820512%;*margin-left:105.02182214948171%;} .row-fluid .offset12:first-child{margin-left:102.56410256410257%;*margin-left:102.45771958537915%;} .row-fluid .offset11{margin-left:96.58119658119658%;*margin-left:96.47481360247316%;} .row-fluid .offset11:first-child{margin-left:94.01709401709402%;*margin-left:93.91071103837061%;} .row-fluid .offset10{margin-left:88.03418803418803%;*margin-left:87.92780505546462%;} .row-fluid .offset10:first-child{margin-left:85.47008547008548%;*margin-left:85.36370249136206%;} .row-fluid .offset9{margin-left:79.48717948717949%;*margin-left:79.38079650845607%;} .row-fluid .offset9:first-child{margin-left:76.92307692307693%;*margin-left:76.81669394435352%;} .row-fluid .offset8{margin-left:70.94017094017094%;*margin-left:70.83378796144753%;} .row-fluid .offset8:first-child{margin-left:68.37606837606839%;*margin-left:68.26968539734497%;} .row-fluid .offset7{margin-left:62.393162393162385%;*margin-left:62.28677941443899%;} .row-fluid .offset7:first-child{margin-left:59.82905982905982%;*margin-left:59.72267685033642%;} .row-fluid .offset6{margin-left:53.84615384615384%;*margin-left:53.739770867430444%;} .row-fluid .offset6:first-child{margin-left:51.28205128205128%;*margin-left:51.175668303327875%;} .row-fluid .offset5{margin-left:45.299145299145295%;*margin-left:45.1927623204219%;} .row-fluid .offset5:first-child{margin-left:42.73504273504273%;*margin-left:42.62865975631933%;} .row-fluid .offset4{margin-left:36.75213675213675%;*margin-left:36.645753773413354%;} .row-fluid .offset4:first-child{margin-left:34.18803418803419%;*margin-left:34.081651209310785%;} .row-fluid .offset3{margin-left:28.205128205128204%;*margin-left:28.0987452264048%;} .row-fluid .offset3:first-child{margin-left:25.641025641025642%;*margin-left:25.53464266230224%;} .row-fluid .offset2{margin-left:19.65811965811966%;*margin-left:19.551736679396257%;} .row-fluid .offset2:first-child{margin-left:17.094017094017094%;*margin-left:16.98763411529369%;} .row-fluid .offset1{margin-left:11.11111111111111%;*margin-left:11.004728132387708%;} .row-fluid .offset1:first-child{margin-left:8.547008547008547%;*margin-left:8.440625568285142%;} input,textarea,.uneditable-input{margin-left:0;} .controls-row [class*="span"]+[class*="span"]{margin-left:30px;} input.span12, textarea.span12, .uneditable-input.span12{width:1156px;} input.span11, textarea.span11, .uneditable-input.span11{width:1056px;} input.span10, textarea.span10, .uneditable-input.span10{width:956px;} input.span9, textarea.span9, .uneditable-input.span9{width:856px;} input.span8, textarea.span8, .uneditable-input.span8{width:756px;} input.span7, textarea.span7, .uneditable-input.span7{width:656px;} input.span6, textarea.span6, .uneditable-input.span6{width:556px;} input.span5, textarea.span5, .uneditable-input.span5{width:456px;} input.span4, textarea.span4, .uneditable-input.span4{width:356px;} input.span3, textarea.span3, .uneditable-input.span3{width:256px;} input.span2, textarea.span2, .uneditable-input.span2{width:156px;} input.span1, textarea.span1, .uneditable-input.span1{width:56px;} .thumbnails{margin-left:-30px;} .thumbnails>li{margin-left:30px;} .row-fluid .thumbnails{margin-left:0;}}@media (max-width:979px){body{padding-top:0;} .navbar-fixed-top,.navbar-fixed-bottom{position:static;} .navbar-fixed-top{margin-bottom:20px;} .navbar-fixed-bottom{margin-top:20px;} .navbar-fixed-top .navbar-inner,.navbar-fixed-bottom .navbar-inner{padding:5px;} .navbar .container{width:auto;padding:0;} .navbar .brand{padding-left:10px;padding-right:10px;margin:0 0 0 -5px;} .nav-collapse{clear:both;} .nav-collapse .nav{float:none;margin:0 0 10px;} .nav-collapse .nav>li{float:none;} .nav-collapse .nav>li>a{margin-bottom:2px;} .nav-collapse .nav>.divider-vertical{display:none;} .nav-collapse .nav .nav-header{color:#777777;text-shadow:none;} .nav-collapse .nav>li>a,.nav-collapse .dropdown-menu a{padding:9px 15px;font-weight:bold;color:#777777;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;} .nav-collapse .btn{padding:4px 10px 4px;font-weight:normal;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;} .nav-collapse .dropdown-menu li+li a{margin-bottom:2px;} .nav-collapse .nav>li>a:hover,.nav-collapse .dropdown-menu a:hover{background-color:#f2f2f2;} .navbar-inverse .nav-collapse .nav>li>a:hover,.navbar-inverse .nav-collapse .dropdown-menu a:hover{background-color:#111111;} .nav-collapse.in .btn-group{margin-top:5px;padding:0;} .nav-collapse .dropdown-menu{position:static;top:auto;left:auto;float:none;display:block;max-width:none;margin:0 15px;padding:0;background-color:transparent;border:none;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;} .nav-collapse .dropdown-menu:before,.nav-collapse .dropdown-menu:after{display:none;} .nav-collapse .dropdown-menu .divider{display:none;} .nav-collapse .nav>li>.dropdown-menu:before,.nav-collapse .nav>li>.dropdown-menu:after{display:none;} .nav-collapse .navbar-form,.nav-collapse .navbar-search{float:none;padding:10px 15px;margin:10px 0;border-top:1px solid #f2f2f2;border-bottom:1px solid #f2f2f2;-webkit-box-shadow:inset 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(255, 255, 255, 0.1);-moz-box-shadow:inset 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(255, 255, 255, 0.1);box-shadow:inset 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(255, 255, 255, 0.1);} .navbar-inverse .nav-collapse .navbar-form,.navbar-inverse .nav-collapse .navbar-search{border-top-color:#111111;border-bottom-color:#111111;} .navbar .nav-collapse .nav.pull-right{float:none;margin-left:0;} .nav-collapse,.nav-collapse.collapse{overflow:hidden;height:0;} .navbar .btn-navbar{display:block;} .navbar-static .navbar-inner{padding-left:10px;padding-right:10px;}}@media (min-width:980px){.nav-collapse.collapse{height:auto !important;overflow:visible !important;}}
.table a:visited
{
text-decoration: line-through;
opacity: .25;
filter: alpha(opacity=25);
}
        </style>
        <!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
      </head>
      <body>
        
		<div class="container">
			<h1>Human Readable Sitemap</h1>
			<p class="lead">
			  This page was generated from a <a href="http://www.sitemaps.org/">sitemap</a> by <a href="https://nanoweb.vn">NanoWeb</a>
			</p>
      <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th>Location</th>
            <th>Last Modification</th>
            <th>Change Frequency</th>
            <th>Priority</th>
          </tr>
        </thead>
        <tbody>
          <xsl:apply-templates select="sitemap:urlset/sitemap:url">
            <xsl:sort select="sitemap:loc" order="ascending"/>
          </xsl:apply-templates>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4" align="right" style="text-align:right;">
              <b>
                <xsl:value-of select="count(sitemap:urlset/sitemap:url)"></xsl:value-of> Locations
              </b>
            </td>
          </tr>
        </tfoot>
      </table>
		</div>
      </body>
    </html>
  </xsl:template>

  <xsl:template match="sitemap:url">
    <xsl:variable name="loc">
      <xsl:choose>
        <xsl:when test="sitemap:loc">
          <xsl:value-of select="sitemap:loc"/>
        </xsl:when>
        <xsl:otherwise>N/A</xsl:otherwise>
      </xsl:choose>
    </xsl:variable>
    <xsl:variable name="lastmod">
      <xsl:choose>
        <xsl:when test="sitemap:lastmod">
          <xsl:value-of select="sitemap:lastmod"/>
        </xsl:when>
        <xsl:otherwise>N/A</xsl:otherwise>
      </xsl:choose>
    </xsl:variable>
    <xsl:variable name="changefreq">
      <xsl:choose>
        <xsl:when test="sitemap:changefreq">
          <xsl:value-of select="sitemap:changefreq"/>
        </xsl:when>
        <xsl:otherwise>N/A</xsl:otherwise>
      </xsl:choose>
    </xsl:variable>
    <xsl:variable name="priority">
      <xsl:choose>
        <xsl:when test="sitemap:priority">
          <xsl:value-of select="sitemap:priority"/>
        </xsl:when>
        <xsl:otherwise>N/A</xsl:otherwise>
      </xsl:choose>
    </xsl:variable>
    <tr>
      <td>
        <a href="{$loc}" target="_blank" ref="nofollow">
          <xsl:value-of select="$loc"></xsl:value-of>
        </a>
      </td>
      <td>
        <xsl:value-of select="$lastmod"/>
      </td>
      <td>
        <xsl:value-of select="$changefreq"/>
      </td>
      <td>
        <xsl:value-of select="$priority"/>
      </td>
    </tr>
  </xsl:template>
</xsl:stylesheet>