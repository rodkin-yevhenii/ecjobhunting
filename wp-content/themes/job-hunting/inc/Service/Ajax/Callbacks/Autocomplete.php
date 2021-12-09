<?php

namespace EcJobHunting\Service\Ajax\Callbacks;

use EcJobHunting\Front\EcResponse;
use EcJobHunting\Service\Ajax\AjaxCallbackAbstract;

/**
 * Class Autocomplete
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Ajax\Callbacks
 */
class Autocomplete extends AjaxCallbackAbstract
{
    protected array $actions = [
        'get_terms_autocomplete_data' => 'getTermsAutocompleteData',
    ];

    public function getTermsAutocompleteData(): void
    {
        $skills = [];
        $searchStr = $_POST['search'] ?? '';
        $taxonomy = $_POST['taxonomy'] ?? false;

        if (!$taxonomy) {
            $this->response
                ->setStatus(204)
                ->setMessage('Taxonomy is required')
                ->send();
        }

        $terms = get_terms(
            [
                'taxonomy' => $taxonomy,
                'hide_empty' => false,
                'fields' => 'id=>name',
                'search' => $searchStr,
            ]
        );

        if (is_wp_error($terms) || empty($terms)) {
            $this->response
                ->setStatus(404)
                ->setMessage('Terms not found')
                ->send();
        }

        foreach ($terms as $id => $name) {
            $skills[] = [
                'value' => $id,
                'text' => $name
            ];
        }

        $this->response
            ->setStatus(200)
            ->setData($skills)
            ->send();
    }
}
