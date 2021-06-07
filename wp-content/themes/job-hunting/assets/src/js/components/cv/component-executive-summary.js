import $ from "jquery";
import ComponentAbstract from "./component-abstract"

export default class ComponentExecutiveSummary extends ComponentAbstract {
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
        elements: '.js-profile-edit-btn, .js-edit-summary',
        callback: this.showForm.bind(this)
      },
      {
        action: 'submit',
        elements: 'form#executive-summary',
        callback: this.submitForm.bind(this)
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
      action: 'load_executive_summary_form',
      formId: 'executive-summary'
    }
  }

  /**
   * Get prepared data object for save form ajax request.
   *
   * @returns {{}}    Data object for save form ajax request
   */
  getSaveFormAjaxData($btn) {
    return {
      action: 'save_executive_summary_form',
      nonce: this.nonce,
      cvId: this.cvId,
      user: this.candidateId,
      holderId: 'executive-summary-holder',
      summary: $('#summary').val()
    }
  }
}
