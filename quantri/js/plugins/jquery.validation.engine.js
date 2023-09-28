/*
 * Inline Form Validation Engine 2.6.2, jQuery plugin
 *
 * Copyright(c) 2010, Cedric Dugas
 * http://www.position-absolute.com
 *
 * 2.0 Rewrite by Olivier Refalo
 * http://www.crionics.com
 *
 * Form validation engine allowing custom regex rules to be added.
 * Licensed under the MIT License
 */
 (function(b){var a={init:function(c){var d=this;if(!d.data("jqv")||d.data("jqv")==null){c=a._saveOptions(d,c);b(".formError").live("click",function(){b(this).fadeOut(150,function(){b(this).parent(".formErrorOuter").remove();b(this).remove()})})}return this},attach:function(e){var d=this;var c;if(e){c=a._saveOptions(d,e)}else{c=d.data("jqv")}c.validateAttribute=(d.find("[data-validation-engine*=validate]").length)?"data-validation-engine":"class";if(c.binded){d.on(c.validationEventTrigger,"["+c.validateAttribute+"*=validate]:not([type=checkbox]):not([type=radio]):not(.datepicker)",a._onFieldEvent);d.on("click","["+c.validateAttribute+"*=validate][type=checkbox],["+c.validateAttribute+"*=validate][type=radio]",a._onFieldEvent);d.on(c.validationEventTrigger,"["+c.validateAttribute+"*=validate][class*=datepicker]",{delay:300},a._onFieldEvent)}if(c.autoPositionUpdate){b(window).bind("resize",{noAnimation:true,formElem:d},a.updatePromptsPosition)}d.on("click","a[data-validation-engine-skip], a[class*='validate-skip'], button[data-validation-engine-skip], button[class*='validate-skip'], input[data-validation-engine-skip], input[class*='validate-skip']",a._submitButtonClick);d.removeData("jqv_submitButton");d.on("submit",a._onSubmitEvent);return this},detach:function(){var d=this;var c=d.data("jqv");d.find("["+c.validateAttribute+"*=validate]").not("[type=checkbox]").off(c.validationEventTrigger,a._onFieldEvent);d.find("["+c.validateAttribute+"*=validate][type=checkbox],[class*=validate][type=radio]").off("click",a._onFieldEvent);d.off("submit",a.onAjaxFormComplete);d.die("submit",a.onAjaxFormComplete);d.removeData("jqv");d.off("click","a[data-validation-engine-skip], a[class*='validate-skip'], button[data-validation-engine-skip], button[class*='validate-skip'], input[data-validation-engine-skip], input[class*='validate-skip']",a._submitButtonClick);d.removeData("jqv_submitButton");if(c.autoPositionUpdate){b(window).unbind("resize",a.updatePromptsPosition)}return this},validate:function(){var d=b(this);var f=null;if((d.is("form")||d.hasClass("validationEngineContainer"))&&!d.hasClass("validating")){d.addClass("validating");var c=d.data("jqv");var f=a._validateFields(this);setTimeout(function(){d.removeClass("validating")},100);if(f&&c.onSuccess){c.onSuccess()}else{if(!f&&c.onFailure){c.onFailure()}}}else{if(d.is("form")||d.hasClass("validationEngineContainer")){d.removeClass("validating")}else{var e=d.closest("form, .validationEngineContainer"),c=(e.data("jqv"))?e.data("jqv"):b.validationEngine.defaults,f=a._validateField(d,c);if(f&&c.onFieldSuccess){c.onFieldSuccess()}else{if(c.onFieldFailure&&c.InvalidFields.length>0){c.onFieldFailure()}}}}if(c.onValidationComplete){return !!c.onValidationComplete(e,f)}return f},updatePromptsPosition:function(f){if(f&&this==window){var e=f.data.formElem;var c=f.data.noAnimation}else{var e=b(this.closest("form, .validationEngineContainer"))}var d=e.data("jqv");e.find("["+d.validateAttribute+"*=validate]").not(":disabled").each(function(){var i=b(this);if(d.prettySelect&&i.is(":hidden")){i=e.find("#"+d.usePrefix+i.attr("id")+d.useSuffix)}var g=a._getPrompt(i);var h=b(g).find(".formErrorContent").html();if(g){a._updatePrompt(i,b(g),h,undefined,false,d,c)}});return this},showPrompt:function(d,f,h,e){var g=this.closest("form, .validationEngineContainer");var c=g.data("jqv");if(!c){c=a._saveOptions(this,c)}if(h){c.promptPosition=h}c.showArrow=e==true;a._showPrompt(this,d,f,false,c);return this},hide:function(){var f=b(this).closest("form, .validationEngineContainer");var d=f.data("jqv");var e=(d&&d.fadeDuration)?d.fadeDuration:0.3;var c;if(b(this).is("form")||b(this).hasClass("validationEngineContainer")){c="parentForm"+a._getClassName(b(this).attr("id"))}else{c=a._getClassName(b(this).attr("id"))+"formError"}b("."+c).fadeTo(e,0.3,function(){b(this).parent(".formErrorOuter").remove();b(this).remove()});return this},hideAll:function(){var d=this;var c=d.data("jqv");var e=c?c.fadeDuration:300;b(".formError").fadeTo(e,300,function(){b(this).parent(".formErrorOuter").remove();b(this).remove()});return this},_onFieldEvent:function(e){var f=b(this);var d=f.closest("form, .validationEngineContainer");var c=d.data("jqv");c.eventTrigger="field";window.setTimeout(function(){a._validateField(f,c);if(c.InvalidFields.length==0&&c.onFieldSuccess){c.onFieldSuccess()}else{if(c.InvalidFields.length>0&&c.onFieldFailure){c.onFieldFailure()}}},(e.data)?e.data.delay:0)},_onSubmitEvent:function(){var f=b(this);var c=f.data("jqv");if(f.data("jqv_submitButton")){var d=b("#"+f.data("jqv_submitButton"));if(d){if(d.length>0){if(d.hasClass("validate-skip")||d.attr("data-validation-engine-skip")=="true"){return true}}}}c.eventTrigger="submit";var e=a._validateFields(f);if(e&&c.ajaxFormValidation){a._validateFormWithAjax(f,c);return false}if(c.onValidationComplete){return !!c.onValidationComplete(f,e)}return e},_checkAjaxStatus:function(d){var c=true;b.each(d.ajaxValidCache,function(e,f){if(!f){c=false;return false}});return c},_checkAjaxFieldStatus:function(c,d){return d.ajaxValidCache[c]==true},_validateFields:function(e){var m=e.data("jqv");var f=false;e.trigger("jqv.form.validating");var n=null;e.find("["+m.validateAttribute+"*=validate]").not(":disabled").each(function(){var p=b(this);var o=[];if(b.inArray(p.attr("name"),o)<0){f|=a._validateField(p,m);if(f&&n==null){if(p.is(":hidden")&&m.prettySelect){n=p=e.find("#"+m.usePrefix+a._jqSelector(p.attr("id"))+m.useSuffix)}else{n=p}}if(m.doNotShowAllErrosOnSubmit){return false}o.push(p.attr("name"));if(m.showOneMessage==true&&f){return false}}});e.trigger("jqv.form.result",[f]);if(f){if(m.scroll){var l=n.offset().top;var h=n.offset().left;var j=m.promptPosition;if(typeof(j)=="string"&&j.indexOf(":")!=-1){j=j.substring(0,j.indexOf(":"))}if(j!="bottomRight"&&j!="bottomLeft"){var i=a._getPrompt(n);if(i){l=i.offset().top}}if(m.scrollOffset){l-=m.scrollOffset}if(m.isOverflown){var c=b(m.overflownDIV);if(!c.length){return false}var d=c.scrollTop();var g=-parseInt(c.offset().top);l+=d+g-5;var k=b(m.overflownDIV+":not(:animated)");k.animate({scrollTop:l},1100,function(){if(m.focusFirstField){n.focus()}})}else{b("html, body").animate({scrollTop:l},1100,function(){if(m.focusFirstField){n.focus()}});b("html, body").animate({scrollLeft:h},1100)}}else{if(m.focusFirstField){n.focus()}}return false}return true},_validateFormWithAjax:function(g,e){var h=g.serialize();var f=(e.ajaxFormValidationMethod)?e.ajaxFormValidationMethod:"GET";var d=(e.ajaxFormValidationURL)?e.ajaxFormValidationURL:g.attr("action");var c=(e.dataType)?e.dataType:"json";b.ajax({type:f,url:d,cache:false,dataType:c,data:h,form:g,methods:a,options:e,beforeSend:function(){return e.onBeforeAjaxFormValidation(g,e)},error:function(i,j){a._ajaxError(i,j)},success:function(n){if((c=="json")&&(n!==true)){var l=false;for(var m=0;m<n.length;m++){var o=n[m];var q=o[0];var k=b(b("#"+q)[0]);if(k.length==1){var p=o[2];if(o[1]==true){if(p==""||!p){a._closePrompt(k)}else{if(e.allrules[p]){var j=e.allrules[p].alertTextOk;if(j){p=j}}if(e.showPrompts){a._showPrompt(k,p,"pass",false,e,true)}}}else{l|=true;if(e.allrules[p]){var j=e.allrules[p].alertText;if(j){p=j}}if(e.showPrompts){a._showPrompt(k,p,"",false,e,true)}}}}e.onAjaxFormComplete(!l,g,n,e)}else{e.onAjaxFormComplete(true,g,n,e)}}})},_validateField:function(d,l,s){if(!d.attr("id")){d.attr("id","form-validation-field-"+b.validationEngine.fieldIdCounter);++b.validationEngine.fieldIdCounter}if(!l.validateNonVisibleFields&&(d.is(":hidden")&&!l.prettySelect||d.parent().is(":hidden"))){return false}var u=d.attr(l.validateAttribute);var z=/validate\[(.*)\]/.exec(u);if(!z){return false}var v=z[1];var r=v.split(/\[|,|\]/);var o=false;var j=d.attr("name");var h="";var y="";var t=false;var A=false;l.isError=false;l.showArrow=true;if(l.maxErrorsPerField>0){A=true}var e=b(d.closest("form, .validationEngineContainer"));for(var x=0;x<r.length;x++){r[x]=r[x].replace(" ","");if(r[x]===""){delete r[x]}}for(var x=0,n=0;x<r.length;x++){if(A&&n>=l.maxErrorsPerField){if(!t){var k=b.inArray("required",r);t=(k!=-1&&k>=x)}break}var g=undefined;switch(r[x]){case"required":t=true;g=a._getErrorMessage(e,d,r[x],r,x,l,a._required);break;case"custom":g=a._getErrorMessage(e,d,r[x],r,x,l,a._custom);break;case"groupRequired":var w="["+l.validateAttribute+"*="+r[x+1]+"]";var f=e.find(w).eq(0);if(f[0]!=d[0]){a._validateField(f,l,s);l.showArrow=true}g=a._getErrorMessage(e,d,r[x],r,x,l,a._groupRequired);if(g){t=true}l.showArrow=false;break;case"ajax":g=a._ajax(d,r,x,l);if(g){y="load"}break;case"minSize":g=a._getErrorMessage(e,d,r[x],r,x,l,a._minSize);break;case"maxSize":g=a._getErrorMessage(e,d,r[x],r,x,l,a._maxSize);break;case"min":g=a._getErrorMessage(e,d,r[x],r,x,l,a._min);break;case"max":g=a._getErrorMessage(e,d,r[x],r,x,l,a._max);break;case"past":g=a._getErrorMessage(e,d,r[x],r,x,l,a._past);break;case"future":g=a._getErrorMessage(e,d,r[x],r,x,l,a._future);break;case"dateRange":var w="["+l.validateAttribute+"*="+r[x+1]+"]";l.firstOfGroup=e.find(w).eq(0);l.secondOfGroup=e.find(w).eq(1);if(l.firstOfGroup[0].value||l.secondOfGroup[0].value){g=a._getErrorMessage(e,d,r[x],r,x,l,a._dateRange)}if(g){t=true}l.showArrow=false;break;case"dateTimeRange":var w="["+l.validateAttribute+"*="+r[x+1]+"]";l.firstOfGroup=e.find(w).eq(0);l.secondOfGroup=e.find(w).eq(1);if(l.firstOfGroup[0].value||l.secondOfGroup[0].value){g=a._getErrorMessage(e,d,r[x],r,x,l,a._dateTimeRange)}if(g){t=true}l.showArrow=false;break;case"maxCheckbox":d=b(e.find("input[name='"+j+"']"));g=a._getErrorMessage(e,d,r[x],r,x,l,a._maxCheckbox);break;case"minCheckbox":d=b(e.find("input[name='"+j+"']"));g=a._getErrorMessage(e,d,r[x],r,x,l,a._minCheckbox);break;case"equals":g=a._getErrorMessage(e,d,r[x],r,x,l,a._equals);break;case"funcCall":g=a._getErrorMessage(e,d,r[x],r,x,l,a._funcCall);break;case"creditCard":g=a._getErrorMessage(e,d,r[x],r,x,l,a._creditCard);break;case"condRequired":g=a._getErrorMessage(e,d,r[x],r,x,l,a._condRequired);if(g!==undefined){t=true}break;default:}var m=false;if(typeof g=="object"){switch(g.status){case"_break":m=true;break;case"_error":g=g.message;break;case"_error_no_prompt":return true;break;default:break}}if(m){break}if(typeof g=="string"){h+=g+"<br/>";l.isError=true;n++}}if(!t&&!(d.val())&&d.val().length<1){l.isError=false}var p=d.prop("type");var c=d.data("promptPosition")||l.promptPosition;if((p=="radio"||p=="checkbox")&&e.find("input[name='"+j+"']").size()>1){if(c==="inline"){d=b(e.find("input[name='"+j+"'][type!=hidden]:last"))}else{d=b(e.find("input[name='"+j+"'][type!=hidden]:first"))}l.showArrow=false}if(d.is(":hidden")&&l.prettySelect){d=e.find("#"+l.usePrefix+a._jqSelector(d.attr("id"))+l.useSuffix)}if(l.isError&&l.showPrompts){a._showPrompt(d,h,y,false,l)}else{if(!o){a._closePrompt(d)}}if(!o){d.trigger("jqv.field.result",[d,l.isError,h])}var q=b.inArray(d[0],l.InvalidFields);if(q==-1){if(l.isError){l.InvalidFields.push(d[0])}}else{if(!l.isError){l.InvalidFields.splice(q,1)}}a._handleStatusCssClasses(d,l);if(l.isError&&l.onFieldFailure){l.onFieldFailure(d)}if(!l.isError&&l.onFieldSuccess){l.onFieldSuccess(d)}return l.isError},_handleStatusCssClasses:function(d,c){if(c.addSuccessCssClassToField){d.removeClass(c.addSuccessCssClassToField)}if(c.addFailureCssClassToField){d.removeClass(c.addFailureCssClassToField)}if(c.addSuccessCssClassToField&&!c.isError){d.addClass(c.addSuccessCssClassToField)}if(c.addFailureCssClassToField&&c.isError){d.addClass(c.addFailureCssClassToField)}},_getErrorMessage:function(c,n,l,p,g,q,m){var j=jQuery.inArray(l,p);if(l==="custom"||l==="funcCall"){var o=p[j+1];l=l+"["+o+"]";delete (p[j])}var d=l;var e=(n.attr("data-validation-engine"))?n.attr("data-validation-engine"):n.attr("class");var h=e.split(" ");var k;if(l=="future"||l=="past"||l=="maxCheckbox"||l=="minCheckbox"){k=m(c,n,p,g,q)}else{k=m(n,p,g,q)}if(k!=undefined){var f=a._getCustomErrorMessage(b(n),h,d,q);if(f){k=f}}return k},_getCustomErrorMessage:function(j,e,h,l){var f=false;var d=a._validityProp[h];if(d!=undefined){f=j.attr("data-errormessage-"+d);if(f!=undefined){return f}}f=j.attr("data-errormessage");if(f!=undefined){return f}var c="#"+j.attr("id");if(typeof l.custom_error_messages[c]!="undefined"&&typeof l.custom_error_messages[c][h]!="undefined"){f=l.custom_error_messages[c][h]["message"]}else{if(e.length>0){for(var g=0;g<e.length&&e.length>0;g++){var k="."+e[g];if(typeof l.custom_error_messages[k]!="undefined"&&typeof l.custom_error_messages[k][h]!="undefined"){f=l.custom_error_messages[k][h]["message"];break}}}}if(!f&&typeof l.custom_error_messages[h]!="undefined"&&typeof l.custom_error_messages[h]["message"]!="undefined"){f=l.custom_error_messages[h]["message"]}return f},_validityProp:{required:"value-missing",custom:"custom-error",groupRequired:"value-missing",ajax:"custom-error",minSize:"range-underflow",maxSize:"range-overflow",min:"range-underflow",max:"range-overflow",past:"type-mismatch",future:"type-mismatch",dateRange:"type-mismatch",dateTimeRange:"type-mismatch",maxCheckbox:"range-overflow",minCheckbox:"range-underflow",equals:"pattern-mismatch",funcCall:"custom-error",creditCard:"pattern-mismatch",condRequired:"value-missing"},_required:function(h,k,f,m,g){switch(h.prop("type")){case"text":case"password":case"textarea":case"file":case"select-one":case"select-multiple":default:var l=b.trim(h.val());var e=b.trim(h.attr("data-validation-placeholder"));var j=b.trim(h.attr("placeholder"));if((!l)||(e&&l==e)||(j&&l==j)){return m.allrules[k[f]].alertText}break;case"radio":case"checkbox":if(g){if(!h.attr("checked")){return m.allrules[k[f]].alertTextCheckboxMultiple}break}var d=h.closest("form, .validationEngineContainer");var c=h.attr("name");if(d.find("input[name='"+c+"']:checked").size()==0){if(d.find("input[name='"+c+"']:visible").size()==1){return m.allrules[k[f]].alertTextCheckboxe}else{return m.allrules[k[f]].alertTextCheckboxMultiple}}break}},_groupRequired:function(f,h,d,c){var g="["+c.validateAttribute+"*="+h[d+1]+"]";var e=false;f.closest("form, .validationEngineContainer").find(g).each(function(){if(!a._required(b(this),h,d,c)){e=true;return false}});if(!e){return c.allrules[h[d]].alertText}},_custom:function(j,k,d,l){var c=k[d+1];var g=l.allrules[c];var h;if(!g){alert("jqv:custom rule not found - "+c);return}if(g.regex){var f=g.regex;if(!f){alert("jqv:custom regex not found - "+c);return}var e=new RegExp(f);if(!e.test(j.val())){return l.allrules[c].alertText}}else{if(g.func){h=g.func;if(typeof(h)!=="function"){alert("jqv:custom parameter 'function' is no function - "+c);return}if(!h(j,k,d,l)){return l.allrules[c].alertText}}else{alert("jqv:custom type not allowed "+c);return}}},_funcCall:function(j,k,d,c){var h=k[d+1];var f;if(h.indexOf(".")>-1){var g=h.split(".");var e=window;while(g.length){e=e[g.shift()]}f=e}else{f=window[h]||c.customFunctions[h]}if(typeof(f)=="function"){return f(j,k,d,c)}},_equals:function(f,g,e,d){var c=g[e+1];if(f.val()!=b("#"+c).val()){return d.allrules.equals.alertText}},_maxSize:function(h,j,f,e){var d=j[f+1];var c=h.val().length;if(c>d){var g=e.allrules.maxSize;return g.alertText+d+g.alertText2}},_minSize:function(h,j,f,d){var e=j[f+1];var c=h.val().length;if(c<e){var g=d.allrules.minSize;return g.alertText+e+g.alertText2}},_min:function(h,j,f,d){var e=parseFloat(j[f+1]);var c=parseFloat(h.val());if(c<e){var g=d.allrules.min;if(g.alertText2){return g.alertText+e+g.alertText2}return g.alertText+e}},_max:function(h,j,f,e){var d=parseFloat(j[f+1]);var c=parseFloat(h.val());if(c>d){var g=e.allrules.max;if(g.alertText2){return g.alertText+d+g.alertText2}return g.alertText+d}},_past:function(d,j,k,e,m){var c=k[e+1];var g=b(d.find("input[name='"+c.replace(/^#+/,"")+"']"));var f;if(c.toLowerCase()=="now"){f=new Date()}else{if(undefined!=g.val()){if(g.is(":disabled")){return}f=a._parseDate(g.val())}else{f=a._parseDate(c)}}var l=a._parseDate(j.val());if(l>f){var h=m.allrules.past;if(h.alertText2){return h.alertText+a._dateToString(f)+h.alertText2}return h.alertText+a._dateToString(f)}},_future:function(d,j,k,e,m){var c=k[e+1];var g=b(d.find("input[name='"+c.replace(/^#+/,"")+"']"));var f;if(c.toLowerCase()=="now"){f=new Date()}else{if(undefined!=g.val()){if(g.is(":disabled")){return}f=a._parseDate(g.val())}else{f=a._parseDate(c)}}var l=a._parseDate(j.val());if(l<f){var h=m.allrules.future;if(h.alertText2){return h.alertText+a._dateToString(f)+h.alertText2}return h.alertText+a._dateToString(f)}},_isDate:function(d){var c=new RegExp(/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(?:(?:0?[1-9]|1[0-2])(\/|-)(?:0?[1-9]|1\d|2[0-8]))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(0?2(\/|-)29)(\/|-)(?:(?:0[48]00|[13579][26]00|[2468][048]00)|(?:\d\d)?(?:0[48]|[2468][048]|[13579][26]))$/);return c.test(d)},_isDateTime:function(d){var c=new RegExp(/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1}$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^((1[012]|0?[1-9]){1}\/(0?[1-9]|[12][0-9]|3[01]){1}\/\d{2,4}\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1})$/);return c.test(d)},_dateCompare:function(d,c){return(new Date(d.toString())<new Date(c.toString()))},_dateRange:function(e,f,d,c){if((!c.firstOfGroup[0].value&&c.secondOfGroup[0].value)||(c.firstOfGroup[0].value&&!c.secondOfGroup[0].value)){return c.allrules[f[d]].alertText+c.allrules[f[d]].alertText2}if(!a._isDate(c.firstOfGroup[0].value)||!a._isDate(c.secondOfGroup[0].value)){return c.allrules[f[d]].alertText+c.allrules[f[d]].alertText2}if(!a._dateCompare(c.firstOfGroup[0].value,c.secondOfGroup[0].value)){return c.allrules[f[d]].alertText+c.allrules[f[d]].alertText2}},_dateTimeRange:function(e,f,d,c){if((!c.firstOfGroup[0].value&&c.secondOfGroup[0].value)||(c.firstOfGroup[0].value&&!c.secondOfGroup[0].value)){return c.allrules[f[d]].alertText+c.allrules[f[d]].alertText2}if(!a._isDateTime(c.firstOfGroup[0].value)||!a._isDateTime(c.secondOfGroup[0].value)){return c.allrules[f[d]].alertText+c.allrules[f[d]].alertText2}if(!a._dateCompare(c.firstOfGroup[0].value,c.secondOfGroup[0].value)){return c.allrules[f[d]].alertText+c.allrules[f[d]].alertText2}},_maxCheckbox:function(h,j,k,g,f){var d=k[g+1];var e=j.attr("name");var c=h.find("input[name='"+e+"']:checked").size();if(c>d){f.showArrow=false;if(f.allrules.maxCheckbox.alertText2){return f.allrules.maxCheckbox.alertText+" "+d+" "+f.allrules.maxCheckbox.alertText2}return f.allrules.maxCheckbox.alertText}},_minCheckbox:function(h,j,k,g,f){var d=k[g+1];var e=j.attr("name");var c=h.find("input[name='"+e+"']:checked").size();if(c<d){f.showArrow=false;return f.allrules.minCheckbox.alertText+" "+d+" "+f.allrules.minCheckbox.alertText2}},_creditCard:function(k,l,f,n){var d=false,m=k.val().replace(/ +/g,"").replace(/-+/g,"");var c=m.length;if(c>=14&&c<=16&&parseInt(m)>0){var g=0,f=c-1,j=1,h,e=new String();do{h=parseInt(m.charAt(f));e+=(j++%2==0)?h*2:h}while(--f>=0);for(f=0;f<e.length;f++){g+=parseInt(e.charAt(f))}d=g%10==0}if(!d){return n.allrules.creditCard.alertText}},_ajax:function(o,r,j,s){var q=r[j+1];var n=s.allrules[q];var e=n.extraData;var l=n.extraDataDynamic;var h={fieldId:o.attr("id"),fieldValue:o.val()};if(typeof e==="object"){b.extend(h,e)}else{if(typeof e==="string"){var k=e.split("&");for(var j=0;j<k.length;j++){var p=k[j].split("=");if(p[0]&&p[0]){h[p[0]]=p[1]}}}}if(l){var g=[];var m=String(l).split(",");for(var j=0;j<m.length;j++){var c=m[j];if(b(c).length){var d=o.closest("form, .validationEngineContainer").find(c).val();var f=c.replace("#","")+"="+escape(d);h[c.replace("#","")]=d}}}if(s.eventTrigger=="field"){delete (s.ajaxValidCache[o.attr("id")])}if(!s.isError&&!a._checkAjaxFieldStatus(o.attr("id"),s)){b.ajax({type:s.ajaxFormValidationMethod,url:n.url,cache:false,dataType:"json",data:h,field:o,rule:n,methods:a,options:s,beforeSend:function(){},error:function(i,t){a._ajaxError(i,t)},success:function(v){var x=v[0];var u=b("#"+x).eq(0);if(u.length==1){var t=v[1];var w=v[2];if(!t){s.ajaxValidCache[x]=false;s.isError=true;if(w){if(s.allrules[w]){var i=s.allrules[w].alertText;if(i){w=i}}}else{w=n.alertText}if(s.showPrompts){a._showPrompt(u,w,"",true,s)}}else{s.ajaxValidCache[x]=true;if(w){if(s.allrules[w]){var i=s.allrules[w].alertTextOk;if(i){w=i}}}else{w=n.alertTextOk}if(s.showPrompts){if(w){a._showPrompt(u,w,"pass",true,s)}else{a._closePrompt(u)}}if(s.eventTrigger=="submit"){o.closest("form").submit()}}}u.trigger("jqv.field.result",[u,s.isError,w])}});return n.alertTextLoad}},_ajaxError:function(c,d){if(c.status==0&&d==null){alert("The page is not served from a server! ajax call failed")}else{if(typeof console!="undefined"){console.log("Ajax error: "+c.status+" "+d)}}},_dateToString:function(c){return c.getFullYear()+"-"+(c.getMonth()+1)+"-"+c.getDate()},_parseDate:function(e){var c=e.split("-");if(c==e){c=e.split("/")}return new Date(c[0],(c[1]-1),c[2])},_showPrompt:function(i,g,h,f,e,d){var c=a._getPrompt(i);if(d){c=false}if(b.trim(g)){if(c){a._updatePrompt(i,c,g,h,f,e)}else{a._buildPrompt(i,g,h,f,e)}}},_buildPrompt:function(h,c,f,j,k){var d=b("<div>");d.addClass(a._getClassName(h.attr("id"))+"formError");d.addClass("parentForm"+a._getClassName(h.closest("form, .validationEngineContainer").attr("id")));d.addClass("formError");switch(f){case"pass":d.addClass("greenPopup");break;case"load":d.addClass("blackPopup");break;default:}if(j){d.addClass("ajaxed")}var l=b("<div>").addClass("formErrorContent").html(c).appendTo(d);var e=h.data("promptPosition")||k.promptPosition;if(k.showArrow){var i=b("<div>").addClass("formErrorArrow");if(typeof(e)=="string"){var g=e.indexOf(":");if(g!=-1){e=e.substring(0,g)}}switch(e){case"bottomLeft":case"bottomRight":d.find(".formErrorContent").before(i);i.addClass("formErrorArrowBottom").html('<div class="line1"><!-- --></div><div class="line2"><!-- --></div><div class="line3"><!-- --></div><div class="line4"><!-- --></div><div class="line5"><!-- --></div><div class="line6"><!-- --></div><div class="line7"><!-- --></div><div class="line8"><!-- --></div><div class="line9"><!-- --></div><div class="line10"><!-- --></div>');break;case"topLeft":case"topRight":i.html('<div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div>');d.append(i);break}}if(k.addPromptClass){d.addClass(k.addPromptClass)}d.css({opacity:0});if(e==="inline"){d.addClass("inline");if(typeof h.attr("data-prompt-target")!=="undefined"&&b("#"+h.attr("data-prompt-target")).length>0){d.appendTo(b("#"+h.attr("data-prompt-target")))}else{h.after(d)}}else{h.before(d)}var g=a._calculatePosition(h,d,k);d.css({position:e==="inline"?"relative":"absolute",top:g.callerTopPosition,left:g.callerleftPosition,marginTop:g.marginTopSize,opacity:0}).data("callerField",h);if(k.autoHidePrompt){setTimeout(function(){d.animate({opacity:0},function(){d.closest(".formErrorOuter").remove();d.remove()})},k.autoHideDelay)}return d.animate({opacity:0.87})},_updatePrompt:function(i,d,c,g,j,k,e){if(d){if(typeof g!=="undefined"){if(g=="pass"){d.addClass("greenPopup")}else{d.removeClass("greenPopup")}if(g=="load"){d.addClass("blackPopup")}else{d.removeClass("blackPopup")}}if(j){d.addClass("ajaxed")}else{d.removeClass("ajaxed")}d.find(".formErrorContent").html(c);var h=a._calculatePosition(i,d,k);var f={top:h.callerTopPosition,left:h.callerleftPosition,marginTop:h.marginTopSize};if(e){d.css(f)}else{d.animate(f)}}},_closePrompt:function(d){var c=a._getPrompt(d);if(c){c.fadeTo("fast",0,function(){c.parent(".formErrorOuter").remove();c.remove()})}},closePrompt:function(c){return a._closePrompt(c)},_getPrompt:function(e){var f=b(e).closest("form, .validationEngineContainer").attr("id");var d=a._getClassName(e.attr("id"))+"formError";var c=b("."+a._escapeExpression(d)+".parentForm"+f)[0];if(c){return b(c)}},_escapeExpression:function(c){return c.replace(/([#;&,\.\+\*\~':"\!\^$\[\]\(\)=>\|])/g,"\\$1")},isRTL:function(e){var f=b(document);var c=b("body");var d=(e&&e.hasClass("rtl"))||(e&&(e.attr("dir")||"").toLowerCase()==="rtl")||f.hasClass("rtl")||(f.attr("dir")||"").toLowerCase()==="rtl"||c.hasClass("rtl")||(c.attr("dir")||"").toLowerCase()==="rtl";return Boolean(d)},_calculatePosition:function(m,f,r){var e,n,k;var g=m.width();var c=m.position().left;var p=m.position().top;var d=m.height();var q=f.height();e=n=0;k=-q;var j=m.data("promptPosition")||r.promptPosition;var i="";var h="";var o=0;var l=0;if(typeof(j)=="string"){if(j.indexOf(":")!=-1){i=j.substring(j.indexOf(":")+1);j=j.substring(0,j.indexOf(":"));if(i.indexOf(",")!=-1){h=i.substring(i.indexOf(",")+1);i=i.substring(0,i.indexOf(","));l=parseInt(h);if(isNaN(l)){l=0}}o=parseInt(i);if(isNaN(i)){i=0}}}switch(j){default:case"topRight":n+=c+g-30;e+=p;break;case"topLeft":e+=p;n+=c;break;case"centerRight":e=p+4;k=0;n=c+m.outerWidth(true)+5;break;case"centerLeft":n=c-(f.width()+2);e=p+4;k=0;break;case"bottomLeft":e=p+m.height()+5;k=0;n=c;break;case"bottomRight":n=c+g-30;e=p+m.height()+5;k=0;break;case"inline":n=0;e=0;k=0}n+=o;e+=l;return{callerTopPosition:e+"px",callerleftPosition:n+"px",marginTopSize:k+"px"}},_saveOptions:function(e,d){if(b.validationEngineLanguage){var c=b.validationEngineLanguage.allRules}else{b.error("jQuery.validationEngine rules are not loaded, plz add localization files to the page")}b.validationEngine.defaults.allrules=c;var f=b.extend(true,{},b.validationEngine.defaults,d);e.data("jqv",f);return f},_getClassName:function(c){if(c){return c.replace(/:/g,"_").replace(/\./g,"_")}},_jqSelector:function(c){return c.replace(/([;&,\.\+\*\~':"\!\^#$%@\[\]\(\)=>\|])/g,"\\$1")},_condRequired:function(g,h,e,d){var c,f;for(c=(e+1);c<h.length;c++){f=jQuery("#"+h[c]).first();if(f.length&&a._required(f,["required"],0,d,true)==undefined){return a._required(g,["required"],0,d)}}},_submitButtonClick:function(e){var c=b(this);var d=c.closest("form, .validationEngineContainer");d.data("jqv_submitButton",c.attr("id"))}};b.fn.validationEngine=function(d){var c=b(this);if(!c[0]){return c}if(typeof(d)=="string"&&d.charAt(0)!="_"&&a[d]){if(d!="showPrompt"&&d!="hide"&&d!="hideAll"){a.init.apply(c)}return a[d].apply(c,Array.prototype.slice.call(arguments,1))}else{if(typeof d=="object"||!d){a.init.apply(c,arguments);return a.attach.apply(c)}else{b.error("Method "+d+" does not exist in jQuery.validationEngine")}}};b.validationEngine={fieldIdCounter:0,defaults:{validationEventTrigger:"blur",scroll:true,focusFirstField:true,showPrompts:true,validateNonVisibleFields:false,promptPosition:"topRight",bindMethod:"bind",inlineAjax:false,ajaxFormValidation:false,ajaxFormValidationURL:false,ajaxFormValidationMethod:"get",onAjaxFormComplete:b.noop,onBeforeAjaxFormValidation:b.noop,onValidationComplete:false,doNotShowAllErrosOnSubmit:false,custom_error_messages:{},binded:true,showArrow:true,isError:false,maxErrorsPerField:false,ajaxValidCache:{},autoPositionUpdate:false,InvalidFields:[],onFieldSuccess:false,onFieldFailure:false,onSuccess:false,onFailure:false,validateAttribute:"class",addSuccessCssClassToField:"",addFailureCssClassToField:"",autoHidePrompt:false,autoHideDelay:10000,fadeDuration:0.3,prettySelect:false,addPromptClass:"",usePrefix:"",useSuffix:"",showOneMessage:false}};b(function(){b.validationEngine.defaults.promptPosition=a.isRTL()?"topLeft":"topRight"})})(jQuery);