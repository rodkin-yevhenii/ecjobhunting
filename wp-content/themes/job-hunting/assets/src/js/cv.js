import $ from 'jquery'
import ComponentAboutMe from "./components/cv/component-about-me"
import ComponentContacts from "./components/cv/component-contacts"
import ComponentWebsites from "./components/cv/component-websites"
import ComponentExecutiveSummary from "./components/cv/component-executive-summary"
import ComponentWorkExperience from "./components/cv/component-work-experience";
import ComponentEducation from "./components/cv/component-education"
import ComponentObjective from "./components/cv/component-objective";
import ComponentAchievements from "./components/cv/component-achievements";
import ComponentAssociations from "./components/cv/component-associations";
import ComponentSkills from "./components/cv/component-skills";
import ComponentProfileActivation from "./components/cv/component-profile-activation";
import ComponentMoreInformation from "./components/cv/component-more-information";
import ComponentResume from "./components/cv/component-resume";
import ComponentReferences from "./components/cv/component-references";
import ComponentCertificates from "./components/cv/component-certificates";
import ComponentGotHired from "./components/cv/component-got-hired";

$(() => {
  const { siteSettings } = window
  const $pageHolder = $('#candidate')
  const cvId = $pageHolder.attr('data-cv-id')
  const candidateId = $pageHolder.attr('data-user-id')

  // Upload avatar
  $(document).on('change', '#profile-photo', () => {
    $('#avatar-form').submit()
  })

  new ComponentAboutMe(cvId, candidateId, siteSettings.nonce)
  new ComponentContacts(cvId, candidateId, siteSettings.nonce)
  new ComponentWebsites(cvId, candidateId, siteSettings.nonce)
  new ComponentExecutiveSummary(cvId, candidateId, siteSettings.nonce)
  new ComponentWorkExperience(cvId, candidateId, siteSettings.nonce)
  new ComponentEducation(cvId, candidateId, siteSettings.nonce)
  new ComponentObjective(cvId, candidateId, siteSettings.nonce)
  new ComponentAchievements(cvId, candidateId, siteSettings.nonce)
  new ComponentAssociations(cvId, candidateId, siteSettings.nonce)
  new ComponentSkills(cvId, candidateId, siteSettings.nonce)
  new ComponentProfileActivation(cvId, candidateId, siteSettings.nonce)
  new ComponentMoreInformation(cvId, candidateId, siteSettings.nonce)
  new ComponentResume(cvId, candidateId, siteSettings.nonce)
  new ComponentReferences(cvId, candidateId, siteSettings.nonce)
  new ComponentCertificates(cvId, candidateId, siteSettings.nonce)
  new ComponentGotHired(cvId, siteSettings.nonce)
})
