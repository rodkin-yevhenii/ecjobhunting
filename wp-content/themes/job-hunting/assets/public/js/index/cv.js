$(() => {
  const $pageHolder = $('#candidate');
  const cvId = $pageHolder.attr('data-cv-id');
  const candidateId = $pageHolder.attr('data-user-id');
  const controller = new CvController();
});

class CvController {
  constructor(cvId, candidateId) {
    this.cvId = cvId;
    this.candidateId = candidateId; // Register DOM actions handlers

    this.registerActions();
  }

  registerActions() {
    // Upload avatar
    $(document).on('change', '#profile-photo', () => {
      $('#avatar-form').submit();
    });
  }

}