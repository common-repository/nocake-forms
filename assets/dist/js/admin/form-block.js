!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=0)}([function(e,t,n){(function(e){function t(e){return(t="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function n(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function r(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}function o(e,n){return!n||"object"!==t(n)&&"function"!=typeof n?l(e):n}function i(e){return(i=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}function l(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}function u(e,t){return(u=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}var a=wp.components.SelectControl,c=jQuery,f=e.ncforms_data;wp.blocks.registerBlockType("ncforms/form",{title:"NoCake Form",icon:"lightbulb",category:"common",attributes:{form_uid:{type:"string"}},edit:function(e){function t(e){var r;n(this,t);var u=l(r=o(this,i(t).apply(this,arguments)));return r.state={forms:[{label:"None",value:null}]},c.ajax({url:f.ajaxUrl,data:{action:"ncforms_forms"},success:function(e){var t=e.data,n=[{label:"None",value:null}];for(var r in t)n.push({label:t[r].name,value:t[r].uid});u.setState({forms:n})}}),r}var s,p,m;return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&u(e,t)}(t,wp.element.Component),s=t,(p=[{key:"iframeLoaded",value:function(){var e=this,t=this.refs.iframe,n=t.contentWindow.document.body.scrollHeight+60;t.style.height=t.parentNode.style.height=t.parentNode.parentNode.parentNode.parentNode.style.height=n+"px",c(t.contentWindow.document.body).on("click",(function(){(0,wp.data.dispatch("core/block-editor").selectBlock)(e.props.clientId)}))}},{key:"render",value:function(){var e=this,t=this.props.attributes.form_uid,n=f.prefix,r=f.siteUrl+"?"+n+"_action=form&"+n+"_form="+t+"&_ncforms_preview=1";return wp.element.createElement("div",null,wp.element.createElement("div",{class:"ncforms-form-select"},wp.element.createElement("label",{style:{paddingRight:"10px",fontSize:"14px",fontFamily:"Arial",display:"inline-block"}},"Selected Form: "),wp.element.createElement("div",{style:{display:"inline-block",verticalAlign:"middle",marginBottom:"-8px"}},wp.element.createElement(a,{label:"",value:this.props.attributes.form_uid,options:this.state.forms,onChange:function(t){return e.props.setAttributes({form_uid:t})}}))),this.props.attributes.form_uid&&wp.element.createElement("div",null,wp.element.createElement("iframe",{src:r,ref:"iframe",style:{border:"0px",width:"100%"},onLoad:function(){return e.iframeLoaded()}})))}}])&&r(s.prototype,p),m&&r(s,m),t}(),save:function(){return null}})}).call(this,n(1))},function(e,t){var n;n=function(){return this}();try{n=n||new Function("return this")()}catch(e){"object"==typeof window&&(n=window)}e.exports=n}]);
//# sourceMappingURL=form-block.js.map