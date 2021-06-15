import $ from 'jquery'
import AjaxRequest from "./components/ajax/ajax-request"
import ComponentAboutMe from "./components/cv/component-about-me"
import ComponentContacts from "./components/cv/component-contacts"
import ComponentWebsites from "./components/cv/component-websites"
import ComponentExecutiveSummary from "./components/cv/component-executive-summary"
import ComponentWorkExperience from "./components/cv/component-work-experience";
import ComponentEducation from "./components/cv/component-education"
import ComponentObjective from "./components/cv/component-objective";
import ComponentAchievements from "./components/cv/component-achievements";
import ComponentAssociations from "./components/cv/component-associations";
import ComponentSkills from "./components/cv/component-skills";
import ComponentProfileActivation from "./components/cv/component-profile-activation";
import ComponentMoreInformation from "./components/cv/component-more-information";

$(() => {
  const { siteSettings } = window
  const $pageHolder = $('#candidate')
  const cvId = $pageHolder.attr('data-cv-id')
  const candidateId = $pageHolder.attr('data-user-id')

  new ComponentAboutMe(cvId, candidateId, siteSettings.nonce)
  new ComponentContacts(cvId, candidateId, siteSettings.nonce)
  new ComponentWebsites(cvId, candidateId, siteSettings.nonce)
  new ComponentExecutiveSummary(cvId, candidateId, siteSettings.nonce)
  new ComponentWorkExperience(cvId, candidateId, siteSettings.nonce)
  new ComponentEducation(cvId, candidateId, siteSettings.nonce)
  new ComponentObjective(cvId, candidateId, siteSettings.nonce)
  new ComponentAchievements(cvId, candidateId, siteSettings.nonce)
  new ComponentAssociations(cvId, candidateId, siteSettings.nonce)
  new ComponentSkills(cvId, candidateId, siteSettings.nonce)
  new ComponentProfileActivation(cvId, candidateId, siteSettings.nonce)
  new ComponentMoreInformation(cvId, candidateId, siteSettings.nonce)
})

class CvController {
  constructor(cvId, candidateId, nonce) {
    this.cvId = cvId
    this.candidateId = candidateId
    this.nonce = nonce

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
    // $(document).on('click', '.js-profile-edit-btn, .js-profile-edit-link', this.showForm.bind(this))

    // Save form in modal window
    // $(document).on('submit', 'form.modal-content', this.submitForm.bind(this))

    // Delete subitem
    $(document).on('click', '.js-profile-delete-subitem-btn, .js-profile-delete-subitem-link', this.deleteSubItem.bind(this))

    // Activate / Deactivate profile
    $(document).on('click', '#profile-activation-switcher', this.profileActivationToggle.bind(this))

    // Load work-experience form
    $(document).on('load-work-experience-form', this.applyDateMask.bind(this, ['to', 'from']))
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
      nonce: this.nonce,
      formId: $edit.attr('data-form-id'),
      rowNumber: $edit.attr('data-row-number')
    }

    const ajax = new AjaxRequest(data)
    ajax.beforeSend = () => {
      $holder.html(
        '<div class="text-center" style="min-height:400px">\n' +
        '    <div class="spinner-border text-success" style="position: absolute;left: 50%;top: 50%" role="status">\n' +
        '        <span class="sr-only">Loading...</span>\n' +
        '    </div>\n' +
        '</div>'
      )
    }

    ajax.send(data)
      .done(
        request => {
          if (request.status !== 200) {
            console.error('Form loading failed.', request.message)
            return
          }

          $holder.html(request.html)
          $(document).trigger(`load-${data.formId}-form`)
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
      case 'executive-summary':
        data = this.getFormExecutiveSummaryData()
        break
      case 'work-experience':
        data = this.getForWorkExperienceData()
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
        () => {
          $notification.text('Updating failed').addClass('alert-danger').removeClass('d-none', 'alert-success')
        }
      )
  }

