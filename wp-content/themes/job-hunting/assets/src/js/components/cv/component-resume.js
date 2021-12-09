import ComponentHiddenAbstract from "./component-hidden-abstract";
import Alert from "../alert";
import $ from 'jquery'
import AjaxRequest from "../ajax/ajax-request";
import NotificationPopup from "../notification-popup";

export default class ComponentResume extends ComponentHiddenAbstract {
  formId = 'resume'
  addLinkId = 'add_resume'
  addLinkHolderId = 'add_resume'
  editLink = '.js-edit-resume'
  removeLink = '.js-remove-resume'
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

    this.notification = new NotificationPopup()
    this.initActions()

    this.actions.push(
      {
        action: 'change',
        elements: `#resume_file`,
        callback: this.loadFile.bind(this)
      }
    )
    this.initAjaxAction()
    this.registerActions()
  }

  loadFile (event) {
    const fileData = jQuery(event.currentTarget).prop('files')[0];
    const formData = new FormData();
    const alert = new Alert('#form-error')

    formData.append('file', fileData);
    formData.append('action', 'load_resume_file');
    formData.append('nonce', this.nonce);
    formData.append('cvId', this.cvId);

    $.ajax({
      url: window.siteSettings.ajaxurl,
      type: 'post',
      contentType: false,
      processData: false,
      data: formData,
      dataType: 'json'
    })
      .done(response => {
        if (response.status !== 200) {
          alert.error(response.message)
          return
        }

        $(`#${this.holderId}`).html(response.html)
        $('#edit').modal('hide')
        this.notification.success(response.message)
      })
      .fail(() => {
        console.error('Resume loading failed')
      })
  }

  removeData (event) {
    event.preventDefault()

    const data = {
      action: this.ajax.remove,
      nonce: this.nonce,
      cvId: this.cvId
    }
    const ajax = new AjaxRequest(data)

    ajax.send()
      .done(
        response => {
          if (response.status !== 200) {
            notification.error(response.message)
            return
          }

          this.notification.success(response.message)
          $(`#${this.holderId}`).html(response.html)
        }
      )
      .fail(
        () => {
          this.notification.error('Updating failed')
        }
      )
  }
}
