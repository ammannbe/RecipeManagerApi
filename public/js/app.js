!function(e){var n={};function o(t){if(n[t])return n[t].exports;var i=n[t]={i:t,l:!1,exports:{}};return e[t].call(i.exports,i,i.exports,o),i.l=!0,i.exports}o.m=e,o.c=n,o.d=function(e,n,t){o.o(e,n)||Object.defineProperty(e,n,{enumerable:!0,get:t})},o.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},o.t=function(e,n){if(1&n&&(e=o(e)),8&n)return e;if(4&n&&"object"==typeof e&&e&&e.__esModule)return e;var t=Object.create(null);if(o.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:e}),2&n&&"string"!=typeof e)for(var i in e)o.d(t,i,function(n){return e[n]}.bind(null,i));return t},o.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return o.d(n,"a",n),n},o.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},o.p="/",o(o.s=0)}([function(e,n,o){o(1),e.exports=o(6)},function(e,n,o){o(2),o(3),o(4),o(5)},function(e,n){var o={remove:function(e){e.parent().fadeOut("slow")}};$(document).ready(function(){$(".toast .alert button").click(function(){o.remove($(this))})})},function(e,n){var o={switch:function(e){$input=e.children("input"),$input.is(":checked")?e.hasClass("edit-mode")&&o.enableEditMode():e.hasClass("edit-mode")&&o.disableEditMode()},enableEditMode:function(){$(".edit-mode.item").removeClass("hidden")},disableEditMode:function(){$(".edit-mode.item").addClass("hidden")},dropdown:function(e,n){e.preventDefault(),e.stopPropagation();var o=n.siblings("ul.js-dropdown");o.is(":visible")?(o.removeClass("show"),o.addClass("hidden")):(o.removeClass("hidden"),o.addClass("show")),o.children("li").show()}};$(document).ready(function(){$(window).click(function(){$(".form form .js-dropdown").removeClass("show"),$(".form form .js-dropdown").addClass("hidden")}),o.switch($(".switch")),$(".switch input[type=checkbox]").change(function(){o.switch($(this).parent())}),$(".form form .js-dropdown li").click(function(e){e.stopPropagation()}),$(".form form .text-input").on("keyup",function(){var e=$(this).siblings(".js-dropdown");if($.trim($(this).val())){e.removeClass("hidden"),e.addClass("show");var n=$(this).val().toLowerCase();e.children("li").filter(function(){$(this).toggle($(this).text().toLowerCase().indexOf(n)>-1)})}else e.addClass("hidden"),e.removeClass("show")}),$(".form form .js-dropdown li").click(function(){var e=$(this).parent();e.siblings(".text-input").val($(this).text()),e.removeClass("show"),e.addClass("hidden")}),$(".form form button.arrow-down").click(function(e){o.dropdown(e,$(this))})})},function(e,n){var o={remove:function(){$(".noscript").remove()}};$(document).ready(function(){o.remove()})},function(e,n){var o={confirm:function(e){confirm("Bist du sicher?")||(e.stopPropagation(),e.preventDefault())}};$(document).ready(function(){$(".delete.confirm").on("click",function(e){o.confirm(e)})})},function(e,n){}]);