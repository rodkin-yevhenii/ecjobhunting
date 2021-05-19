$(() => {
  const ajaxUrl = window.siteSettings.ajaxurl;
  const $publishJobFrom = $('.publish-job-form');
  const $duplicateJobFrom = $('.duplicate-job-form');
  const $vacancyHolder = $('.js-vacancies');
  const $loadMoreBtn = $('.js-load-more');
  const $filterLoadMoreBtn = $('.js-filter-load-more');
  const $addBookmarkBtn = $('.add-bookmark');
  const $applyBtn = $('.js-apply');
  const $revokeBtn = $('.js-revoke');
  const $dismissBtn = $('.js-dismiss');

  function postJobAjax(data, $messageContainer) {
    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: data,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function (response) {
        if (response && response.status === 201) {
          $($messageContainer).removeClass('is-error');
          $($messageContainer).html(response.message);
          setTimeout(() => {
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
    let paged = $holder.attr('data-paged');
    const postType = $holder.attr('data-posttype');
    const perPage = $holder.attr('data-perpage');
    const offset = perPage * paged;
    const data = {
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
      dataType: 'json',
      success: function (response) {
        if (response.html) {
          $holder.append(response.html);
        }

        const shown = Number(offset) + Number(response.itemsCount);
        $holder.attr('data-paged', ++paged);
        $holder.attr('data-shown', shown);

        if (Number(response.total) <= shown) {
          $btn.fadeOut();
        }
      }
    });
  }

  function filterLoadMore($holder, $btn) {
    const paged = $holder.attr('data-paged');
    const per_page = $holder.attr('data-perpage');
    const s = $('#s').val();
    const location = $('#location').val();
    const publish_date = $('#publish-date').val();
    const compensation = $('#compensation').val();
    const employment_type = $('#employment-type').val();
    const category = $('#category').val();
    const company = $('#company').val();
    const data = {
      action: 'filter_load_more',
      paged,
      s,
      location,
      publish_date,
      compensation,
      employment_type,
      category,
      company
    };

    const success = response => {
      switch (response.status) {
        case 501:
        case 204:
          console.log(response.status, response.message);
          $btn.fadeOut();
          return;

        case 200:
          if (response.isEnd) {
            $btn.fadeOut();
          }

          $vacancyHolder.append(response.html);
          $vacancyHolder.attr('data-paged', response.paged);
          break;

        default:
          console.log('Unknown error');
      }
    };

    const error = error => {
      console.log(error);
    };

    ajaxRequest(data, () => {}, success, error);
  }

  function ajaxRequest(data, beforeCallback = () => {}, successCallback = () => {}, errorCallback = () => {}) {
    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: data,
      dataType: 'json',
      before: beforeCallback,
      success: successCallback,
      error: errorCallback
    });
  }

  $applyBtn.on('click', event => {
    event.preventDefault();
    const $btn = $(event.currentTarget);
    const text = {
      apply: $btn.attr('data-apply-text'),
      revoke: $btn.attr('data-revoke-text')
    };
    const data = {
      action: 'apply_job',
      vacancyId: $btn.attr('data-vacancy-id')
    };
    ajaxRequest(data, () => {}, response => {
      if (response.status !== 200) {
        console.error(response.status, response.message);
        return;
      }

      if (response.message === 'applied') {
        $btn.text(text.revoke);
      } else {
        $btn.text(text.apply);
      }
    }, error => {
      console.error(error);
    });
  }); // $revokeBtn.on('click', (event) => {
  //   const $btnRevoke = $(event.currentTarget);
  //   const $holder = $btnRevoke.parent()
  //   const $btnApply = $holder.find('.js-apply')
  //   const data = {
  //     action: 'revoke_job',
  //     vacancyId: $btnRevoke.attr('data-vacancy-id')
  //   }
  //
  //   ajaxRequest(
  //     data,
  //     () => {},
  //     (response) => {
  //       if (response.status === 200) {
  //         $btnRevoke.fadeOut(0)
  //         $btnApply.fadeIn(500)
  //
  //         return
  //       }
  //       console.error(response.status, response.message)
  //     },
  //     (error) => {
  //       console.error(error)
  //     }
  //   )
  // })

  $addBookmarkBtn.on('click', event => {
    event.preventDefault();
    const $btn = $(event.currentTarget);
    window.btn = $btn;
    const id = $btn.parents('.vacancies-item').attr('id');
    const isAdded = $btn.attr('data-is-added');
    const $icon = $btn.children('i.fa');
    const data = {
      action: 'update_bookmark',
      id,
      isAdded
    };

    const success = response => {
      console.log(response);

      if (response.isAdded) {
        $icon.removeClass('color-grey').addClass('color-gold');
      } else {
        $icon.removeClass('color-gold').addClass('color-grey');
      }
    };

    const error = error => {
      console.log(error);
    };

    ajaxRequest(data, () => {}, success, error);
  });
  $publishJobFrom.on('click', '[data-select-item]', function () {
    const select = $(this).parents('[data-select]');

    if (!$(this).hasClass('active')) {
      const value = $(this).attr('data-key');
      select.find($('input')).attr('data-value', value);
      select.children('[data-select-value]').html(value);
    }
  });
  $publishJobFrom.on('click', 'fieldset input', function () {
    const $input = $(this);

    if ($input.hasClass('selected')) {
      $input.removeClass('selected');
    } else {
      $input.addClass('selected');
    }
  });
  $duplicateJobFrom.on('submit', event => {
    event.preventDefault();
    const postId = $('#post-job-title-duplicate').val();
    const author = $duplicateJobFrom.attr('data-author');
    const submitBtn = $duplicateJobFrom.find('button[type="submit"]');
    let formData = new FormData();
    formData.append('action', 'duplicate_job');
    formData.append('postId', postId || 0);
    formData.append('author', author || '');
    postJobAjax(formData, submitBtn);
  });
  $publishJobFrom.on('submit', event => {
    event.preventDefault();
    const submitBtn = $publishJobFrom.find('button[type=submit]:focus');
    let benefits = [];
    let agreements = [];
    let skills = [];
    $('input[name="post-job-benefits[]"]:checked').each((index, item) => {
      benefits.push($(item).attr('id'));
    });
    $('input[name="post-job-send[]"]:checked').each((index, item) => {
      agreements.push($(item).attr('id'));
    });
    const $compensationRange = $('.field-prices input');
    $('.field-skills-list li').each((index, item) => {
      skills.push($(item).attr('data-key'));
    });
    let formData = new FormData();
    formData.append('action', 'create_job');
    formData.append('id', $(this).attr('id'));
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
  $loadMoreBtn.on('click', e => {
    const total = $vacancyHolder.attr('data-total');
    const itemsShown = $vacancyHolder.attr('data-shown');

    if (total <= itemsShown) {
      $btn.fadeOut();
    }

    loadMoreAjax($vacancyHolder, $loadMoreBtn);
  });
  $filterLoadMoreBtn.on('click', e => {
    filterLoadMore($vacancyHolder, $filterLoadMoreBtn);
  });
  $(document).on('submit', '#register-candidate-form, #register-employer-form', e => {
    e.preventDefault();
    const $form = $(e.currentTarget);
    const isEmployer = 'register-employer-form' === $form.attr('id');

    if (isEmployer) {
      const rules = {
        email: "required",
        password: "required",
        employer_pwd_confirmation: {
          equalTo: ".employer_pwd"
        }
      };
    } else {
      const rules = {
        email: "required",
        password: "required",
        candidate_pwd_confirmation: {
          equalTo: ".candidate_pwd"
        }
      };
    }

    const validator = $form.validate({
      rules: this.rules,
      highlight: function (element) {
        $(element).parent().addClass('form-invalid');
      },
      unhighlight: function (element) {
        $(element).parent().removeClass('form-invalid');
      },
      messages: {
        password: "Incorrect password",
        pwd_confirmation: "<small>Password doesn't match</small>"
      }
    });

    if (!validator.form()) {
      return;
    }

    const data = {
      action: 'register_user',
      email: $form.find("input[name='email']").val(),
      username: $form.find("input[name='username']").val(),
      password: isEmployer ? $form.find("input[name='employer_pwd']").val() : $form.find("input[name='candidate_pwd']").val(),
      pwd_confirmation: isEmployer ? $form.find("input[name='employer_pwd_confirmation']").val() : $form.find("input[name='candidate_pwd_confirmation']").val(),
      role: $form.find("input[name='role']").val(),
      nonce: $form.find("input[name='nonce']").val()
    };
    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: data,
      dataType: 'json',
      success: function (response) {
        const $message = $('.results-content__message');
        $message.html(response.message);

        if (response.status === 200) {
          $message.removeClass('alert-danger d-none');
          $message.addClass('alert-success d-block');
          setTimeout(() => {
            window.location.href = '/login/';
          }, 3000);
        } else {
          $message.removeClass('alert-success d-none');
          $message.addClass('alert-danger d-block');
        }
      }
    });
  });
});