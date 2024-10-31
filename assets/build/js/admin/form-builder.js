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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/admin/form-builder.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/admin/form-builder.js":
/*!**************************************!*\
  !*** ./src/js/admin/form-builder.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("(function ($, global) {\n  var ncfData = global.ncforms_data;\n  $(function () {\n    var id = ncfData.id || null,\n        prefix = ncfData.prefix; // Create form builder.\n\n    var builder = nocake.form.builder.create({\n      el: '#ncforms-form-builder',\n      value: ncfData.value || null,\n      // Wordpress top bar have 99999.\n      previewZIndex: 100000,\n      themes: {\n        evfbdef: {\n          name: 'Default',\n          url: ncfData.pluginUrl + '/form-builder/assets/themes/default.css'\n        }\n      },\n      onPreviewSubmit: function onPreviewSubmit(form) {\n        // Save builders form first, then submit preview form.\n        saveReq().then(function () {\n          var obj = {};\n          obj[prefix + '_action'] = 'submit';\n          obj[prefix + '_form'] = form.form.uuid;\n          form.send(obj);\n        });\n      },\n      formHandlerUrl: ncfData.siteUrl,\n      controls: {\n        'test.root': {\n          cmp: function cmp() {},\n          props: function props() {},\n          info: {\n            data: {},\n            desc: 'Test component',\n            icon: '',\n            internal: false,\n            name: 'Test',\n            validators: {}\n          },\n          onBeforeInsert: function onBeforeInsert() {\n            console.log('before inserted');\n          }\n        }\n      }\n    });\n\n    var save = _.debounce(function () {\n      saveReq();\n    }, 500);\n\n    builder.on('change', save);\n\n    var saveReq = function saveReq() {\n      return $.ajax({\n        url: ncfData.restUrl + 'ncforms/v1/form/save',\n        method: 'POST',\n        beforeSend: function beforeSend(xhr) {\n          xhr.setRequestHeader('X-WP-Nonce', ncfData.nonce);\n        },\n        data: {\n          id: id,\n          form: JSON.stringify(builder.getValue())\n        },\n        success: function success(data) {\n          id = data.id;\n        },\n        error: function error() {\n          console.log('error');\n        }\n      });\n    };\n  });\n})(jQuery, window);//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9zcmMvanMvYWRtaW4vZm9ybS1idWlsZGVyLmpzLmpzIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vc3JjL2pzL2FkbWluL2Zvcm0tYnVpbGRlci5qcz80M2YzIl0sInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbigkLCBnbG9iYWwpIHtcclxuICAgIHZhciBuY2ZEYXRhID0gZ2xvYmFsLm5jZm9ybXNfZGF0YTtcclxuXHJcbiAgICAkKGZ1bmN0aW9uKCkge1xyXG4gICAgICAgIHZhciBpZCA9IG5jZkRhdGEuaWQgfHwgbnVsbCxcclxuICAgICAgICAgICAgcHJlZml4ID0gbmNmRGF0YS5wcmVmaXg7XHJcblxyXG4gICAgICAgIC8vIENyZWF0ZSBmb3JtIGJ1aWxkZXIuXHJcbiAgICAgICAgdmFyIGJ1aWxkZXIgPSBub2Nha2UuZm9ybS5idWlsZGVyLmNyZWF0ZSh7XHJcbiAgICAgICAgICAgIGVsOiAnI25jZm9ybXMtZm9ybS1idWlsZGVyJyxcclxuICAgICAgICAgICAgdmFsdWU6IG5jZkRhdGEudmFsdWUgfHwgbnVsbCxcclxuICAgICAgICAgICAgLy8gV29yZHByZXNzIHRvcCBiYXIgaGF2ZSA5OTk5OS5cclxuICAgICAgICAgICAgcHJldmlld1pJbmRleDogMTAwMDAwLFxyXG4gICAgICAgICAgICB0aGVtZXM6IHtcclxuICAgICAgICAgICAgICAgIGV2ZmJkZWY6IHsgbmFtZTogJ0RlZmF1bHQnLCB1cmw6IG5jZkRhdGEucGx1Z2luVXJsICsgJy9mb3JtLWJ1aWxkZXIvYXNzZXRzL3RoZW1lcy9kZWZhdWx0LmNzcycgfVxyXG4gICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICBvblByZXZpZXdTdWJtaXQoZm9ybSkge1xyXG4gICAgICAgICAgICAgICAgLy8gU2F2ZSBidWlsZGVycyBmb3JtIGZpcnN0LCB0aGVuIHN1Ym1pdCBwcmV2aWV3IGZvcm0uXHJcbiAgICAgICAgICAgICAgICBzYXZlUmVxKCkudGhlbihmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgb2JqID0ge31cclxuICAgICAgICAgICAgICAgICAgICBvYmpbcHJlZml4ICsgJ19hY3Rpb24nXSA9ICdzdWJtaXQnXHJcbiAgICAgICAgICAgICAgICAgICAgb2JqW3ByZWZpeCArICdfZm9ybSddID0gZm9ybS5mb3JtLnV1aWRcclxuICAgICAgICAgICAgICAgICAgICBmb3JtLnNlbmQob2JqKVxyXG4gICAgICAgICAgICAgICAgfSlcclxuICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgZm9ybUhhbmRsZXJVcmw6IG5jZkRhdGEuc2l0ZVVybCxcclxuICAgICAgICAgICAgY29udHJvbHM6IHtcclxuICAgICAgICAgICAgICAgICd0ZXN0LnJvb3QnOiB7XHJcbiAgICAgICAgICAgICAgICAgICAgY21wOiBmdW5jdGlvbigpIHt9LFxyXG4gICAgICAgICAgICAgICAgICAgIHByb3BzOiBmdW5jdGlvbigpIHt9LFxyXG4gICAgICAgICAgICAgICAgICAgIGluZm86IHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgZGF0YToge30sXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGRlc2M6ICdUZXN0IGNvbXBvbmVudCcsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGljb246ICcnLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpbnRlcm5hbDogZmFsc2UsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIG5hbWU6ICdUZXN0JyxcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFsaWRhdG9yczoge31cclxuICAgICAgICAgICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICAgICAgICAgIG9uQmVmb3JlSW5zZXJ0KCkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBjb25zb2xlLmxvZygnYmVmb3JlIGluc2VydGVkJylcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9KVxyXG5cclxuICAgICAgICB2YXIgc2F2ZSA9IF8uZGVib3VuY2UoZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgIHNhdmVSZXEoKVxyXG4gICAgICAgIH0sIDUwMClcclxuXHJcbiAgICAgICAgYnVpbGRlci5vbignY2hhbmdlJywgc2F2ZSlcclxuXHJcbiAgICAgICAgdmFyIHNhdmVSZXEgPSBmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgcmV0dXJuICQuYWpheCh7XHJcbiAgICAgICAgICAgICAgICB1cmw6IG5jZkRhdGEucmVzdFVybCArICduY2Zvcm1zL3YxL2Zvcm0vc2F2ZScsXHJcbiAgICAgICAgICAgICAgICBtZXRob2Q6ICdQT1NUJyxcclxuICAgICAgICAgICAgICAgIGJlZm9yZVNlbmQ6IGZ1bmN0aW9uKHhocikge1xyXG4gICAgICAgICAgICAgICAgICAgIHhoci5zZXRSZXF1ZXN0SGVhZGVyKCAnWC1XUC1Ob25jZScsIG5jZkRhdGEubm9uY2UpO1xyXG4gICAgICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgICAgIGRhdGE6IHtcclxuICAgICAgICAgICAgICAgICAgICBpZDogaWQsXHJcbiAgICAgICAgICAgICAgICAgICAgZm9ybTogSlNPTi5zdHJpbmdpZnkoYnVpbGRlci5nZXRWYWx1ZSgpKVxyXG4gICAgICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgICAgIHN1Y2Nlc3MoZGF0YSkge1xyXG4gICAgICAgICAgICAgICAgICAgIGlkID0gZGF0YS5pZFxyXG4gICAgICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgICAgIGVycm9yKCkge1xyXG4gICAgICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdlcnJvcicpXHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH0pXHJcbiAgICAgICAgfVxyXG4gICAgfSlcclxufSkoalF1ZXJ5LCB3aW5kb3cpXHJcbiJdLCJtYXBwaW5ncyI6IkFBQUE7QUFDQTtBQUVBO0FBQ0E7QUFBQTtBQUNBO0FBR0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFBQTtBQUFBO0FBQUE7QUFEQTtBQUdBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQU5BO0FBUUE7QUFDQTtBQUNBO0FBYkE7QUFEQTtBQWxCQTtBQUNBO0FBb0NBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRkE7QUFJQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFmQTtBQWlCQTtBQUNBO0FBQ0EiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./src/js/admin/form-builder.js\n");

/***/ })

/******/ });