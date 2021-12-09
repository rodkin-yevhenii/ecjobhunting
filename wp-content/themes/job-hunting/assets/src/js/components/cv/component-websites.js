import $ from "jquery";
import ComponentAbstract from "./component-abstract"

export default class ComponentWebsites extends ComponentAbstract {
  id = 'websites'

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
    this.registerActions()
  }

  /**
   * Get prepared data object for save form ajax request.
   *
   * @returns {{}}    Data object for save form ajax request
   */
  getSaveFormAjaxData () {
    const data = super.getSaveFormAjaxData()

    data.website = $('#website').val()
    data.twitter = $('#twitter').val()
    data.linkedin = $('#linkedin').val()
    data.facebook = $('#facebook').val()

    return data
  }
}
