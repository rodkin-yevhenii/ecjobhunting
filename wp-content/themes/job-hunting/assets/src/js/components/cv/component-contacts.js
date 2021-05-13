import $ from "jquery";
import ComponentAbstract from "./component-abstract"
import AjaxRequest from "../ajax/ajax-request";

export default class ComponentContacts extends ComponentAbstract {
  /**
   * ComponentEducation constructor.
   *
   * @param cvId
   * @param candidateId
   * @param nonce
   */
  constructor(cvId, candidateId, nonce) {
    super(cvId, candidateId, nonce)

    this.actions.push(
      {
        action: 'click',
        elements: '.js-edit-contacts',
        callback: this.showForm.bind(this)
      },
      {
        action: 'submit',
        elements: 'form#contacts',
        callback: this.submitForm.bind(this)
      },
      {
        action: 'click',
        elements: '.js-resend-email-confirmation',
        callback: this.sendEmailConfirmation.bind(this)
      }
    )

    super.registerActions()
  }

  /**
   * Get prepared data object for show form ajax request.
   *
   * @param $btn    Edit button (jQuery object).
   * @returns {{}}  Data object for show form ajax request.
   */
  getShowFormAjaxData($btn) {
    return {
      nonce: this.nonce,
      action: 'load_contacts_form',
      formId: 'contacts'
    }
  }

  /**
   * Get prepared data object for save form ajax request.
   *
   * @returns {{}}    Data object for save form ajax request
   */
  getSaveFormAjaxData () {
    return {
      action: 'save_contacts_form',
      nonce: this.nonce,
      cvId: this.cvId,
      user: this.candidateId,
      holderId: 'contacts-holder',
      phone: $('#phone').val(),
      new_email: $('#public_email').val(),
    }
  }

  sendEmailConfirmation () {
    const data = {
      action: 'send_email_confirmation',
      nonce: this.nonce
    }

    const ajax = new AjaxRequest(data)
    ajax.beforeSend = () => {
      $('#profile-notification')
        .addClass('d-none')
    }
    ajax
      .send()
      .done(response => {
        if (200 !== parseInt(response.status)) {
          $('#profile-notification')
            .text(response.message)
            .addClass('alert-danger')

          return
        }

        $('.js-verification-text')
          .addClass('color-primary')
          .removeClass('color-red')
          .text(response.message)

        $('.js-resend-email-confirmation')
          .remove()
      })
      .fail(error => {
        $('#profile-notification')
          .text(error.statusText)
          .addClass('alert-danger')
          .removeClass('d-none')
      })
  }

}
