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
    const $edit = $(event.currentTarget)
    const $holder = $('.modal-dialog')
    const data = {
      action: $edit.attr('data-action'),
      formId: $edit.attr('data-form-id'),
    }

    this
      .sendAjax(
        data,
        () => {
          $holder.html(
            '<div class="text-center" style="min-height:400px">\n' +
            '    <div class="spinner-border text-success" style="position: absolute;left: 50%;top: 50%" role="status">\n' +
            '        <span class="sr-only">Loading...</span>\n' +
            '    </div>\n' +
            '</div>'
          )
        }
      )
      .done(
        request => {
          if (request.status !== 200) {
            console.error('Form loading failed.', request.message)
            return
          }

          $holder.html(request.html)
        }
      )
      .fail(
        error => {
          console.error('Form loading failed.', error)
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
    const $holder = $('#about-me-holder')
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
          $holder.html(request.html)

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
   * Ajax request. The function return promise.
   *
   * @param data        Object with data
   * @param beforeSend  Callback
   * @returns {*|jQuery|{getAllResponseHeaders: function(): *|null, abort: function(*=): this, setRequestHeader: function(*=, *): this, readyState: number, getResponseHeader: function(*): null|*, overrideMimeType: function(*): this, statusCode: function(*=): this}}
   */
  sendAjax(data, beforeSend = () => {}) {
    return $.ajax({
      type: 'POST',
      url: siteSettings.ajaxurl,
      data,
      dataType: 'json',
      beforeSend,
    })
  }
}
