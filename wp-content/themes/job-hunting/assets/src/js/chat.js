$(() => {
  const ajaxUrl = window.siteSettings.ajaxurl
  const $form = $('#chat-form')

  $('.js-chat-card').removeClass('active')

  setInterval(() => {
    loadContacts();
  }, 240 * 1000)

  $(document).on('submit', '#chat-form', event => {
    event.preventDefault();

    const data = {
      action: 'send_chat_message',
      nonce: $form.attr('data-nonce'),
      chat: $form.attr('data-chat-id'),
      message: $form.find('textarea').val()
    }

    if (!data.message.length) {
      console.error('Error: empty message')

      return
    }

    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: data,
      dataType: 'json',
      success: function (response) {
        if (response.status === 200) {
          $(document).trigger('load_messages', [$form.attr('data-chat-id'), $('.js-messages').attr('data-nonce')])
          $form.find('textarea').val('')
        } else {
          console.error(response.message)
        }
      }
    })
  })

  $(document).on('click', '.js-chat-card', event => {
    $('.js-chat-card').removeClass('active')
    const $chatCard = $(event.currentTarget)
    const $form = $('#chat-form')
    const $messages = $('.js-messages')
    const contactName = $chatCard.attr('data-contact-name')
    const chatId = $chatCard.attr('data-chat-id')
    $chatCard.find('.js-card__contact-name sup').remove()
    $chatCard.addClass('active')
    $form.attr('data-chat-id', chatId)
    $('.js-contact-name').html(contactName)
    $(document).trigger('load_messages', [chatId, $messages.attr('data-nonce')])
    $messages.show()
  })

  $(document).on('load_messages', (event, chatId) => {
    const data = {
      action: 'load_chat_messages',
      nonce: $('.js-messages').attr('data-nonce'),
      chatId
    }

    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: data,
      dataType: 'json',
      success: function (response) {
        if (response.status === 200) {
          const $messages = $('.messages-answer')
          const isBottom = $messages[0].scrollHeight === $messages[0].clientHeight + $messages[0].scrollTop
          $('.js-messages-container').html(response.html)

          if (isBottom) {
            $messages.animate(
              {scrollTop: $messages[0].scrollHeight},
              0
            )
          }
        } else if (response.status === 404) {
          $('.js-messages-container').html('There are no messages yet...')
        } else {
          console.error(response.message)
        }
      }
    })
  })

  function loadContacts() {
    const $contacts = $('.js-contacts')
    const $activeChat = $contacts.find('li.active')
    const chatId = $activeChat.length ? $activeChat.attr('data-chat-id') : null

    const data = {
      action: 'reload_contacts',
      nonce: $contacts.attr('data-nonce'),
      activeChatId: chatId
    }

    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: data,
      dataType: 'json',
      success: function (response) {
        if (response.status === 200) {
          $('.js-contacts-container').html(response.html)
        } else {
          console.error(response.message)
        }
      }
    })
  }
})
