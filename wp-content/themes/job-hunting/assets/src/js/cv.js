$(() => {
  const { siteSettings } = window
  const $pageHolder = $('#candidate')
  const cvId = $pageHolder.attr('data-cv-id')
  const candidateId = $pageHolder.attr('data-user-id')

  new CvController(cvId, candidateId)
})

class CvController {
  constructor(cvId, candidateId) {
    this.cvId = cvId
    this.candidateId = candidateId

    this.fillFormCalbacks = {
      about_me: this.fillFormAboutMe
    }

    this.saveFormCalbacks = {
      about_me: this.saveFormAboutMe
    }

    // Register DOM actions handlers
    this.registerActions()
  }

  /**
   * Register handlers for DOM actions.
   */
  registerActions () {
    // Upload avatar
    $(document).on('change', '#profile-photo', () => {
      $('#avatar-form').submit()
    })

    // Show form in modal window
    $(document).on('click', '.js-profile-edit-btn, .js-profile-edit-link', this.showForm.bind(this))

    // Save form in modal window
    $(document).on('submit', '#about_me', this.saveFormAboutMe.bind(this))

    // Save form in modal window
    $(document).on('submit', '#contacts', this.saveFormContacts.bind(this))
  }

  /**
   * Show open modal window with different forms on
   * candidate dashboard page.
   *
   * @param event
   */
  showForm (event) {
    event.preventDefault()

    $('.js-notification').addClass('d-none').removeClass('alert-danger', 'alert-success')

    const $edit = $(event.currentTarget)
    const formId = $edit.attr('data-form-id')
    const formHeading = $edit.attr('data-heading')

    // Hide any active form
    $('.modal-dialog').find('form').map((index, item) => {
      const $form = $(item)
      $form.hide()
    })

    // Show form by id attribute
    switch (formId) {
      case 'about_me':
        this.fillFormAboutMe()
        break
      case 'contacts':
        this.fillFormContacts()
        break
    }

    $('.js-header-text').text(formHeading)
    $('#' + formId).show()
  }

  /**
   * Fill "About me" form by Ajax.
   */
  fillFormAboutMe () {
    const $notification = $('.js-notification')
    const data = {
      action: 'load_about_me_form',
      cvId: this.cvId,
    }

    this
      .sendAjax(data)
      .done(
        request => {
          const $notification = $('.js-notification')

          if (request.status !== 200) {
            $notification.text(request.message).addClass('alert-danger').removeClass('d-none', 'alert-warning', 'alert-success')
            return
          }

          $notification.addClass('d-none').removeClass('alert-danger', 'alert-warning', 'alert-success')

          $('#edit_full_name').val(request.data.fullName)
          $('#edit_headline').val(request.data.headline)
          $('#edit_location').val(request.data.location)
          $('#edit_zip').val(request.data.zip)

          if (request.data.isReadyToRelocate) {
            $('#edit_ready_to_relocate').attr('checked', 'checked')
          }
        }
      )
      .fail(
        error => {
          $notification.text('Updating failed').addClass('alert-danger').removeClass('d-none', 'alert-success')
        }
      )
  }

  /**
   * Save "About me" form by Ajax.
   *
   * @param event
   */
  saveFormAboutMe (event) {
    event.preventDefault()

    const $notification = $('.js-notification')
    const data = {
      action: 'save_about_me_form',
      cvId: this.cvId,
      user: this.candidateId,
      fullName: $('#edit_full_name').val(),
      headline: $('#edit_headline').val(),
      location: $('#edit_location').val(),
      zip: $('#edit_zip').val(),
      isReadyToRelocate:  $('#edit_ready_to_relocate').prop('checked'),
    }

    this
      .sendAjax(data)
      .done(
        request => {
          if (request.status !== 200) {
            $notification.text(request.message).addClass('alert-danger').removeClass('d-none', 'alert-success')
            return
          }

          $notification.text(request.message).addClass('alert-success').removeClass('d-none', 'alert-danger')

          $('#cv_full_name').text(data.fullName)
          $('#cv_headline').text(data.headline)
          $('#cv_location').text(data.location)
          $('#cv_zip').text(data.zip)

          if (data.isReadyToRelocate) {
            $('#ready_to_relocate').removeClass('d-none')
          } else {
            $('#ready_to_relocate').addClass('d-none')
          }

          setTimeout(() => {
            $notification.addClass('d-none').removeClass('alert-success')
          }, 3000)
        }
      )
      .fail(
        error => {
          $notification.text('Updating failed').addClass('alert-danger').removeClass('d-none', 'alert-success')
        }
      )
  }

  fillFormContacts () {
    const $notification = $('.js-notification')
    const data = {
      action: 'load_contacts_form',
      cvId: this.cvId,
    }

    this
      .sendAjax(data)
      .done(
        request => {
          const $notification = $('.js-notification')

          if (request.status !== 200) {
            $notification.text(request.message).addClass('alert-danger').removeClass('d-none', 'alert-warning', 'alert-success')
            return
          }

          $notification.addClass('d-none').removeClass('alert-danger', 'alert-warning', 'alert-success')

          $('#edit_phone').val(request.data.phone)
          $('#edit_email').val(request.data.email)
        }
      )
      .fail(
        error => {
          $notification.text('Updating failed').addClass('alert-danger').removeClass('d-none', 'alert-success')
        }
      )
  }

  /**
   * Save "Contacts" form by Ajax.
   *
   * @param event
   */
  saveFormContacts (event) {
    event.preventDefault()

    const $notification = $('.js-notification')
    const $holder = $('#contacts-holder')
    const data = {
      action: 'save_contacts_form',
      cvId: this.cvId,
      user: this.candidateId,
      phone: $('#edit_phone').val(),
      email: $('#edit_email').val(),
    }

    this
      .sendAjax(data)
      .done(
        request => {
          if (request.status !== 200) {
            $notification.text(request.message).addClass('alert-danger').removeClass('d-none', 'alert-success')
            return
          }

          $notification.text(request.message).addClass('alert-success').removeClass('d-none', 'alert-danger')
          $holder.html(request.html)

          setTimeout(() => {
            $notification.addClass('d-none').removeClass('alert-success')
          }, 3000)
        }
      )
      .fail(
        () => {
          $notification.text('Updating failed').addClass('alert-danger').removeClass('d-none', 'alert-success')
        }
      )
  }

  /**
   * Ajax request.
   * The function return promise.
   *
   * @param data
   * @returns {*|jQuery|{getAllResponseHeaders: function(): *|null, abort: function(*=): this, setRequestHeader: function(*=, *): this, readyState: number, getResponseHeader: function(*): null|*, overrideMimeType: function(*): this, statusCode: function(*=): this}}
   */
  sendAjax(data) {
    return $.ajax({
      type: 'POST',
      url: siteSettings.ajaxurl,
      data,
      dataType: 'json',
    })
  }
}
