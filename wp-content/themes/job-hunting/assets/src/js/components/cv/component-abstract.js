import $ from "jquery";
import AjaxRequest from "../ajax/ajax-request";
import Alert from "../alert";
import NotificationPopup from "../notification-popup";

export default class ComponentAbstract {
  id = ''
  actions = []

  /**
   * ComponentSimpleAbstract constructor
   *
   * @param cvId
   * @param candidateId
   * @param nonce
   */
  constructor(cvId, candidateId, nonce) {
    this.cvId = cvId
    this.candidateId = candidateId
    this.nonce = nonce
  }

  /**
   * Initialize notification elements
   */
  init () {
    this.notification = new NotificationPopup()
    this.alert = new Alert('#form-error')
    this.actions = [
      {
        action: 'click',
        elements: `.js-edit-${this.id}`,
        callback: this.showForm.bind(this)
      },
      {
        action: 'submit',
        elements: `form#${this.id}`,
        callback: this.submitForm.bind(this)
      }
    ]
  }

  /**
   * Register handlers for DOM actions.
   */
  registerActions () {
    this.actions.forEach(item => {
      $(document).on(item.action, item.elements, item.callback)
    })
  }

  /**
   * Show open modal window with different forms on
   * candidate dashboard page.
   *
   * @param event
   */
  showForm (event) {
    event.preventDefault()

    const $edit = $(event.currentTarget)
    const $holder = $('#edit .modal-dialog')
    const data = this.getShowFormAjaxData($edit)
    const ajax = new AjaxRequest(data)

    ajax.beforeSend = () => {
      $holder.html(
        '<div class="text-center" style="min-height:400px">\n' +
        '    <div class="spinner-border text-success" style="position: absolute;left: 50%;top: 50%" role="status">\n' +
        '        <span class="sr-only">Loading...</span>\n' +
        '    </div>\n' +
        '</div>'
      )
    }

    ajax.send()
      .done(
        response => {
          if (response.status !== 200) {
            console.error('Form loading failed.', response.message)
            return
          }

          $holder.html(response.html)
          $(document).trigger(`load-${data.formId}-form`)
          console.log(`Run "load-${data.formId}-form" action`)
        }
      )
      .fail(
        error => {
          console.error('Form loading failed.', error)
        }
      )
  }

  /**
   * Save form data by Ajax.
   *
   * @param event
   */
  submitForm (event) {
    event.preventDefault()

    const data = this.getSaveFormAjaxData()
    const ajax = new AjaxRequest(data)

    ajax.send()
      .done(
        response => {
          if (response.status !== 200) {
            this.alert.error(response.message)
            return
          }

          $(`#${data.holderId}`).html(response.html)
          $('#edit').modal('hide')
          this.notification.success(response.message)
          $(document).trigger(`updated-${this.id}-block`)
          console.log(`Run "updated-${this.id}-block" action`)
        }
      )
      .fail(
        () => {
          this.alert.error('Updating failed')
        }
      )
  }

  /**
   * Get prepared data object for show form ajax request.
   *
   * @param $btn    Edit button (jQuery object).
   * @returns {{}}  Data object for show form ajax request.
   */
  getShowFormAjaxData ($btn) {
    return {
      nonce: this.nonce,
      action: `load_${this.id}_form`,
      formId: this.id
    }
  }

  /**
   * Get prepared data object for save form ajax request.
   *
   * @returns {{}}    Data object for save form ajax request
   */
  getSaveFormAjaxData () {
    return {
      nonce: this.nonce,
      action: `save_${this.id}_form`,
      cvId: this.cvId,
      user: this.candidateId,
      holderId: `${this.id}-holder`,
      formId: this.id,
    }
  }
}
