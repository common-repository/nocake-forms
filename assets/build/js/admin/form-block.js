/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/admin/form-block.jsx");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/webpack/buildin/global.js":
/*!***********************************!*\
  !*** (webpack)/buildin/global.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("var g; // This works in non-strict mode\n\ng = function () {\n  return this;\n}();\n\ntry {\n  // This works if eval is allowed (see CSP)\n  g = g || new Function(\"return this\")();\n} catch (e) {\n  // This works if the window reference is available\n  if (typeof window === \"object\") g = window;\n} // g can still be undefined, but nothing to do about it...\n// We return undefined, instead of nothing here, so it's\n// easier to handle this case. if(!global) { ...}\n\n\nmodule.exports = g;//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9ub2RlX21vZHVsZXMvd2VicGFjay9idWlsZGluL2dsb2JhbC5qcy5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8od2VicGFjaykvYnVpbGRpbi9nbG9iYWwuanM/Y2QwMCJdLCJzb3VyY2VzQ29udGVudCI6WyJ2YXIgZztcblxuLy8gVGhpcyB3b3JrcyBpbiBub24tc3RyaWN0IG1vZGVcbmcgPSAoZnVuY3Rpb24oKSB7XG5cdHJldHVybiB0aGlzO1xufSkoKTtcblxudHJ5IHtcblx0Ly8gVGhpcyB3b3JrcyBpZiBldmFsIGlzIGFsbG93ZWQgKHNlZSBDU1ApXG5cdGcgPSBnIHx8IG5ldyBGdW5jdGlvbihcInJldHVybiB0aGlzXCIpKCk7XG59IGNhdGNoIChlKSB7XG5cdC8vIFRoaXMgd29ya3MgaWYgdGhlIHdpbmRvdyByZWZlcmVuY2UgaXMgYXZhaWxhYmxlXG5cdGlmICh0eXBlb2Ygd2luZG93ID09PSBcIm9iamVjdFwiKSBnID0gd2luZG93O1xufVxuXG4vLyBnIGNhbiBzdGlsbCBiZSB1bmRlZmluZWQsIGJ1dCBub3RoaW5nIHRvIGRvIGFib3V0IGl0Li4uXG4vLyBXZSByZXR1cm4gdW5kZWZpbmVkLCBpbnN0ZWFkIG9mIG5vdGhpbmcgaGVyZSwgc28gaXQnc1xuLy8gZWFzaWVyIHRvIGhhbmRsZSB0aGlzIGNhc2UuIGlmKCFnbG9iYWwpIHsgLi4ufVxuXG5tb2R1bGUuZXhwb3J0cyA9IGc7XG4iXSwibWFwcGluZ3MiOiJBQUFBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBR0E7QUFDQTtBQUNBO0FBQ0E7QUFBQSIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./node_modules/webpack/buildin/global.js\n");

/***/ }),

