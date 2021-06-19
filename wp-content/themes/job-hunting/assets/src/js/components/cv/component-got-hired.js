import $ from "jquery"
import NotificationPopup from "../notification-popup"

export default class ComponentGotHired {
  constructor(cvId, nonce) {
    this.button = document.querySelector('#got_hired_btn')
    this.notification = new NotificationPopup()
    this.cvId = cvId
    this.nonce = nonce

    this.registerActions()
  }

  registerActions () {
    $(document).on('profile_published', () => $(this.button).removeClass('d-none'))
    $(document).on('profile_drafted', () => $(this.button).addClass('d-none'))
    $(document).on('click', '#got_hired_btn', this.deactivateProfile.bind(this))
  }

  deactivateProfile () {
    event.preventDefault()

    if (isDoingAjax) {
      return
    }

    let isDoingAjax = true
    const data = {
      action: 'profile_deactivate',
      cvId: this.cvId,
      nonce: this.nonce
    }

    $.ajax({
      url: window.siteSettings.ajaxurl,
      type: 'post',
      data: {
        action: 'profile_deactivate',
        cvId: this.cvId,
        nonce: this.nonce
      },
      dataType: 'json'
    })
      .done(response => {
        if (response.status !== 200) {
          this.notification.error(response.message)
        } else {
          $(document).trigger('profile_drafted')
        }
      })
      .fail(() => {
        console.error('Profile updating failed')
      })
      .always(() => {
        isDoingAjax = false
      })
  }
}
