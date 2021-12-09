import $ from "jquery";
import ComponentHiddenAbstract from "./component-hidden-abstract";
import Autocomplete from "../autocomplate/autocomplete";

export default class ComponentSkills extends ComponentHiddenAbstract {
  formId = 'skills'
  addLinkId = 'add_skill'
  addLinkHolderId = 'add_skill'
  editLink = '.js-edit-skills'
  holderId = `${this.formId}-holder`
  skillElement = '.js-skill'
  addSkillField = '.js-add-skill-field'
  addSkillBtn = '.js-add-skill-btn'
  removeSkillBtn = '.js-delete-skill-btn'
  skillsContainer = '.js-skills-container'

  /**
   * ComponentEducation constructor.
   *
   * @param cvId
   * @param candidateId
   * @param nonce
   */
  constructor(cvId, candidateId, nonce ) {
    super(cvId, candidateId, nonce)

    this.initActions()
    this.actions.push(
      {
        action: 'load-skills-form',
        elements: document,
        callback: () => {
          const $input = $('.js-auto-complete')

          new Autocomplete($input, 'skill')
        }
      },
      {
        action: 'click',
        elements: this.addSkillBtn,
        callback: this.addSkill.bind(this)
      },
      {
        action: 'click',
        elements: this.removeSkillBtn,
        callback: this.removeSkill.bind(this)
      }
    )

    this.initAjaxAction()
    this.registerActions()
  }

  removeData(event) {
    //do nothing
  }

  /**
   * Add new skill to list.
   *
   * @param event
   */
  addSkill (event) {
    event.preventDefault()

    const skills = this.getAddedSkills()
    const field = $(this.addSkillField)
    const newSkill = field.val()
    field.val('')

    if (skills.includes(newSkill)) {
      console.log(`Skill "${newSkill}" already added`)
      return
    }

    const deleteLink = $('<a href="#"></a>')
      .addClass('delete js-delete-skill-btn')
      .text('x')
    const element = $('<li></li>')
      .addClass('candidate-skills__item js-skill')
      .attr('data-name', newSkill)
      .text(newSkill)
      .append(deleteLink)

    $(this.skillsContainer).append(element)
  }

  removeSkill (event) {
    event.preventDefault()

    const $btn = $(event.currentTarget)
    $btn.parent().remove()
  }

  /**
   * Get added skills.
   *
   * @returns {*[]}
   */
  getAddedSkills () {
    const skills = []

    for (let item of $(this.skillElement)) {
      skills.push($(item).attr('data-name'))
    }

    return skills
  }

  getSaveFormAjaxData() {
    return {
      action: this.ajax.save,
      nonce: this.nonce,
      cvId: this.cvId,
      user: this.candidateId,
      holderId: this.holderId,
      skills: this.getAddedSkills()
    }
  }

  submitForm(event) {
    const skills = this.getAddedSkills()
    console.log(skills)

    if (!skills.length) {
      this.hideBlock()
    }

    super.submitForm(event);
  }
}
