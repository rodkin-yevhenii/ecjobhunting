import $ from "jquery";
import ComponentAbstract from "./component-abstract"
import Autocomplete from "../autocomplate/autocomplete";

export default class ComponentAboutMe extends ComponentAbstract {
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
        elements: '.js-edit-about-me',
        callback: this.showForm.bind(this)
      },
      {
        action: 'submit',
        elements: 'form#about-me',
        callback: this.submitForm.bind(this)
      },
      {
        action: 'load-about-me-form',
        elements: document,
        callback: () => {
          const $input = $('.js-auto-complete')

          new Autocomplete($input, 'location')
        }
      }
    )

    super.registerActions()
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
      action: 'load_about_me_form',
      formId: 'about-me'
    }
  }

  /**
   * Get prepared data object for save form ajax request.
   *
   * @returns {{}}    Data object for save form ajax request
   */
  getSaveFormAjaxData () {
    return {
      action: 'save_about_me_form',
      nonce: this.nonce,
      cvId: this.cvId,
      user: this.candidateId,
      holderId: 'about-me-holder',
      fullName: $('#name').val(),
      headline: $('#headline').val(),
      location: $('#location').val(),
      zip: $('#zip').val(),
      isReadyToRelocate: $('#is-ready-to-relocate').is(':checked'),
    }
  }
}
