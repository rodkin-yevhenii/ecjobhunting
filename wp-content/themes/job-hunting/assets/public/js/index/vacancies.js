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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/vacancies.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/vacancies.js":
/*!*****************************!*\
  !*** ./src/js/vacancies.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nfunction asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }\n\nfunction _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, \"next\", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, \"throw\", err); } _next(undefined); }); }; }\n\nfunction getVacancy(_x) {\n  return _getVacancy.apply(this, arguments);\n}\n\nfunction _getVacancy() {\n  _getVacancy = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee(id) {\n    var response;\n    return regeneratorRuntime.wrap(function _callee$(_context) {\n      while (1) {\n        switch (_context.prev = _context.next) {\n          case 0:\n            _context.next = 2;\n            return fetch(\"/wp-json/wp/v2/vacancies/\".concat(id), {\n              method: 'GET',\n              headers: {\n                'Content-Type': 'application/json;charset=utf-8'\n              }\n            });\n\n          case 2:\n            response = _context.sent;\n            _context.next = 5;\n            return response.json();\n\n          case 5:\n            return _context.abrupt(\"return\", _context.sent);\n\n          case 6:\n          case \"end\":\n            return _context.stop();\n        }\n      }\n    }, _callee);\n  }));\n  return _getVacancy.apply(this, arguments);\n}\n\nfunction updateVacancy(_x2, _x3) {\n  return _updateVacancy.apply(this, arguments);\n}\n\nfunction _updateVacancy() {\n  _updateVacancy = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee2(id, dataset) {\n    var response;\n    return regeneratorRuntime.wrap(function _callee2$(_context2) {\n      while (1) {\n        switch (_context2.prev = _context2.next) {\n          case 0:\n            _context2.next = 2;\n            return fetch(\"/wp-json/wp/v2/vacancies/\".concat(id), {\n              method: 'PUT',\n              headers: {\n                'Content-Type': 'application/json;charset=utf-8',\n                'Authorization': 'Basic ' + window._basic\n              },\n              body: JSON.stringify(dataset)\n            });\n\n          case 2:\n            response = _context2.sent;\n            return _context2.abrupt(\"return\", response);\n\n          case 4:\n          case \"end\":\n            return _context2.stop();\n        }\n      }\n    }, _callee2);\n  }));\n  return _updateVacancy.apply(this, arguments);\n}\n\n$(function () {\n  var $edit = $('.js-edit-job');\n  var $duplicate = $('.js-duplicate-job');\n  var $delete = $('.js-delete-job');\n  var $publish = $('.js-publish-job');\n  var $archive = $('.js-archive-job');\n  var $modal = $('.ec-job-modal');\n  $edit.on('click', function (e) {\n    $modal.removeClass('is-hidden');\n    var id = $(e.currentTarget).closest('ul').attr('data-job-id');\n    var response = getVacancy(id);\n    response.then(function (r) {\n      var job = {\n        title: r.title,\n        jobLocation: r.location,\n        employmentType: r.employmentType,\n        jobDescription: r.content.rendered,\n        benefits: r.meta.benefits,\n        compensationFrom: r.meta.compensation_range_from[0],\n        compensationTo: r.meta.compensation_range_to[0],\n        currency: r.meta.compensation_currency,\n        period: r.meta.compensation_period,\n        isCommissionIncluded: Boolean(r.meta.is_commission_included[0]),\n        street: r.meta.street_address,\n        reasonToWork: r.meta.why_work_at_this_company,\n        skills: r.skills,\n        companyName: r.meta.hiring_company,\n        companyDesc: r.meta.hiring_company_description,\n        notifyMe: r.meta.send_new_candidates_to,\n        emailsToInform: r.meta.emails_to_inform,\n        options: r.meta.additional_options\n      };\n      console.log(job);\n      var skills = job.skills.map(function (item) {\n        return '<li data-key=\"' + item + '\"><span>' + item + '</span><span class=\"field-skills-close\"></span></li>';\n      });\n      job.options.forEach(function (item) {\n        $('#' + item).attr('checked', 'checked');\n      });\n      job.benefits.forEach(function (item) {\n        $('#' + item).attr('checked', 'checked');\n      });\n      $('#post-job-title').val(job.title);\n      $('#post-job-location').val(job.jobLocation.join(', '));\n      $('#employment-type').val(job.employmentType);\n      $('#post-job-description').val(job.jobDescription);\n      $('#compensation_from').val(job.compensationFrom);\n      $('#compensation_to').val(job.compensationTo);\n      $('#post-job-address').val(job.street);\n      $('.field-skills-list').html(skills.join(''));\n      $('#post-job-company').val(job.companyName);\n      $('#post-job-company-description').val(job.companyDesc);\n      $('#post-job-why').val(job.reasonToWork);\n      if (job.isCommissionIncluded) $('#post-job-commission').attr('checked', 'checked');\n    });\n  });\n  $modal.on('click', '.close', function () {\n    $modal.addClass('is-hidden');\n  });\n  $publish.on('click', function (e) {\n    var dataset = {\n      status: 'publish'\n    };\n    var id = $(e.currentTarget).closest('ul').attr('data-job-id');\n    var promise = updateVacancy(id, dataset);\n    promise.then(function (response) {\n      return response.json();\n    }).then(function (data) {\n      console.log(data);\n    })[\"catch\"](function (err) {\n      console.log(err);\n    });\n  });\n});\n\n//# sourceURL=webpack:///./src/js/vacancies.js?");

/***/ })

/******/ });