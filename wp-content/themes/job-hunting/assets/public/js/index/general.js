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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/general.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/general.js":
/*!***************************!*\
  !*** ./src/js/general.js ***!
  \***************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nfunction _typeof(obj) { \"@babel/helpers - typeof\"; if (typeof Symbol === \"function\" && typeof Symbol.iterator === \"symbol\") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === \"function\" && obj.constructor === Symbol && obj !== Symbol.prototype ? \"symbol\" : typeof obj; }; } return _typeof(obj); }\n\n$(function () {\n  var wrapper = $('.wrapper'),\n      body = $('body'),\n      headerButtonWrapper = $('.header-button-wrapper'),\n      headerAccountWrapper = headerButtonWrapper.length ? headerButtonWrapper : $('.header-account-wrapper'),\n      headerAccount = headerButtonWrapper.length ? headerButtonWrapper.children('.btn') : headerAccountWrapper.children('.header-account'),\n      headerNav = $('.header nav');\n  setTimeout(function () {\n    wrapper.animate({\n      opacity: 1\n    }, 500);\n  }, 500);\n  pageRepaint();\n  $('.candidate-list').slick({\n    slidesToShow: 3,\n    dots: false,\n    arrows: true,\n    responsive: [{\n      breakpoint: 1200,\n      settings: {\n        slidesToShow: 2,\n        dots: false,\n        arrows: true\n      }\n    }, {\n      breakpoint: 768,\n      settings: {\n        slidesToShow: 1,\n        dots: true,\n        arrows: false\n      }\n    }]\n  });\n  var noUiSliderCustom = $('[data-noui-slider]');\n  noUiSliderCustom.each(function () {\n    var step = parseInt($(this).attr('data-noui-step')),\n        start = parseInt($(this).attr('data-noui-start')),\n        end = parseInt($(this).attr('data-noui-end'));\n    noUiSlider.create(this, {\n      start: start,\n      step: step,\n      range: {\n        'min': start,\n        'max': end\n      }\n    });\n    var resumeMilesValue = $('[data-noui-value=\"' + $(this).attr('data-noui-slider') + '\"]');\n    this.noUiSlider.on('update', function (values, handle) {\n      resumeMilesValue.get(0).innerHTML = Math.abs(values[handle]);\n    });\n  });\n  $(document).ready(function () {\n    $('li.profile-menu.active-item').attr('data-select-value', 'true');\n  });\n  $(window).on('resize', function () {\n    pageRepaint();\n  });\n  $(document).on('click', function (event) {\n    var target = $(event.target);\n    if (!target.closest('[data-tab-value]').length || !target.closest('[data-tab-value]').length) $('[data-tab]').removeClass('active');\n\n    if (!target.closest('[data-handler]').length && !target.closest('[data-dropdown]').length) {\n      $('[data-handler]').removeClass('active');\n      $('[data-dropdown]').removeClass('active');\n    }\n\n    if (!target.closest('[data-select]').length) {\n      $('[data-select]').removeClass('active');\n      $('[data-select-value]').removeClass('active');\n    }\n  });\n  $(document).on('click', '.header-burger', function () {\n    body.toggleClass('menu-opened');\n  });\n  $(document).on('click', '.filter-database-handler', function () {\n    $(this).toggleClass('active');\n    $('.filter-database').toggleClass('active');\n  });\n  $(document).on('click', '.see-more', function () {\n    $(this).toggleClass('active');\n    $(this).siblings('.see-more-hidden').toggleClass('active');\n  });\n  $(document).on('click', '[data-select-value]', function () {\n    var select = $(this).parents('[data-select]');\n\n    if (!select.hasClass('disabled')) {\n      if (select.hasClass('active')) {\n        $(this).removeClass('active');\n        select.removeClass('active');\n      } else {\n        $('[data-select-value]').removeClass('active');\n        $('[data-select]').removeClass('active');\n        $(this).addClass('active');\n        select.addClass('active');\n      }\n    }\n  });\n  $(document).on('click', '[data-select-item]', function () {\n    var select = $(this).parents('[data-select]');\n\n    if (!$(this).hasClass('active')) {\n      $(this).siblings().removeClass('active');\n      $(this).addClass('active');\n      var value = $(this).attr('data-select-item-value');\n      var label = $(this).html();\n\n      if (undefined === _typeof(value)) {\n        value = label;\n      }\n\n      select.find($('input')).val(value);\n      select.children('[data-select-value]').html(label);\n      select.removeClass('active');\n    }\n  });\n  $(document).ready(function () {\n    var $select = $('div[data-select]');\n    window.test = $select;\n    $select.map(function (i, item) {\n      var currentSelect = $(item);\n      var value = currentSelect.find('li.active').attr('data-select-item-value');\n      var label = currentSelect.find('li.active').html();\n\n      if (undefined === _typeof(value)) {\n        value = label;\n      }\n\n      currentSelect.find('input').val(value);\n      currentSelect.children('[data-select-value]').html(label);\n    });\n  });\n  $(document).on('click', '.custom-handler div', function () {\n    var handler = $(this).parents('.custom-handler'),\n        form = handler.next('form'),\n        fields = form.find('input');\n\n    if (handler.hasClass('active')) {\n      handler.removeClass('active');\n      form.addClass('disabled');\n      fields.each(function () {\n        $(this).attr('disabled', true);\n      });\n    } else {\n      handler.addClass('active');\n      form.removeClass('disabled');\n      fields.each(function () {\n        $(this).attr('disabled', null);\n      });\n    }\n  });\n  $(document).on('click', '[data-handler]', function () {\n    var target = $(this).attr('data-handler');\n    $('[data-dropdown=\"' + target + '\"]').toggleClass('active');\n    $(this).toggleClass('active');\n  });\n  $(document).on('click', '[data-tab-value]', function () {\n    var parent = $(this).parents('[data-tab]');\n    $(this).toggleClass('active');\n    parent.toggleClass('active');\n  });\n  $(document).on('click', '[data-tab-item]', function () {\n    var parent = $(this).parents('[data-tab]');\n\n    if (!$(this).hasClass('active')) {\n      if ($(window).width() < 768 && parent.find('[data-tab-value]').length) {\n        var text = $(this).text();\n        parent.find('[data-tab-value]').find('span').text(text);\n        parent.removeClass('active');\n      }\n\n      var index = $(this).attr('data-tab-item');\n      $(this).addClass('active');\n      $(this).siblings('.active').removeClass('active');\n      var previousItem = parent.find('.active[data-tab-content]');\n      var currentItem = parent.find('[data-tab-content=\"' + index + '\"]');\n      previousItem.removeClass('active');\n      currentItem.addClass('active');\n    }\n  });\n  $(document).on('click', '.recent-info-tab ul.results-header li', function () {\n    var headerText = $(this).parents('.recent-info-tab').find('h2');\n    headerText.text($(this).attr('data-tab-message'));\n  });\n  $(document).on('click', '[data-tab-back]', function () {\n    var parent = $(this).parents('[data-tab]');\n    parent.find(\"[data-tab-item]\").removeClass('active');\n    parent.find(\"[data-tab-content]\").removeClass('active');\n  });\n  $(document).on('click', '.field-skills-close', function () {\n    $(this).parents('li').detach();\n  });\n  $(document).on('click', '.field-skills-panel button', function () {\n    addSkill($(this).parents('.field-skills'));\n  });\n  $(document).on('keydown', '.field-skills-panel input', function (event) {\n    if (event.keyCode === 13) {\n      event.preventDefault();\n      addSkill($(this).parents('.field-skills'));\n    }\n  });\n\n  function addSkill(skills) {\n    var input = $(skills).find('input:not([type=\"hidden\"])'),\n        value = input.val(),\n        list = $(skills).find('ul');\n\n    if (value && value.length) {\n      $(\"<li data-key=\\\"\".concat(value, \"\\\"><span>\").concat(value, \"</span><span class=\\\"field-skills-close\\\"></span></li>\")).appendTo(list);\n      input.val('');\n    }\n  }\n\n  function repaintTablet() {\n    headerAccount.appendTo(headerAccountWrapper);\n    setMessagesTablet();\n  }\n\n  function repaintMobile() {\n    headerAccount.appendTo(headerNav);\n    setMessagesMobile();\n  }\n\n  function pageRepaint() {\n    if ($(window).width() < 768) {\n      repaintMobile();\n    } else {\n      repaintTablet();\n    }\n  }\n\n  function setMessagesMobile() {\n    var messages = $('.messages [data-tab]');\n\n    if (messages.length && messages.find('.messages-content.active').length) {\n      messages.find('.messages-content').removeClass('active');\n      messages.find('[data-tab-item]').removeClass('active');\n    }\n  }\n\n  function setMessagesTablet() {\n    var messages = $('.messages [data-tab]');\n\n    if (messages.length && messages.find('.messages-content.active').length === 0) {\n      var value = messages.find('.messages-content').eq(0).attr('data-tab-content');\n      messages.find('.messages-content').eq(0).addClass('active');\n      messages.find(\"[data-tab-item=\\\"\".concat(value, \"\\\"]\")).addClass('active');\n    }\n  }\n});\n\n//# sourceURL=webpack:///./src/js/general.js?");

/***/ })

/******/ });