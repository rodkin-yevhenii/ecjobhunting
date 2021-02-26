<?php

/***
 * Template Name: Registration
 */
$tab = $_GET['user'] ?? 'candidate';
get_header(); ?>
    <div class="results page">
    <div class="container">
        <div class="row">
            <div class="col-12" data-tab>
                <ul class="results-header results-header-large">
                    <li class="d-md-none" data-tab-value><span><?php _e(
                                'Sign Up as Candidate',
                                'ecjobhunting'
                            ); ?></span></li>
                    <li <?php echo $tab === 'candidate' ? 'class="active"' : ''; ?> data-tab-item="candidate"><?php _e(
                            'Sign Up as Candidate',
                            'ecjobhunting'
                        ); ?></li>
                    <li <?php echo $tab === 'employer' ? 'class="active"' : ''; ?> data-tab-item="employer"><?php _e(
                            'Sign Up as Employer',
                            'ecjobhunting'
                        ); ?></li>
                </ul>
                <div class="results-content">
                    <div data-tab-content="candidate" <?php echo $tab === 'candidate' ? 'class="active"' : ''; ?>>
                        <form class="registerform" method="post" autocomplete="off">
                            <label class="field-label" for="email"><?php _e(
                                    'Email',
                                    'ecjobhunting'
                                ); ?>
                                <input class="field-text" type="email" name="email" required></label>
                            <label class="field-label" for="username"><?php _e(
                                    'Username',
                                    'ecjobhunting'
                                ); ?>
                                <input class="field-text" type="text" name="username" required></label>
                            <label class="field-label" for="pwd">Password
                                <input class="field-text password" type="password" name="pwd" required></label>
                            <label class="field-label" for="pwd_confirmation">Confirm Password
                                <input class="field-text" type="password" name="pwd_confirmation" required></label>
                            <input type="submit" name="wp-submit"
                                   class="btn btn-primary" value="<?php _e('Sign Up', 'ecjobhunting'); ?>">
                            <input type="hidden" name="role" value="candidate"/>
                        </form>
                    </div>
                    <div data-tab-content="employer" <?php echo $tab === 'employer' ? 'class="active"' : ''; ?>>
                        <form class="registerform" method="post" autocomplete="off">
                            <label class="field-label" for="email"><?php _e(
                                    'Email',
                                    'ecjobhunting'
                                ); ?>
                                <input class="field-text" type="email" name="email" required></label>
                            <label class="field-label" for="username"><?php _e(
                                    'Username',
                                    'ecjobhunting'
                                ); ?>
                                <input class="field-text" type="text" name="username" required></label>
                            <label class="field-label" for="pwd">Password
                                <input class="field-text" type="password" name="pwd" required></label>
                            <label class="field-label pwd_confirmation" for="pwd_confirmation">Confirm Password
                                <input class="field-text" type="password" name="pwd_confirmation" required></label>
                            <input type="submit" name="wp-submit"
                                   class="btn btn-primary" value="<?php _e('Sign Up', 'ecjobhunting'); ?>">
                            <input type="hidden" name="role" value="employer"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer();
