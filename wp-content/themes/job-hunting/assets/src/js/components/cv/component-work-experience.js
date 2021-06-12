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

    this.actions.push(
      {
        action: 'click',
        elements: '.js-is-in-progress',
        callback: this.updateToField.bind(this)
      }
    )

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
      isInProgress: $('#is_in_progress').is(':checked'),
      description: $('#description').val(),
      rowNumber: $('#row_number').val(),
      doAction: $('#do_action').val()
    }
  }

  updateToField(event) {
    const isInProgress = $(event.currentTarget).is(':checked')
    const $to = $('#to')

    if (isInProgress) {
      $to
        .prop('disabled', true)
        .val('Current')
    } else {
      $to
        .prop('disabled', false)
        .val('')
    }
  }
}
