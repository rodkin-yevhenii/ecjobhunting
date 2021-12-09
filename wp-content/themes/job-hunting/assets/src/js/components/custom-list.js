export default class CustomList {
  constructor() {
    this.initActions()
  }

  initActions ()
  {
    $(document).on('click', '.js-custom-list-item-close', function () {
      $(this).parents('li').detach()
    })

    $(document).on('click', '.js-custom-list-add-button', function (event) {
      this.addItem($(event.currentTarget).parents('.js-custom-list-component'))
    }.bind(this))

    $(document).on('keydown', '.js-custom-list-input', function (event) {
      if (event.keyCode === 13) {
        event.preventDefault()
        this.addItem($(event.currentTarget).parents('.js-custom-list-component'))
      }
    }.bind(this))
  }

  addItem (parentContainer)
  {
    const input = $(parentContainer).find('.js-custom-list-input'),
    value = input.val(),
    list = $(parentContainer).find('.js-custom-list-items')

    if (value && value.length) {
      $(`<li data-key="${value}"><span>${value}</span><span class="custom-list__item-close js-custom-list-item-close"></span></li>`).appendTo(list)
      input.val('')
    }
  }
}

