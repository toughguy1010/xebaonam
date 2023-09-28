<div class="tim">
    <form class="searchform" id="searchForm">
        <input id="searchInput" type="text" class="form-control inputSearch keyword" name="<?php echo $keyName ?>"
               value="<?php echo $keyWord; ?>" placeholder="<?php echo $placeHolder; ?>" autocomplete="off">
        <button id="btnsuggestinstall"><i class="icontg-tim"></i></button>
        <div id="searchResults" class="search-results">
        </div>
    </form>
</div>

<style>
    #searchForm {
        position: relative;
    }

    #searchResults {
        display: none;
        position: absolute;
        width: 30vw;
        padding: 5px 10px;
        top: 39px;
        left: 5px;
        background-color: #FFF;
        max-height: 340px;
        overflow-x: hidden;
        overflow-y: auto;
        z-index: 1;
        box-shadow: 0px 3px 5px #999;
    }

    #searchResults .result-group {
        font-weight: bold;
    }

    #searchResults .result ul {
        list-style: none;
        margin-left: 15px;
    }
    #searchInput {
        text-align: left;
    }
    #searchResults .result ul a {
        float: left;
        width: 100%;
        padding: 5px 0;
        color: #333;
    }
</style>
<script type="text/javascript">
    var timeOut = null, timeOut1 = null;
    var time = 320;
    var timeItem = 80;
    var isAppend = false;
    var keyWordTemp = '';
    jQuery(document).on('click', function (e) {
        if ($(e.target).closest("#searchForm").length === 0) {
            jQuery('#searchResults').fadeOut(200);
        }
    });
    jQuery('#searchInput').on('keyup', function () {
        var keyword = jQuery.trim(jQuery(this).val());
        isAppend = false;
        if (keyword && keyword != keyWordTemp) {
            keyWordTemp = keyword;
            if (timeOut) {
                clearTimeout(timeOut);
                clearTimeout(timeOut1);
            }
            timeOut = setTimeout(function () {
                search(keyword, '<?php echo ClaSite::SEARCH_INDEX_TYPE_PRODUCT ?>');
                timeOut1 = setTimeout(function () {
                    search(keyword, '<?php echo ClaSite::SEARCH_INDEX_TYPE_PRODUCT_CATEGORY ?>');
                }, timeItem * 2);
            }, time);
        } else if (!keyword) {
            jQuery('#searchResults').fadeOut(200);
        }
    });

    //
    function search(keyword, type, isLast) {
        var url = "<?php echo $action; ?>";
        if (!type) {
            type = "<?php echo ClaSite::SEARCH_INDEX_TYPE_PRODUCT ?>";
        }
        jQuery.ajax({
            type: 'POST',
            url: url,
            dataType: 'JSON',
            data: {'<?php echo ClaSite::SEARCH_KEYWORD ?>': keyword, '<?php echo ClaSite::SEARCH_TYPE ?>': type},
            beforSend: function () {
            },
            success: function (res) {
                if (res.code == 200) {
                    if (res.html) {
                        if (isAppend) {
                            jQuery('#searchResults').append(res.html);
                        } else {
                            jQuery('#searchResults').html(res.html);
                            isAppend = true;
                        }
                        jQuery('#searchResults').fadeIn(200);
                    }
                }
                if (isLast) {
                    isAppend = false;
                    jQuery('#searchResults').scrollTop(0);
                }
            },
            error: function () {
            }
        });
        if (isLast && !isAppend) {
            jQuery('#searchResults').fadeOut(200);
        }
    }

    function resetSearchResult() {
        return;
        jQuery('#searchResults').html('');
        jQuery('#searchResults').hide();
    }
</script>