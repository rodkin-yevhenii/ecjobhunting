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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/chat.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/chat.js":
/*!************************!*\
  !*** ./src/js/chat.js ***!
  \************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\n$(function () {\n  var ajaxUrl = window.siteSettings.ajaxurl;\n  var $form = $('#chat-form');\n  $('.js-chat-card').removeClass('active');\n  setInterval(function () {\n    loadContacts();\n  }, 240 * 1000);\n  $(document).on('submit', '#chat-form', function (event) {\n    event.preventDefault();\n    var data = {\n      action: 'send_chat_message',\n      nonce: $form.attr('data-nonce'),\n      chat: $form.attr('data-chat-id'),\n      message: $form.find('textarea').val()\n    };\n\n    if (!data.message.length) {\n      console.error('Error: empty message');\n      return;\n    }\n\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      success: function success(response) {\n        if (response.status === 200) {\n          $(document).trigger('load_messages', [$form.attr('data-chat-id'), $('.js-messages').attr('data-nonce')]);\n          $form.find('textarea').val('');\n        } else {\n          console.error(response.message);\n        }\n      }\n    });\n  });\n  $(document).on('click', '.js-chat-card', function (event) {\n    $('.js-chat-card').removeClass('active');\n    var $chatCard = $(event.currentTarget);\n    var $form = $('#chat-form');\n    var $messages = $('.js-messages');\n    var contactName = $chatCard.attr('data-contact-name');\n    var chatId = $chatCard.attr('data-chat-id');\n    $chatCard.find('.js-card__contact-name sup').remove();\n    $chatCard.addClass('active');\n    $form.attr('data-chat-id', chatId);\n    $('.js-contact-name').html(contactName);\n    $(document).trigger('load_messages', [chatId, $messages.attr('data-nonce')]);\n    $messages.show();\n  });\n  $(document).on('load_messages', function (event, chatId) {\n    var data = {\n      action: 'load_chat_messages',\n      nonce: $('.js-messages').attr('data-nonce'),\n      chatId: chatId\n    };\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      success: function success(response) {\n        if (response.status === 200) {\n          var $messages = $('.messages-answer');\n          var isBottom = $messages[0].scrollHeight === $messages[0].clientHeight + $messages[0].scrollTop;\n          $('.js-messages-container').html(response.html);\n\n          if (isBottom) {\n            $messages.animate({\n              scrollTop: $messages[0].scrollHeight\n            }, 0);\n          }\n        } else if (response.status === 404) {\n          $('.js-messages-container').html('There are no messages yet...');\n        } else {\n          console.error(response.message);\n        }\n      }\n    });\n  });\n\n  function loadContacts() {\n    var $contacts = $('.js-contacts');\n    var $activeChat = $contacts.find('li.active');\n    var chatId = $activeChat.length ? $activeChat.attr('data-chat-id') : null;\n    var data = {\n      action: 'reload_contacts',\n      nonce: $contacts.attr('data-nonce'),\n      activeChatId: chatId\n    };\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      success: function success(response) {\n        if (response.status === 200) {\n          $('.js-contacts-container').html(response.html);\n        } else {\n          console.error(response.message);\n        }\n      }\n    });\n  }\n});\n\n//# sourceURL=webpack:///./src/js/chat.js?");

/***/ })

/******/ });