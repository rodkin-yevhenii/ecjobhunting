import $ from 'jquery'

export default class NotificationPopup {
  constructor() {
    this.popup = $('#notification-popup')
    this.textContainer = this.popup.find('.content')

    this.registerActions()
  }

  registerActions() {
    this.popup.on('show.bs.modal', function () {
          setTimeout(() => {
            this.popup.modal('hide')
          }, 5000)
      }.bind(this)
    )
  }

  /**
   * Show success notification.
   *
   * @param message string    Text message.
   */
  success(message) {
    this.textContainer.text(message)
    this.setAlertType('success')
    this.popup.modal('show')
  }

  /**
   * Show success notification.
   *
   * @param message   Text message.
   */
  error(message) {
    this.textContainer.text(message)
    this.setAlertType('danger')
    this.popup.modal('show')
  }

  /**
   * Show success notification.
   *
   * @param message   Text message.
   */
  warning(message) {
    this.textContainer.text(message)
    this.setAlertType('warning')
    this.popup.modal('show')
  }

  setAlertType(type) {
    const alert = this.popup.find('.alert')

    if (!['warning', 'success', 'danger'].includes(type)) {
      alert.addClass('alert-success')
    }

    alert.addClass('alert-' + type)
  }
}
