import $ from "jquery";
import AjaxRequest from "../ajax/ajax-request";
import Alert from "../alert";
import NotificationPopup from "../notification-popup";

export default class ComponentRepeaterAbstract {

  /**
   * ComponentSimpleAbstract constructor
   *
   * @param cvId
   * @param candidateId
   * @param nonce
   * @param formId
   */
  constructor(cvId, candidateId, nonce, formId) {
    this.cvId = cvId
    this.candidateId = candidateId
    this.nonce = nonce
    this.formId = formId
    this.notification = new NotificationPopup()
    this.actions = [
      {
        action: 'click',
        elements: '.js-add-' + formId + '-subitem',
        callback: this.addSubItem.bind(this)
      },
      {
        action: 'click',
        elements: '.js-edit-' + formId + '-subitem',
        callback: this.editSubItem.bind(this)
      },
      {
        action: 'click',
        elements: '.js-delete-' + formId + '-subitem',
        callback: this.deleteSubItem.bind(this)
      },
      {
        action: 'submit',
        elements: 'form#' + formId,
        callback: this.saveSubItem.bind(this)
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
   * Show open modal window with empty form on
   * candidate dashboard page.
   *
   * @param event
   */
  addSubItem (event) {
    event.preventDefault()

    const $edit = $(event.currentTarget)
    const $holder = $('#edit .modal-dialog')
    const data = {
      nonce: this.nonce,
      action: 'load_add_' + this.formId + '_subitem_form',
      formId: this.formId
    }
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
   * Show open modal window with form with sub item
   * data on candidate dashboard page.
   *
   * @param event
   */
  editSubItem (event) {
    event.preventDefault()

    const $edit = $(event.currentTarget)
    const $holder = $('#edit .modal-dialog')
    const data = {
      nonce: this.nonce,
      action: 'load_edit_' + this.formId + '_subitem_form',
      formId: this.formId,
      rowNumber: $edit.attr('data-row-number')
    }
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
   * Send delete sub item request.
   *
   * @param event
   */
  deleteSubItem (event) {
    event.preventDefault()

    const $edit = $(event.currentTarget)
    const $holder = $('#edit .modal-dialog')
    const data = {
      cvId: this.cvId,
      nonce: this.nonce,
      action: 'delete_' + this.formId + '_subitem',
      blockId: this.formId,
      rowNumber: $edit.attr('data-row-number')
    }
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
            this.notification.error(response.message)
            return
          }

          this.notification.success(response.message)
          $(`#${this.formId}-holder`).html(response.html)
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
  saveSubItem (event) {
    event.preventDefault()

    const data = this.getSaveSubItemAjaxData()
    const ajax = new AjaxRequest(data)
    const alert = new Alert('#form-error')

    ajax.send()
      .done(
        response => {
          if (response.status !== 200) {
            alert.error(response.message)
            return
          }

          $(`#${data.holderId}`).html(response.html)
          $('#edit').modal('hide')
          this.notification.success(response.message)
        }
      )
      .fail(
        () => {
          alert.error('Updating failed')
        }
      )
  }

  /**
   * Get prepared data object for save form ajax request.
   *
   * @returns {{}}    Data object for save form ajax request
   */
  getSaveSubItemAjaxData () {
    return {}
  }
}
