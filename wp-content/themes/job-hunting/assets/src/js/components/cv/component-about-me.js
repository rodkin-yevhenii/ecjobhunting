import $ from "jquery";
import ComponentAbstract from "./component-abstract"
import Autocomplete from "../autocomplate/autocomplete";

export default class ComponentAboutMe extends ComponentAbstract {
  id = 'about-me'

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
    this.actions.push(
      {
        action: `load-${this.id}-form`,
        elements: document,
        callback: () => {
          const $input = $('.js-auto-complete')

          new Autocomplete($input, 'location')
        }
      }
    )

    this.registerActions()
  }

  /**
   * Get prepared data object for save form ajax request.
   *
   * @returns {{}}    Data object for save form ajax request
   */
  getSaveFormAjaxData () {
    const data = super.getSaveFormAjaxData()

    data.fullName = $('#name').val()
    data.headline = $('#headline').val()
    data.location = $('#location').val()
    data.zip = $('#zip').val()
    data.isReadyToRelocate = $('#is-ready-to-relocate').val()

    return data
  }
}
