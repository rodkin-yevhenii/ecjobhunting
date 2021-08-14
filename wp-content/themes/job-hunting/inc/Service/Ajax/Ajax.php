<?php

namespace EcJobHunting\Service\Ajax;

use EcJobHunting\Entity\Company;
use EcJobHunting\Entity\Vacancy;
use EcJobHunting\Front\EcResponse;
use EcJobHunting\Service\Ajax\Callbacks\Autocomplete;
use EcJobHunting\Service\User\UserService;

/**
 * Class Ajax
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Ajax
 */
class Ajax extends AjaxCallbackAbstract
{
    /**
     * Ajax constructor
     */
    public function __construct()
    {
        new Autocomplete();

        // Register Actions
        $this->actions['rate_candidate'] = 'rateEmployee';
        $this->actions['load_vacancy_candidates'] = 'loadVacancyCandidates';
        $this->actions['load_employer_candidates'] = 'loadEmployerCandidates';

        parent::__construct();
    }

    /**
     * Ajax callback for updating rated candidates list fo employer.
     */
    public function rateEmployee(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'rate_user')) {
            $this->response
                ->setStatus(403)
                ->setMessage('You are unauthorized. Access denied.')
                ->send();
        }

        if (empty($_POST['userId'])) {
            $this->response
                ->setStatus(204)
                ->setMessage('User ID is required')
                ->send();
        }

        if (empty($_POST['rating'])) {
            $this->response
                ->setStatus(204)
                ->setMessage('Rating value is required')
                ->send();
        }

        $userId = (int) $_POST['userId'];
        $userMeta = get_userdata($userId);

        if ('candidate' !== $userMeta->roles[0]) {
            $this->response
                ->setStatus(204)
                ->setMessage('Incorrect User ID.')
                ->send();
        }

        $company = new Company(wp_get_current_user());
        $ratedCandidates = $company->getRatedCandidates();
        $ratedCandidates[$userId] = $_POST['rating'];

        $result = update_user_meta(get_current_user_id(), 'rated_candidates', $ratedCandidates);

        if ($result === false) {
            $this->response
                ->setStatus(500)
                ->setMessage('Candidate rating wasn\'t saved')
                ->send();
        }

        $this->response
            ->setStatus(200)
            ->send();
    }

    /**
     * Ajax callback for rendering vacancy candidates
     */
    public function loadVacancyCandidates(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_employer_candidates')) {
            $this->response
                ->setStatus(403)
                ->setMessage('You are unauthorized. Access denied.')
                ->send();
        }

        $id = $_POST['id'] ?? false;
        $type = $_POST['type'] ?? 'all';

        if ($id) {
            $object = new Vacancy($id);
        } else {
            $object = new Company(wp_get_current_user());
        }

        switch ($type) {
            case 'new':
                $candidates = $object->getNewCandidatesData();
                break;
            case 'great_matches':
                $candidates = $object->getGreatMatchedCandidatesData();
                break;
            case 'unrated':
                $candidates = $object->getUnratedCandidatesData();
                break;
            case 'interested':
                $candidates = $object->getInterestedCandidatesData();
                break;
            default:
                $candidates = $object->getCandidatesData();
                break;
        }

        if (empty($candidates)) {
            $this->response
                ->setStatus(404)
                ->setMessage('Candidates not found')
                ->send();
        }

        ob_start();
        $isFirst = true;

        foreach ($candidates as $candidate) :
            get_template_part(
                'template-parts/candidate/card',
                'default',
                [
                    'candidateData' => $candidate,
                    'company' => $id ? $object->getEmployer() : $object,
                    'isFirst' => $isFirst,
                ]
            );
            if ($isFirst) {
                $isFirst = false;
            }
        endforeach;
        wp_reset_postdata();
        $html = ob_get_clean();

        $this->response
            ->setStatus(200)
            ->setResponseBody($html)
            ->send();
    }

    /**
     * Ajax callback for rendering employer candidates
     */
    public function loadEmployerCandidates(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_employer_candidates')) {
            $this->response
                ->setStatus(403)
                ->setMessage('You are unauthorized. Access denied.')
                ->send();
        }

        $type = $_POST['type'] ?? 'all';
        $company = new Company(wp_get_current_user());

        switch ($type) {
            case 'new':
                $candidates = $company->getNewCandidatesData();
                break;
            case 'great_matches':
                $candidates = $company->getGreatMatchedCandidatesData();
                break;
            case 'unrated':
                $candidates = $company->getUnratedCandidatesData();
                break;
            case 'interested':
                $candidates = $company->getInterestedCandidatesData();
                break;
            default:
                $candidates = $company->getCandidatesData();
                break;
        }

        if (empty($candidates)) {
            $this->response
                ->setStatus(404)
                ->setMessage('Candidates not found')
                ->send();
        }

        ob_start();
        $isFirst = true;

        foreach ($candidates as $candidate) :
            get_template_part(
                'template-parts/candidate/card',
                'default',
                [
                    'candidateData' => $candidate,
                    'company' => $company,
                    'isFirst' => $isFirst,
                ]
            );
            if ($isFirst) {
                $isFirst = false;
            }
        endforeach;
        wp_reset_postdata();
        $html = ob_get_clean();

        $this->response
            ->setStatus(200)
            ->setResponseBody($html)
            ->send();
    }
}
