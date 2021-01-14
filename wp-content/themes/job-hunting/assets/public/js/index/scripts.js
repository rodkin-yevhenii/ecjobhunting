"use strict";

$(function () {
  var wrapper = $('.wrapper'),
      body = $('body'),
      headerButtonWrapper = $('.header-button-wrapper'),
      headerAccountWrapper = headerButtonWrapper.length ? headerButtonWrapper : $('.header-account-wrapper'),
      headerAccount = headerButtonWrapper.length ? headerButtonWrapper.children('.btn') : headerAccountWrapper.children('.header-account'),
      headerNav = $('.header nav');
  setTimeout(function () {
    wrapper.animate({
      opacity: 1
    }, 500);
  }, 500);
  pageRepaint();
  $('.candidate-list').slick({
    slidesToShow: 3,
    dots: false,
    arrows: true,
    responsive: [{
      breakpoint: 1200,
      settings: {
        slidesToShow: 2,
        dots: false,
        arrows: true
      }
    }, {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
        dots: true,
        arrows: false
      }
    }]
  });
  var noUiSliderCustom = $('[data-noui-slider]');
  noUiSliderCustom.each(function () {
    var step = parseInt($(this).attr('data-noui-step')),
        start = parseInt($(this).attr('data-noui-start')),
        end = parseInt($(this).attr('data-noui-end'));
    noUiSlider.create(this, {
      start: start,
      step: step,
      range: {
        'min': start,
        'max': end
      }
    });
    var resumeMilesValue = $('[data-noui-value="' + $(this).attr('data-noui-slider') + '"]');
    this.noUiSlider.on('update', function (values, handle) {
      resumeMilesValue.get(0).innerHTML = Math.abs(values[handle]);
    });
  });
  $(document).ready(function () {
    $('li.profile-menu.active-item').attr('data-select-value', 'true');
  });
  $(window).on('resize', function () {
    pageRepaint();
  });
  $(document).on('click', function (event) {
    var target = $(event.target);
    if (!target.closest('[data-tab-value]').length || !target.closest('[data-tab-value]').length) $('[data-tab]').removeClass('active');

    if (!target.closest('[data-handler]').length && !target.closest('[data-dropdown]').length) {
      $('[data-handler]').removeClass('active');
      $('[data-dropdown]').removeClass('active');
    }

    if (!target.closest('[data-select]').length) {
      $('[data-select]').removeClass('active');
      $('[data-select-value]').removeClass('active');
    }
  });
  $(document).on('click', '.header-burger', function () {
    body.toggleClass('menu-opened');
  });
  $(document).on('click', '.filter-database-handler', function () {
    $(this).toggleClass('active');
    $('.filter-database').toggleClass('active');
  });
  $(document).on('click', '.see-more', function () {
    $(this).toggleClass('active');
    $(this).siblings('.see-more-hidden').toggleClass('active');
  });
  $(document).on('click', '[data-select-value]', function () {
    var select = $(this).parents('[data-select]');

    if (!select.hasClass('disabled')) {
      if (select.hasClass('active')) {
        $(this).removeClass('active');
        select.removeClass('active');
      } else {
        $('[data-select-value]').removeClass('active');
        $('[data-select]').removeClass('active');
        $(this).addClass('active');
        select.addClass('active');
      }
    }
  });
  $(document).on('click', '[data-select-item]', function () {
    var select = $(this).parents('[data-select]');

    if (!$(this).hasClass('active')) {
      $(this).siblings().removeClass('active');
      $(this).addClass('active');
      var value = $(this).html();
      select.find($('input')).val(value);
      select.children('[data-select-value]').html(value);
      select.removeClass('active');
    }
  });
  $(document).on('click', '.custom-handler div', function () {
    var handler = $(this).parents('.custom-handler'),
        form = handler.next('form'),
        fields = form.find('input');

    if (handler.hasClass('active')) {
      handler.removeClass('active');
      form.addClass('disabled');
      fields.each(function () {
        $(this).attr('disabled', true);
      });
    } else {
      handler.addClass('active');
      form.removeClass('disabled');
      fields.each(function () {
        $(this).attr('disabled', null);
      });
    }
  });
  $(document).on('click', '[data-handler]', function () {
    var target = $(this).attr('data-handler');
    $('[data-dropdown="' + target + '"]').toggleClass('active');
    $(this).toggleClass('active');
  });
  $(document).on('click', '[data-tab-value]', function () {
    var parent = $(this).parents('[data-tab]');
    $(this).toggleClass('active');
    parent.toggleClass('active');
  });
  $(document).on('click', '[data-tab-item]', function () {
    var parent = $(this).parents('[data-tab]');

    if (!$(this).hasClass('active')) {
      if ($(window).width() < 768 && parent.find('[data-tab-value]').length) {
        var text = $(this).text();
        parent.find('[data-tab-value]').find('span').text(text);
        parent.removeClass('active');
      }

      var index = $(this).attr('data-tab-item');
      $(this).addClass('active');
      $(this).siblings('.active').removeClass('active');
      var previousItem = parent.find('.active[data-tab-content]');
      var currentItem = parent.find('[data-tab-content="' + index + '"]');
      previousItem.removeClass('active');
      currentItem.addClass('active');
    }
  });
  $(document).on('click', '[data-tab-back]', function () {
    var parent = $(this).parents('[data-tab]');
    parent.find("[data-tab-item]").removeClass('active');
    parent.find("[data-tab-content]").removeClass('active');
  });
  $(document).on('click', '.field-skills-close', function () {
    $(this).parents('li').detach();
  });
  $(document).on('click', '.field-skills-panel button', function () {
    addSkill($(this).parents('.field-skills'));
  });
  $(document).on('keydown', '.field-skills-panel input', function (event) {
    if (event.keyCode === 13) {
      event.preventDefault();
      addSkill($(this).parents('.field-skills'));
    }
  });

  function addSkill(skills) {
    var input = $(skills).find('input:not([type="hidden"])'),
        value = input.val(),
        list = $(skills).find('ul');

    if (value && value.length) {
      $("<li data-key=\"".concat(value, "\"><span>").concat(value, "</span><span class=\"field-skills-close\"></span></li>")).appendTo(list);
      input.val('');
    }
  }

  function repaintTablet() {
    headerAccount.appendTo(headerAccountWrapper);
    setMessagesTablet();
  }

  function repaintMobile() {
    headerAccount.appendTo(headerNav);
    setMessagesMobile();
  }

  function pageRepaint() {
    if ($(window).width() < 768) {
      repaintMobile();
    } else {
      repaintTablet();
    }
  }

  function setMessagesMobile() {
    var messages = $('.messages [data-tab]');

    if (messages.length && messages.find('.messages-content.active').length) {
      messages.find('.messages-content').removeClass('active');
      messages.find('[data-tab-item]').removeClass('active');
    }
  }

  function setMessagesTablet() {
    var messages = $('.messages [data-tab]');

    if (messages.length && messages.find('.messages-content.active').length === 0) {
      var value = messages.find('.messages-content').eq(0).attr('data-tab-content');
      messages.find('.messages-content').eq(0).addClass('active');
      messages.find("[data-tab-item=\"".concat(value, "\"]")).addClass('active');
    }
  }
});
"use strict";

