if (typeof jQuery === 'undefined') {
    throw new Error('Bootstrap\'s JavaScript requires jQuery')
}

/* ========================================================================
 * Bootstrap: tab.js v3.2.0
 * http://getbootstrap.com/javascript/#tabs
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
    'use strict';
    // TAB CLASS DEFINITION
    // ====================

    var Tab = function (element) {
        this.element = $(element)
    }

    Tab.VERSION = '3.2.0'

    Tab.prototype.show = function () {
        var $this = this.element
        var $ul = $this.closest('ul:not(.dropdown-menu)')
        var selector = $this.data('target')

        if (!selector) {
            selector = $this.attr('href')
            selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
        }

        if ($this.parent('li').hasClass('active'))
            return

        var previous = $ul.find('.active:last a')[0]
        var e = $.Event('show.bs.tab', {
            relatedTarget: previous
        })

        $this.trigger(e)

        if (e.isDefaultPrevented())
            return

        var $target = $(selector)

        this.activate($this.closest('li'), $ul)
        this.activate($target, $target.parent(), function () {
            $this.trigger({
                type: 'shown.bs.tab',
                relatedTarget: previous
            })
        })
    }

    Tab.prototype.activate = function (element, container, callback) {
        var $active = container.find('> .active')
        var transition = callback
                && $.support.transition
                && $active.hasClass('fade')

        function next() {
            $active
                    .removeClass('active')
                    .find('> .dropdown-menu > .active')
                    .removeClass('active')

            element.addClass('active')

            if (transition) {
                element[0].offsetWidth // reflow for transition
                element.addClass('in')
            } else {
                element.removeClass('fade')
            }

            if (element.parent('.dropdown-menu')) {
                element.closest('li.dropdown').addClass('active')
            }

            callback && callback()
        }

        transition ?
                $active
                .one('bsTransitionEnd', next)
                .emulateTransitionEnd(150) :
                next()

        $active.removeClass('in')
    }


// TAB PLUGIN DEFINITION
// =====================

    function Plugin(option) {
        return this.each(function () {
            var $this = $(this)
            var data = $this.data('bs.tab')

            if (!data)
                $this.data('bs.tab', (data = new Tab(this)))
            if (typeof option == 'string')
                data[option]()
        })
    }

    var old = $.fn.tab

    $.fn.tab = Plugin
    $.fn.tab.Constructor = Tab


    // TAB NO CONFLICT
    // ===============

    $.fn.tab.noConflict = function () {
        $.fn.tab = old
        return this
    }


// TAB DATA-API
// ============

    $(document).on('click', '.tab .nav-tabs li a', function (e) {
        e.preventDefault();
        Plugin.call($(this), 'show');
    })

}(jQuery);
+function ($) {
    'use strict';
    // DROPDOWN CLASS DEFINITION
    // =========================

    var backdrop = '.dropdown-backdrop'
    var toggle = '[data-toggle="dropdown"]'
    var Dropdown = function (element) {
        $(element).on('click.bs.dropdown', this.toggle)
    }

    Dropdown.VERSION = '3.2.0'

    Dropdown.prototype.toggle = function (e) {
        var $this = $(this)

        if ($this.is('.disabled, :disabled'))
            return

        var $parent = getParent($this)
        var isActive = $parent.hasClass('open')

        clearMenus()

        if (!isActive) {
            if ('ontouchstart' in document.documentElement && !$parent.closest('.navbar-nav').length) {
                // if mobile we use a backdrop because click events don't delegate
                $('<div class="dropdown-backdrop"/>').insertAfter($(this)).on('click', clearMenus)
            }

            var relatedTarget = {relatedTarget: this}
            $parent.trigger(e = $.Event('show.bs.dropdown', relatedTarget))

            if (e.isDefaultPrevented())
                return

            $this.trigger('focus')

            $parent
                    .toggleClass('open')
                    .trigger('shown.bs.dropdown', relatedTarget)
        }

        return false
    }

    Dropdown.prototype.keydown = function (e) {
        if (!/(38|40|27)/.test(e.keyCode))
            return

        var $this = $(this)

        e.preventDefault()
        e.stopPropagation()

        if ($this.is('.disabled, :disabled'))
            return

        var $parent = getParent($this)
        var isActive = $parent.hasClass('open')

        if (!isActive || (isActive && e.keyCode == 27)) {
            if (e.which == 27)
                $parent.find(toggle).trigger('focus')
            return $this.trigger('click')
        }

        var desc = ' li:not(.divider):visible a'
        var $items = $parent.find('[role="menu"]' + desc + ', [role="listbox"]' + desc)

        if (!$items.length)
            return

        var index = $items.index($items.filter(':focus'))

        if (e.keyCode == 38 && index > 0)
            index--                        // up
        if (e.keyCode == 40 && index < $items.length - 1)
            index++                        // down
        if (!~index)
            index = 0

        $items.eq(index).trigger('focus')
    }

    function clearMenus(e) {
        if (e && e.which === 3)
            return
        $(backdrop).remove()
        $(toggle).each(function () {
            var $parent = getParent($(this))
            var relatedTarget = {relatedTarget: this}
            if (!$parent.hasClass('open'))
                return
            $parent.trigger(e = $.Event('hide.bs.dropdown', relatedTarget))
            if (e.isDefaultPrevented())
                return
            $parent.removeClass('open').trigger('hidden.bs.dropdown', relatedTarget)
        })
    }

    function getParent($this) {
        var selector = $this.attr('data-target')

        if (!selector) {
            selector = $this.attr('href')
            selector = selector && /#[A-Za-z]/.test(selector) && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
        }

        var $parent = selector && $(selector)

        return $parent && $parent.length ? $parent : $this.parent()
    }


    // DROPDOWN PLUGIN DEFINITION
    // ==========================

    function Plugin(option) {
        return this.each(function () {
            var $this = $(this)
            var data = $this.data('bs.dropdown')

            if (!data)
                $this.data('bs.dropdown', (data = new Dropdown(this)))
            if (typeof option == 'string')
                data[option].call($this)
        })
    }

    var old = $.fn.dropdown

    $.fn.dropdown = Plugin
    $.fn.dropdown.Constructor = Dropdown


    // DROPDOWN NO CONFLICT
    // ====================

    $.fn.dropdown.noConflict = function () {
        $.fn.dropdown = old
        return this
    }


    // APPLY TO STANDARD DROPDOWN ELEMENTS
    // ===================================

    $(document)
            .on('click.bs.dropdown.data-api', clearMenus)
            .on('click.bs.dropdown.data-api', '.dropdown form', function (e) {
                e.stopPropagation()
            })
            .on('click.bs.dropdown.data-api', toggle, Dropdown.prototype.toggle)
            .on('keydown.bs.dropdown.data-api', toggle + ', [role="menu"], [role="listbox"]', Dropdown.prototype.keydown)

}(jQuery);
/*!
 * Lazy Load - jQuery plugin for lazy loading images
 *
 * Copyright (c) 2007-2015 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/lazyload
 *
 * Version:  1.9.7
 *
 */

