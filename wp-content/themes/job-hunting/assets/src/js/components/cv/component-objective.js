import ComponentAbstract from "./component-abstract";
import $ from "jquery";

export default class ComponentObjective extends ComponentAbstract {
  id = 'objective'

  /**
   * ComponentEducation constructor.
   *
   * @param cvId
   * @param candidateId
   * @param nonce
   */
  constructor(cvId, candidateId, nonce ) {
    super(cvId, candidateId, nonce)

    this.init()
    this.registerActions()
  }

  /**
   * Get prepared data object for save form ajax request.
   *
   * @returns {{}}    Data object for save form ajax request
   */
  getSaveFormAjaxData () {
    const data = super.getSaveFormAjaxData()
    data.content = $('#text').val()

    return data
  }
}
