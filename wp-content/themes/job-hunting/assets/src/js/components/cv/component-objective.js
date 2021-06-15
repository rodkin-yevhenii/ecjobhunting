import $ from "jquery";
import ComponentHiddenAbstract from "./component-hidden-abstract";
import Alert from "../alert";

export default class ComponentObjective extends ComponentHiddenAbstract {
  formId = 'objective'
  addLinkId = 'add_objective'
  addLinkHolderId = 'add_objective'
  editLink = '.js-edit-objective'
  removeLink = '.js-remove-objective'
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
