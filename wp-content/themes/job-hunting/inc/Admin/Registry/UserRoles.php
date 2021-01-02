<?php

namespace EcJobHunting\Admin\Registry;

class UserRoles
{
    public function __invoke()
    {
        $this->registerEmployee();
        $this->registerEmployer();
    }

    private function registerEmployee()
    {
        add_role(
            'candidate',
            'Candidate',
            [
                'read' => true,
                'edit_posts' => true,
                'upload_files' => true,
                'publish_posts' => true,
            ]
        );
    }

    private function registerEmployer()
    {
        add_role(
            'employer',
            'Employer',
            [
                'read' => true,
                'edit_posts' => true,
                'upload_files' => true,
                'publish_posts' => true,
            ]
        );
    }
}