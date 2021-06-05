import $ from 'jquery'

export default class Alert {
  constructor(id) {
    this.alert = $(id)
    this.allowedTypes = [
      'alert-primary',
      'alert-secondary',
      'alert-success',
      'alert-danger',
      'alert-warning',
      'alert-info'
    ]

    if (!this.alert.length) {
      return null
    }

    this.text = this.alert.find('.content')
    this.registerActions()
  }

  registerActions() {
    this.alert.on('click', '.close', function () {
        this.alert.hide()
      }.bind(this)
    )
  }

  /**
   * Show success alert.
   *
   * @param message string    Text message.
   */
  success(message) {
    this.customAlert(message, 'success')
  }

  /**
   * Show success alert.
   *
   * @param message   Text message.
   */
  error(message) {
    this.customAlert(message, 'danger')
  }

  /**
   * Show success alert.
   *
   * @param message   Text message.
   */
  warning(message) {
    this.customAlert(message, 'warning')
  }

  /**
   * Show alert.
   *
   * @param message   Text message.
   * @param type      Alert type: primary, secondary, success, danger, warning, info.
   */
  customAlert(message, type) {
    this.restore()
    this.text.text(message)
    this.setAlertType(type)
    this.alert.show()
  }

  /**
   * Set alert type.
   *
   * @param type   Alert type: primary, secondary, success, danger, warning, info.
   */
  setAlertType(type) {
    if (!this.allowedTypes.includes(type)) {
      this.alert.addClass('alert-secondary')
    }

    this.alert.addClass('alert-' + type)
  }

  restore () {
    this.allowedTypes.forEach(item => this.alert.removeClass(item))
  }
}
