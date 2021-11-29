import $ from "jquery";
import AjaxRequest from "../ajax/ajax-request";
import NotificationPopup from "../notification-popup";

export default class ComponentProfileActivation {
  /**
   * ComponentProfileActivation constructor
   *
   * @param cvId
   * @param candidateId
   * @param nonce
   */
  constructor(cvId, candidateId, nonce) {
    this.cvId = cvId
    this.candidateId = candidateId
    this.nonce = nonce

    const $switcher = $('#profile-activation-switcher')

    $switcher.on('click', this.profileActivationToggle.bind(this))
    $(document).on('profile_drafted', () => {
      $switcher.removeClass('active')
      $('.profile-activation__text').text('Private: Your profile is not publicly accessible.')
    })
  }

  profileActivationToggle () {
    const $switcher = $('#profile-activation-switcher')
    const isSwitcherActive = !$switcher.hasClass('active')
    const $notification = $('#profile-notification')
    const $textHolder = $('.profile-activation__text')
    const data = {
      action: 'profile_activation',
      nonce: this.nonce,
      user: this.candidateId,
    }
    const ajax = new AjaxRequest(data)
    const notification = new NotificationPopup()

    ajax
      .send()
      .done(
        response => {
          if (response.status !== 200) {
            notification.error(response.message)

            if (isSwitcherActive) {
              $switcher.addClass('active')
            } else {
              $switcher.removeClass('active')
            }

            return
          }

          $textHolder.text(response.data.message)
          notification.success(response.message)

          if (response.data.status === 'publish') {
            $switcher.addClass('active')
            $(document).trigger('profile_published')
          } else {
            $switcher.removeClass('active');
            $(document).trigger('profile_drafted')
          }
        }
      )
      .fail(
        error => {
          notification.error('Updating failed')

          if (isSwitcherActive) {
            $switcher.addClass('active')
          } else {
            $switcher.removeClass('active')
          }
        }
      )
  }
}
