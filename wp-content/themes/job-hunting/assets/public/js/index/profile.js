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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/profile.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/components/notification-popup.js":
/*!*************************************************!*\
  !*** ./src/js/components/notification-popup.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nObject.defineProperty(exports, \"__esModule\", {\n  value: true\n});\nexports[\"default\"] = void 0;\n\nvar _jquery = _interopRequireDefault(__webpack_require__(/*! jquery */ \"jquery\"));\n\nfunction _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { \"default\": obj }; }\n\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\nvar NotificationPopup = /*#__PURE__*/function () {\n  function NotificationPopup() {\n    _classCallCheck(this, NotificationPopup);\n\n    this.allowedTypes = ['alert-primary', 'alert-secondary', 'alert-success', 'alert-danger', 'alert-warning', 'alert-info'];\n    this.popup = (0, _jquery[\"default\"])('#notification-popup');\n    this.registerActions();\n  }\n\n  _createClass(NotificationPopup, [{\n    key: \"registerActions\",\n    value: function registerActions() {\n      this.popup.on('show.bs.modal', function () {\n        var _this = this;\n\n        setTimeout(function () {\n          _this.popup.modal('hide');\n\n          _this.restore();\n        }, 5000);\n      }.bind(this));\n    }\n    /**\r\n     * Show success notification.\r\n     *\r\n     * @param message string    Text message.\r\n     */\n\n  }, {\n    key: \"success\",\n    value: function success(message) {\n      this.customNotification(message, 'success');\n    }\n    /**\r\n     * Show success notification.\r\n     *\r\n     * @param message   Text message.\r\n     */\n\n  }, {\n    key: \"error\",\n    value: function error(message) {\n      this.customNotification(message, 'danger');\n    }\n    /**\r\n     * Show success notification.\r\n     *\r\n     * @param message   Text message.\r\n     */\n\n  }, {\n    key: \"warning\",\n    value: function warning(message) {\n      this.customNotification(message, 'warning');\n    }\n    /**\r\n     * Show notification.\r\n     *\r\n     * @param message   Text message.\r\n     * @param type      Alert type: primary, secondary, success, danger, warning, info.\r\n     */\n\n  }, {\n    key: \"customNotification\",\n    value: function customNotification(message, type) {\n      this.popup.find('.content').text(message);\n      this.setAlertType(type);\n      this.popup.modal('show');\n    }\n    /**\r\n     * Set notification type.\r\n     *\r\n     * @param type   Alert type: primary, secondary, success, danger, warning, info.\r\n     */\n\n  }, {\n    key: \"setAlertType\",\n    value: function setAlertType(type) {\n      this.restore();\n      var alert = this.popup.find('.alert');\n\n      if (!this.allowedTypes.includes(type)) {\n        alert.addClass('alert-secondary');\n      }\n\n      alert.addClass('alert-' + type);\n    }\n  }, {\n    key: \"restore\",\n    value: function restore() {\n      var _this2 = this;\n\n      this.allowedTypes.forEach(function (item) {\n        return _this2.popup.removeClass(item);\n      });\n    }\n  }]);\n\n  return NotificationPopup;\n}();\n\nexports[\"default\"] = NotificationPopup;\n\n//# sourceURL=webpack:///./src/js/components/notification-popup.js?");

/***/ }),

/***/ "./src/js/profile.js":
/*!***************************!*\
  !*** ./src/js/profile.js ***!
  \***************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nvar _notificationPopup = _interopRequireDefault(__webpack_require__(/*! ./components/notification-popup */ \"./src/js/components/notification-popup.js\"));\n\nfunction _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { \"default\": obj }; }\n\n'./components/notification-popup';\n$(function () {\n  var ajaxUrl = window.siteSettings.ajaxurl;\n  var notification = new _notificationPopup[\"default\"]();\n  var $form = $('#profile-change-password');\n  var $currentPwdInput = $form.find('.js-current-pwd');\n  var $newPwdInput = $form.find('.js-new-pwd');\n  var $confirmPwdInput = $form.find('.js-confirmation-pwd');\n  var nonce = $form.attr('data-nonce');\n  $(document).on('blur', '.js-current-pwd', function () {\n    var password = $currentPwdInput.val();\n\n    if (!password.length) {\n      notification.error('Current password shouldn\\'t be empty.');\n    }\n\n    var data = {\n      action: 'check_user_password',\n      nonce: nonce,\n      password: password\n    };\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      success: function success(response) {\n        if (response.status !== 200) {\n          notification.error(response.message);\n        }\n      }\n    });\n  });\n  $form.on('submit', function (event) {\n    event.preventDefault();\n    var pwd = $currentPwdInput.val();\n    var newPwd = $newPwdInput.val();\n    var confirmPwd = $confirmPwdInput.val();\n    console.log(pwd, newPwd, confirmPwd);\n\n    if (!pwd.length) {\n      notification.error('Current password shouldn\\'t be empty.');\n      return;\n    }\n\n    if (!newPwd.length || !confirmPwd.length) {\n      notification.error('New & confirmation passwords shouldn\\'t be empty');\n      return;\n    }\n\n    if (newPwd !== confirmPwd) {\n      notification.error('New & confirmation passwords are different');\n      return;\n    }\n\n    var data = {\n      action: 'change_user_password',\n      nonce: nonce,\n      password: pwd,\n      newPassword: newPwd,\n      passwordConfirmation: confirmPwd\n    };\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      success: function success(response) {\n        if (response.status === 200) {\n          notification.success('Password updated');\n          document.location.href = '/login/';\n        } else {\n          notification.error(response.message);\n        }\n      }\n    });\n  });\n});\n\n//# sourceURL=webpack:///./src/js/profile.js?");

/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("module.exports = jQuery;\n\n//# sourceURL=webpack:///external_%22jQuery%22?");

/***/ })

/******/ });