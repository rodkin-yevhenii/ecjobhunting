import $ from "jquery";
import ComponentAbstract from "./component-abstract"
import AjaxRequest from "../ajax/ajax-request";

export default class ComponentContacts extends ComponentAbstract {
  id = 'contacts'

  /**
   * ComponentEducation constructor.
   *
   * @param cvId
   * @param candidateId
   * @param nonce
   */
  constructor(cvId, candidateId, nonce) {
    super(cvId, candidateId, nonce)

    this.init()
    this.actions.push(
      {
        action: 'click',
        elements: '.js-resend-email-confirmation',
        callback: this.sendEmailConfirmation.bind(this)
      }
    )

    this.registerActions()
  }

  /**
   * Get prepared data object for save form ajax request.
   *
   * @returns {{}}    Data object for save form ajax request
   */
  getSaveFormAjaxData () {
    const data = super.getSaveFormAjaxData()

    data.phone = $('#phone').val()
    data.new_email = $('#public_email').val()

    return data
  }

  /**
   * Send email with confirmation link
   */
  sendEmailConfirmation () {
    const data = {
      action: 'send_email_confirmation',
      nonce: this.nonce
    }
    const ajax = new AjaxRequest(data)

    ajax
      .send()
      .done(response => {
        if (200 !== parseInt(response.status)) {
          this.notification.error(response.message)

          return
        }

        this.notification.success(response.message)
        $('.js-verification-text')
          .remove()

        $('.js-resend-email-confirmation')
          .remove()
      })
      .fail(error => {
        this.notification.error(error.statusText)
      })
  }

}
