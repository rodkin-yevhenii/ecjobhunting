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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/ajax.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/ajax.js":
/*!************************!*\
  !*** ./src/js/ajax.js ***!
  \************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nvar _this = void 0;\n\n$(function () {\n  var ajaxUrl = window.siteSettings.ajaxurl;\n  var $publishJobFrom = $('.publish-job-form');\n  var $duplicateJobFrom = $('.duplicate-job-form');\n  var $vacancyHolder = $('.js-vacancies');\n  var $loadMoreBtn = $('.js-load-more');\n  var $filterLoadMoreBtn = $('.js-filter-load-more');\n  var $addBookmarkBtn = $('.add-bookmark');\n  var $applyBtn = $('.js-apply');\n  var $revokeBtn = $('.js-revoke');\n  var $dismissBtn = $('.js-dismiss-job');\n  var $showDismissedJobsBtn = $('.js-show-dismissed-jobs');\n  var $showSuggestedJobsBtn = $('.js-show-dismissed-jobs');\n  var $suggestedJobsContainer = $('.js-suggested-jobs');\n  var $dismissedJobsContainer = $('.js-dismissed-jobs');\n\n  function postJobAjax(data, $messageContainer) {\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      processData: false,\n      contentType: false,\n      dataType: 'json',\n      success: function success(response) {\n        if (response && response.status === 201) {\n          $($messageContainer).removeClass('is-error');\n          $($messageContainer).html(response.message);\n          setTimeout(function () {\n            window.location.replace(response.permalink);\n          }, 3000);\n        } else if (response.status === 404 || response.status === 401) {\n          $($messageContainer).html(response.message);\n          $($messageContainer).addClass('is-error');\n        } else {\n          $($messageContainer).addClass('is-error');\n          $($messageContainer).html('Something went wrong, try again');\n        }\n      }\n    });\n  }\n\n  function loadMoreAjax($holder, $btn) {\n    var paged = $holder.attr('data-paged');\n    var postType = $holder.attr('data-posttype');\n    var perPage = $holder.attr('data-perpage');\n    var offset = perPage * paged;\n    var data = {\n      action: 'load_more',\n      post_type: postType,\n      post_status: 'publish',\n      per_page: perPage,\n      offset: offset\n    };\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      success: function success(response) {\n        if (response.html) {\n          $holder.append(response.html);\n        }\n\n        var shown = Number(offset) + Number(response.itemsCount);\n        $holder.attr('data-paged', ++paged);\n        $holder.attr('data-shown', shown);\n\n        if (Number(response.total) <= shown) {\n          $btn.fadeOut();\n        }\n      }\n    });\n  }\n\n  function filterLoadMore($holder, $btn) {\n    var paged = $holder.attr('data-paged');\n    var per_page = $holder.attr('data-perpage');\n    var s = $('#s').val();\n    var location = $('#location').val();\n    var publish_date = $('#publish-date').val();\n    var compensation = $('#compensation').val();\n    var employment_type = $('#employment-type').val();\n    var category = $('#category').val();\n    var company = $('#company').val();\n    var data = {\n      action: 'filter_load_more',\n      paged: paged,\n      s: s,\n      location: location,\n      publish_date: publish_date,\n      compensation: compensation,\n      employment_type: employment_type,\n      category: category,\n      company: company\n    };\n\n    var success = function success(response) {\n      switch (response.status) {\n        case 501:\n        case 204:\n          console.log(response.status, response.message);\n          $btn.fadeOut();\n          return;\n\n        case 200:\n          if (response.isEnd) {\n            $btn.fadeOut();\n          }\n\n          $vacancyHolder.append(response.html);\n          $vacancyHolder.attr('data-paged', response.paged);\n          break;\n\n        default:\n          console.log('Unknown error');\n      }\n    };\n\n    var error = function error(_error) {\n      console.log(_error);\n    };\n\n    ajaxRequest(data, function () {}, success, error);\n  }\n\n  function ajaxRequest(data) {\n    var beforeCallback = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : function () {};\n    var successCallback = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : function () {};\n    var errorCallback = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : function () {};\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      before: beforeCallback,\n      success: successCallback,\n      error: errorCallback\n    });\n  }\n\n  $applyBtn.on('click', function (event) {\n    event.preventDefault();\n    var $btn = $(event.currentTarget);\n    var text = {\n      apply: $btn.attr('data-apply-text'),\n      revoke: $btn.attr('data-revoke-text')\n    };\n    var data = {\n      action: 'apply_job',\n      vacancyId: $btn.attr('data-vacancy-id')\n    };\n    ajaxRequest(data, function () {}, function (response) {\n      if (response.status !== 200) {\n        console.error(response.status, response.message);\n        return;\n      }\n\n      if (response.message === 'applied') {\n        $btn.text(text.revoke);\n      } else {\n        $btn.text(text.apply);\n      }\n    }, function (error) {\n      console.error(error);\n    });\n  }); // $revokeBtn.on('click', (event) => {\n  //   const $btnRevoke = $(event.currentTarget);\n  //   const $holder = $btnRevoke.parent()\n  //   const $btnApply = $holder.find('.js-apply')\n  //   const data = {\n  //     action: 'revoke_job',\n  //     vacancyId: $btnRevoke.attr('data-vacancy-id')\n  //   }\n  //\n  //   ajaxRequest(\n  //     data,\n  //     () => {},\n  //     (response) => {\n  //       if (response.status === 200) {\n  //         $btnRevoke.fadeOut(0)\n  //         $btnApply.fadeIn(500)\n  //\n  //         return\n  //       }\n  //       console.error(response.status, response.message)\n  //     },\n  //     (error) => {\n  //       console.error(error)\n  //     }\n  //   )\n  // })\n\n  $addBookmarkBtn.on('click', function (event) {\n    event.preventDefault();\n    var $btn = $(event.currentTarget);\n    window.btn = $btn;\n    var id = $btn.parents('.vacancies-item').attr('id');\n    var isAdded = $btn.attr('data-is-added');\n    var $icon = $btn.children('i.fa');\n    var data = {\n      action: 'update_bookmark',\n      id: id,\n      isAdded: isAdded\n    };\n\n    var success = function success(response) {\n      console.log(response);\n\n      if (response.isAdded) {\n        $icon.removeClass('color-grey').addClass('color-gold');\n      } else {\n        $icon.removeClass('color-gold').addClass('color-grey');\n      }\n    };\n\n    var error = function error(_error2) {\n      console.log(_error2);\n    };\n\n    ajaxRequest(data, function () {}, success, error);\n  });\n  $(document).on('click', '.js-dismiss-job', function (event) {\n    event.preventDefault();\n    var $btn = $(event.currentTarget);\n    var $card = $btn.parents('.card-vacancy');\n    var id = $card.attr('id');\n    var data = {\n      action: 'dismiss_job',\n      id: id\n    };\n\n    var success = function success(response) {\n      if (response.status !== 200) {\n        console.log(response.message);\n        return;\n      }\n\n      $('.js-show-dismissed-jobs').show();\n      var $cardClone = $card.parent().clone();\n      $card.parent().remove();\n      $cardClone.appendTo($dismissedJobsContainer);\n      $cardClone.find('.js-dismiss-job').replaceWith('<a class=\"btn btn-outline-primary js-un-dismiss-job\" href=\"#\">Un-Dismiss</a>');\n    };\n\n    var error = function error(_error3) {\n      console.log(_error3);\n    };\n\n    ajaxRequest(data, function () {}, success, error);\n  });\n  $(document).on('click', '.js-un-dismiss-job', function (event) {\n    event.preventDefault();\n    var $btn = $(event.currentTarget);\n    var $card = $btn.parents('.card-vacancy');\n    var id = $card.attr('id');\n    var data = {\n      action: 'un_dismiss_job',\n      id: id\n    };\n\n    var success = function success(response) {\n      if (response.status !== 200) {\n        console.log(response.message);\n        return;\n      }\n\n      var $cardClone = $card.parent().clone();\n      $card.parent().remove();\n      $cardClone.appendTo($suggestedJobsContainer);\n      $cardClone.find('.js-un-dismiss-job').replaceWith('<a class=\"btn btn-outline-primary js-dismiss-job\" href=\"#\">Dismiss</a>');\n    };\n\n    var error = function error(_error4) {\n      console.log(_error4);\n    };\n\n    ajaxRequest(data, function () {}, success, error);\n  });\n  $(document).on('click', '.js-show-dismissed-jobs', function (event) {\n    event.preventDefault();\n    $suggestedJobsContainer.toggle();\n    $dismissedJobsContainer.toggle();\n    $(event.currentTarget).replaceWith('<a class=\"color-primary js-show-suggested-jobs\" href=\"#\"><i class=\"fa fa-angle-left ml-0 mr-2\"></i> View Suggested Jobs</a>');\n  });\n  $(document).on('click', '.js-show-suggested-jobs', function (event) {\n    event.preventDefault();\n    $suggestedJobsContainer.toggle();\n    $dismissedJobsContainer.toggle();\n    var $dismissButton = $('<a>View Dismissed Jobs <i class=\"fa fa-angle-right\"></i></a>');\n    $dismissButton.addClass('color-primary js-show-dismissed-jobs');\n\n    if (!$dismissedJobsContainer.children('div').length) {\n      $dismissButton.css('display', 'none');\n    }\n\n    $(event.currentTarget).replaceWith($dismissButton);\n  });\n  $publishJobFrom.on('click', '[data-select-item]', function () {\n    var select = $(this).parents('[data-select]');\n\n    if (!$(this).hasClass('active')) {\n      var value = $(this).attr('data-key');\n      select.find($('input')).attr('data-value', value);\n      select.children('[data-select-value]').html(value);\n    }\n  });\n  $publishJobFrom.on('click', 'fieldset input', function () {\n    var $input = $(this);\n\n    if ($input.hasClass('selected')) {\n      $input.removeClass('selected');\n    } else {\n      $input.addClass('selected');\n    }\n  });\n  $duplicateJobFrom.on('submit', function (event) {\n    event.preventDefault();\n    var postId = $('#post-job-title-duplicate').val();\n    var author = $duplicateJobFrom.attr('data-author');\n    var submitBtn = $duplicateJobFrom.find('button[type=\"submit\"]');\n    var formData = new FormData();\n    formData.append('action', 'duplicate_job');\n    formData.append('postId', postId || 0);\n    formData.append('author', author || '');\n    postJobAjax(formData, submitBtn);\n  });\n  $publishJobFrom.on('submit', function (event) {\n    event.preventDefault();\n    var submitBtn = $publishJobFrom.find('button[type=submit]:focus');\n    var benefits = [];\n    var agreements = [];\n    var skills = [];\n    $('input[name=\"post-job-benefits[]\"]:checked').each(function (index, item) {\n      benefits.push($(item).attr('id'));\n    });\n    $('input[name=\"post-job-send[]\"]:checked').each(function (index, item) {\n      agreements.push($(item).attr('id'));\n    });\n    var $compensationRange = $('.field-prices input');\n    $('.field-skills-list li').each(function (index, item) {\n      skills.push($(item).attr('data-key'));\n    });\n    var formData = new FormData();\n    formData.append('action', 'create_job');\n    formData.append('id', $(_this).attr('id'));\n    formData.append('status', $(submitBtn).attr('data-status')) || 'draft';\n    formData.append('title', $('#post-job-title').val());\n    formData.append('location', $('#post-job-location').val());\n    formData.append('typeId', $('#employment-type').attr('data-value'));\n    formData.append('description', $('#post-job-description').val());\n    formData.append('benefits', benefits);\n    formData.append('compensationFrom', $($compensationRange[0]).val());\n    formData.append('compensationTo', $($compensationRange[1]).val());\n    formData.append('currency', $('#currency').attr('data-value') || 'USD');\n    formData.append('period', $('#period').attr('data-value') || 'annualy');\n    formData.append('isCommissionIncluded', $('#post-job-commission').val());\n    formData.append('street', $('#post-job-address').val());\n    formData.append('skills', skills);\n    formData.append('company', $('#post-job-company').val());\n    formData.append('reasonsToWork', $('#post-job-why').val());\n    formData.append('companyDesc', $('#post-job-company-description').val());\n    formData.append('notifyMe', $('#post-job-send').val());\n    formData.append('notifyEmail', $('#post-job-send-email').val());\n    formData.append('agreements', agreements);\n    formData.append('author', $publishJobFrom.attr('data-author'));\n    postJobAjax(formData, submitBtn);\n  });\n  $loadMoreBtn.on('click', function (e) {\n    var total = $vacancyHolder.attr('data-total');\n    var itemsShown = $vacancyHolder.attr('data-shown');\n\n    if (total <= itemsShown) {\n      $btn.fadeOut();\n    }\n\n    loadMoreAjax($vacancyHolder, $loadMoreBtn);\n  });\n  $filterLoadMoreBtn.on('click', function (e) {\n    filterLoadMore($vacancyHolder, $filterLoadMoreBtn);\n  });\n  $(document).on('submit', '#register-candidate-form, #register-employer-form', function (e) {\n    e.preventDefault();\n    var $form = $(e.currentTarget);\n    var isEmployer = 'register-employer-form' === $form.attr('id');\n\n    if (isEmployer) {\n      var rules = {\n        email: \"required\",\n        password: \"required\",\n        employer_pwd_confirmation: {\n          equalTo: \".employer_pwd\"\n        }\n      };\n    } else {\n      var _rules = {\n        email: \"required\",\n        password: \"required\",\n        candidate_pwd_confirmation: {\n          equalTo: \".candidate_pwd\"\n        }\n      };\n    }\n\n    var validator = $form.validate({\n      rules: _this.rules,\n      highlight: function highlight(element) {\n        $(element).parent().addClass('form-invalid');\n      },\n      unhighlight: function unhighlight(element) {\n        $(element).parent().removeClass('form-invalid');\n      },\n      messages: {\n        password: \"Incorrect password\",\n        pwd_confirmation: \"<small>Password doesn't match</small>\"\n      }\n    });\n\n    if (!validator.form()) {\n      return;\n    }\n\n    var data = {\n      action: 'register_user',\n      email: $form.find(\"input[name='email']\").val(),\n      username: $form.find(\"input[name='username']\").val(),\n      password: isEmployer ? $form.find(\"input[name='employer_pwd']\").val() : $form.find(\"input[name='candidate_pwd']\").val(),\n      pwd_confirmation: isEmployer ? $form.find(\"input[name='employer_pwd_confirmation']\").val() : $form.find(\"input[name='candidate_pwd_confirmation']\").val(),\n      role: $form.find(\"input[name='role']\").val(),\n      nonce: $form.find(\"input[name='nonce']\").val()\n    };\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      success: function success(response) {\n        var $message = $('.results-content__message');\n        $message.html(response.message);\n\n        if (response.status === 200) {\n          $message.removeClass('alert-danger d-none');\n          $message.addClass('alert-success d-block');\n          setTimeout(function () {\n            window.location.href = '/login/';\n          }, 3000);\n        } else {\n          $message.removeClass('alert-success d-none');\n          $message.addClass('alert-danger d-block');\n        }\n      }\n    });\n  });\n});\n\n//# sourceURL=webpack:///./src/js/ajax.js?");

/***/ })

/******/ });