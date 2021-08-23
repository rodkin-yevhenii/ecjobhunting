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
eval("\n\nfunction _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }\n\nfunction _nonIterableSpread() { throw new TypeError(\"Invalid attempt to spread non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\"); }\n\nfunction _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === \"string\") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === \"Object\" && o.constructor) n = o.constructor.name; if (n === \"Map\" || n === \"Set\") return Array.from(o); if (n === \"Arguments\" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }\n\nfunction _iterableToArray(iter) { if (typeof Symbol !== \"undefined\" && Symbol.iterator in Object(iter)) return Array.from(iter); }\n\nfunction _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }\n\nfunction _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }\n\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\nfunction _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }\n\n$(function () {\n  var $form = $('#cv-filter form');\n  var ajaxUrl = window.siteSettings.ajaxurl;\n\n  if (!$form.length) {\n    return;\n  }\n\n  $form.on('submit', function (event) {\n    event.preventDefault();\n    loadCvs();\n  });\n  $(document).on('click', '.js-load-more-cvs', function (event) {\n    event.preventDefault();\n    loadCvs(true);\n  });\n\n  function prepareData(paged) {\n    var $daysAgoRange = $('#resume-days-ago [data-noui-value]');\n    var degree = null;\n    var skills = $('.js-skills-list li').map(function (index, item) {\n      return $(item).attr('data-key');\n    });\n    $('input[name=resume-education]').each(function (index, item) {\n      if (item.checked) {\n        degree = $(item).val();\n      }\n    });\n    return {\n      action: 'get-filtered-cvs',\n      nonce: $form.attr('data-nonce'),\n      vacancyId: $('#vacancy-id').val() || null,\n      skills: Array.prototype.join.call(skills),\n      location: $('#location').val() || null,\n      jobTitle: $('#resumes-job').val() || null,\n      company: $('#resumes-company').val() || null,\n      daysAgo: $daysAgoRange.text() === '0' ? null : parseInt($daysAgoRange.text()),\n      degree: degree,\n      paged: paged,\n      category: $('#resume-category').val() || null,\n      isVeteran: $('#resume-veteran')[0].checked ? 1 : null\n    };\n  }\n\n  function loadCvs() {\n    var isLoadMore = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;\n\n    if (isAjax !== undefined && isAjax) {\n      return;\n    }\n\n    var paged = 1;\n\n    if (isLoadMore) {\n      paged = $form.attr('data-paged');\n    }\n\n    var isAjax = false;\n    var data = prepareData(paged);\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      beforeSend: function beforeSend() {\n        isAjax = true;\n      },\n      success: function success(response) {\n        if (response.status === 200) {\n          isAjax = false;\n          paged++;\n          $form.attr('data-paged', paged);\n\n          if (isLoadMore) {\n            $('.js-candidates-container').append(response.html);\n          } else {\n            $('.js-candidates-container').html(response.html);\n            $('.js-load-more-cvs').show();\n          }\n\n          if (response.isEnd) {\n            $('.js-load-more-cvs').hide();\n          }\n\n          $([document.documentElement, document.body]).animate({\n            scrollTop: $(\".js-candidates-container\").offset().top - 20\n          }, 300);\n        } else if (response.status === 404) {\n          $('.js-load-more-cvs').hide();\n          $('.js-candidates-container').html(response.message);\n          $([document.documentElement, document.body]).animate({\n            scrollTop: $(\".js-candidates-container\").offset().top - 20\n          }, 300);\n        } else {\n          console.error(response.status, response.message);\n        }\n      },\n      error: function error(_error) {\n        console.error(_error);\n      }\n    });\n  }\n\n  var CvFilterForm = /*#__PURE__*/function () {\n    function CvFilterForm() {\n      var _this = this;\n\n      _classCallCheck(this, CvFilterForm);\n\n      _defineProperty(this, \"vacancy\", {\n        restore: function restore() {\n          _this.DOM.vacancy.find('li[data-default]').click();\n        },\n        update: function update(id) {\n          _this.DOM.vacancy.find(\"li[data-select-item-value=\".concat(id, \"]\")).click();\n        }\n      });\n\n      _defineProperty(this, \"skills\", {\n        restore: function restore() {\n          _this.DOM.skills.find('.js-custom-list-items').html('');\n        },\n        update: function update(skills) {\n          var $input = _this.DOM.skills.find('input');\n\n          var $button = _this.DOM.skills.find('button');\n\n          skills.forEach(function (item) {\n            $input.val(item);\n            $button.click();\n          });\n        }\n      });\n\n      _defineProperty(this, \"location\", {\n        restore: function restore() {\n          _this.DOM.location.find('li[data-default]').click();\n        },\n        update: function update(name) {\n          _this.DOM.location.find(\"li[data-select-item-value=\".concat(name, \"]\")).click();\n        }\n      });\n\n      _defineProperty(this, \"headline\", {\n        restore: function restore() {\n          _this.DOM.headline.find('input').val('');\n        },\n        update: function update(title) {\n          _this.DOM.headline.find('input').val(title);\n        }\n      });\n\n      _defineProperty(this, \"prevCompany\", {\n        restore: function restore() {\n          _this.DOM.prevCompany.find('input').val('');\n        },\n        update: function update(title) {\n          _this.DOM.prevCompany.find('input').val(title);\n        }\n      });\n\n      _defineProperty(this, \"posted\", {\n        restore: function restore() {\n          _this.DOM.posted.find('[data-noui-value]').html(0);\n        },\n        update: function update(days) {\n          _this.DOM.posted.find('[data-noui-value]').html(days);\n        }\n      });\n\n      _defineProperty(this, \"degree\", {\n        restore: function restore() {\n          _this.DOM.degree.find('input[data-default]').click();\n        },\n        update: function update(degree) {\n          _this.DOM.degree.find(\"input[value=\".concat(degree, \"]\")).click();\n        }\n      });\n\n      _defineProperty(this, \"category\", {\n        restore: function restore() {\n          _this.DOM.category.find('li[data-default]').click();\n        },\n        update: function update(name) {\n          _this.DOM.category.find(\"li[data-select-item-value=\".concat(name, \"]\")).click();\n        }\n      });\n\n      _defineProperty(this, \"veteranStatus\", {\n        restore: function restore() {\n          _this.DOM.veteranStatus.find('input').attr('checked', false);\n        },\n        update: function update(isVeteran) {\n          if (isVeteran) {\n            _this.DOM.veteranStatus.find('input').attr('checked', true);\n          } else {\n            _this.DOM.veteranStatus.find('input').attr('checked', false);\n          }\n        }\n      });\n\n      var $form = $('#cv-filter form');\n      this.DOM = {\n        form: $form,\n        vacancy: $form.find('#vacancy'),\n        skills: $form.find('#skills'),\n        location: $form.find('#locations'),\n        headline: $form.find('#headline'),\n        prevCompany: $form.find('#prev-company'),\n        posted: $form.find('#posted'),\n        degree: $form.find('#degree'),\n        category: $form.find('#category'),\n        veteranStatus: $form.find('#veteran-status')\n      };\n    }\n\n    _createClass(CvFilterForm, [{\n      key: \"restore\",\n      value: function restore() {\n        this.vacancy.restore();\n        this.skills.restore();\n        this.location.restore();\n        this.headline.restore();\n        this.prevCompany.restore();\n        this.posted.restore();\n        this.degree.restore();\n        this.category.restore();\n        this.veteranStatus.restore();\n      }\n    }]);\n\n    return CvFilterForm;\n  }();\n\n  var SearchQuery = /*#__PURE__*/function () {\n    function SearchQuery() {\n      _classCallCheck(this, SearchQuery);\n\n      this.loadQueries();\n      this.registerActions();\n      this.renderQueryCards();\n      this.form = new CvFilterForm();\n    }\n\n    _createClass(SearchQuery, [{\n      key: \"registerActions\",\n      value: function registerActions() {\n        $(document).on('click', '.js-save-query', function (event) {\n          event.preventDefault();\n          this.addQuery();\n          this.renderQueryCards();\n        }.bind(this));\n        $(document).on('click', '.js-apply-cv-search-query', function (event) {\n          event.preventDefault();\n          this.form.restore();\n          var key = $(event.currentTarget).attr('data-key');\n          var data = this.queries[key];\n          this.form.vacancy.update(data.vacancyId);\n          this.form.skills.update(data.skills.split(','));\n          this.form.location.update(data.location);\n          this.form.headline.update(data.jobTitle);\n          this.form.prevCompany.update(data.company);\n          this.form.posted.update(data.daysAgo ? data.daysAgo : 0);\n          this.form.degree.update(data.degree);\n          this.form.category.update(data.category);\n          this.form.veteranStatus.update(data.isVeteran === 1);\n          this.form.DOM.form.submit();\n          $('[data-tab-item=search]').click();\n        }.bind(this));\n        $(document).on('click', '.js-remove-cv-search-query', function (event) {\n          event.preventDefault();\n          var button = $(event.currentTarget);\n          var key = button.attr('data-key');\n          button.closest('.js-query-card').remove();\n          this.queries.splice(key, 1);\n          localStorage.setItem('cvs_search_queries', JSON.stringify(this.queries));\n          this.renderQueryCards();\n        }.bind(this));\n      }\n    }, {\n      key: \"loadQueries\",\n      value: function loadQueries() {\n        var queries = JSON.parse(localStorage.getItem('cvs_search_queries'));\n\n        if (queries && queries.length) {\n          this.queries = queries;\n        } else {\n          this.queries = [];\n        }\n      }\n    }, {\n      key: \"addQuery\",\n      value: function addQuery() {\n        var data = prepareData(1);\n        this.queries = [data].concat(_toConsumableArray(this.queries));\n        localStorage.setItem('cvs_search_queries', JSON.stringify(this.queries));\n      }\n    }, {\n      key: \"renderQueryCards\",\n      value: function renderQueryCards() {\n        var $container = $('.js-query-cards-container');\n        $container.html('');\n        this.queries.forEach(function (item, index) {\n          var _item$vacancyId, _item$skills$replace, _item$location, _item$jobTitle, _item$company, _item$daysAgo, _item$degree, _item$category;\n\n          if (!item) {\n            return;\n          }\n\n          var $card = $('<div class=\"col-12 col-md-6 col-lg-4 col-xl-3 mb-4 js-query-card\"></div>');\n          var $list = $('<ul class=\"mb-2\"></ul>');\n          $list.append(\"<li class=\\\"mb-1\\\">Job ID: <strong>\".concat((_item$vacancyId = item.vacancyId) !== null && _item$vacancyId !== void 0 ? _item$vacancyId : '', \"</strong></li>\"));\n          $list.append(\"<li class=\\\"mb-1\\\">Skills: <strong>\".concat((_item$skills$replace = item.skills.replace(',', ', ')) !== null && _item$skills$replace !== void 0 ? _item$skills$replace : '', \"</strong></li>\"));\n          $list.append(\"<li class=\\\"mb-1\\\">Location: <strong>\".concat((_item$location = item.location) !== null && _item$location !== void 0 ? _item$location : '', \"</strong></li>\"));\n          $list.append(\"<li class=\\\"mb-1\\\">Job Title: <strong>\".concat((_item$jobTitle = item.jobTitle) !== null && _item$jobTitle !== void 0 ? _item$jobTitle : '', \"</strong></li>\"));\n          $list.append(\"<li class=\\\"mb-1\\\">Prev. Company: <strong>\".concat((_item$company = item.company) !== null && _item$company !== void 0 ? _item$company : '', \"</strong></li>\"));\n          $list.append(\"<li class=\\\"mb-1\\\">Posted days ago: <strong>\".concat((_item$daysAgo = item.daysAgo) !== null && _item$daysAgo !== void 0 ? _item$daysAgo : '', \"</strong></li>\"));\n          $list.append(\"<li class=\\\"mb-1\\\">Minimum Education: <strong>\".concat((_item$degree = item.degree) !== null && _item$degree !== void 0 ? _item$degree : '', \"</strong></li>\"));\n          $list.append(\"<li class=\\\"mb-1\\\">Industry: <strong>\".concat((_item$category = item.category) !== null && _item$category !== void 0 ? _item$category : '', \"</strong></li>\"));\n          $list.append(\"<li class=\\\"mb-1\\\">Veteran Status: <strong>\".concat(item.isVeteran ? 'yes' : 'no', \"</strong></li>\"));\n          $card.append($list);\n          $card.append(\"<button class=\\\"btn btn-primary js-apply-cv-search-query\\\" data-key=\\\"\".concat(index, \"\\\">Apply</button>\"));\n          $card.append(\"<button class=\\\"btn btn-primary ml-2 js-remove-cv-search-query\\\" data-key=\\\"\".concat(index, \"\\\">Remove</button>\"));\n          $container.append($card);\n        });\n      }\n    }]);\n\n    return SearchQuery;\n  }();\n\n  new SearchQuery();\n});\n\n//# sourceURL=webpack:///./src/js/cv-filter.js?");

/***/ })

/******/ });