import $ from "jquery";
import ComponentAbstract from "./component-abstract"

export default class ComponentWebsites extends ComponentAbstract {
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
        elements: '.js-edit-websites',
        callback: this.showForm.bind(this)
      },
      {
        action: 'submit',
        elements: 'form#websites',
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
      action: 'load_websites_form',
      formId: 'websites'
    }
  }

  /**
   * Get prepared data object for save form ajax request.
   *
   * @returns {{}}    Data object for save form ajax request
   */
  getSaveFormAjaxData () {
    return {
      action: 'save_websites_form',
      nonce: this.nonce,
      cvId: this.cvId,
      user: this.candidateId,
      holderId: 'websites-holder',
      website: $('#website').val(),
      twitter: $('#twitter').val(),
      linkedin: $('#linkedin').val(),
      facebook: $('#facebook').val()
    }
  }
}
