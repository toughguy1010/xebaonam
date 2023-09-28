<div class="product-filter-box">      
    <table class="table table-bordered attr-table">
        <?php
        if ($priceFilter) {
            $this->render('priceFilter', array('key' => $key, 'attribute' => $attribute, 'formUrl' => $formUrl));
        }
        ?>
        <?php 
        if ($manufacturersOptions) {
            $this->render('manufacturersFilter', array('key' => $key, 'manufacturers_options' => $manufacturersOptions));
        }
        ?>
        <?php
        if ($count = count($attributes)) {
            foreach ($attributes as $key => $attribute) {
                ?>
                <?php $this->render('partial/' . $attribute['att']['frontend_input'], array('key' => $key, 'attribute' => $attribute)); ?>
                <?php
            }
        }
        ?>
    </table>
    <script type="text/javascript">
        var addParamToUrl = function(url, key, value) {
            var sep = (url.indexOf('?') > -1) ? '&' : '?';
            return url + sep + key + '=' + value;
        };
        //
        function isNumber(n) {
            return !isNaN(parseFloat(n)) && isFinite(n);
        }
        //
        $(document).on('keyup', '.priceFormat', function(evt) {
            var val = $.trim($(this).val());
            var formattext = $(this).closest('.priceItem').find('.priceFormat-text');
            if (!val) {
                formattext.hide();
                return false;
            }
            formattext.html(val);
            formattext.show();
            formattext.prettynumber();
        });
        //
        $(document).on('keypress', '.isnumber', function(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (evt.ctrlKey || evt.shiftKey)
                return true;
            if (charCode != 37 && charCode != 38 && charCode != 39 && charCode != 40 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            } else {
                return true;
            }
        });
        (function($) {
            $.fn.prettynumber = function(options) {
                var opts = $.extend({}, $.fn.prettynumber.defaults, options);
                return this.each(function() {
                    $this = $(this);
                    var o = $.meta ? $.extend({}, opts, $this.data()) : opts;
                    var str = $this.html();
                    $this.html($this.html().toString().replace(new RegExp("(^\\d{" + ($this.html().toString().length % 3 || -1) + "})(?=\\d{3})"), "$1" + o.delimiter).replace(/(\d{3})(?=\d)/g, "$1" + o.delimiter));
                });
            };
            $.fn.prettynumber.defaults = {
                delimiter: '.'
            };
        })(jQuery);
        //
    </script>
</div>

