import $ from "jquery";
import ComponentAbstract from "./component-abstract"

export default class ComponentMoreInformation extends ComponentAbstract {
  formId = 'more-information'

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
        elements: '.js-edit-' + this.formId,
        callback: this.showForm.bind(this)
      },
      {
        action: 'submit',
        elements: 'form#' + this.formId,
        callback: this.submitForm.bind(this)
      }
    )

    this.registerActions()
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
      action: 'load_' + this.formId + '_form',
      formId: this.formId
    }
  }

  /**
   * Get prepared data object for save form ajax request.
   *
   * @returns {{}}    Data object for save form ajax request
   */
  getSaveFormAjaxData () {
    return {
      action: 'save_' + this.formId + '_form',
      nonce: this.nonce,
      cvId: this.cvId,
      user: this.candidateId,
      holderId: this.formId + '-holder',
      desired_salary: $('#desired_salary').val(),
      years_of_experience: $('#years_of_experience').val(),
      highest_degree_earned: $('#highest_degree_earned').val(),
      category: $('#category').val(),
      veteran_status: $('#veteran_status').val(),
    }
  }
}
