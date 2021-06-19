import $ from "jquery";
import ComponentAbstract from "./component-abstract"

export default class ComponentMoreInformation extends ComponentAbstract {
  id = 'more-information'

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

    data.desired_salary = $('#desired_salary').val()
    data.years_of_experience = $('#years_of_experience').val()
    data.highest_degree_earned = $('#highest_degree_earned').val()
    data.category = $('#category').val()
    data.veteran_status = $('#veteran_status').val()

    return data
  }
}
