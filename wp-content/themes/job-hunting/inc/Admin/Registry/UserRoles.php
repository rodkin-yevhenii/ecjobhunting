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
        $result = add_role(
            'candidate',
            'Candidate',
            [
                'read' => true,
                'edit_posts' => true,
                'edit_published_posts' => true,
                'upload_files' => true,
                'publish_posts' => true,
            ]
        );

        if ($result) {
            return;
        }

        $this->updateRole('candidate');
    }

    private function registerEmployer()
    {
        $result = add_role(
            'employer',
            'Employer',
            [
                'read' => true,
                'edit_posts' => true,
                'edit_published_posts' => true,
                'upload_files' => true,
                'publish_posts' => true,
            ]
        );

        if ($result) {
            return;
        }

        $this->updateRole('candidate');
    }

    public function updateRole(string $role): void {
        $role = get_role($role);

        if (!$role->has_cap('read')) {
            $role->add_cap('read', true);
        }

        if (!$role->has_cap('edit_posts')) {
            $role->add_cap('edit_posts', true);
        }

        if (!$role->has_cap('edit_published_posts')) {
            $role->add_cap('edit_published_posts', true);
        }

        if (!$role->has_cap('upload_files')) {
            $role->add_cap('upload_files', true);
        }

        if (!$role->has_cap('publish_posts')) {
            $role->add_cap('publish_posts', true);
        }
    }
}
