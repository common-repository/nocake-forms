!function(e){var n={};function t(o){if(n[o])return n[o].exports;var r=n[o]={i:o,l:!1,exports:{}};return e[o].call(r.exports,r,r.exports,t),r.l=!0,r.exports}t.m=e,t.c=n,t.d=function(e,n,o){t.o(e,n)||Object.defineProperty(e,n,{enumerable:!0,get:o})},t.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},t.t=function(e,n){if(1&n&&(e=t(e)),8&n)return e;if(4&n&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(t.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&n&&"string"!=typeof e)for(var r in e)t.d(o,r,function(n){return e[n]}.bind(null,r));return o},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},t.p="",t(t.s=4)}({4:function(e,n){var t,o;t=jQuery,o=window.ncforms_data,t((function(){t("body").on("click",".js-ncforms-delete-submission",(function(e){if(e.preventDefault(),confirm("Are you sure you want to delete this submission?")){var n=t(this);t.ajax({url:o.ajaxUrl,data:{action:"ncforms_delete_submission",id:n.data("id"),nonce:n.data("nonce")},complete:function(){window.location.reload()}})}})),t(".js-ncforms-submissions-select-form").on("change",(function(e){e.preventDefault(),window.location=t(this).val()}))}))}});
//# sourceMappingURL=submissions-list.js.map