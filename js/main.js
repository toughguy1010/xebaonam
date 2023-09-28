(function($) {
    $.fn.LoPopUp = function(options) {
        var settings = $.extend({
            clearBefore: false,
            contentHtml: '',
            timeoutAppend: '',
            title: '',
            top: '',
            maxwidth: '',
            minwidth: '',
            maxheight: '',
            minheight: '',
            loadingStart: false,
            closePopup: false,
            afterSuccess: null
        }, options);
        if (!$('#IDLOpopup').html()) {
            $('body').append('<div id="IDLOpopup" rel="0" class="LOpopup"><div class="LOpopupDialogClass"><div class="LOpopupDialogHead">Tiêu đề</div> <span  class="closepopup" onclick="closeAllPopup($(this));; return false;">X</span><div class="loading"></div> <div class="LOpopupDialogBody"></div></div></div>');
        }
        if (settings.clearBefore) {
            $(this).find('.LOpopupDialogBody').html('');
        }
        if (!settings.closePopup) {
            $(this).show();
        }
        else {
            $(this).hide();
        }
        if (settings.loadingStart) {
            $(this).find('.loading').show();
        }
        if ($.trim(settings.contentHtml) != '') {
            if ($.trim(settings.timeoutAppend) == '') {
                $(this).find('.LOpopupDialogBody').html(settings.contentHtml);
                $(this).find('.loading').hide();
                $(this).find('.LOpopupDialogBody').slideDown('slow');
                $(this).find('.loading').hide();
                if ($.isFunction(settings.afterSuccess)) {
                    settings.afterSuccess.call(this);
                }
            } else {
                var object = $(this);
                setTimeout(function() {
                    object.find('.LOpopupDialogBody').html(settings.contentHtml);
                    object.find('.loading').hide();
                    object.find('.LOpopupDialogBody').slideDown('slow');
                    object.find('.loading').hide();
                    if ($.isFunction(settings.afterSuccess)) {
                        settings.afterSuccess.call(this);
                    }
                }, settings.timeoutAppend)
            }
        }
        if ($.trim(settings.title) != '') {
            $(this).find('.LOpopupDialogHead').html(settings.title);
        }
        if ($.trim(settings.top) != '') {
            $(this).css('top', settings.top);
        }
        if ($.trim(settings.maxwidth) != '') {

            $(this).find('.LOpopupDialogClass ').css('max-width', settings.maxwidth);
        }
        if ($.trim(settings.minwidth) != '') {
            $(this).find('.LOpopupDialogClass ').css('min-width', settings.minwidth);
        }
        if ($.trim(settings.maxheight) != '') {
            $(this).find('.LOpopupDialogClass ').css('max-height', settings.maxheight);
        }
        if ($.trim(settings.minheight) != '') {
            $(this).find('.LOpopupDialogClass ').css('max-height', settings.minheight);
        }
        var thi = this;
        setTimeout(function() {
            var LOpopupDialogHead = $(thi).find('.LOpopupDialogHead');
            if ($.trim(settings.maxheight) != '') {
                $(thi).find('.LOpopupDialogBody').css('max-height', (parseInt(settings.maxheight) - 8 - LOpopupDialogHead.outerHeight(true)) + 'px');
            } else
                $(thi).find('.LOpopupDialogBody').css('max-height', ($(thi).find('.LOpopupDialogClass').height() - LOpopupDialogHead.outerHeight(true)) + 'px');
        }, 10);
        return this;

        // Do your awesome plugin stuff here
    };
})(jQuery);
function closeAllPopup() {
    $('.LOpopup').each(function() {
        $(this).hide();
    });
}
function createPopup(options) {
    if (options.popupId == '')
        return false;
    $('#IDLOpopup').clone().attr('id', options.popupId).after('#IDLOpopup');
    $("#" + settings.popupId).LoPopUp(options);
}

