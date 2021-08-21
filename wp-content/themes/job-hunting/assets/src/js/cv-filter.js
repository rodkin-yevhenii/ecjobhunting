$(() => {
  const $form = $('#cv-filter form')
  const ajaxUrl = window.siteSettings.ajaxurl

  if (!$form.length) {
    return
  }

  $form.on('submit', event => {
    event.preventDefault()

    loadCvs()
  })

  $(document).on('click', '.js-load-more-cvs', event => {
    event.preventDefault()

    loadCvs(true)
  })

  function loadCvs(isLoadMore = false) {
    if (isAjax !== undefined && isAjax) {
      return
    }

    let paged = 1;

    if (isLoadMore) {
      paged = $form.attr('data-paged')
    }

    let isAjax = false;
    let degree = null;
    const $daysAgoRange = $('#resume-days-ago [data-noui-value]')
    const skills = $('.js-skills-list li').map((index, item) => {
      return $(item).attr('data-key')
    })

    $('input[name=resume-education]').each((index, item) => {
      if (item.checked) {
        degree = $(item).val()
      }
    })

    const data = {
      action: 'get-filtered-cvs',
      nonce: $form.attr('data-nonce'),
      vacancyId: $('#vacancy-id').val() || null,
      skills: Array.prototype.join.call(skills),
      location: $('#location').val() || null,
      jobTitle: $('#resumes-job').val() || null,
      company: $('#resumes-company').val() || null,
      daysAgo: $daysAgoRange.text() === '0' ? null : parseInt($daysAgoRange.text()),
      degree,
      paged: paged,
      category: $('#resume-category').val() || null,
      isVeteran: $('#resume-veteran')[0].checked ? 1 : null
    }

    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data,
      dataType: 'json',
      beforeSend: function () {
        isAjax = true;
      },
      success: function (response) {
        if (response.status === 200) {
          isAjax = false;
          paged++
          $form.attr('data-paged', paged)

          if (isLoadMore) {
            $('.js-candidates-container').append(response.html)
          } else {
            $('.js-candidates-container').html(response.html)
            $('.js-load-more-cvs').show()
          }

          if (response.isEnd) {
            $('.js-load-more-cvs').hide()
          }

          $([document.documentElement, document.body]).animate({
            scrollTop: $(".js-candidates-container").offset().top - 20
          }, 300);
        } else if (response.status === 404) {
          $('.js-load-more-cvs').hide()
          $('.js-candidates-container').html(response.message)
          $([document.documentElement, document.body]).animate({
            scrollTop: $(".js-candidates-container").offset().top - 20
          }, 300);
        } else {
          console.error(response.status, response.message)
        }
      },
      error: function (error) {
        console.error(error)
      }
    })
  }
})