(function($, window, document, undefined) {
    var $window = $(window);

    $.fn.lazyload = function(options) {
        var elements = this;
        var $container;
        var settings = {
            threshold       : 0,
            failure_limit   : 0,
            event           : "scroll",
            effect          : "show",
            container       : window,
            data_attribute  : "original",
            skip_invisible  : false,
            appear          : null,
            load            : null,
            placeholder     : "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
        };

        function update() {
            var counter = 0;

            elements.each(function() {
                var $this = $(this);
                if (settings.skip_invisible && !$this.is(":visible")) {
                    return;
                }
                if ($.abovethetop(this, settings) ||
                    $.leftofbegin(this, settings)) {
                        /* Nothing. */
                } else if (!$.belowthefold(this, settings) &&
                    !$.rightoffold(this, settings)) {
                        $this.trigger("appear");
                        /* if we found an image we'll load, reset the counter */
                        counter = 0;
                } else {
                    if (++counter > settings.failure_limit) {
                        return false;
                    }
                }
            });

        }

        if(options) {
            /* Maintain BC for a couple of versions. */
            if (undefined !== options.failurelimit) {
                options.failure_limit = options.failurelimit;
                delete options.failurelimit;
            }
            if (undefined !== options.effectspeed) {
                options.effect_speed = options.effectspeed;
                delete options.effectspeed;
            }

            $.extend(settings, options);
        }

        /* Cache container as jQuery as object. */
        $container = (settings.container === undefined ||
                      settings.container === window) ? $window : $(settings.container);

        /* Fire one scroll event per scroll. Not one scroll event per image. */
        if (0 === settings.event.indexOf("scroll")) {
            $container.on(settings.event, function() {
                return update();
            });
        }

        this.each(function() {
            var self = this;
            var $self = $(self);

            self.loaded = false;

            /* If no src attribute given use data:uri. */
            if ($self.attr("src") === undefined || $self.attr("src") === false) {
                if ($self.is("img")) {
                    $self.attr("src", settings.placeholder);
                }
            }

            /* When appear is triggered load original image. */
            $self.one("appear", function() {
                if (!this.loaded) {
                    if (settings.appear) {
                        var elements_left = elements.length;
                        settings.appear.call(self, elements_left, settings);
                    }
                    $("<img />")
                        .one("load", function() {
                            var original = $self.attr("data-" + settings.data_attribute);
                            $self.hide();
                            if ($self.is("img")) {
                                $self.attr("src", original);
                            } else {
                                $self.css("background-image", "url('" + original + "')");
                            }
                            $self[settings.effect](settings.effect_speed);

                            self.loaded = true;

                            /* Remove image from array so it is not looped next time. */
                            var temp = $.grep(elements, function(element) {
                                return !element.loaded;
                            });
                            elements = $(temp);

                            if (settings.load) {
                                var elements_left = elements.length;
                                settings.load.call(self, elements_left, settings);
                            }
                        })
                        .attr("src", $self.attr("data-" + settings.data_attribute));
                }
            });

            /* When wanted event is triggered load original image */
            /* by triggering appear.                              */
            if (0 !== settings.event.indexOf("scroll")) {
                $self.on(settings.event, function() {
                    if (!self.loaded) {
                        $self.trigger("appear");
                    }
                });
            }
        });

        /* Check if something appears when window is resized. */
        $window.on("resize", function() {
            update();
        });

        /* With IOS5 force loading images when navigating with back button. */
        /* Non optimal workaround. */
        if ((/(?:iphone|ipod|ipad).*os 5/gi).test(navigator.appVersion)) {
            $window.on("pageshow", function(event) {
                if (event.originalEvent && event.originalEvent.persisted) {
                    elements.each(function() {
                        $(this).trigger("appear");
                    });
                }
            });
        }

        /* Force initial check if images should appear. */
        $(document).ready(function() {
            update();
        });

        return this;
    };

    /* Convenience methods in jQuery namespace.           */
    /* Use as  $.belowthefold(element, {threshold : 100, container : window}) */

    $.belowthefold = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = (window.innerHeight ? window.innerHeight : $window.height()) + $window.scrollTop();
        } else {
            fold = $(settings.container).offset().top + $(settings.container).height();
        }

        return fold <= $(element).offset().top - settings.threshold;
    };

    $.rightoffold = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = $window.width() + $window.scrollLeft();
        } else {
            fold = $(settings.container).offset().left + $(settings.container).width();
        }

        return fold <= $(element).offset().left - settings.threshold;
    };

    $.abovethetop = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = $window.scrollTop();
        } else {
            fold = $(settings.container).offset().top;
        }

        return fold >= $(element).offset().top + settings.threshold  + $(element).height();
    };

    $.leftofbegin = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = $window.scrollLeft();
        } else {
            fold = $(settings.container).offset().left;
        }

        return fold >= $(element).offset().left + settings.threshold + $(element).width();
    };

    $.inviewport = function(element, settings) {
         return !$.rightoffold(element, settings) && !$.leftofbegin(element, settings) &&
                !$.belowthefold(element, settings) && !$.abovethetop(element, settings);
     };

    /* Custom selectors for your convenience.   */
    /* Use as $("img:below-the-fold").something() or */
    /* $("img").filter(":below-the-fold").something() which is faster */

    $.extend($.expr[":"], {
        "below-the-fold" : function(a) { return $.belowthefold(a, {threshold : 0}); },
        "above-the-top"  : function(a) { return !$.belowthefold(a, {threshold : 0}); },
        "right-of-screen": function(a) { return $.rightoffold(a, {threshold : 0}); },
        "left-of-screen" : function(a) { return !$.rightoffold(a, {threshold : 0}); },
        "in-viewport"    : function(a) { return $.inviewport(a, {threshold : 0}); },
        /* Maintain BC for couple of versions. */
        "above-the-fold" : function(a) { return !$.belowthefold(a, {threshold : 0}); },
        "right-of-fold"  : function(a) { return $.rightoffold(a, {threshold : 0}); },
        "left-of-fold"   : function(a) { return !$.rightoffold(a, {threshold : 0}); }
    });

})(jQuery, window, document);
(function ($) {
    $.fn.LoPopUp = function (options) {
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
                setTimeout(function () {
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
        setTimeout(function () {
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
    $('.LOpopup').each(function () {
        $(this).hide();
    });
}
function createPopup(options) {
    if (options.popupId == '')
        return false;
    $('#IDLOpopup').clone().attr('id', options.popupId).after('#IDLOpopup');
    $("#" + settings.popupId).LoPopUp(options);
}

//
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
        });
        $('#objloading').fadeTo("fast", 1);
    }
    return false;
}
//Ẩn loading
function w3HideLoading() {
    jQuery('#objloading').fadeTo("slow", 0, function () {
        $(this).hide();
    });
}
//
jQuery(document).on('submit', '.w3f-form', function () {
    var thi = $(this);
    if (thi.hasClass('disable'))
        return false;
    thi.addClass('disable');
    //
    var info = $(this).serialize();
    var href = $(this).attr('action');
    if (href) {
        jQuery.ajax({
            url: href,
            type: 'POST',
            dataType: 'JSON',
            data: info,
            success: function (res) {
                switch (res.code) {
                    case 200:
                        {
                            if (res.redirect)
                                window.location.href = res.redirect;
                            else
                                window.location.href = window.location.href;
                        }
                        break;
                    default:
                        {
                            if (res.errors) {
                                parseJsonErrors(res.errors, thi);
                            }
                        }
                        break;
                }
                thi.removeClass('disable');
            },
            error: function () {
                thi.removeClass('disable');
            }
        });
    } else
        thi.removeClass('disable');
    return false;
});
function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

//
function updateCountCart(count, products) {
    if (!count)
        return false;
    if (isNumber(count)) {
        jQuery('.countCart').html(count);
        jQuery('.countCart').show();
        jQuery('.countCart').removeClass('shake');
        setTimeout(function () {
            jQuery('.countCart').addClass('shake');
        }, 200);
    }
    if (isNumber(products)) {
        var element = '.countProduct';
        if (jQuery('.cart-quantity').length)
            element = '.cart-quantity';
        jQuery(element).html(products);
        jQuery(element).show();
        jQuery(element).removeClass('shake');
        setTimeout(function () {
            jQuery(element).addClass('shake');
        }, 200);
    }
}

jQuery(document).ready(function () {
//
    var containerout = jQuery('.container-out');
    if (containerout.length) {
        var container_width = parseInt(jQuery('.container:first').outerWidth());
        if (container_width) {
            var body_width = jQuery('body').innerWidth();
            var containerout_width = (body_width - container_width) / 2;
            if (containerout_width > 10) {
                containerout.css({'width': containerout_width});
            } else {
                containerout.css({'display': 'none'});
            }
        }
    }
// product detail
    if (jQuery('.product-detail .product-detail-img').length) {
        if (jQuery('.product-detail .product-detail-img').hasClass('mobile')) {
            var windowHeight = jQuery(window).height();
            console.log()
            $(".product-detail .product-detail-img a.product-img-large").colorbox({rel: 'product-img-large', innerHeight: windowHeight - 20, innerWidth: '100%'});
            $(".product-detail .product-detail-img a.product-img-small").colorbox({rel: 'product-img-small', innerHeight: windowHeight - 20, innerWidth: '100%'});
        } else {
            $(".product-detail .product-detail-img a.product-img-large").colorbox({rel: 'product-img-large', innerHeight: 600, innerWidth: 800});
            $(".product-detail .product-detail-img a.product-img-small").colorbox({rel: 'product-img-small', innerHeight: 600, innerWidth: 800});
        }
        jQuery('.product-detail .product-detail-img a.product-img-small').on('mouseover', function () {
            thumb_img_w = (typeof thumb_img_w != 'undefined') ? thumb_img_w : 330;
            thumb_img_h = (typeof thumb_img_h != 'undefined') ? thumb_img_h : 330;
            var href = jQuery(this).attr('href');
            var src = jQuery(this).find('img').attr('src');
            var thumb = jQuery(this).find('img').attr('data-thumb-image');
            if (href) {
                var clo = jQuery(this).closest('.product-detail-img');
                clo.find('.product-img-main a.product-img-large').attr('href', href);
                if (!thumb)
                    clo.find('.product-img-main a.product-img-large img').attr('src', src.replace('\/s50_50\/', '\/s' + thumb_img_w + '_' + thumb_img_h + '\/'));
                else
                    clo.find('.product-img-main a.product-img-large img').attr('src', thumb);
            }
            return false;
        });
    }
// add to cart
    jQuery('.addtocart').on('click', function () {
        var thi = jQuery(this);
        var url = thi.attr('href');
        if (!url)
            url = thi.attr('src');
        if (!url)
            return false;
        var data_params = thi.attr('data-params');
        var data = '';
        /**
         * get all data input
         */
        if (data_params) {
            var data_params_object = jQuery(data_params);
            //
            if (data_params_object.find('.product-attr').length) {
                var check = true;
                var text = '';
                data_params_object.find('.product-attr').each(function () {
                    if (!$(this).find('.attrConfig-input').val()) {
                        check = false;
                        if (!text)
                            text = $(this).attr('attr-title');
                        else
                            text += ', ' + $(this).attr('attr-title');
                    }
                });
                if (!check) {
                    var attrError = data_params_object.find('.product-attr-error');
                    attrError.show();
                    attrError.find('b').html(text);
                    return false;
                } else
                    data_params_object.find('.product-attr-error').hide();
            }
//
            if (data_params_object.length) {
                data = data_params_object.find('input,select,textarea').serialize();
            }
        }
        jQuery.ajax({
            type: 'post',
            url: url,
            data: data,
            dataType: "JSON",
            beforeSend: function () {
                w3ShowLoading(thi, 'right', 15, 0);
            },
            success: function (res) {
                if (res.code == '200') {
                    updateCountCart(res.total, res.products);
                    if (thi.hasClass('refreshcart')) {
                        $('.cart').append(res.cart);
                    } else if (!thi.hasClass('noredirect') && res.redirect) {
                        window.location.href = res.redirect;
                    } else {
                        if (res.cart && res.cartTitle) {
                            $(document).LoPopUp({
                                title: res.cartTitle,
                                clearBefore: true,
                                clearAfter: true,
                                maxwidth: '800px',
                                minwidth: '800px',
                                maxheight: '600px',
                                top: '100px',
                                contentHtml: res.cart
                            });
                            $(".LOpopup").show();
                        }
                    }
                }
                w3HideLoading();
            },
            error: function () {
                w3HideLoading();
                return false;
            }
        });
        return false;
    });
    //
    jQuery(document).on('mouseover', '.get-product-detail', function () {
        var thi = jQuery(this);
        //
        var attributes = thi.getAttributes();
        //
        var url = attributes.href;
        if (!url)
            url = attributes.src;
        if (!url)
            return false;
        var target = attributes['target-detail'];
        if (!target || !thi.find(target).length)
            return false;
        if ($.trim(thi.find(target).html()) != '')
            return false;
        //
        if (thi.hasClass('block'))
            return false;
        thi.addClass('block');
        //
        jQuery.ajax({
            type: 'post',
            data: {'attributes': JSON.stringify(attributes)},
            url: url,
            dataType: "JSON",
            beforeSend: function () {
                if (attributes['show-loading'] != 'false')
                    w3ShowLoading(thi, 'right', 0, 0);
            },
            success: function (res) {
                if (res.code == '200') {
                    if (res.html)
                        thi.find(target).html(res.html);
                }
                w3HideLoading();
                thi.removeClass('block');
            },
            error: function () {
                w3HideLoading();
                thi.removeClass('block');
                return false;
            }
        });
        return false;
    });
    //
});
// get all attribute of element
(function ($) {
    $.fn.getAttributes = function () {
        var attributes = {};
        if (this.length) {
            $.each(this[0].attributes, function (index, attr) {
                attributes[ attr.name ] = attr.value;
            });
        }
        return attributes;
    };
})(jQuery);
// print element
(function ($) {
    var opt;
    $.fn.printThis = function (options) {
        opt = $.extend({}, $.fn.printThis.defaults, options);
        var $element = this instanceof jQuery ? this : $(this);
        var strFrameName = "printThis-" + (new Date()).getTime();
        if (window.location.hostname !== document.domain && navigator.userAgent.match(/msie/i)) {
            // Ugly IE hacks due to IE not inheriting document.domain from parent
            // checks if document.domain is set by comparing the host name against document.domain
            var iframeSrc = "javascript:document.write(\"<head><script>document.domain=\\\"" + document.domain + "\\\";</script></head><body></body>\")";
            var printI = document.createElement('iframe');
            printI.name = "printIframe";
            printI.id = strFrameName;
            printI.className = "MSIE";
            document.body.appendChild(printI);
            printI.src = iframeSrc;
        } else {
            // other browsers inherit document.domain, and IE works if document.domain is not explicitly set
            var $frame = $("<iframe id='" + strFrameName + "' name='printIframe' />");
            $frame.appendTo("body");
        }
        var $iframe = $("#" + strFrameName);
        // show frame if in debug mode
        if (!opt.debug)
            $iframe.css({
                position: "absolute",
                width: "0px",
                height: "0px",
                left: "-600px",
                top: "-600px"
            });
        // $iframe.ready() and $iframe.load were inconsistent between browsers    
        setTimeout(function () {
            var $doc = $iframe.contents(),
                    $head = $doc.find("head"),
                    $body = $doc.find("body");
            // add base tag to ensure elements use the parent domain
            $head.append('<base href="' + document.location.protocol + '//' + document.location.host + '">');
            // import page stylesheets
            if (opt.importCSS)
                $("link[rel=stylesheet]").each(function () {
                    var href = $(this).attr("href");
                    if (href) {
                        var media = $(this).attr("media") || "all";
                        $head.append("<link type='text/css' rel='stylesheet' href='" + href + "' media='" + media + "'>")
                    }
                });
            // import style tags
            if (opt.importStyle)
                $("style").each(function () {
                    $(this).clone().appendTo($head);
                    //$head.append($(this));
                });
            //add title of the page
            if (opt.pageTitle)
                $head.append("<title>" + opt.pageTitle + "</title>");
            // import additional stylesheet(s)
            if (opt.loadCSS) {
                if ($.isArray(opt.loadCSS)) {
                    jQuery.each(opt.loadCSS, function (index, value) {
                        $head.append("<link type='text/css' rel='stylesheet' href='" + this + "'>");
                    });
                } else {
                    $head.append("<link type='text/css' rel='stylesheet' href='" + opt.loadCSS + "'>");
                }
            }
            // print header
            if (opt.header)
                $body.append(opt.header);
            // grab $.selector as container
            if (opt.printContainer)
                $body.append($element.outer());
            // otherwise just print interior elements of container
            else
                $element.each(function () {
                    $body.append($(this).html());
                });
            // capture form/field values
            if (opt.formValues) {
                // loop through inputs
                var $input = $element.find('input');
                if ($input.length) {
                    $input.each(function () {
                        var $this = $(this),
                                $name = $(this).attr('name'),
                                $checker = $this.is(':checkbox') || $this.is(':radio'),
                                $iframeInput = $doc.find('input[name="' + $name + '"]'),
                                $value = $this.val();
                        //order matters here
                        if (!$checker) {
                            $iframeInput.val($value);
                        } else if ($this.is(':checked')) {
                            if ($this.is(':checkbox')) {
                                $iframeInput.attr('checked', 'checked');
                            } else if ($this.is(':radio')) {
                                $doc.find('input[name="' + $name + '"][value=' + $value + ']').attr('checked', 'checked');
                            }
                        }

                    });
                }
                //loop through selects
                var $select = $element.find('select');
                if ($select.length) {
                    $select.each(function () {
                        var $this = $(this),
                                $name = $(this).attr('name'),
                                $value = $this.val();
                        $doc.find('select[name="' + $name + '"]').val($value);
                    });
                }

                //loop through textareas
                var $textarea = $element.find('textarea');
                if ($textarea.length) {
                    $textarea.each(function () {
                        var $this = $(this),
                                $name = $(this).attr('name'),
                                $value = $this.val();
                        $doc.find('textarea[name="' + $name + '"]').val($value);
                    });
                }
            } // end capture form/field values
            // remove inline styles
            if (opt.removeInline) {
                // $.removeAttr available jQuery 1.7+
                if ($.isFunction($.removeAttr)) {
                    $doc.find("body *").removeAttr("style");
                } else {
                    $doc.find("body *").attr("style", "");
                }
            }
            setTimeout(function () {
                if ($iframe.hasClass("MSIE")) {
                    // check if the iframe was created with the ugly hack
                    // and perform another ugly hack out of neccessity
                    window.frames["printIframe"].focus();
                    $head.append("<script>  window.print(); </script>");
                } else {
                    // proper method
                    $iframe[0].contentWindow.focus();
                    $iframe[0].contentWindow.print();
                }
                //remove iframe after print
                if (!opt.debug) {
                    setTimeout(function () {
                        $iframe.remove();
                    }, 1000);
                }
            }, opt.printDelay);
        }, 333);
    };
    // defaults
    $.fn.printThis.defaults = {
        debug: false, // show the iframe for debugging
        importCSS: true, // import parent page css
        importStyle: false, // import style tags
        printContainer: true, // print outer container/$.selector
        loadCSS: "", // load an additional css file - load multiple stylesheets with an array []
        pageTitle: "", // add title to print page
        removeInline: false, // remove all inline styles
        printDelay: 333, // variable print delay
        header: null, // prefix to html
        formValues: true        // preserve input/form values
    };
    // $.selector container
    jQuery.fn.outer = function () {
        return $($("<div></div>").html(this.clone())).html();
    };
    // load Image
    if (typeof noImageUrl === 'undefined' || !noImageUrl) {
        var noImageUrl = "/images/no-image.png";
    }
    jQuery("img").error(function () {
        jQuery(this).attr("data-src", jQuery(this).attr("src"));
        jQuery(this).attr("src", noImageUrl);
    });

    if (typeof lazyLoadClass === 'undefined' || !lazyLoadClass) {
        var lazyLoadClass = 'imglazyload';
    }
    if (typeof lazyLoadTimeOut === 'undefined' || !lazyLoadTimeOut) {
        var lazyLoadTimeOut = 200;
    }
    if (typeof lazyLoadRefer === 'undefined' || !lazyLoadRefer) {
        var lazyLoadRefer = 'src';
    }
    if (typeof lazyLoadOrigin === 'undefined' || !lazyLoadOrigin) {
        var lazyLoadOrigin = 'data-original';
    }
//    var lazyT = setInterval(function () {
//        res = lazyLoad();
//        if(!res){
//            clearInterval(lazyT);
//        }
//    }, lazyLoadTimeOut);
    //
    function lazyLoad(){
        var result = false;
        jQuery('.'+lazyLoadClass).each(function (index, element) {
            var original = jQuery(element).attr(lazyLoadOrigin);
            if (original) {
                jQuery(element).attr(lazyLoadRefer, original);
            }
            jQuery(element).removeClass(lazyLoadClass);
            result = true;
            return false;
        });
        return result;
    }
    //
    if(jQuery('img.'+lazyLoadClass).length){
        jQuery('img.'+lazyLoadClass).lazyload();
    }
})(jQuery);

var w3nPublic = {};
w3nPublic.NotFollowViewSource = function () {
    w3nPublic.disableRightClick();
    w3nPublic.disableViewSource();
};
/**
 * disable right click
 * @returns {undefined}
 */
w3nPublic.disableRightClick = function () {
    $(document).mousedown(function (e) {
        if (e.button == 2) {
            return false;
        }
    });
    $(document).on("contextmenu", function (e) {
        e.preventDefault();
        return false;
    });
};
/**
 * disable ctrl + u and F12
 * @returns {undefined}
 */
w3nPublic.disableViewSource = function () {
    $(document).on('keydown', function (e) {
        var ctrlKey = e.ctrlKey || e.metaKey;
        var keyCode = e.keyCode || e.which;
        // ctrl+u and f12
        if ((ctrlKey && keyCode == 85) || keyCode == 123) {
            e.preventDefault();
            return false;
        }

    });
};
/**
 * add param to url
 * @param {type} url
 * @param {type} key
 * @param {type} value
 * @returns {String}
 */
w3nPublic.addParamToUrl = function (url, key, value) {
    var sep = (url.indexOf('?') > -1) ? '&' : '?';
    return url + sep + key + '=' + value;
};
