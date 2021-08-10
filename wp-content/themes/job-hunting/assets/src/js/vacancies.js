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
        title: r.title,
        jobLocation: r.location,
        employmentType: r.employmentType,
        jobDescription: r.content.rendered,
        benefits: r.meta.benefits,
        compensationFrom: r.meta.compensation_range_from[0],
        compensationTo: r.meta.compensation_range_to[0],
        currency: r.meta.compensation_currency,
        period: r.meta.compensation_period,
        isCommissionIncluded: Boolean(r.meta.is_commission_included[0]),
        street: r.meta.street_address,
        reasonToWork: r.meta.why_work_at_this_company,
        skills: r.skills,
        companyName: r.meta.hiring_company,
        companyDesc: r.meta.hiring_company_description,
        notifyMe: r.meta.send_new_candidates_to,
        emailsToInform: r.meta.emails_to_inform,
        options: r.meta.additional_options,
      }
      console.log(job)
      let skills = job.skills.map((item) => {
        return '<li data-key="' + item + '"><span>' + item + '</span><span class="field-skills-close"></span></li>'
      })

      job.options.forEach((item) => {
        $('#' + item).attr('checked', 'checked')
      })

      job.benefits.forEach((item) => {
        $('#' + item).attr('checked', 'checked')
      })
      $('#post-job-title').val(job.title)
      $('#post-job-location').val(job.jobLocation.join(', '))
      $('#employment-type').val(job.employmentType)
      $('#post-job-description').val(job.jobDescription)
      $('#compensation_from').val(job.compensationFrom)
      $('#compensation_to').val(job.compensationTo)
      $('#post-job-address').val(job.street)
      $('.field-skills-list').html(skills.join(''))
      $('#post-job-company').val(job.companyName)
      $('#post-job-company-description').val(job.companyDesc)
      $('#post-job-why').val(job.reasonToWork)
      if (job.isCommissionIncluded)
        $('#post-job-commission').attr('checked', 'checked')
    })
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
