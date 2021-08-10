$(() => {
  const ajaxUrl = window.siteSettings.ajaxurl
  const $publishJobFrom = $('.publish-job-form')
  const $duplicateJobFrom = $('.duplicate-job-form')
  const $vacancyHolder = $('.js-vacancies')
  const $loadMoreBtn = $('.js-load-more')
  const $filterLoadMoreBtn = $('.js-filter-load-more')
  const $addBookmarkBtn = $('.add-bookmark')
  const $applyBtn = $('.js-apply')
  const $revokeBtn = $('.js-revoke')
  const $dismissBtn = $('.js-dismiss-job')
  const $suggestedJobsContainer = $('.js-suggested-jobs')
  const $dismissedJobsContainer = $('.js-dismissed-jobs')

  $(document).on('click', '.js-employer-my-jobs-types a', event => {
    event.preventDefault();

    if (isAjax !== undefined && isAjax) {
      return
    }

    let isAjax = false;
    const currentLink = $(event.currentTarget);

    if (currentLink.hasClass('active')) {
      return
    }

    $('.js-employer-my-jobs-types a').removeClass('active')
    currentLink.addClass('active');
    const type = currentLink.parent().data('type')

    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: {
        action: 'load_employer_vacancies',
        url: ajaxUrl,
        nonce: $('.js-employer-my-jobs-types').data('nonce'),
        type
      },
      dataType: 'json',
      beforeSend: function () {
        isAjax = true;
      },
      success: function (response) {
        if (response && response.status === 200) {
          $('.js-employer-my-jobs-container').html(response.html)
        } else if (response.status === 404) {
          $('.js-employer-my-jobs-container').html(`<p>${response.message}</p>`)
        } else {
          console.log(response.message)
        }
      }
    })
  })

  function postJobAjax (data, $messageContainer) {
    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: data,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function (response) {
        if (response && response.status === 201) {
          $($messageContainer).removeClass('is-error')
          $($messageContainer).html(response.message)
          setTimeout(() => {
            window.location.replace(response.permalink)
          }, 3000)
        } else if (response.status === 404 || response.status === 401) {
          $($messageContainer).html(response.message)
          $($messageContainer).addClass('is-error')
        } else {
          $($messageContainer).addClass('is-error')
          $($messageContainer).html('Something went wrong, try again')
        }
      }
    })
  }

  function loadMoreAjax ($holder, $btn) {
    let paged = $holder.attr('data-paged')
    const postType = $holder.attr('data-posttype')
    const perPage = $holder.attr('data-perpage')
    const offset = perPage * paged
    const data = {
      action: 'load_more',
      post_type: postType,
      post_status: 'publish',
      per_page: perPage,
      offset: offset
    }
    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: data,
      dataType: 'json',
      success: function (response) {
        if (response.html) {
          $holder.append(response.html)
        }
        const shown = Number(offset) + Number(response.itemsCount)
        $holder.attr('data-paged', ++paged)
        $holder.attr('data-shown', shown)
        if (Number(response.total) <= shown) {
          $btn.fadeOut()
        }
      }
    })
  }

  function filterLoadMore($holder, $btn) {
    const paged = $holder.attr('data-paged')
    const per_page = $holder.attr('data-perpage')
    const s = $('#s').val()
    const location = $('#location').val()
    const publish_date = $('#publish-date').val()
    const compensation = $('#compensation').val()
    const employment_type = $('#employment-type').val()
    const category = $('#category').val()
    const company = $('#company').val()
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
    }

    const success = (response) => {
      switch (response.status) {
        case 501:
        case 204:
          console.log(response.status, response.message)
          $btn.fadeOut()
          return
        case 200:
          if (response.isEnd) {
            $btn.fadeOut()
          }
          $vacancyHolder.append(response.html)
          $vacancyHolder.attr('data-paged', response.paged)
          break
        default:
          console.log('Unknown error')
      }
    }

    const error = (error) => {
      console.log(error)
    }

    ajaxRequest(
      data,
      () => {},
      success,
      error
    )
  }

  function ajaxRequest(
    data,
    beforeCallback = () => {},
    successCallback = () => {},
    errorCallback = () => {}
  ) {
    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: data,
      dataType: 'json',
      before: beforeCallback,
      success: successCallback,
      error: errorCallback,
    })
  }

  $applyBtn.on('click', (event) => {
    event.preventDefault()

    const $btn = $(event.currentTarget);
    const text = {
      apply: $btn.attr('data-apply-text'),
      revoke: $btn.attr('data-revoke-text')
    }
    const data = {
      action: 'apply_job',
      vacancyId: $btn.attr('data-vacancy-id')
    }

    ajaxRequest(
      data,
      () => {},
      (response) => {
        if (response.status !== 200) {
          console.error(response.status, response.message)
          return
        }

        if (response.message === 'applied') {
          $btn.text(text.revoke)
        } else {
          $btn.text(text.apply)
        }
      },
      (error) => {
        console.error(error)
      }
    )
  })

  // $revokeBtn.on('click', (event) => {
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

  $addBookmarkBtn.on('click', (event) => {
    event.preventDefault()
    const $btn = $(event.currentTarget)
    window.btn = $btn
    const id = $btn.parents('.vacancies-item').attr('id')
    const isAdded = $btn.attr('data-is-added')
    const $icon = $btn.children('i.fa')
    const data = {
      action: 'update_bookmark',
      id,
      isAdded
    }

    const success = (response) => {
      console.log(response)
      if (response.isAdded) {
        $icon.removeClass('color-grey').addClass('color-gold')
      } else {
        $icon.removeClass('color-gold').addClass('color-grey')
      }
    }

    const error = (error) => {
      console.log(error)
    }

    ajaxRequest(data, () => {}, success, error)
  })

  $(document).on('click', '.js-dismiss-job', event => {
    event.preventDefault()

    const $btn = $(event.currentTarget)
    const $card = $btn.parents('.card-vacancy')
    const id = $card.attr('id')
    const data = {
      action: 'dismiss_job',
      id
    }

    const success = (response) => {
      if (response.status !== 200) {
        console.log(response.message)

        return
      }

      $('.js-show-dismissed-jobs').show()
      const $cardClone = $card.parent().clone()
      $card.parent().remove()
      $cardClone.appendTo($dismissedJobsContainer)
      $cardClone.find('.js-dismiss-job').replaceWith('<a class="btn btn-outline-primary js-un-dismiss-job" href="#">Un-Dismiss</a>')
    }

    const error = (error) => {
      console.log(error)
    }

    ajaxRequest(data, () => {}, success, error)
  })

  $(document).on('click', '.js-un-dismiss-job', event => {
    event.preventDefault()

    const $btn = $(event.currentTarget)
    const $card = $btn.parents('.card-vacancy')
    const id = $card.attr('id')
    const data = {
      action: 'un_dismiss_job',
      id
    }

    const success = (response) => {
      if (response.status !== 200) {
        console.log(response.message)

        return
      }

      const $cardClone = $card.parent().clone()
      $card.parent().remove()
      $cardClone.appendTo($suggestedJobsContainer)
      $cardClone.find('.js-un-dismiss-job').replaceWith('<a class="btn btn-outline-primary js-dismiss-job" href="#">Dismiss</a>')
    }

    const error = (error) => {
      console.log(error)
    }

    ajaxRequest(data, () => {}, success, error)
  })

  $(document).on('click', '.js-show-dismissed-jobs', event => {
    event.preventDefault()

    $suggestedJobsContainer.toggle()
    $dismissedJobsContainer.toggle()
    $(event.currentTarget).replaceWith('<a class="color-primary js-show-suggested-jobs" href="#"><i class="fa fa-angle-left ml-0 mr-2"></i> View Suggested Jobs</a>')
  })

  $(document).on('click', '.js-show-suggested-jobs', event => {
    event.preventDefault()

    $suggestedJobsContainer.toggle()
    $dismissedJobsContainer.toggle()
    const $dismissButton = $('<a>View Dismissed Jobs <i class="fa fa-angle-right"></i></a>')
    $dismissButton.addClass('color-primary js-show-dismissed-jobs')

    if (!$dismissedJobsContainer.children('div').length) {
      $dismissButton.css('display', 'none')
    }

    $(event.currentTarget).replaceWith($dismissButton)
  })

  $publishJobFrom.on('click', '[data-select-item]', function () {
    const select = $(this).parents('[data-select]')
    if (!$(this).hasClass('active')) {
      const value = $(this).attr('data-key')
      select.find($('input')).attr('data-value', value)
      select.children('[data-select-value]').html(value)
    }
  })

  $publishJobFrom.on('click', 'fieldset input', function () {
    const $input = $(this)
    if ($input.hasClass('selected')) {
      $input.removeClass('selected')
    } else {
      $input.addClass('selected')
    }
  })

  $duplicateJobFrom.on('submit', (event) => {
    event.preventDefault()
    const postId = $('#post-job-title-duplicate').val()
    const author = $duplicateJobFrom.attr('data-author')
    const submitBtn = $duplicateJobFrom.find('button[type="submit"]')

    let formData = new FormData()
    formData.append('action', 'duplicate_job')
    formData.append('postId', postId || 0)
    formData.append('author', author || '')

    postJobAjax(formData, submitBtn)
  })

  $publishJobFrom.on('submit', (event) => {
    event.preventDefault()
    const submitBtn = $publishJobFrom.find('button[type=submit]:focus')

    let benefits = []
    let agreements = []
    let skills = []
    let emails = []

    $('input[name="post-job-benefits[]"]:checked').each((index, item) => {
      benefits.push($(item).attr('id'))
    })

    $('input[name="post-job-send[]"]:checked').each((index, item) => {
      agreements.push($(item).attr('id'))
    })

    const fileInput = $('#post-company-logo')
    let file = null

    if (fileInput.length &&  fileInput[0].files !== undefined && fileInput[0].files.length) {
      file = fileInput[0].files[0]
    }

    const $compensationRange = $('.field-prices input')
    $('.js-skills-list li').each((index, item) => {
      skills.push($(item).attr('data-key'))
    })
    $('.js-emails-list li').each((index, item) => {
      emails.push($(item).attr('data-key'))
    })
    let formData = new FormData()
    formData.append('action', 'create_job')
    formData.append('id', $(this).attr('id'))
    formData.append('status', $(submitBtn).attr('data-status')) || 'draft'
    formData.append('logo', file)
    formData.append('title', $('#post-job-title').val())
    formData.append('location', $('#post-job-location').val())
    formData.append('category', $('#post-job-category').val())
    formData.append('typeId', $('#employment-type').attr('data-value'))
    formData.append('description', $('#post-job-description').val())
    formData.append('benefits', benefits)
    formData.append('compensationFrom', $($compensationRange[0]).val())
    formData.append('compensationTo', $($compensationRange[1]).val())
    formData.append('currency', $('#currency').attr('data-value') || 'USD')
    formData.append('period', $('#period').attr('data-value') || 'annualy')
    formData.append('isCommissionIncluded', $('#post-job-commission').val())
    formData.append('street', $('#post-job-address').val())
    formData.append('skills', skills)
    formData.append('company', $('#post-job-company').val())
    formData.append('reasonsToWork', $('#post-job-why').val())
    formData.append('companyDesc', $('#post-job-company-description').val())
    formData.append('notifyMe', $('#post-job-send').is(':checked'))
    formData.append('notifyEmail', $('#post-job-send-email').val())
    formData.append('agreements', agreements)
    formData.append('emails', emails)
    formData.append('author', $publishJobFrom.attr('data-author'))

    postJobAjax(formData, submitBtn)
  })

  $loadMoreBtn.on('click', (e) => {
    const total = $vacancyHolder.attr('data-total')
    const itemsShown = $vacancyHolder.attr('data-shown')
    if (total <= itemsShown) {
      $btn.fadeOut()
    }
    loadMoreAjax($vacancyHolder, $loadMoreBtn)
  })

  $filterLoadMoreBtn.on('click', (e) => {
    filterLoadMore($vacancyHolder, $filterLoadMoreBtn)
  })

  $(document).on('submit', '#register-candidate-form, #register-employer-form', (e) => {
    e.preventDefault()
    const $form = $(e.currentTarget)
    const isEmployer = 'register-employer-form' === $form.attr('id')

    if (isEmployer) {
      const rules = {
        email: "required",
        password: "required",
        employer_pwd_confirmation: {
          equalTo: ".employer_pwd"
        }
      }
    } else {
      const rules = {
        email: "required",
        password: "required",
        candidate_pwd_confirmation: {
          equalTo: ".candidate_pwd"
        }
      }
    }

    const validator = $form.validate({
      rules: this.rules,
      highlight: function (element) {
        $(element).parent().addClass('form-invalid')
      },
      unhighlight: function (element) {
        $(element).parent().removeClass('form-invalid')
      },
      messages: {
        password: "Incorrect password",
        pwd_confirmation: "<small>Password doesn't match</small>"
      }
    });

    if (!validator.form()) {
      return
    }

    const data = {
      action: 'register_user',
      email: $form.find("input[name='email']").val(),
      username: $form.find("input[name='username']").val(),
      password: isEmployer ?
        $form.find("input[name='employer_pwd']").val() :
        $form.find("input[name='candidate_pwd']").val(),
      pwd_confirmation: isEmployer ?
        $form.find("input[name='employer_pwd_confirmation']").val() :
        $form.find("input[name='candidate_pwd_confirmation']").val(),
      role: $form.find("input[name='role']").val(),
      nonce: $form.find("input[name='nonce']").val()
    }

    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: data,
      dataType: 'json',
      success: function (response) {
        const $message = $('.results-content__message')
        $message.html(response.message)

        if (response.status === 200) {
          $message.removeClass('alert-danger d-none')
          $message.addClass('alert-success d-block')

          setTimeout(() => {
            window.location.href = '/login/'
          }, 3000)
        } else {
          $message.removeClass('alert-success d-none')
          $message.addClass('alert-danger d-block')
        }
      }
    })
  })
})