  deleteSubItem (event) {
    event.preventDefault()

    const $notification = $('#profile-notification')
    const $btn = $(event.currentTarget)
    const blockId = $btn.attr('data-block-id')
    const $holder = $(`#${blockId}-holder`)
    const data = {
      action: 'delete_profile_subitem',
      nonce: this.nonce,
      cvId: this.cvId,
      blockId: $btn.attr('data-block-id'),
      rowNumber: $btn.attr('data-row-number')
    }

    this
      .sendAjax(
        data,
        () => {
          $notification.addClass('d-none').removeClass('alert-danger')
        }
      )
      .done(
        request => {
          if (request.status !== 200) {
            $notification.html(request.message).addClass('alert-danger').removeClass('d-none')
            return
          }

          $holder.html(request.html)
        }
      )
      .fail(
        () => {
          $notification.text('Updating failed').addClass('alert-danger').removeClass('d-none')
        }
      )
  }

  profileActivationToggle () {
    const $switcher = $('#profile-activation-switcher')
    const isSwitcherActive = !$switcher.hasClass('active')
    const $spinner = $('.profile-activation__spinner')
    const $notification = $('#profile-notification')
    const $textHolder = $('.profile-activation__text')
    const data = {
      action: 'profile_activation',
      nonce: this.nonce,
      user: this.candidateId,
    }

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
        () => {
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
      nonce: this.nonce,
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
      nonce: this.nonce,
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
   * @returns {{cvId: *, summary: (*|jQuery), action: string, nonce: *, user: *, holderId: string}}
   */
  getFormExecutiveSummaryData () {
    return  {
      action: 'save_executive_summary_form',
      nonce: this.nonce,
      cvId: this.cvId,
      user: this.candidateId,
      holderId: 'executive-summary-holder',
      summary: $('#summary').val(),
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
      nonce: this.nonce,
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
   * Generate "Work Experience" form data for ajax request.
   *
   * @returns {{cvId: *, do_action: (*|jQuery), action: string, from: (*|jQuery), company: (*|jQuery), to: (*|jQuery), position: (*|jQuery), nonce: *, user: *, holderId: string, work_order: (*|jQuery)}}
   */
  getForWorkExperienceData () {
    return  {
      action: 'save_profile_subitem',
      nonce: this.nonce,
      cvId: this.cvId,
      user: this.candidateId,
      holderId: 'work-experience-holder',
      from: $('#from').val(),
      to: $('#to').val(),
      position: $('#position').val(),
      company: $('#company').val(),
      description: $('#description').val(),
      rowNumber: $('#row_number').val(),
      doAction: $('#do_action').val(),
    }
  }

  /**
   * Generate repeater sub item data.
   *
   * @returns {{cvId: *, do_action: (*|jQuery), action: string, from: (*|jQuery), company: (*|jQuery), to: (*|jQuery), position: (*|jQuery), nonce: *, user: *, holderId: string, work_order: (*|jQuery)}}
   */
  getDeleteSubItemData ($btn) {
    return  {
      action: 'delete_profile_subitem',
      nonce: this.nonce,
      cvId: this.cvId,
      blockId: $btn.attr('data-block-id'),
      rowNumber: $btn.attr('data-row-number'),
    }
  }

  /**
   * Ajax request. The function return promise.
   *
   * @param data        Object with data
   * @param beforeSend  Callback
   * @returns {*|jQuery|{getAllResponseHeaders: function(): *|null, abort: function(*=): this, setRequestHeader: function(*=, *): this, readyState: number, getResponseHeader: function(*): null|*, overrideMimeType: function(*): this, statusCode: function(*=): this}}
   */

  applyDateMask(ids) {
    const mask = {
      mask: Date,
      lazy: false,
      overwrite: true,
      autofix: true,
      blocks: {
        d: {mask: IMask.MaskedRange, placeholderChar: 'd', from: 1, to: 31, maxLength: 2},
        m: {mask: IMask.MaskedRange, placeholderChar: 'm', from: 1, to: 12, maxLength: 2},
        Y: {mask: IMask.MaskedRange, placeholderChar: 'y', from: 1900, to: 2100, maxLength: 4}
      }
    }

    ids.forEach(element => {
      IMask(document.getElementById(element), mask)
    })
  }
}