var _this = void 0;

$(function () {
  var ajaxUrl = window.siteSettings.ajaxurl;
  var $publishJobFrom = $('.publish-job-form');
  var $duplicateJobFrom = $('.duplicate-job-form');
  var $vacancyHolder = $('.js-vacancies');
  var $loadMoreBtn = $('.js-load-more');

  function postJobAjax(data, $messageContainer) {
    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: data,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function success(response) {
        if (response && response.status === 201) {
          $($messageContainer).removeClass('is-error');
          $($messageContainer).html(response.message);
          setTimeout(function () {
            window.location.replace(response.permalink);
          }, 3000);
        } else if (response.status === 404 || response.status === 401) {
          $($messageContainer).html(response.message);
          $($messageContainer).addClass('is-error');
        } else {
          $($messageContainer).addClass('is-error');
          $($messageContainer).html('Something went wrong, try again');
        }
      }
    });
  }

  function loadMoreAjax($holder, $btn) {
    var paged = $holder.attr('data-paged');
    var postType = $holder.attr('data-posttype');
    var perPage = $holder.attr('data-perpage');
    var offset = perPage * paged;
    var data = {
      action: 'load_more',
      post_type: postType,
      post_status: 'publish',
      per_page: perPage,
      offset: offset
    };
    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: data,
      dataType: "json",
      success: function success(response) {
        if (response.html) {
          $holder.append(response.html);
        }

        var shown = Number(offset) + Number(response.itemsCount);
        $holder.attr('data-paged', ++paged);
        $holder.attr('data-shown', shown);

        if (Number(response.total) <= shown) {
          $btn.fadeOut();
        }
      }
    });
  }

  $publishJobFrom.on('click', '[data-select-item]', function () {
    var select = $(this).parents('[data-select]');

    if (!$(this).hasClass('active')) {
      var value = $(this).attr('data-key');
      select.find($('input')).attr('data-value', value);
      select.children('[data-select-value]').html(value);
    }
  });
  $publishJobFrom.on('click', 'fieldset input', function () {
    var $input = $(this);

    if ($input.hasClass('selected')) {
      $input.removeClass('selected');
    } else {
      $input.addClass('selected');
    }
  });
  $duplicateJobFrom.on('submit', function (event) {
    event.preventDefault();
    var postId = $('#post-job-title-duplicate').val();
    var author = $duplicateJobFrom.attr('data-author');
    var submitBtn = $duplicateJobFrom.find('button[type="submit"]');
    var formData = new FormData();
    formData.append('action', 'duplicate_job');
    formData.append('postId', postId || 0);
    formData.append('author', author || '');
    postJobAjax(formData, submitBtn);
  });
  $publishJobFrom.on('submit', function (event) {
    event.preventDefault();
    var submitBtn = $publishJobFrom.find("button[type=submit]:focus");
    var benefits = [];
    var agreements = [];
    var skills = [];
    $('input[name="post-job-benefits[]"]:checked').each(function (index, item) {
      benefits.push($(item).attr('id'));
    });
    $('input[name="post-job-send[]"]:checked').each(function (index, item) {
      agreements.push($(item).attr('id'));
    });
    var $compensationRange = $('.field-prices input');
    $('.field-skills-list li').each(function (index, item) {
      skills.push($(item).attr('data-key'));
    });
    var formData = new FormData();
    formData.append('action', 'create_job');
    formData.append('id', $(_this).attr('id'));
    formData.append('status', $(submitBtn).attr('data-status')) || 'draft';
    formData.append('title', $('#post-job-title').val());
    formData.append('location', $('#post-job-location').val());
    formData.append('typeId', $('#employment-type').attr('data-value'));
    formData.append('description', $('#post-job-description').val());
    formData.append('benefits', benefits);
    formData.append('compensationFrom', $($compensationRange[0]).val());
    formData.append('compensationTo', $($compensationRange[1]).val());
    formData.append('currency', $('#currency').attr('data-value') || 'USD');
    formData.append('period', $('#period').attr('data-value') || 'annualy');
    formData.append('isCommissionIncluded', $('#post-job-commission').val());
    formData.append('street', $('#post-job-address').val());
    formData.append('skills', skills);
    formData.append('company', $('#post-job-company').val());
    formData.append('reasonsToWork', $('#post-job-why').val());
    formData.append('companyDesc', $('#post-job-company-description').val());
    formData.append('notifyMe', $('#post-job-send').val());
    formData.append('notifyEmail', $('#post-job-send-email').val());
    formData.append('agreements', agreements);
    formData.append('author', $publishJobFrom.attr('data-author'));
    postJobAjax(formData, submitBtn);
  });
  $loadMoreBtn.on('click', function (e) {
    var total = $vacancyHolder.attr('data-total');
    var itemsShown = $vacancyHolder.attr('data-shown');

    if (total <= itemsShown) {
      $btn.fadeOut();
    }

    loadMoreAjax($vacancyHolder, $loadMoreBtn);
  });
});