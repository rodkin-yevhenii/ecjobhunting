async function getVacancy (id) {
  const response = await fetch(`/wp-json/wp/v2/vacancies/${id}`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json;charset=utf-8',
      'X-WP-Nonce': REST_API_data.nonce
    }
  })
  return await response.json()
}

async function updateVacancy (id, dataset) {
  return await fetch(`/wp-json/wp/v2/vacancies/${id}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json;charset=utf-8',
      'X-WP-Nonce': REST_API_data.nonce
    },
    body: JSON.stringify(dataset)
  })
}

async function getCompanyLogo (id) {
  const response = await fetch(`/wp-json/wp/v2/media/${id}`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json;charset=utf-8',
      'X-WP-Nonce': REST_API_data.nonce
    },
  })

  return await response.json()
}

async function deleteVacancy (id) {
  return await fetch(`/wp-json/wp/v2/vacancies/${id}`, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json;charset=utf-8',
      'X-WP-Nonce': REST_API_data.nonce
    },
    body: JSON.stringify({})
  })
}

$(() => {
  const $modal = $('.ec-job-modal')

  $(document).on('click', '.js-edit-job', (e) => {
    e.preventDefault()

    $modal.removeClass('is-hidden')
    const id = $(e.currentTarget).closest('ul').attr('data-job-id')
    let response = getVacancy(id)

    response.then((r) => {
      console.log(r)
      const job = {
        id: r.id,
        title: r.title,
        jobLocation: r.location,
        jobCategory: r.jobCategory,
        employmentType: r.employmentType[0],
        jobDescription: r.content.rendered,
        benefits: r.meta.benefits,
        compensationFrom: r.meta.compensation_range_from[0],
        compensationTo: r.meta.compensation_range_to[0],
        currency: r.meta.compensation_currency[0],
        period: r.meta.compensation_period[0],
        isCommissionIncluded: r.isCommissionIncluded,
        street: r.meta.street_address,
        reasonToWork: r.meta.why_work_at_this_company,
        skills: r.skills,
        companyName: r.company,
        companyDesc: r.meta.hiring_company_description,
        isEmailsToInform: r.isInformEmployer,
        additionalEmailsToInform: r.additionalEmailsToInform,
        options: r.meta.additional_options,
        companyLogoId: r.meta.company_logo[0] || false
      }

      job.jobDescription = job.jobDescription.replace('<p>', '')
      job.jobDescription = job.jobDescription.replace('</p>', '')

      const skills = job.skills.map((item) => {
        return '<li data-key="' + item + '">' +
          '<span>' + item + '</span>' +
          '<span class="custom-list__item-close js-custom-list-item-close"></span>' +
          '</li>'
      })

      if (job.companyLogoId) {
        getCompanyLogo(job.companyLogoId).then(
          (logoResponse => {
            if (logoResponse.source_url) {
              const image = $(`<img src="${logoResponse.source_url}" alt="${job.companyName}"/>`)
              const button = $('<button class="btn btn-primary mt-1 js-change-company-logo">Change logo</button>')
              $('.js-file-input-container')
                .html('')
                .append(image)
                .append(button)
            }
          })
        )
      }

      let additionalEmployerEmails = [];

      if (!!job.additionalEmailsToInform && job.additionalEmailsToInform.length) {
        additionalEmployerEmails = job.additionalEmailsToInform.map((item) => {
          return '<li data-key="' + item.email + '">' +
            '<span>' + item.email + '</span>' +
            '<span class="custom-list__item-close js-custom-list-item-close"></span>' +
            '</li>'
        })
      }


      job.options.forEach((item) => {
        $('#' + item).attr('checked', 'checked')
      })

      if (!!job.benefits && job.benefits.length) {
        job.benefits.forEach((item) => {
          $('#' + item).attr('checked', 'checked')
        })
      }

      // Update Employment type view
      renderCustomSelect(job.employmentType, $('.js-employment-type'))
      renderCustomSelect(job.currency, $('.js-currency'))
      renderCustomSelect(job.period, $('.js-period'))

      $('#publish-job-form').attr('id', job.id)
      $('#post-job-title').val(job.title)
      $('#post-job-location').val(job.jobLocation.join(', '))
      $('#post-job-description').val(job.jobDescription)
      $('#compensation_from').val(job.compensationFrom)
      $('#compensation_to').val(job.compensationTo)
      $('#post-job-address').val(job.street)
      $('#post-job-category').val(job.jobCategory)
      $('.js-skills-list').html(skills.join(''))
      $('.js-emails-list').html(additionalEmployerEmails.join(''))
      $('#post-job-company').val(job.companyName)
      $('#post-job-company-description').val(job.companyDesc)
      $('#post-job-why').val(job.reasonToWork)

      if (job.isCommissionIncluded) {
        $('#post-job-commission').attr('checked', 'checked')
      }

      if (job.isEmailsToInform) {
        $('#post-job-send').attr('checked', 'checked')
      }
    })
  })

  $(document).on('click', '.js-change-company-logo', () => {
    const input = $('<input class="file" type="file" name="logo" id="post-company-logo" accept=".jpg,.png" required/>')
    $('.js-file-input-container')
      .html('')
      .append(input)
  })

  $modal.on('click', '.close', () => {
    $modal.addClass('is-hidden')
  })

  // Publish vacancy
  $(document).on('click', '.js-publish-job', e => {
    const dataset = {
      status: 'publish'
    }
    const id = $(e.currentTarget).attr('data-job-id')

    let promise = updateVacancy(id, dataset)
    promise.then((response) => response.json())
      .then(
        data => {
          if (data.code !== undefined) {
            console.error(data)
          } else {
            document.location.reload()
          }
        }
      )
      .catch((err) => { console.log(err) })
  })

  // CLose/Archive vacancy
  $(document).on('click', '.js-archive-job', e => {
    const dataset = {
      status: 'private'
    }
    const id = $(e.currentTarget).attr('data-job-id')

    let promise = updateVacancy(id, dataset)
    promise.then((response) => response.json())
      .then(
        data => {
          if (data.code !== undefined) {
            console.error(data)
          } else {
            document.location.reload()
          }
        }
      )
      .catch((err) => { console.log(err) })
  })

  // Delete vacancy
  $(document).on('click', '.js-delete-job', e => {
    const id = $(e.currentTarget).closest('ul').attr('data-job-id')

    let promise = deleteVacancy(id)
    promise.then((response) => response.json())
      .then(
        data => {
          if (data.code !== undefined) {
            console.error(data)
          } else {
            document.location.reload()
          }
        }
      )
      .catch((err) => { console.log(err) })
  })
})

function renderCustomSelect (value, select) {
  select.find('li').each((index, item) => {
    if ($(item).attr('data-key') === value) {
      $(item).click()
    }
  })
}
