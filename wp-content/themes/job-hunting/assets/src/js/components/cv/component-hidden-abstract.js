import $ from "jquery";
import ComponentAbstract from "./component-abstract";
import AjaxRequest from "../ajax/ajax-request";
import Alert from "../alert";
import NotificationPopup from "../notification-popup";

export default class ComponentHiddenAbstract extends ComponentAbstract{

  formId = ''
  addLinkId = ''
  addLinkHolderId = ''
  editLink = ''
  removeLink = ''
  holderId = ''
  actions = [];
  ajax = {}

  /**
   * ComponentSimpleAbstract constructor
   *
   * @param cvId
   * @param candidateId
   * @param nonce
   */
  constructor(cvId, candidateId, nonce) {
    super(cvId, candidateId, nonce)

    // this.initActions()
  }

  initActions () {
    this.actions = [
      {
        action: 'click',
        elements: `#${this.addLinkId} a,${this.editLink}`,
        callback: this.showForm.bind(this)
      },
      {
        action: 'click',
        elements: this.removeLink,
        callback: this.removeData.bind(this)
      },
      {
        action: 'submit',
        elements: `form#${this.formId}`,
        callback: this.submitForm.bind(this)
      }
    ]
  }

  initAjaxAction () {
    this.ajax = {
      load: `load_${this.formId}_form`,
      save: `save_${this.formId}_form`,
      remove: `remove_${this.formId}_form`,
    }
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
      action: this.ajax.load,
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
      action: this.ajax.save,
      nonce: this.nonce,
      cvId: this.cvId,
      user: this.candidateId,
      holderId: this.holderId,
      content: $(`#${this.formId} textarea`).val()
    }
  }

  /**
   * Save form data by Ajax.
   *
   * @param event
   */
  submitForm (event) {
    super.submitForm(event)
    this.showBlock()
  }

  removeData (event) {
    event.preventDefault()

    const data = {
      action: this.ajax.remove,
      nonce: this.nonce,
      cvId: this.cvId
    }
    const ajax = new AjaxRequest(data)
    const notification = new NotificationPopup()

    ajax.send()
      .done(
        response => {
          if (response.status !== 200) {
            notification.error(response.message)
            return
          }

          notification.success(response.message)
          this.hideBlock()
        }
      )
      .fail(
        () => {
          notification.error('Updating failed')
        }
      )
  }

  hideBlock () {
    $(`#${this.holderId}`).addClass('d-none')
    $(`#${this.addLinkHolderId}`).removeClass('d-none')
  }

  showBlock () {
    $(`#${this.holderId}`).removeClass('d-none')
    $(`#${this.addLinkHolderId}`).addClass('d-none')
  }
}
