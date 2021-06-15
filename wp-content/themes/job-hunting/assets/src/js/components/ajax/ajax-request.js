import $ from "jquery";

export default class AjaxRequest {
  constructor(data) {
    this.beforeSend = () => {}
    this.data = data
    this.ajaxurl = window.siteSettings.ajaxurl
  }

  send() {
    return $.ajax({
      type: 'POST',
      url: this.ajaxurl,
      data: this.data,
      dataType: 'json',
      beforeSend: this.beforeSend,
    })
  }
}
