async function getVacancy(id) {
  const response = await fetch(`/wp-json/wp/v2/vacancies/${id}`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json;charset=utf-8'
    }
  });
  return await response.json();
}

$(() => {
  const $edit = $('.js-edit-job');
  const $duplicate = $('.js-duplicate-job');
  const $delete = $('.js-delete-job');
  const $publish = $('.js-publish-job');
  const $archive = $('.js-archive-job');
  const $modal = $('.ec-job-modal');
  $edit.on('click', e => {
    $modal.removeClass('is-hidden');
    const id = $(e.currentTarget).closest('ul').attr('data-job-id');
    let response = getVacancy(id);
    response.then(r => {
      const job = {
        title: r.title
      };
      console.log(r);
      console.log(job);
    });
  });
  $modal.on('click', '.close', () => {
    $modal.addClass('is-hidden');
  });
});