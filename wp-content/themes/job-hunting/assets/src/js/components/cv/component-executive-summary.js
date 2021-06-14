import ComponentHiddenAbstract from "./component-hidden-abstract";

export default class ComponentExecutiveSummary extends ComponentHiddenAbstract {
  formId = 'executive-summary'
  addLinkId = 'add_executive-summary'
  addLinkHolderId = 'add_executive-summary'
  editLink = '.js-edit-executive-summary'
  removeLink = '.js-remove-executive-summary'
  holderId = `${this.formId}-holder`

  /**
   * ComponentEducation constructor.
   *
   * @param cvId
   * @param candidateId
   * @param nonce
   */
  constructor(cvId, candidateId, nonce ) {
    super(cvId, candidateId, nonce)

    this.initActions()
    this.initAjaxAction()
    this.registerActions()
  }
}
