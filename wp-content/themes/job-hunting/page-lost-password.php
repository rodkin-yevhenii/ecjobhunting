<?php
/**
 * Template Name: Lost password
 * Template Post Type: page
 */

use EcJobHunting\Service\User\RetrievePassword;

$errors = [];
if (isset($_REQUEST['errors'])) {
    $errorCodes = explode(',', $_REQUEST['errors']);

    foreach ($errorCodes as $code) {
        $errors[] = RetrievePassword::getErrorMessage($code);
    }
}

get_header(); ?>
    <section class="account mt-3">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-10 col-xl-6">
                    <?php if (!empty($_REQUEST['key']) && !empty($_REQUEST['login'])) :
                        get_template_part(
                            'template-parts/reset-password/form',
                            'reset-password',
                            ['errors' => $errors]
                        );
                    else :
                        get_template_part(
                            'template-parts/reset-password/form',
                            'send',
                            ['errors' => $errors]
                        );
                    endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php get_footer();
