import $ from "jquery";
import ComponentRepeaterAbstract from "./component-repeater-abstract";

export default class ComponentAssociations extends ComponentRepeaterAbstract {
  /**
   * ComponentEducation constructor.
   *
   * @param cvId
   * @param candidateId
   * @param nonce
   */
  constructor(cvId, candidateId, nonce) {
    super(cvId, candidateId, nonce, 'associations')
    this.registerActions()
  }


  /**
   * Get prepared data object for save form ajax request.
   *
   * @returns {{}}    Data object for save form ajax request
   */
  getSaveSubItemAjaxData () {
    return {
      action: `save_${this.formId}_subitem`,
      nonce: this.nonce,
      cvId: this.cvId,
      user: this.candidateId,
      holderId: this.formId + '-holder',
      content: $(`#${this.formId} textarea`).val(),
      rowNumber: $('#row_number').val(),
      doAction: $('#do_action').val()
    }
  }
}
