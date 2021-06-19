import ComponentDocumentsAbstract from "./component-documents-abstract";

export default class ComponentCertificates extends ComponentDocumentsAbstract {
  /**
   * ComponentEducation constructor.
   *
   * @param cvId
   * @param candidateId
   * @param nonce
   */
  constructor(cvId, candidateId, nonce) {
    const id = 'certificates'
    const options = {
      elements: {
        input: '#add_' + id,
        removeButtons: `.js-delete-${id}-item`
      },
      events: [],
      ajaxActions: {
        uploadFile: 'upload_' + id,
        removeFile: 'remove_' + id
      },
      holder: document.querySelector(`#${id}-holder`),
    }

    super(cvId, candidateId, nonce, options)
  }
}
