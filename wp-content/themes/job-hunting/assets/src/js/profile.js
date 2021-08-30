import NotificationPopup from "./components/notification-popup";'./components/notification-popup'

$(() => {
  const ajaxUrl = window.siteSettings.ajaxurl
  const notification = new NotificationPopup()
  const $form = $('#profile-change-password')
  const $currentPwdInput = $form.find('.js-current-pwd')
  const $newPwdInput = $form.find('.js-new-pwd')
  const $confirmPwdInput = $form.find('.js-confirmation-pwd')
  const nonce = $form.attr('data-nonce')

  $(document).on('blur', '.js-current-pwd', () => {
    const password = $currentPwdInput.val()

    if (!password.length) {
      notification.error('Current password shouldn\'t be empty.')
    }

    const data = {
      action: 'check_user_password',
      nonce,
      password,
    }

    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: data,
      dataType: 'json',
      success: function (response) {
        if (response.status !== 200) {
          notification.error(response.message)
        }
      }
    })
  })

  $form.on('submit', event => {
    event.preventDefault()

    const pwd = $currentPwdInput.val()
    const newPwd = $newPwdInput.val()
    const confirmPwd = $confirmPwdInput.val()

    console.log(pwd, newPwd, confirmPwd)

    if (!pwd.length) {
      notification.error('Current password shouldn\'t be empty.')
      return
    }

    if (!newPwd.length || !confirmPwd.length) {
      notification.error('New & confirmation passwords shouldn\'t be empty')
      return
    }

    if (newPwd !== confirmPwd) {
      notification.error('New & confirmation passwords are different')
      return
    }

    const data = {
      action: 'change_user_password',
      nonce,
      password: pwd,
      newPassword: newPwd,
      passwordConfirmation: confirmPwd
    }

    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: data,
      dataType: 'json',
      success: function (response) {
        if (response.status === 200) {
          notification.success('Password updated')
          document.location.href = '/login/'
        } else {
          notification.error(response.message)
        }
      }
    })
  })
})
