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
eval("\n\n$(function () {\n  var ajaxUrl = window.siteSettings.ajaxurl;\n  var $publishJobFrom = $('.publish-job-form');\n  var $duplicateJobFrom = $('.duplicate-job-form');\n  var $vacancyHolder = $('.js-vacancies');\n  var $loadMoreBtn = $('.js-load-more');\n  var $filterLoadMoreBtn = $('.js-filter-load-more');\n  var $addBookmarkBtn = $('.add-bookmark');\n  var $applyBtn = $('.js-apply');\n  var $suggestedJobsContainer = $('.js-suggested-jobs');\n  var $dismissedJobsContainer = $('.js-dismissed-jobs');\n  $(document).on('click', '.js-start-chat', function (event) {\n    var _$$attr;\n\n    event.preventDefault();\n    var data = {\n      action: 'create_chat',\n      nonce: $(event.currentTarget).attr('data-nonce'),\n      userId: $(event.currentTarget).attr('data-user-id'),\n      vacancyId: (_$$attr = $(event.currentTarget).attr('data-vacancy-id')) !== null && _$$attr !== void 0 ? _$$attr : ''\n    };\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      success: function success(response) {\n        if (response.status === 200) {\n          window.location.href = \"/messages/?chatId=\".concat(response.data.chatId);\n        } else {\n          console.error(response.message);\n        }\n      }\n    });\n  });\n  $(document).on('click', '.js-employer-my-jobs-types a', function (event) {\n    event.preventDefault();\n\n    if (isAjax !== undefined && isAjax) {\n      return;\n    }\n\n    var isAjax = false;\n    var currentLink = $(event.currentTarget);\n\n    if (currentLink.hasClass('active')) {\n      return;\n    }\n\n    $('.js-employer-my-jobs-types a').removeClass('active');\n    currentLink.addClass('active');\n    var type = currentLink.parent().data('type');\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: {\n        action: 'load_employer_vacancies',\n        url: ajaxUrl,\n        nonce: $('.js-employer-my-jobs-types').data('nonce'),\n        type: type\n      },\n      dataType: 'json',\n      beforeSend: function beforeSend() {\n        isAjax = true;\n      },\n      success: function success(response) {\n        if (response && response.status === 200) {\n          $('.js-employer-my-jobs-container').html(response.html);\n        } else if (response.status === 404) {\n          $('.js-employer-my-jobs-container').html(\"<p>\".concat(response.message, \"</p>\"));\n        } else {\n          console.log(response.message);\n        }\n      }\n    });\n  }); // Duplicate vacancy\n\n  $(document).on('click', '.js-duplicate-job', function (e) {\n    var menuDuplicateItem = $(e.currentTarget);\n    var id = menuDuplicateItem.closest('ul').attr('data-job-id');\n    var author = menuDuplicateItem.closest('ul').attr('data-author');\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: {\n        action: 'duplicate_job',\n        postId: id || 0,\n        author: author || ''\n      },\n      dataType: 'json',\n      beforeSend: function beforeSend() {\n        menuDuplicateItem.removeClass('js-duplicate-job');\n      },\n      success: function success(response) {\n        if (response && response.status === 201) {\n          window.location.replace(response.permalink);\n        } else {\n          console.error(response);\n        }\n      },\n      always: function always() {\n        menuDuplicateItem.addClass('js-duplicate-job');\n      }\n    });\n  });\n  $(document).on('submit', '.js-employer-my-job-search', function (event) {\n    event.preventDefault();\n\n    if (isAjax !== undefined && isAjax) {\n      return;\n    }\n\n    var isAjax = false;\n    var activeFilter = $('.js-employer-my-jobs-types li a.active');\n    var type = activeFilter.parent().data('type');\n    var search = $(event.currentTarget).find('input').val();\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: {\n        action: 'load_employer_vacancies',\n        url: ajaxUrl,\n        nonce: $('.js-employer-my-jobs-types').data('nonce'),\n        type: type,\n        search: search\n      },\n      dataType: 'json',\n      beforeSend: function beforeSend() {\n        isAjax = true;\n      },\n      success: function success(response) {\n        if (response && response.status === 200) {\n          $('.js-employer-my-jobs-container').html(response.html);\n        } else if (response.status === 404) {\n          $('.js-employer-my-jobs-container').html(\"<p>\".concat(response.message, \"</p>\"));\n        } else {\n          console.log(response.message);\n        }\n      }\n    });\n  });\n\n  function postJobAjax(data, $submitBtn) {\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      processData: false,\n      contentType: false,\n      dataType: 'json',\n      beforeSend: function beforeSend() {\n        $submitBtn.prop('disabled', true);\n      },\n      success: function success(response) {\n        if (response && response.status === 201) {\n          $($submitBtn).removeClass('is-error');\n          $($submitBtn).html(response.message);\n          setTimeout(function () {\n            window.location.replace(response.permalink);\n          }, 3000);\n        } else if (response.status === 404 || response.status === 401) {\n          $($submitBtn).html(response.message);\n          $($submitBtn).addClass('is-error');\n        } else {\n          $($submitBtn).addClass('is-error');\n          $($submitBtn).html('Something went wrong, try again');\n        }\n      },\n      always: function always() {\n        $submitBtn.prop('disabled', false);\n      }\n    });\n  }\n\n  function loadMoreAjax($holder, $btn) {\n    var paged = $holder.attr('data-paged');\n    var postType = $holder.attr('data-posttype');\n    var perPage = $holder.attr('data-perpage');\n    var offset = perPage * paged;\n    var data = {\n      action: 'load_more',\n      post_type: postType,\n      post_status: 'publish',\n      per_page: perPage,\n      offset: offset\n    };\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      success: function success(response) {\n        if (response.html) {\n          $holder.append(response.html);\n        }\n\n        var shown = Number(offset) + Number(response.itemsCount);\n        $holder.attr('data-paged', ++paged);\n        $holder.attr('data-shown', shown);\n\n        if (Number(response.total) <= shown) {\n          $btn.fadeOut();\n        }\n      }\n    });\n  }\n\n  function filterLoadMore($holder, $btn) {\n    var paged = $holder.attr('data-paged'); // const per_page = $holder.attr('data-perpage')\n\n    var s = $('#s').val();\n    var location = $('#location').val();\n    var publish_date = $('#publish-date').val();\n    var compensation = $('#compensation').val();\n    var employment_type = $('#employment-type').val();\n    var category = $('#category').val();\n    var company = $('#company').val();\n    var data = {\n      action: 'filter_load_more',\n      paged: paged,\n      s: s,\n      location: location,\n      publish_date: publish_date,\n      compensation: compensation,\n      employment_type: employment_type,\n      category: category,\n      company: company\n    };\n\n    var success = function success(response) {\n      switch (response.status) {\n        case 501:\n        case 204:\n          console.log(response.status, response.message);\n          $btn.fadeOut();\n          return;\n\n        case 200:\n          if (response.isEnd) {\n            $btn.fadeOut();\n          }\n\n          $vacancyHolder.append(response.html);\n          $vacancyHolder.attr('data-paged', response.paged);\n          break;\n\n        default:\n          console.log('Unknown error');\n      }\n    };\n\n    var error = function error(_error) {\n      console.log(_error);\n    };\n\n    ajaxRequest(data, function () {}, success, error);\n  }\n\n  function ajaxRequest(data) {\n    var beforeCallback = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : function () {};\n    var successCallback = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : function () {};\n    var errorCallback = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : function () {};\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      before: beforeCallback,\n      success: successCallback,\n      error: errorCallback\n    });\n  }\n\n  $applyBtn.on('click', function (event) {\n    event.preventDefault();\n\n    if (isAjax) {\n      return;\n    }\n\n    var isAjax = false;\n    var $btn = $(event.currentTarget);\n    var data = {\n      action: 'apply_job',\n      vacancyId: $btn.attr('data-vacancy-id')\n    };\n    ajaxRequest(data, function () {\n      isAjax = true;\n    }, function (response) {\n      isAjax = false;\n\n      if (response.status !== 200) {\n        console.error(response.status, response.message);\n        return;\n      }\n\n      if (response.message === 'applied') {\n        $btn.text('Already Applied');\n        $btn.attr('disabled', true);\n      }\n    }, function (error) {\n      console.error(error);\n    });\n  });\n  $addBookmarkBtn.on('click', function (event) {\n    event.preventDefault();\n    var $btn = $(event.currentTarget);\n    window.btn = $btn;\n    var id = $btn.parents('.vacancies-item').attr('id');\n    var isAdded = $btn.attr('data-is-added');\n    var $icon = $btn.children('i.fa');\n    var data = {\n      action: 'update_bookmark',\n      id: id,\n      isAdded: isAdded\n    };\n\n    var success = function success(response) {\n      console.log(response);\n\n      if (response.isAdded) {\n        $icon.removeClass('color-grey').addClass('color-gold');\n      } else {\n        $icon.removeClass('color-gold').addClass('color-grey');\n      }\n    };\n\n    var error = function error(_error2) {\n      console.log(_error2);\n    };\n\n    ajaxRequest(data, function () {}, success, error);\n  });\n  $(document).on('click', '.js-dismiss-job', function (event) {\n    event.preventDefault();\n    var $btn = $(event.currentTarget);\n    var $card = $btn.parents('.card-vacancy');\n    var id = $card.attr('id');\n    var data = {\n      action: 'dismiss_job',\n      id: id\n    };\n\n    var success = function success(response) {\n      if (response.status !== 200) {\n        console.log(response.message);\n        return;\n      }\n\n      $('.js-show-dismissed-jobs').show();\n      var $cardClone = $card.parent().clone();\n      $card.parent().remove();\n      $cardClone.appendTo($dismissedJobsContainer);\n      $cardClone.find('.js-dismiss-job').replaceWith('<a class=\"btn btn-outline-primary js-un-dismiss-job\" href=\"#\">Un-Dismiss</a>');\n    };\n\n    var error = function error(_error3) {\n      console.log(_error3);\n    };\n\n    ajaxRequest(data, function () {}, success, error);\n  });\n  $(document).on('click', '.js-un-dismiss-job', function (event) {\n    event.preventDefault();\n    var $btn = $(event.currentTarget);\n    var $card = $btn.parents('.card-vacancy');\n    var id = $card.attr('id');\n    var data = {\n      action: 'un_dismiss_job',\n      id: id\n    };\n\n    var success = function success(response) {\n      if (response.status !== 200) {\n        console.log(response.message);\n        return;\n      }\n\n      var $cardClone = $card.parent().clone();\n      $card.parent().remove();\n      $cardClone.appendTo($suggestedJobsContainer);\n      $cardClone.find('.js-un-dismiss-job').replaceWith('<a class=\"btn btn-outline-primary js-dismiss-job\" href=\"#\">Dismiss</a>');\n    };\n\n    var error = function error(_error4) {\n      console.log(_error4);\n    };\n\n    ajaxRequest(data, function () {}, success, error);\n  });\n  $(document).on('click', '.js-show-dismissed-jobs', function (event) {\n    event.preventDefault();\n    $('li[data-tab-item=suggested]').click();\n    $suggestedJobsContainer.toggle();\n    $dismissedJobsContainer.toggle();\n    $(event.currentTarget).replaceWith('<a class=\"color-primary js-show-suggested-jobs\" href=\"#\"><i class=\"fa fa-angle-left ml-0 mr-2\"></i> View Suggested Jobs</a>');\n  });\n  $(document).on('click', '.js-show-suggested-jobs', function (event) {\n    event.preventDefault();\n    $('li[data-tab-item=suggested]').click();\n    $suggestedJobsContainer.toggle();\n    $dismissedJobsContainer.toggle();\n    var $dismissButton = $('<a>View Dismissed Jobs <i class=\"fa fa-angle-right\"></i></a>');\n    $dismissButton.addClass('color-primary js-show-dismissed-jobs');\n\n    if (!$dismissedJobsContainer.children('div').length) {\n      $dismissButton.css('display', 'none');\n    }\n\n    $(event.currentTarget).replaceWith($dismissButton);\n  });\n  $publishJobFrom.on('click', '[data-select-item]', function () {\n    var select = $(this).parents('[data-select]');\n\n    if (!$(this).hasClass('active')) {\n      var value = $(this).attr('data-key');\n      select.find($('input')).attr('data-value', value);\n      select.children('[data-select-value]').html(value);\n    }\n  });\n  $publishJobFrom.on('click', 'fieldset input', function () {\n    var $input = $(this);\n\n    if ($input.hasClass('selected')) {\n      $input.removeClass('selected');\n    } else {\n      $input.addClass('selected');\n    }\n  });\n  $duplicateJobFrom.on('submit', function (event) {\n    event.preventDefault();\n    var postId = $('#post-job-title-duplicate').val();\n    var author = $duplicateJobFrom.attr('data-author');\n    var submitBtn = $duplicateJobFrom.find('button[type=\"submit\"]');\n    var formData = new FormData();\n    formData.append('action', 'duplicate_job');\n    formData.append('postId', postId || 0);\n    formData.append('author', author || '');\n    postJobAjax(formData, submitBtn);\n  });\n  $publishJobFrom.on('submit', function (event) {\n    event.preventDefault();\n    var submitBtn = $publishJobFrom.find('button[type=submit]:focus');\n    var benefits = [];\n    var agreements = [];\n    var skills = [];\n    var emails = [];\n    $('input[name=\"post-job-benefits[]\"]:checked').each(function (index, item) {\n      benefits.push($(item).attr('id'));\n    });\n    $('input[name=\"post-job-send[]\"]:checked').each(function (index, item) {\n      agreements.push($(item).attr('id'));\n    });\n    var fileInput = $('#post-company-logo');\n    var file = null;\n\n    if (fileInput.length && fileInput[0].files !== undefined && fileInput[0].files.length) {\n      file = fileInput[0].files[0];\n    }\n\n    var $compensationRange = $('.field-prices input');\n    $('.js-skills-list li').each(function (index, item) {\n      skills.push($(item).attr('data-key'));\n    });\n    $('.js-emails-list li').each(function (index, item) {\n      emails.push($(item).attr('data-key'));\n    });\n    var formData = new FormData();\n    formData.append('action', 'create_job');\n    formData.append('id', $(event.currentTarget).attr('id'));\n    formData.append('status', $(submitBtn).attr('data-status')) || 'draft';\n    formData.append('logo', file);\n    formData.append('title', $('#post-job-title').val());\n    formData.append('location', $('#post-job-location').val());\n    formData.append('category', $('#post-job-category').val());\n    formData.append('typeId', $('#employment-type').attr('data-value'));\n    formData.append('description', $('#post-job-description').val());\n    formData.append('benefits', benefits);\n    formData.append('compensationFrom', $($compensationRange[0]).val());\n    formData.append('compensationTo', $($compensationRange[1]).val());\n    formData.append('currency', $('#currency').attr('data-value') || 'USD');\n    formData.append('period', $('#period').attr('data-value') || 'annualy');\n    formData.append('isCommissionIncluded', $('#post-job-commission').is(':checked'));\n    formData.append('street', $('#post-job-address').val());\n    formData.append('skills', skills);\n    formData.append('company', $('#post-job-company').val());\n    formData.append('reasonsToWork', $('#post-job-why').val());\n    formData.append('companyDesc', $('#post-job-company-description').val());\n    formData.append('notifyMe', $('#post-job-send').is(':checked'));\n    formData.append('agreements', agreements);\n    formData.append('emails', emails);\n    formData.append('author', $publishJobFrom.attr('data-author'));\n    postJobAjax(formData, submitBtn);\n  });\n  $loadMoreBtn.on('click', function () {\n    var total = $vacancyHolder.attr('data-total');\n    var itemsShown = $vacancyHolder.attr('data-shown');\n\n    if (total <= itemsShown) {\n      $btn.fadeOut();\n    }\n\n    loadMoreAjax($vacancyHolder, $loadMoreBtn);\n  });\n  $filterLoadMoreBtn.on('click', function () {\n    filterLoadMore($vacancyHolder, $filterLoadMoreBtn);\n  });\n  $(document).on('submit', '#register-candidate-form, #register-employer-form', function (e) {\n    e.preventDefault();\n    var $form = $(e.currentTarget);\n    var isEmployer = 'register-employer-form' === $form.attr('id');\n    var rules;\n\n    if (isEmployer) {\n      rules = {\n        email: \"required\",\n        password: \"required\",\n        employer_pwd_confirmation: {\n          equalTo: \".employer_pwd\"\n        }\n      };\n    } else {\n      rules = {\n        email: \"required\",\n        password: \"required\",\n        candidate_pwd_confirmation: {\n          equalTo: \".candidate_pwd\"\n        }\n      };\n    }\n\n    console.log(rules);\n    var validator = $form.validate({\n      rules: rules,\n      highlight: function highlight(element) {\n        $(element).parent().addClass('form-invalid');\n      },\n      unhighlight: function unhighlight(element) {\n        $(element).parent().removeClass('form-invalid');\n      },\n      messages: {\n        password: \"Incorrect password\",\n        pwd_confirmation: \"<small>Password doesn't match</small>\"\n      }\n    });\n\n    if (!validator.form()) {\n      return;\n    }\n\n    var data = {\n      action: 'register_user',\n      email: $form.find(\"input[name='email']\").val(),\n      username: $form.find(\"input[name='username']\").val(),\n      password: isEmployer ? $form.find(\"input[name='employer_pwd']\").val() : $form.find(\"input[name='candidate_pwd']\").val(),\n      pwd_confirmation: isEmployer ? $form.find(\"input[name='employer_pwd_confirmation']\").val() : $form.find(\"input[name='candidate_pwd_confirmation']\").val(),\n      role: $form.find(\"input[name='role']\").val(),\n      nonce: $form.find(\"input[name='nonce']\").val()\n    };\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      success: function success(response) {\n        var $message = $('.results-content__message');\n        $message.html(response.message);\n\n        if (response.status === 200) {\n          $message.removeClass('alert-danger d-none');\n          $message.addClass('alert-success d-block');\n          setTimeout(function () {\n            window.location.href = '/login/';\n          }, 3000);\n        } else {\n          $message.removeClass('alert-success d-none');\n          $message.addClass('alert-danger d-block');\n        }\n      }\n    });\n  });\n  $(document).on('click', '.rate-button', function (event) {\n    event.preventDefault();\n\n    if (isAjax) {\n      return;\n    }\n\n    var isAjax = false;\n    var currentButton = $(event.currentTarget);\n    var buttons = currentButton.parent().find('.rate-button');\n    buttons.each(function (index, item) {\n      $(item).removeClass('active');\n    });\n    currentButton.addClass('active');\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: {\n        action: 'rate_candidate',\n        userId: currentButton.parent().attr('data-user'),\n        rating: currentButton.attr('data-rate'),\n        nonce: currentButton.parent().attr('data-nonce')\n      },\n      dataType: 'json',\n      beforeSend: function beforeSend() {\n        isAjax = true;\n      },\n      success: function success(response) {\n        if (response.status !== 200) {\n          console.error(response.status, response.message);\n        }\n\n        isAjax = false;\n      }\n    });\n  });\n  $(document).on('click', '.js-vacancies-filter li', function (event) {\n    event.preventDefault();\n    var li = $(event.currentTarget);\n    var id = li.attr('data-id');\n    $('#vacancy').val(id);\n    $(\".vacancies-select li[data-id=\".concat(id, \"]\")).click();\n  });\n  $(document).on('click', '.js-vacancies-select li', function (event) {\n    event.preventDefault();\n\n    if (isAjax) {\n      return;\n    }\n\n    var isAjax = false;\n    var li = $(event.currentTarget);\n    var id = li.attr('data-id');\n    var userType = $('.js-employer-candidates-types').attr('data-users-type');\n    $('#vacancy').val(id);\n    var data = {\n      action: userType === 'candidates' ? 'load_vacancy_candidates' : 'load_vacancy_visitors',\n      id: li.attr('data-id'),\n      type: $('.js-employer-candidates-types a.active').parent().attr('data-type'),\n      nonce: li.parents('.employer').attr('data-nonce')\n    };\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      beforeSend: function beforeSend() {\n        isAjax = true;\n      },\n      success: function success(response) {\n        if (response && response.status === 200) {\n          $('.js-candidates-container').html(response.html);\n          $('.js-users-counter').html(\"(\".concat(response.data.count, \")\"));\n        } else if (response.status === 404) {\n          $('.js-candidates-container').html(\"<p>\".concat(response.message, \"</p>\"));\n          $('.js-users-counter').html('(0)');\n        } else {\n          console.log(response.message);\n        }\n\n        isAjax = false;\n      }\n    });\n  });\n  $(document).on('click', '.js-employer-candidates-types li', function (event) {\n    event.preventDefault();\n\n    if (isAjax) {\n      return;\n    }\n\n    var isAjax = false;\n    var action;\n    var currentLi = $(event.currentTarget);\n    var id = $('#vacancy').val();\n    var userType = $('.js-employer-candidates-types').attr('data-users-type');\n    currentLi.parent().find('li a').removeClass('active');\n    currentLi.find('a').addClass('active');\n    console.log(userType, id);\n\n    if (userType === 'candidates' && !!id) {\n      action = 'load_vacancy_candidates';\n    } else if (userType === 'visitors' && !!id) {\n      action = 'load_vacancy_visitors';\n    } else if (userType === 'candidates') {\n      action = 'load_employer_candidates';\n    } else {\n      action = 'load_employer_visitors';\n    }\n\n    var data = {\n      action: action,\n      id: id,\n      userType: userType,\n      type: currentLi.attr('data-type'),\n      nonce: currentLi.parents('.employer').attr('data-nonce')\n    };\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      beforeSend: function beforeSend() {\n        isAjax = true;\n      },\n      success: function success(response) {\n        if (response && response.status === 200) {\n          $('.js-candidates-container').html(response.html);\n          $('.js-users-counter').html(\"(\".concat(response.data.count, \")\"));\n        } else if (response.status === 404) {\n          $('.js-candidates-container').html(\"<p>\".concat(response.message, \"</p>\"));\n          $('.js-users-counter').html('(0)');\n        } else {\n          console.log(response.message);\n        }\n\n        isAjax = false;\n      }\n    });\n  });\n  $(document).on('click', '.js-subscription-card input[name=submit]', function () {\n    if (isAjax) {\n      return;\n    }\n\n    var isAjax = false;\n    var $card = $(this).closest('.js-subscription-card');\n    var $form = $card.find('form');\n    var data = {\n      action: 'activate_subscription_trial',\n      subscriptionId: $card.attr('data-subscriptionId'),\n      trialPeriod: $form.find('input[name=p1]').val(),\n      nonce: $card.attr('data-nonce')\n    };\n    $.ajax({\n      type: 'POST',\n      url: ajaxUrl,\n      data: data,\n      dataType: 'json',\n      beforeSend: function beforeSend() {\n        isAjax = true;\n      },\n      success: function success() {\n        $card.find('form').remove();\n        isAjax = false;\n      }\n    });\n  });\n});\n\n//# sourceURL=webpack:///./src/js/ajax.js?");

/***/ })

/******/ });