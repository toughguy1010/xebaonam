if(typeof jQuery==="undefined"){throw new Error("Bootstrap's JavaScript requires jQuery")}+function(d){var b=function(e){this.element=d(e)};b.VERSION="3.2.0";b.prototype.show=function(){var k=this.element;var h=k.closest("ul:not(.dropdown-menu)");var g=k.data("target");if(!g){g=k.attr("href");g=g&&g.replace(/.*(?=#[^\s]*$)/,"")}if(k.parent("li").hasClass("active")){return}var i=h.find(".active:last a")[0];var j=d.Event("show.bs.tab",{relatedTarget:i});k.trigger(j);if(j.isDefaultPrevented()){return}var f=d(g);this.activate(k.closest("li"),h);this.activate(f,f.parent(),function(){k.trigger({type:"shown.bs.tab",relatedTarget:i})})};b.prototype.activate=function(g,f,j){var e=f.find("> .active");var i=j&&d.support.transition&&e.hasClass("fade");function h(){e.removeClass("active").find("> .dropdown-menu > .active").removeClass("active");g.addClass("active");if(i){g[0].offsetWidth;g.addClass("in")}else{g.removeClass("fade")}if(g.parent(".dropdown-menu")){g.closest("li.dropdown").addClass("active")}j&&j()}i?e.one("bsTransitionEnd",h).emulateTransitionEnd(150):h();e.removeClass("in")};function c(e){return this.each(function(){var g=d(this);var f=g.data("bs.tab");if(!f){g.data("bs.tab",(f=new b(this)))}if(typeof e=="string"){f[e]()}})}var a=d.fn.tab;d.fn.tab=c;d.fn.tab.Constructor=b;d.fn.tab.noConflict=function(){d.fn.tab=a;return this};d(document).on("click",".tab .nav-tabs li a",function(f){f.preventDefault();c.call(d(this),"show")})}(jQuery);+function(h){var e=".dropdown-backdrop";var b='[data-toggle="dropdown"]';var a=function(i){h(i).on("click.bs.dropdown",this.toggle)};a.VERSION="3.2.0";a.prototype.toggle=function(m){var l=h(this);if(l.is(".disabled, :disabled")){return}var k=f(l);var j=k.hasClass("open");d();if(!j){if("ontouchstart" in document.documentElement&&!k.closest(".navbar-nav").length){h('<div class="dropdown-backdrop"/>').insertAfter(h(this)).on("click",d)}var i={relatedTarget:this};k.trigger(m=h.Event("show.bs.dropdown",i));if(m.isDefaultPrevented()){return}l.trigger("focus");k.toggleClass("open").trigger("shown.bs.dropdown",i)}return false};a.prototype.keydown=function(m){if(!/(38|40|27)/.test(m.keyCode)){return}var l=h(this);m.preventDefault();m.stopPropagation();if(l.is(".disabled, :disabled")){return}var k=f(l);var j=k.hasClass("open");if(!j||(j&&m.keyCode==27)){if(m.which==27){k.find(b).trigger("focus")}return l.trigger("click")}var n=" li:not(.divider):visible a";var o=k.find('[role="menu"]'+n+', [role="listbox"]'+n);if(!o.length){return}var i=o.index(o.filter(":focus"));if(m.keyCode==38&&i>0){i--}if(m.keyCode==40&&i<o.length-1){i++}if(!~i){i=0}o.eq(i).trigger("focus")};function d(i){if(i&&i.which===3){return}h(e).remove();h(b).each(function(){var k=f(h(this));var j={relatedTarget:this};if(!k.hasClass("open")){return}k.trigger(i=h.Event("hide.bs.dropdown",j));if(i.isDefaultPrevented()){return}k.removeClass("open").trigger("hidden.bs.dropdown",j)})}function f(k){var i=k.attr("data-target");if(!i){i=k.attr("href");i=i&&/#[A-Za-z]/.test(i)&&i.replace(/.*(?=#[^\s]*$)/,"")}var j=i&&h(i);return j&&j.length?j:k.parent()}function g(i){return this.each(function(){var k=h(this);var j=k.data("bs.dropdown");if(!j){k.data("bs.dropdown",(j=new a(this)))}if(typeof i=="string"){j[i].call(k)}})}var c=h.fn.dropdown;h.fn.dropdown=g;h.fn.dropdown.Constructor=a;h.fn.dropdown.noConflict=function(){h.fn.dropdown=c;return this};h(document).on("click.bs.dropdown.data-api",d).on("click.bs.dropdown.data-api",".dropdown form",function(i){i.stopPropagation()}).on("click.bs.dropdown.data-api",b,a.prototype.toggle).on("keydown.bs.dropdown.data-api",b+', [role="menu"], [role="listbox"]',a.prototype.keydown)}(jQuery);
jQuery(document).ready(function () {
    jQuery('.addmodule-action').on('click', function () {
        var _this = jQuery(this);
        if (_this.hasClass('disable'))
            return false;
        _this.addClass('disable');
        var url = $(this).attr('href');
        if (!url)
            return false;
        jQuery.ajax({
            type: 'post',
            dataType: 'JSON',
            url: url,
            beforeSend: function () {
                w3ShowLoading(_this, 'right', 0, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    $(document).LoPopUp({
                        title: 'Thêm module',
                        clearBefore: true,
                        clearAfter: true,
                        maxwidth: '800px',
                        minwidth: '800px',
                        maxheight: '550px',
                        top: '200px',
                        contentHtml: res.html
                    });
                    $(".LOpopup").show();
                }
                w3HideLoading();
                _this.removeClass('disable');
            },
            error: function () {
                w3HideLoading();
                _this.removeClass('disable');
            }

        });
        return false;
    });
    jQuery('.editModule').on('change', function () {
        var _this = jQuery(this);
        if (_this.hasClass('disable'))
            return false;
        _this.addClass('disable');
        var url = $(this).data('src');
        if (!url)
            return false;
        var val = 0;
        if (_this.prop('checked')) {
            val = 1;
        }
        jQuery.ajax({
            type: 'post',
            dataType: 'JSON',
            url: url,
            data: {'value': val},
            beforeSend: function () {
                w3ShowLoading(_this, 'right', 0, 0);
            },
            success: function (res) {
                window.location.href = window.location.href;
                _this.removeClass('disable');
            },
            error: function () {
                w3HideLoading();
                _this.removeClass('disable');
            }

        });
        return false;
    });

    jQuery(document).on('click', '#savewidget', function () {
        var _this = jQuery(this);
        if (_this.hasClass('disable'))
            return false;
        _this.addClass('disable');
    });

    jQuery(document).on('submit', '#widgets-form', function () {
        var _this = jQuery(this);
        var url = jQuery(this).attr('action');
        var method = jQuery(this).attr('method');
        var data = jQuery(this).serialize();
        jQuery.ajax({
            url: url,
            type: method,
            dataType: 'JSON',
            data: data,
            beforeSend: function () {
                w3ShowLoading(_this, 'left', 0, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    if (res.nstep && res.nstep != '') {
                        $(document).LoPopUp({
                            title: 'Cấu hình cho module',
                            clearBefore: true,
                            clearAfter: true,
                            maxwidth: '800px',
                            minwidth: '800px',
                            maxheight: '550px',
                            contentHtml: res.nstep
                        });
                    }

                } else {
                    if (res.errors) {
                        parseJsonErrors(res.errors, _this);
                    }
                }
                w3HideLoading();
                $('#savewidget').removeClass('disable');
            }
            ,
            error: function () {
                w3HideLoading();
                $('#savewidget').removeClass('disable');
            }
        });
        return false;
    });
    //
    jQuery(document).on('click', '#savewidgetconfig', function () {
        var _this = jQuery(this);
        if (_this.hasClass('disable'))
            return false;
        _this.addClass('disable');
    });
    //
    jQuery(document).on('submit', '#widget-config-form', function () {
        var _this = jQuery(this);
        var url = jQuery(this).attr('action');
        var method = jQuery(this).attr('method');
        var data = jQuery(this).serialize();
        jQuery.ajax({
            url: url,
            type: method,
            dataType: 'JSON',
            data: data,
            beforeSend: function () {
                w3ShowLoading(_this, 'left', 0, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    window.location.href = window.location.href;
                } else {
                    if (res.errors) {
                        parseJsonErrors(res.errors, _this);
                    }
                }
                w3HideLoading();
                $('#savewidgetconfig').removeClass('disable');
            }
            ,
            error: function () {
                w3HideLoading();
                $('#savewidgetconfig').removeClass('disable');
            }
        });
        return false;
    });
    //
    jQuery(document).on('click', '.mwidgetedit', function () {
        var _this = jQuery(this);
        if (_this.hasClass('disable'))
            return false;
        _this.addClass('disable');
        var url = jQuery(this).attr('href');
        jQuery.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(_this.closest('.mwhead'), 'right', 0, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    if (res.html && res.html != '') {
                        $(document).LoPopUp({
                            title: 'Cập nhật module',
                            clearBefore: true,
                            clearAfter: true,
                            maxwidth: '800px',
                            minwidth: '800px',
                            maxheight: '550px',
                            contentHtml: res.html
                        });
                        $(".LOpopup").show();
                    }

                }
                w3HideLoading();
                _this.removeClass('disable');
            }
            ,
            error: function () {
                w3HideLoading();
                _this.removeClass('disable');
            }
        });
        return false;
    });
    //
    //
    jQuery(document).on('click', '.mwiddelete', function () {
        if (!confirm('Bạn có chắc chắn muốn xóa module này không?'))
            return false;
        var _this = jQuery(this);
        if (_this.hasClass('disable'))
            return false;
        _this.addClass('disable');
        var url = jQuery(this).attr('href');
        jQuery.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(_this.closest('.mwhead'), 'right', 0, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    _this.closest('.mwidget').remove();
                }
                w3HideLoading();
                _this.removeClass('disable');
            }
            ,
            error: function () {
                w3HideLoading();
                _this.removeClass('disable');
            }
        });
        return false;
    });
    //
    //
    jQuery(document).on('click', '.mwidmove', function () {
        var _this = jQuery(this);
        if (_this.hasClass('disable'))
            return false;
        _this.addClass('disable');
        var url = jQuery(this).attr('href');
        jQuery.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(_this.closest('.mwhead'), 'right', 0, 0);
            },
            success: function (res) {
                if (res.code == 200 && res.cm) {
                    window.location.href = window.location.href;
                }
                w3HideLoading();
                _this.removeClass('disable');
            }
            ,
            error: function () {
                w3HideLoading();
                _this.removeClass('disable');
            }
        });
        return false;
    });
});
//
(function ($) {
    $.fn.clickToggle20 = function (func1, func2) {
        var funcs = [func1, func2];
        this.data('toggleclicked', 0);
        this.click(function () {
            var data = $(this).data();
            var tc = data.toggleclicked;
            $.proxy(funcs[tc], this)();
            data.toggleclicked = (tc + 1) % 2;
        });
        return this;
    };
}(jQuery));
//
$(document).ready(function () {
    $(".dropdown-toggle").unbind('click');
    $('.dropdown-toggle2').clickToggle20(function () {
        $(this).next().css('display', 'block');
    }, function () {
        $(this).next().css('display', 'none');
    });
});