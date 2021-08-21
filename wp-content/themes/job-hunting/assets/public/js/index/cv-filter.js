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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/cv-filter.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/cv-filter.js":
/*!*****************************!*\
  !*** ./src/js/cv-filter.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\n$(function () {\n  var $form = $('#cv-filter form');\n  var ajaxUrl = window.siteSettings.ajaxurl;\n\n  if (!$form.length) {\n    return;\n  }\n\n  $form.on('submit', function (event) {\n    event.preventDefault();\n    loadCvs();\n  });\n  $(document).on('click', '.js-load-more-cvs', function (event) {\n    event.preventDefault();\n    loadCvs(true);\n  });\n\n  function loadCvs() {\n    var isLoadMore = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;\n\n    if (isAjax !== undefined && isAjax) {\n      return;\n    }\n\n    var paged = 1;\n\n    if (isLoadMore) {\n      paged = $form.attr('data-paged');\n    }\n\n    var isAjax = false;\n    var degree = null;\n    var $daysAgoRange = $('#resume-days-ago [data-noui-value]');\n    var skills = $('.js-skills-list li').map(function (index, item) {\n      return $(item).attr('data-key');\n    });\n    $('input[name=resume-education]').each(function (index, item) {\n      if (item.checked) {\n        degree = $(item).val();\n      }\n    });\n    var data = {\n      action: 'get-filtered-cvs',\n      nonce: $form.attr('data-nonce'),\n      vacancyId: $('#vacancy-id').val() || null,\n      skills: Array.prototype.join.call(skills),\n      location: $('#location').val() || null,\n      jobTitle: $('#resumes-job').val() || null,\n      company: $('#resumes-company').val() || null,\n      daysAgo: $daysAgoRange.text() === '0' ? null : parseInt($daysAgoRange.text()),\n      degree: degree,\n      paged: paged,\n      category: $('#resume-category').val() || null,\n      isVeteran: $('#resume-veteran')[0].checked ? 1 : null\n    };\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      beforeSend: function beforeSend() {\n        isAjax = true;\n      },\n      success: function success(response) {\n        if (response.status === 200) {\n          isAjax = false;\n          paged++;\n          $form.attr('data-paged', paged);\n\n          if (isLoadMore) {\n            $('.js-candidates-container').append(response.html);\n          } else {\n            $('.js-candidates-container').html(response.html);\n            $('.js-load-more-cvs').show();\n          }\n\n          if (response.isEnd) {\n            $('.js-load-more-cvs').hide();\n          }\n\n          $([document.documentElement, document.body]).animate({\n            scrollTop: $(\".js-candidates-container\").offset().top - 20\n          }, 300);\n        } else if (response.status === 404) {\n          $('.js-load-more-cvs').hide();\n          $('.js-candidates-container').html(response.message);\n          $([document.documentElement, document.body]).animate({\n            scrollTop: $(\".js-candidates-container\").offset().top - 20\n          }, 300);\n        } else {\n          console.error(response.status, response.message);\n        }\n      },\n      error: function error(_error) {\n        console.error(_error);\n      }\n    });\n  }\n});\n\n//# sourceURL=webpack:///./src/js/cv-filter.js?");

/***/ })

/******/ });