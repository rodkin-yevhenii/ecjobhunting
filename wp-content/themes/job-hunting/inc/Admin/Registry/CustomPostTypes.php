<?php


namespace EcJobHunting\Admin\Registry;


class CustomPostTypes
{
    public function __construct()
    {
        $this->registerVacancy();
    }

    private function registerVacancy(){
        register_post_type('vacancy', array(
            'labels'             => array(
                'name'               => 'Vacancies',
                'singular_name'      => 'Vacancy',
                'add_new'            => 'Add Vacancy',
                'add_new_item'       => 'Create new Vacancy',
                'edit_item'          => 'Edit Vacancy',
                'new_item'           => 'New Vacancy',
                'view_item'          => 'View Vacancy',
                'search_items'       => 'Find Vacancies',
                'not_found'          => 'Vacancies not found',
                'not_found_in_trash' => 'Vacancies not found in trash',
                'parent_item_colon'  => '',
                'menu_name'          => 'Vacancies'

            ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => true,
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title','editor','author','thumbnail',)
        ) );
    }
}