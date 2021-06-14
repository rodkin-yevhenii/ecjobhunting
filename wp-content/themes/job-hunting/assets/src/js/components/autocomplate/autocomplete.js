import AjaxRequest from "../ajax/ajax-request";

export default class Autocomplete {
  constructor(element, taxonomy) {
    this.input = element
    this.taxonomy = taxonomy
    this.options = {
      resolver: 'custom',
      events: {
        search: this.search.bind(this)
      }
    }

    element.autoComplete(this.options)
  }

  search (queryStr, callback) {
    const ajax = new AjaxRequest(
      {
        action: 'get_terms_autocomplete_data',
        search: queryStr,
        taxonomy: this.taxonomy
      }
    )

    ajax.send()
      .done(
        response => {
          if (response.status !== 200) {
            console.log(response.message)
            return
          }

          callback(response.data)
        }
      )
      .fail(
        () => {
          console.error('request failed')
        }
      )
  }
}
