import $ from 'jquery'

export default class NotificationPopup {
  constructor() {
    this.allowedTypes = [
      'alert-primary',
      'alert-secondary',
      'alert-success',
      'alert-danger',
      'alert-warning',
      'alert-info'
    ]
    this.popup = $('#notification-popup')

    this.registerActions()
  }

  registerActions() {
    this.popup.on('show.bs.modal', function () {
          setTimeout(() => {
            this.popup.modal('hide')
            this.restore()
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
    this.customNotification(message, 'success')
  }

  /**
   * Show success notification.
   *
   * @param message   Text message.
   */
  error(message) {
    this.customNotification(message, 'danger')
  }

  /**
   * Show success notification.
   *
   * @param message   Text message.
   */
  warning(message) {
    this.customNotification(message, 'warning')
  }

  /**
   * Show notification.
   *
   * @param message   Text message.
   * @param type      Alert type: primary, secondary, success, danger, warning, info.
   */
  customNotification(message, type) {
    this.popup.find('.content').text(message)
    this.setAlertType(type)
    this.popup.modal('show')
  }

  /**
   * Set notification type.
   *
   * @param type   Alert type: primary, secondary, success, danger, warning, info.
   */
  setAlertType(type) {
    const alert = this.popup.find('.alert')

    if (!this.allowedTypes.includes(type)) {
      alert.addClass('alert-secondary')
    }

    alert.addClass('alert-' + type)
  }

  restore () {
    this.allowedTypes.forEach(item => this.popup.removeClass(item))
  }
}