jQuery(document).ready(function() {
    jQuery('#nav-mainmenu .accordion-group').on('click', function() {
        jQuery('#nav-mainmenu').find('.accordion-group').removeClass('active');
        $(this).addClass('active');
        var mid = jQuery(this).find('> a').attr('href');
        var href = jQuery(mid + ' li:first > a').attr('href');
        if (href) {
            window.location.href = href;
        }
    });

    //
    $(document).on('keypress', '.isnumber', function(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (evt.ctrlKey || evt.shiftKey)
            return true;
        // 44: dấu phẩy
        if (charCode!=44 && charCode != 46 && charCode != 37 && charCode != 38 && charCode != 39 && charCode != 40 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        } else {
            return true;
        }
    });
    //
    $(document).on('keypress', '.numericHasNA', function(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        var oldval = $.trim($(this).val());
        if (evt.ctrlKey || evt.shiftKey)
            return true;
        switch (charCode) {
            case 110:
            case 78:
                if (oldval != '') {
                    return false;
                }
                break;
            default:
                if (isNumber(oldval)) {
                    $(this).val(oldval);
                }
                else {
                    $(this).val('');
                }
                if (charCode != 46 && charCode != 37 && charCode != 38 && charCode != 39 && charCode != 40 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                } else {
                    return true;
                }
        }

    });
    $(document).on('keyup', '.numericHasNA', function(evt) {
        var oldval = $.trim($(this).val());
        if (oldval == 'n') {
            $(this).val('n/a');
            return true;
        }

    });
    //
    jQuery('.delAllinGrid').on('click', function() {
        return deleteItemInGridview(this, jQuery(this).attr('grid'));
    });

    $(document).on('change', '.checkpage', function(e) {
        e.preventDefault();
        var thi = $(this);
        var checked = thi.prop("checked");
        var value = thi.val();
        //
        if (checked) {
            if (value == 'all')
                jQuery('.checkpage').prop('checked', true);
        } else {
            if (value == 'all')
                jQuery('.checkpage').prop('checked', false);
            //
            jQuery('.checkpage[value=all]').prop('checked', false);
        }
    });
    //
    //number format
    jQuery(".numberFormat").keypress(function(e) {
        return w3n.numberOnly(e);
    }).keyup(function(e) {
        var value = $(this).val();
        if (value != '') {
            var valueTemp = w3n.ToNumber(value);
            var formatNumber = w3n.FormatNumber(valueTemp);
            if (value != formatNumber)
                $(this).val(formatNumber);
        }
    });
    //
    jQuery(document).on('submit', 'form', function() {
        jQuery(".numberFormat").each(function() {
            jQuery(this).val(w3n.ToNumber(jQuery(this).val()));
        });
    });
});

/**
 * check is numeric
 * @param {type} n
 * @returns {unresolved}
 */
function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}
//
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
/**
 * sort value in object
 * @param type is ASC, DESC
 */

function sortObjectProperties(obj, type) {
    var keys = [];
    Object.keys(obj)
            .map(function(k) {
                return [k, obj[k]];
            })
            .sort(function(a, b) {
                if (type == 'ASC') {
                    if (a[1] < b[1])
                        return -1;
                    if (a[1] > b[1])
                        return 1;
                    return 0;
                }
                else {
                    if (a[1] > b[1])
                        return -1;
                    if (a[1] < b[1])
                        return 1;
                    return 0;
                }
            })
            .forEach(function(d) {
                keys.push(d[0]);
            });
    return keys;
}

/**
 * preview image that dont need to upload and get url
 * tested in chrome and fireFox, IE10
 * dont run in IE9,8... fixing
 * 
 * @param {type} input
 * @returns {undefined}
 */
function preivewImagesBeforeUpload(input, objShow) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            objShow.attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

/*
 *Show loading
 */

function w3ShowLoading(obj, pos, rangleft, rangtop) {
    if (!pos)
        pos = 'right';
    if (!rangleft)
        rangleft = 0;
    if (!rangtop)
        rangtop = 0;
    rangleft = parseInt(rangleft);
    rangtop = parseInt(rangtop);
    var _oposition = obj.offset();
    if (_oposition) {
        var _oobj_width = obj.width();
        var _oobj_height = obj.height();
        switch (pos) {
            case "left":
            case "top":
                {
                    var _oleft = _oposition.left + rangleft;
                    var _otop = _oposition.top + rangtop;
                }
                break;
            case "bottom":
                {
                    var _oleft = _oposition.left + rangleft;
                    var _otop = _oposition.top - rangtop + _oobj_height;
                }
                break;
            default:
                {
                    var _oleft = _oposition.left + rangleft + _oobj_width;
                    var _otop = _oposition.top + rangtop;
                }
                break;
        }
        if (!$("#objloading").html()) {
            $('body').append('<div id="objloading" style="position: absolute; top: 0px; left: 0px;z-index: 9999"><div id="imgloading" style="position: absolute; top:' + _otop + 'px; left:' + _oleft + 'px;"><img style="display: block;" src="img/wating.gif" /></div></div>');
        }
        $("#imgloading").css({
            top: _otop + 'px',
            left: _oleft + 'px'
        })
        $('#objloading').fadeTo("fast", 1);

    }
    return false;
}
//Ẩn loading
function w3HideLoading() {
    jQuery('#objloading').fadeTo("slow", 0, function() {
        $(this).hide();
    });
}
//
function parseJsonErrors($_errors, specialobject) {
    var errors = $.parseJSON($_errors);
    if (specialobject) {
        specialobject.find('.errorMessage').hide();
        $.each(errors, function(key, val) {
            specialobject.find("#" + key + "_em_").text(val);
            specialobject.find("#" + key + "_em_").show();
        });
    } else {
        jQuery('.errorMessage').hide();
        $.each(errors, function(key, val) {
            jQuery("#" + key + "_em_").text(val);
            jQuery("#" + key + "_em_").show();
        });
    }
}
/** Check grid view **/
function deleteItemInGridview(obj, grid_id) {
    if (!grid_id)
        return false;
    var au = isCheck(grid_id);
    if (au) {
        var url = $(obj).attr('href') ? $(obj).attr('href') : $(obj).attr('src');
        if (!url)
            return false;
        var confi = $(obj).attr('comfirm');
        if (!confi)
            confi = "Bạn có chắc chắn muốn thực hiện hành động được chọn không?";
        if (confirm(confi))
            var id = getCheckvalue(grid_id);
        var th = this;
        $.fn.yiiGridView.update(grid_id, {
            type: "POST",
            url: url,
            data: {
                "lid": id
            },
            success: function(data) {
                $.fn.yiiGridView.update(grid_id);
            },
            error: function(XHR) {
                return afterDelete(th, false, XHR);
            }
        });
    } else
        alert("Xin vui lòng chọn một hoặc nhiều mục trước.");
    return false;
}
function isCheck(grid_id) {
    var items = document.getElementsByName(grid_id + "_c0[]");
    for (i = 0; i < items.length; i++) {
        if (items[i].checked) {
            return true;
        }
    }
    return false;
}
function getCheckvalue(grid_id) {
    var array = document.getElementsByName(grid_id + "_c0[]");
    var resul = "";
    for (i = 0; i < array.length; i++) {
        if (array[i].checked)
            resul += array[i].value + ",";
    }
    return resul;
}
/*** End grid view ****/
/*
 w3n prototype;
 */
