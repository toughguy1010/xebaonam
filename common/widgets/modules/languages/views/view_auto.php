<div class="language-header clearfix">
    <div class="language-header-content" id="language"><a class="gflag nturl" href="#" onclick="doTrans('vi|en');
            return false;" style="background-position:-0px -0px;" title="English"><img alt="English" height="18" src="images/flag/blank.png" width="32" /></a><a class="gflag nturl" href="#" onclick="doTrans('vi|vi');
                    return false;" style="background-position:-200px -400px;" title="Vietnamese"><img alt="Vietnamese" height="18" src="images/flag/blank.png" width="32" /></a>
        <style type="text/css"><!--
            a.gflag {vertical-align:middle;font-size:18px;padding:1px 0;background-repeat:no-repeat;background-image:url('images/flag/24.png');}
            a.gflag img {border:0; width: 32px;}
            a.gflag:hover {background-image:url('images/flag/24a.png');}
            #goog-gt-tt {display:none !important;}
            .goog-te-banner-frame {display:none !important;}
            .goog-te-menu-value:hover {text-decoration:none !important;}
            body {top:0 !important;}
            #google_translate_element2 {display:none!important;}
            -->
        </style>
        <div id="google_translate_element2">&nbsp;</div>
        <script type="text/javascript">
            function doTrans(str) {
                doGTranslate(str);
                return false;
            }
            function googleTranslateElementInit2() {
                new google.translate.TranslateElement({pageLanguage: 'vi', autoDisplay: false}, 'google_translate_element2');
            }
            function GTranslateFireEvent(a, b) {
                try {
                    if (document.createEvent) {
                        var c = document.createEvent("HTMLEvents");
                        c.initEvent(b, true, true);
                        a.dispatchEvent(c)
                    } else {
                        var c = document.createEventObject();
                        a.fireEvent('on' + b, c)
                    }
                } catch (e) {
                }
            }
            function doGTranslate(a) {
                if (a.value)
                    a = a.value;
                if (a == '')
                    return;
                var b = a.split('|')[1];
                var c;
                var d = document.getElementsByTagName('select');
                for (var i = 0; i < d.length; i++)
                    if (d[i].className == 'goog-te-combo')
                        c = d[i];
                if (document.getElementById('google_translate_element2') == null || document.getElementById('google_translate_element2').innerHTML.length == 0 || c.length == 0 || c.innerHTML.length == 0) {
                    setTimeout(function () {
                        doGTranslate(a)
                    }, 500)
                } else {
                    c.value = b;
                    GTranslateFireEvent(c, 'change');
                    GTranslateFireEvent(c, 'change')
                }
            }
            ;
        </script> <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script></div>
</div>