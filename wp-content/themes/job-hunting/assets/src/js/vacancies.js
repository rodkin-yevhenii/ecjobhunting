async function getVacancy (id) {
  const response = await fetch(`/wp-json/wp/v2/vacancies/${id}`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json;charset=utf-8'
    }
  })
  return await response.json()
}

$(() => {
  const $edit = $('.js-edit-job')
  const $duplicate = $('.js-duplicate-job')
  const $delete = $('.js-delete-job')
  const $publish = $('.js-publish-job')
  const $archive = $('.js-archive-job')
  const $modal = $('.ec-job-modal')

  $edit.on('click', (e) => {
    $modal.removeClass('is-hidden')
    const id = $(e.currentTarget).closest('ul').attr('data-job-id')
    let response = getVacancy(id)

    response.then((r) => {
      const job = {
        title: r.title,
        jobLocation: r.location,
        employmentType: r.employmentType,
        jobDescription: r.content.rendered,
        benefits: r.meta.benefits,
        compensationFrom: r.meta.compensation_range_from,
        compensationTo: r.meta.compensation_range_to,
        currency: r.meta.compensation_currency,
        period: r.meta.compensation_period,
        isCommissionIncluded: r.meta.is_commission_included,
        street: r.meta.street_address,
        reasonToWork: r.meta.why_work_at_this_company,
        skills: r.skills,
        companyName: r.meta.hiring_company,
        companyDesc: r.meta.hiring_company_description,
        notifyMe: r.meta.send_new_candidates_to,
        emailsToInform: r.meta.emails_to_inform,
        options: r.meta.additional_options,
      }

      console.log(r)
      console.log(job)
    })
  })

  $modal.on('click', '.close', () => {
    $modal.addClass('is-hidden')
  })

})