var w3n = {};
//check every thing;
w3n.is_arr = function(arr) {
    return (arr != null && arr.constructor == Array)
};

w3n.is_str = function(str) {
    return (str && (/string/).test(typeof str))
};

w3n.is_func = function(func) {
    return (func != null && func.constructor == Function)
};

w3n.is_num = function(num) {
    return (num != null && num.constructor == Number)
};

w3n.is_obj = function(obj) {
    return (obj != null && obj instanceof Object)
};

w3n.is_ele = function(ele) {
    return (ele && ele.tagName && ele.nodeType == 1)
};

w3n.is_exists = function(obj) {
    return (obj != null && obj != undefined && obj != "undefined")
};

w3n.is_blank = function(str) {
    return (w3n.util_trim(str) == "")
};

w3n.is_phone = function(num) {
    return (/^(0121|0122|0123|0125|0126|0127|0166|0168|0169|0199|090|091|092|093|094|095|096|097|098)(\d{7})$/i).test(num)
};

w3n.is_email = function(str) {
    return (/^[a-z][a-z-_0-9\.]+@[a-z-_=>0-9\.]+\.[a-z]{2,3}$/i).test(w3n.util_trim(str))
};

w3n.is_username = function(value) {
    return (value.match(/^[0-9]/) == null) && (value.search(/^[0-9_a-zA-Z]*$/) > -1);
}

w3n.is_link = function(str) {
    return (/(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/).test(w3n.util_trim(str))
};

w3n.is_image = function(imagePath) {
    var fileType = imagePath.substring(imagePath.lastIndexOf("."), imagePath.length).toLowerCase();
    return (fileType == ".gif") || (fileType == ".jpg") || (fileType == ".png") || (fileType == ".jpeg");
};

w3n.is_ff = function() {
    return (/Firefox/).test(navigator.userAgent)
};

w3n.is_ie = function() {
    return (/MSIE/).test(navigator.userAgent)
};

w3n.is_ie6 = function() {
    return (/MSIE 6/).test(navigator.userAgent)
};

w3n.is_ie7 = function() {
    return (/MSIE 7/).test(navigator.userAgent)
};

w3n.is_ie8 = function() {
    return (/MSIE 8/).test(navigator.userAgent)
};

w3n.is_chrome = function() {
    return (/Chrome/).test(navigator.userAgent)
};

w3n.is_opera = function() {
    return (/Opera/).test(navigator.userAgent)
};

w3n.is_safari = function() {
    return (/Safari/).test(navigator.userAgent)
};
//Working with something;
w3n.util_trim = function(str) {
    return (/string/).test(typeof str) ? str.replace(/^\s+|\s+$/g, "") : "";
};

w3n.util_random = function(a, b) {
    return Math.floor(Math.random() * (b - a + 1)) + a
};

w3n.get_ele = function(id) {
    return document.getElementById(id)
};

w3n.numberOnly = function(e) {
    var ctrlKey = e.ctrlKey || e.metaKey;
    var keyCode = e.keyCode || e.which;
    //alert(keyCode);
    // Ctr+c, Ctrl + v, 0-9, Dấu phẩy
    if (ctrlKey && (keyCode == 86 || keyCode == 118) || 34 < keyCode && keyCode < 41 || keyCode == 44 || keyCode == 9)
        return true;
    else if (keyCode != 8 && keyCode != 0 && (keyCode < 48 || keyCode > 57)) {
        return false;
    }
    return true;
};
//number format
w3n.FormatNumber = function(nStr) {
    nStr += '';
    x = nStr.split(',');
    x1 = x[0];
    x2 = x.length > 1 ? ',' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    var value = x1 + x2;
    if (value === "NaN") {
        return 0;
    }
    return value;
};

w3n.ToNumber = function(nStr) {
    if (nStr !== null && nStr !== NaN) {
        var rgx = /[đ₫\s,.]/;
        while (rgx.test(nStr)) {
            nStr = nStr.replace(rgx, '');
        }
        return eval(nStr) + 0;
    }
    return 0;

};
