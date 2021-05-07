$(() => {
  const { siteSettings } = window
  const $pageHolder = $('#candidate')
  const cvId = $pageHolder.attr('data-cv-id')
  const candidateId = $pageHolder.attr('data-user-id')

  new CvController(cvId, candidateId, siteSettings.nonce)
})

class CvController {
  constructor(cvId, candidateId, nonce) {
    this.cvId = cvId
    this.candidateId = candidateId
    this.nonce = nonce

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
    $(document).on('submit', 'form.modal-content', this.submitForm.bind(this))

    $(document).on('click', '#profile-activation-switcher', this.profileActivationToggle.bind(this))
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
   * Save form data by Ajax.
   *
   * @param event
   */
  submitForm (event) {
    event.preventDefault()

    const $notification = $('.js-notification')
    let data = {}

    switch (event.currentTarget.id) {
      case 'about-me':
        data = this.getFormAboutMeData()
        break
      case 'contacts':
        data = this.getFormContactsData()
        break
      case 'websites':
        data = this.getFormWebsitesData()
        break
    }

    this
      .sendAjax(
        data,
        () => {}
      )
      .done(
        request => {
          if (request.status !== 200) {
            $notification.text(request.message).addClass('alert-danger').removeClass('d-none', 'alert-success')
            return
          }

          $notification.text(request.message).addClass('alert-success').removeClass('d-none', 'alert-danger')
          $(`#${data.holderId}`).html(request.html)

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

  profileActivationToggle (event) {
    const $switcher = $('#profile-activation-switcher')
    const isSwitcherActive = !$switcher.hasClass('active')
    const $spinner = $('.profile-activation__spinner')
    const $notification = $('#profile-notification')
    const $textHolder = $('.profile-activation__text')
    const data = {
      action: 'profile_activation',
      user: this.candidateId,
      nonce: this.nonce
    }

    console.log(isSwitcherActive)

    this
      .sendAjax(
        data,
        () => {
          $spinner.toggleClass('d-none')
          $switcher.toggleClass('d-none')
          $notification.addClass('d-none').removeClass('alert-danger')
        }
      )
      .done(
        request => {
          if (request.status !== 200) {
            $notification.html(request.message).addClass('alert-danger').removeClass('d-none')

            if (isSwitcherActive) {
              $switcher.addClass('active')
            } else {
              $switcher.removeClass('active')
            }

            return
          }

          $textHolder.text(request.data.message)
          if (request.data.status === 'publish') {
            $switcher.addClass('active')
          } else {
            $switcher.removeClass('active');
          }
        }
      )
      .fail(
        error => {
          $notification.text('Updating failed').addClass('alert-danger').removeClass('d-none', 'alert-success')

          if (isSwitcherActive) {
            $switcher.addClass('active')
          } else {
            $switcher.removeClass('active')
          }
        }
      )
      .always(
        () => {
          $spinner.toggleClass('d-none')
          $switcher.toggleClass('d-none')
        }
      )
  }

  /**
   * Generate "about me" form data for ajax request.
   *
   * @returns {{cvId: *, zip: (*|jQuery), isReadyToRelocate: (*|jQuery), action: string, fullName: (*|jQuery), location: (*|jQuery), user: *, holderId: string, headline: (*|jQuery)}}
   */
  getFormAboutMeData () {
    return  {
      action: 'save_about_me_form',
      cvId: this.cvId,
      user: this.candidateId,
      holderId: 'about-me-holder',
      fullName: $('#name').val(),
      headline: $('#headline').val(),
      location: $('#location').val(),
      zip: $('#zip').val(),
      isReadyToRelocate: $('#is-ready-to-relocate').prop('checked'),
    }
  }

  /**
   * Generate "contact information" form data for ajax request.
   *
   * @returns {{cvId: *, phone: (*|jQuery), action: string, user: *, holderId: string, email: (*|jQuery)}}
   */
  getFormContactsData () {
    return  {
      action: 'save_contacts_form',
      cvId: this.cvId,
      user: this.candidateId,
      holderId: 'contacts-holder',
      phone: $('#phone').val(),
      email: $('#public_email').val(),
    }
  }

  /**
   * Generate "contact information" form data for ajax request.
   *
   * @returns {{cvId: *, phone: (*|jQuery), action: string, user: *, holderId: string, email: (*|jQuery)}}
   */
  getFormWebsitesData () {
    return  {
      action: 'save_websites_form',
      cvId: this.cvId,
      user: this.candidateId,
      holderId: 'websites-holder',
      website: $('#website').val(),
      twitter: $('#twitter').val(),
      linkedin: $('#linkedin').val(),
      facebook: $('#facebook').val(),
    }
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
