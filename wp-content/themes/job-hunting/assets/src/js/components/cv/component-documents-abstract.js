import NotificationPopup from "../notification-popup";
import $ from "jquery";

export default class ComponentDocumentsAbstract {
  /**
   * ComponentEducation constructor.
   *
   * @param cvId
   * @param candidateId
   * @param nonce
   * @param options
   */
  constructor(cvId, candidateId, nonce, options) {
    const { elements, events, ajaxActions, holder } = options

    this.cvId = cvId
    this.candidateId = candidateId
    this.nonce = nonce
    this.notification = new NotificationPopup()
    this.input = elements.input
    this.removeButtons = elements.removeButtons
    this.ajaxActions = ajaxActions
    this.holder = holder

    this.events = [
      {
        action: 'change',
        element: this.input,
        callback: this.uploadFile.bind(this)
      },
      {
        action: 'click',
        element: this.removeButtons,
        callback: this.removeFile.bind(this)
      }
    ]

    if (Array.isArray(elements.events) && elements.events.length) {
      this.events = [elements.events, ...this.events]
    }

    this.registerEvents()
  }

  registerEvents () {
    this.events.forEach(event => {
      const { element, action, callback } = event
      $(document).on(action, element, callback)
    })
  }

  uploadFile (event) {
    if (isDoingAjax) {
      return
    }

    const fileData = event.currentTarget.files[0];
    const formData = new FormData();
    let isDoingAjax = true

    formData.append('file', fileData)
    formData.append('action', this.ajaxActions.uploadFile)
    formData.append('nonce', this.nonce)
    formData.append('cvId', this.cvId)

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
          this.notification.error(response.message)
          return
        }

        // this.notification.success(response.message)
        this.holder.innerHTML = response.html
        isDoingAjax = false
      })
      .fail(() => {
        console.error('Resume loading failed')
        isDoingAjax = false
      })
  }

  removeFile (event) {
    event.preventDefault()

    if (isDoingAjax) {
      return
    }

    let isDoingAjax = true
    const item = event.currentTarget.closest('.profile-subitem')
    const data = {
      action: this.ajaxActions.removeFile,
      cvId: this.cvId,
      nonce: this.nonce,
      row: ++ event.currentTarget.dataset.rowNumber
    }

    $.ajax({
      url: window.siteSettings.ajaxurl,
      type: 'post',
      data,
      dataType: 'json'
    })
      .done(response => {
        if (response.status !== 200) {
          this.notification.error(response.message)
          return
        }

        this.holder.innerHTML = response.html
        isDoingAjax = false
      })
      .fail(() => {
        console.error('Reference deleting failed')
        isDoingAjax = false
      })
  }
}