/***/ "./src/js/admin/form-block.jsx":
/*!*************************************!*\
  !*** ./src/js/admin/form-block.jsx ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("/* WEBPACK VAR INJECTION */(function(global) {function _typeof(obj) { \"@babel/helpers - typeof\"; if (typeof Symbol === \"function\" && typeof Symbol.iterator === \"symbol\") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === \"function\" && obj.constructor === Symbol && obj !== Symbol.prototype ? \"symbol\" : typeof obj; }; } return _typeof(obj); }\n\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\nfunction _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === \"object\" || typeof call === \"function\")) { return call; } return _assertThisInitialized(self); }\n\nfunction _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }\n\nfunction _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError(\"this hasn't been initialised - super() hasn't been called\"); } return self; }\n\nfunction _inherits(subClass, superClass) { if (typeof superClass !== \"function\" && superClass !== null) { throw new TypeError(\"Super expression must either be null or a function\"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }\n\nfunction _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }\n\nvar SelectControl = wp.components.SelectControl;\nvar $ = jQuery;\nvar ncfData = global.ncforms_data;\nwp.blocks.registerBlockType('ncforms/form', {\n  title: 'NoCake Form',\n  icon: 'lightbulb',\n  category: 'common',\n  attributes: {\n    form_uid: {\n      type: \"string\"\n    }\n  },\n  edit: /*#__PURE__*/function (_wp$element$Component) {\n    _inherits(edit, _wp$element$Component);\n\n    function edit(props) {\n      var _this;\n\n      _classCallCheck(this, edit);\n\n      _this = _possibleConstructorReturn(this, _getPrototypeOf(edit).apply(this, arguments));\n\n      var me = _assertThisInitialized(_this);\n\n      _this.state = {\n        forms: [{\n          label: 'None',\n          value: null\n        }]\n      };\n      $.ajax({\n        url: ncfData.ajaxUrl,\n        data: {\n          action: 'ncforms_forms'\n        },\n        success: function success(data) {\n          var items = data.data,\n              options = [{\n            label: 'None',\n            value: null\n          }];\n\n          for (var key in items) {\n            options.push({\n              label: items[key].name,\n              value: items[key].uid\n            });\n          }\n\n          me.setState({\n            forms: options\n          });\n        }\n      });\n      return _this;\n    }\n\n    _createClass(edit, [{\n      key: \"iframeLoaded\",\n      value: function iframeLoaded() {\n        var _this2 = this;\n\n        var iframe = this.refs.iframe,\n            height = iframe.contentWindow.document.body.scrollHeight + 60;\n        iframe.style.height = iframe.parentNode.style.height = iframe.parentNode.parentNode.parentNode.parentNode.style.height = height + 'px'; // Select block when clicking inside iframe.\n\n        $(iframe.contentWindow.document.body).on('click', function () {\n          var _wp$data$dispatch = wp.data.dispatch('core/block-editor'),\n              selectBlock = _wp$data$dispatch.selectBlock;\n\n          selectBlock(_this2.props.clientId);\n        });\n      }\n    }, {\n      key: \"render\",\n      value: function render() {\n        var _this3 = this;\n\n        var formUid = this.props.attributes.form_uid,\n            prefix = ncfData.prefix,\n            iframeUrl = ncfData.siteUrl + '?' + prefix + '_action=form&' + prefix + '_form=' + formUid + '&_ncforms_preview=1';\n        return wp.element.createElement(\"div\", null, wp.element.createElement(\"div\", {\n          \"class\": \"ncforms-form-select\"\n        }, wp.element.createElement(\"label\", {\n          style: {\n            paddingRight: '10px',\n            fontSize: '14px',\n            fontFamily: 'Arial',\n            display: 'inline-block'\n          }\n        }, \"Selected Form: \"), wp.element.createElement(\"div\", {\n          style: {\n            display: 'inline-block',\n            verticalAlign: 'middle',\n            marginBottom: '-8px'\n          }\n        }, wp.element.createElement(SelectControl, {\n          label: \"\",\n          value: this.props.attributes.form_uid,\n          options: this.state.forms,\n          onChange: function onChange(value) {\n            return _this3.props.setAttributes({\n              form_uid: value\n            });\n          }\n        }))), this.props.attributes.form_uid && wp.element.createElement(\"div\", null, wp.element.createElement(\"iframe\", {\n          src: iframeUrl,\n          ref: \"iframe\",\n          style: {\n            border: '0px',\n            width: '100%'\n          },\n          onLoad: function onLoad() {\n            return _this3.iframeLoaded();\n          }\n        })));\n      }\n    }]);\n\n    return edit;\n  }(wp.element.Component),\n  save: function save() {\n    return null;\n  }\n});\n/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../../node_modules/webpack/buildin/global.js */ \"./node_modules/webpack/buildin/global.js\")))//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9zcmMvanMvYWRtaW4vZm9ybS1ibG9jay5qc3guanMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9zcmMvanMvYWRtaW4vZm9ybS1ibG9jay5qc3g/ZmVlMCJdLCJzb3VyY2VzQ29udGVudCI6WyJjb25zdCB7IFNlbGVjdENvbnRyb2wgfSA9IHdwLmNvbXBvbmVudHNcclxuY29uc3QgJCA9IGpRdWVyeVxyXG5jb25zdCBuY2ZEYXRhID0gZ2xvYmFsLm5jZm9ybXNfZGF0YTtcclxuXHJcbndwLmJsb2Nrcy5yZWdpc3RlckJsb2NrVHlwZSgnbmNmb3Jtcy9mb3JtJywge1xyXG4gICAgdGl0bGU6ICdOb0Nha2UgRm9ybScsXHJcbiAgICBpY29uOiAnbGlnaHRidWxiJyxcclxuICAgIGNhdGVnb3J5OiAnY29tbW9uJyxcclxuICAgIGF0dHJpYnV0ZXM6IHtcclxuICAgICAgICBmb3JtX3VpZDoge1xyXG4gICAgICAgICAgICB0eXBlOiBcInN0cmluZ1wiXHJcbiAgICAgICAgfVxyXG4gICAgfSxcclxuICAgIGVkaXQ6IGNsYXNzIGV4dGVuZHMgd3AuZWxlbWVudC5Db21wb25lbnQge1xyXG4gICAgICAgIGNvbnN0cnVjdG9yKHByb3BzKSB7XHJcbiAgICAgICAgICAgIHN1cGVyKC4uLmFyZ3VtZW50cylcclxuICAgICAgICAgICAgY29uc3QgbWUgPSB0aGlzXHJcbiAgICAgICAgICAgIHRoaXMuc3RhdGUgPSB7XHJcbiAgICAgICAgICAgICAgICBmb3JtczogW1xyXG4gICAgICAgICAgICAgICAgICAgIHsgbGFiZWw6ICdOb25lJywgdmFsdWU6IG51bGwgfVxyXG4gICAgICAgICAgICAgICAgXVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICQuYWpheCh7XHJcbiAgICAgICAgICAgICAgICB1cmw6IG5jZkRhdGEuYWpheFVybCxcclxuICAgICAgICAgICAgICAgIGRhdGE6IHtcclxuICAgICAgICAgICAgICAgICAgICBhY3Rpb246ICduY2Zvcm1zX2Zvcm1zJ1xyXG4gICAgICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgICAgIHN1Y2Nlc3MoZGF0YSkge1xyXG4gICAgICAgICAgICAgICAgICAgIGNvbnN0XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGl0ZW1zID0gZGF0YS5kYXRhLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBvcHRpb25zID0gW3sgbGFiZWw6ICdOb25lJywgdmFsdWU6IG51bGwgfV1cclxuICAgICAgICAgICAgICAgICAgICBmb3IgKGxldCBrZXkgaW4gaXRlbXMpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgb3B0aW9ucy5wdXNoKHsgbGFiZWw6IGl0ZW1zW2tleV0ubmFtZSwgdmFsdWU6IGl0ZW1zW2tleV0udWlkIH0pXHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIG1lLnNldFN0YXRlKHsgZm9ybXM6IG9wdGlvbnMgfSlcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfSlcclxuICAgICAgICB9XHJcbiAgICAgICAgaWZyYW1lTG9hZGVkKCkge1xyXG4gICAgICAgICAgICBjb25zdFxyXG4gICAgICAgICAgICAgICAgaWZyYW1lID0gdGhpcy5yZWZzLmlmcmFtZSxcclxuICAgICAgICAgICAgICAgIGhlaWdodCA9IGlmcmFtZS5jb250ZW50V2luZG93LmRvY3VtZW50LmJvZHkuc2Nyb2xsSGVpZ2h0ICsgNjBcclxuICAgICAgICAgICAgaWZyYW1lLnN0eWxlLmhlaWdodCA9XHJcbiAgICAgICAgICAgIGlmcmFtZS5wYXJlbnROb2RlLnN0eWxlLmhlaWdodCA9XHJcbiAgICAgICAgICAgIGlmcmFtZS5wYXJlbnROb2RlLnBhcmVudE5vZGUucGFyZW50Tm9kZS5wYXJlbnROb2RlLnN0eWxlLmhlaWdodCA9IGhlaWdodCArICdweCdcclxuICAgICAgICAgICAgLy8gU2VsZWN0IGJsb2NrIHdoZW4gY2xpY2tpbmcgaW5zaWRlIGlmcmFtZS5cclxuICAgICAgICAgICAgJChpZnJhbWUuY29udGVudFdpbmRvdy5kb2N1bWVudC5ib2R5KS5vbignY2xpY2snLCAoKSA9PiB7XHJcbiAgICAgICAgICAgICAgICBjb25zdCB7IHNlbGVjdEJsb2NrIH0gPSB3cC5kYXRhLmRpc3BhdGNoKCdjb3JlL2Jsb2NrLWVkaXRvcicpXHJcbiAgICAgICAgICAgICAgICBzZWxlY3RCbG9jayh0aGlzLnByb3BzLmNsaWVudElkKVxyXG4gICAgICAgICAgICB9KVxyXG4gICAgICAgIH1cclxuICAgICAgICByZW5kZXIoKSB7XHJcbiAgICAgICAgICAgIGNvbnN0XHJcbiAgICAgICAgICAgICAgICBmb3JtVWlkID0gdGhpcy5wcm9wcy5hdHRyaWJ1dGVzLmZvcm1fdWlkLFxyXG4gICAgICAgICAgICAgICAgcHJlZml4ID0gbmNmRGF0YS5wcmVmaXgsXHJcbiAgICAgICAgICAgICAgICBpZnJhbWVVcmwgPSBuY2ZEYXRhLnNpdGVVcmwgKyAnPycgKyBwcmVmaXggKyAnX2FjdGlvbj1mb3JtJicrcHJlZml4KydfZm9ybT0nK2Zvcm1VaWQrJyZfbmNmb3Jtc19wcmV2aWV3PTEnXHJcbiAgICAgICAgICAgIHJldHVybiAoXHJcbiAgICAgICAgICAgICAgICA8ZGl2PlxyXG4gICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJuY2Zvcm1zLWZvcm0tc2VsZWN0XCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDxsYWJlbCBzdHlsZT17eyBwYWRkaW5nUmlnaHQ6ICcxMHB4JywgZm9udFNpemU6ICcxNHB4JywgZm9udEZhbWlseTogJ0FyaWFsJywgZGlzcGxheTogJ2lubGluZS1ibG9jaycgfX0+U2VsZWN0ZWQgRm9ybTogPC9sYWJlbD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPGRpdiBzdHlsZT17eyBkaXNwbGF5OiAnaW5saW5lLWJsb2NrJywgdmVydGljYWxBbGlnbjogJ21pZGRsZScsIG1hcmdpbkJvdHRvbTogJy04cHgnIH19PlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPFNlbGVjdENvbnRyb2xcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBsYWJlbD1cIlwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU9e3RoaXMucHJvcHMuYXR0cmlidXRlcy5mb3JtX3VpZH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBvcHRpb25zPXt0aGlzLnN0YXRlLmZvcm1zfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG9uQ2hhbmdlPXsodmFsdWUpID0+IHRoaXMucHJvcHMuc2V0QXR0cmlidXRlcyh7IGZvcm1fdWlkOiB2YWx1ZSB9KX1cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdGhpcy5wcm9wcy5hdHRyaWJ1dGVzLmZvcm1fdWlkICYmXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDxkaXY+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8aWZyYW1lIHNyYz17aWZyYW1lVXJsfSByZWY9XCJpZnJhbWVcIiBzdHlsZT17e2JvcmRlcjogJzBweCcsIHdpZHRoOiAnMTAwJSd9fSBvbkxvYWQ9eygpPT50aGlzLmlmcmFtZUxvYWRlZCgpfT48L2lmcmFtZT5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgIClcclxuICAgICAgICB9XHJcbiAgICB9LFxyXG4gICAgc2F2ZSgpIHtcclxuICAgICAgICByZXR1cm4gbnVsbFxyXG4gICAgfVxyXG59KVxyXG4iXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQUFBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBREE7QUFEQTtBQUtBO0FBQUE7QUFDQTtBQUFBO0FBQUE7QUFDQTtBQURBO0FBQ0E7QUFBQTtBQUNBO0FBQUE7QUFDQTtBQUFBO0FBQ0E7QUFDQTtBQUFBO0FBQUE7QUFGQTtBQUtBO0FBQ0E7QUFDQTtBQUNBO0FBREE7QUFHQTtBQUNBO0FBQUE7QUFFQTtBQUFBO0FBQUE7QUFDQTtBQUFBO0FBQ0E7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQUNBO0FBQUE7QUFBQTtBQUFBO0FBQ0E7QUFiQTtBQVJBO0FBdUJBO0FBQ0E7QUF6QkE7QUFBQTtBQUFBO0FBeUJBO0FBQ0E7QUFBQTtBQUFBO0FBR0E7QUFDQTtBQUdBO0FBQUE7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBckNBO0FBQUE7QUFBQTtBQXNDQTtBQUNBO0FBQUE7QUFBQTtBQUFBO0FBSUE7QUFFQTtBQUFBO0FBQ0E7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBSkE7QUFXQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUtBO0FBaEVBO0FBQ0E7QUFEQTtBQUFBO0FBa0VBO0FBQ0E7QUFDQTtBQTdFQTtBIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./src/js/admin/form-block.jsx\n");

/***/ })

/******/ });