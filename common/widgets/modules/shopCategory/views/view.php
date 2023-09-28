<?php if (isset($cat_info) && count($cat_info)) { ?>
    <div class="check-box clearfix">
        <div class="container">
            <div class="col-xs-1">
                <p class="title-option">Lựa chọn:</p>
            </div>
            <div class="cont col-xs-11">
                <form class="me-select clearfix">
                    <ul id="me-select-list">
                        <?php
                        foreach ($cat_info as $cat_id => $cat_name) {
                            ?>
                            <li class="col-xs-3">
                                <input id="cb<?php echo $cat_id; ?>" <?php echo (in_array($cat_id, $cid) ? 'checked' : ''); ?> onclick="insertParam('cid', <?php echo $cat_id ?>)" type="checkbox" value="<?php echo $cat_id ?>"> 
                                <label for="cb<?php echo $cat_id; ?>"><?php echo $cat_name ?></label>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function insertParam(key, value) {
            key = encodeURI(key);
            value = encodeURI(value);
            var kvp = document.location.search.substr(1).split('&');
            var i = kvp.length;
            var x;
            while (i--) {
                x = kvp[i].split('=');
                if (x[0] == key) {
                    x[1] = value;
                    kvp[i] = x.join('=');
                    break;
                }
            }
            if (i < 0) {
                kvp[kvp.length] = [key, value].join('=');
            }
            document.location.search = kvp.join('&');
        }
    </script>
    <?php
} 