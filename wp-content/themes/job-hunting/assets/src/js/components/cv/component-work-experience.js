import $ from "jquery";
import ComponentRepeaterAbstract from "./component-repeater-abstract";

export default class ComponentWorkExperience extends ComponentRepeaterAbstract {
  /**
   * ComponentEducation constructor.
   *
   * @param cvId
   * @param candidateId
   * @param nonce
   */
  constructor(cvId, candidateId, nonce) {
    super(cvId, candidateId, nonce, 'work-experience')

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
      position: $('#position').val(),
      company: $('#company').val(),
      from: $('#from').val(),
      to: $('#to').val(),
      description: $('#description').val(),
      rowNumber: $('#row_number').val(),
      doAction: $('#do_action').val()
    }
  }
}
