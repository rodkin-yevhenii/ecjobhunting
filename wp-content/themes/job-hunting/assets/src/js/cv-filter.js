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

  function prepareData(paged) {
    const $daysAgoRange = $('#resume-days-ago [data-noui-value]')
    let degree = null;
    const skills = $('.js-skills-list li').map((index, item) => {
      return $(item).attr('data-key')
    })

    $('input[name=resume-education]').each((index, item) => {
      if (item.checked) {
        degree = $(item).val()
      }
    })

    return  {
      action: 'get-filtered-cvs',
      nonce: $form.attr('data-nonce'),
      vacancyId: $('#vacancy-id').val() || null,
      skills: Array.prototype.join.call(skills),
      location: $('#location').val() || null,
      jobTitle: $('#resumes-job').val() || null,
      company: $('#resumes-company').val() || null,
      daysAgo: $daysAgoRange.text() === '0' ? null : parseInt($daysAgoRange.text()),
      degree,
      paged,
      category: $('#resume-category').val() || null,
      isVeteran: $('#resume-veteran')[0].checked ? 1 : null
    }
  }

  function loadCvs(isLoadMore = false) {
    if (isAjax !== undefined && isAjax) {
      return
    }

    let paged = 1;

    if (isLoadMore) {
      paged = $form.attr('data-paged')
    }

    let isAjax = false;
    const data = prepareData(paged)

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

  class CvFilterForm {
    constructor() {
      const $form = $('#cv-filter form')

      this.DOM = {
        form: $form,
        vacancy: $form.find('#vacancy'),
        skills: $form.find('#skills'),
        location: $form.find('#locations'),
        headline: $form.find('#headline'),
        prevCompany: $form.find('#prev-company'),
        posted: $form.find('#posted'),
        degree: $form.find('#degree'),
        category: $form.find('#category'),
        veteranStatus: $form.find('#veteran-status'),
      }
    }

    restore () {
      this.vacancy.restore()
      this.skills.restore()
      this.location.restore()
      this.headline.restore()
      this.prevCompany.restore()
      this.posted.restore()
      this.degree.restore()
      this.category.restore()
      this.veteranStatus.restore()
    }

    vacancy = {
      restore: () => {
        this.DOM.vacancy.find('li[data-default]').click()
      },

      update: (id) => {
        this.DOM.vacancy.find(`li[data-select-item-value="${id}"]`).click()
      }
    }

    skills = {
      restore: () => {
        this.DOM.skills.find('.js-custom-list-items').html('')
      },

      update: (skills) => {
        const $input = this.DOM.skills.find('input')
        const $button = this.DOM.skills.find('button')

        skills.forEach((item) => {
          $input.val(item)
          $button.click()
        })
      }
    }

    location = {
      restore: () => {
        this.DOM.location.find('li[data-default]').click()
      },

      update: (name) => {
        this.DOM.location.find(`li[data-select-item-value="${name}"]`).click()
      }
    }

    headline = {
      restore: () => {
        this.DOM.headline.find('input').val('')
      },

      update: (title) => {
        this.DOM.headline.find('input').val(title)
      }
    }

    prevCompany = {
      restore: () => {
        this.DOM.prevCompany.find('input').val('')
      },

      update: (title) => {
        this.DOM.prevCompany.find('input').val(title)
      }
    }

    posted = {
      restore: () => {
        this.DOM.posted.find('[data-noui-value]').html(0)
      },

      update: (days) => {
        this.DOM.posted.find('[data-noui-value]').html(days)
      }
    }

    degree = {
      restore: () => {
        this.DOM.degree.find('input[data-default]').click()
      },

      update: (degree) => {
        this.DOM.degree.find(`input[value="${degree}"]`).click()
      }
    }

    category = {
      restore: () => {
        this.DOM.category.find('li[data-default]').click()
      },

      update: (name) => {
        this.DOM.category.find(`li[data-select-item-value="${name}"]`).click()
      }
    }

    veteranStatus = {
      restore: () => {
        this.DOM.veteranStatus.find('input').attr('checked', false)
      },

      update: (isVeteran) => {
        if (isVeteran) {
          this.DOM.veteranStatus.find('input').attr('checked', true)
        } else {
          this.DOM.veteranStatus.find('input').attr('checked', false)
        }
      }
    }
  }

  class SearchQuery {
    constructor() {
      this.loadQueries()
      this.registerActions()
      this.renderQueryCards()
      this.form = new CvFilterForm()
    }

    registerActions () {
      $(document).on('click', '.js-save-query', function (event) {
        event.preventDefault()

        this.addQuery()
        this.renderQueryCards()
      }.bind(this))

      $(document).on('click', '.js-apply-cv-search-query', function (event) {
        event.preventDefault()
        this.form.restore()

        const key = $(event.currentTarget).attr('data-key')
        const data = this.queries[key]

        this.form.vacancy.update(data.vacancyId)
        this.form.skills.update(data.skills.split(','))
        this.form.location.update(data.location)
        this.form.headline.update(data.jobTitle)
        this.form.prevCompany.update(data.company)
        this.form.posted.update(data.daysAgo ? data.daysAgo : 0)
        this.form.degree.update(data.degree)
        this.form.category.update(data.category)
        this.form.veteranStatus.update(data.isVeteran === 1)

        this.form.DOM.form.submit()
        $('[data-tab-item=search]').click()
      }.bind(this))

      $(document).on('click', '.js-remove-cv-search-query', function (event) {
        event.preventDefault()
        const button = $(event.currentTarget)
        const key = button.attr('data-key')
        button.closest('.js-query-card').remove()
        this.queries.splice(key, 1)
        localStorage.setItem('cvs_search_queries', JSON.stringify(this.queries))
        this.renderQueryCards()
      }.bind(this))
    }

    loadQueries () {
      const queries =  JSON.parse(localStorage.getItem('cvs_search_queries'))

      if (queries && queries.length) {
        this.queries = queries
      } else {
        this.queries = []
      }
    }

    addQuery () {
      const data = prepareData(1)
      this.queries = [data, ...this.queries]

      localStorage.setItem('cvs_search_queries', JSON.stringify(this.queries))
    }

    renderQueryCards () {
      const $container = $('.js-query-cards-container')
      $container.html('')

      this.queries.forEach((item, index) => {
        if (!item) {
          return
        }
        const $card = $('<div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4 js-query-card"></div>')
        const $list = $('<ul class="mb-2"></ul>')
        $list.append(`<li class="mb-1">Job ID: <strong>${item.vacancyId ?? ''}</strong></li>`)
        $list.append(`<li class="mb-1">Skills: <strong>${item.skills.replace(',', ', ') ?? ''}</strong></li>`)
        $list.append(`<li class="mb-1">Location: <strong>${item.location ?? ''}</strong></li>`)
        $list.append(`<li class="mb-1">Job Title: <strong>${item.jobTitle ?? ''}</strong></li>`)
        $list.append(`<li class="mb-1">Prev. Company: <strong>${item.company ?? ''}</strong></li>`)
        $list.append(`<li class="mb-1">Posted days ago: <strong>${item.daysAgo ?? ''}</strong></li>`)
        $list.append(`<li class="mb-1">Minimum Education: <strong>${item.degree ?? ''}</strong></li>`)
        $list.append(`<li class="mb-1">Industry: <strong>${item.category ?? ''}</strong></li>`)
        $list.append(`<li class="mb-1">Veteran Status: <strong>${item.isVeteran ? 'yes' : 'no'}</strong></li>`)
        $card.append($list)
        $card.append(`<button class="btn btn-primary js-apply-cv-search-query" data-key="${index}">Apply</button>`)
        $card.append(`<button class="btn btn-primary ml-2 js-remove-cv-search-query" data-key="${index}">Remove</button>`)
        $container.append($card)
      })
    }
  }

  new SearchQuery()
})
