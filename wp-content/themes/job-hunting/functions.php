<?php
// phpcs:disable PSR1.Files.SideEffects

require_once get_stylesheet_directory() . "/vendor/autoload.php";
/**
 * Define constants
 */
if (!defined('IMG_URI')) {
    define('IMG_URI', get_stylesheet_directory_uri() . '/assets/public/images/');
}
if (!defined('SIGNUP_URL')) {
    define('SIGNUP_URL', site_url('/signup/'));
}
if (!defined('CANDIDATE_PROFILE_URL')) {
    define('CANDIDATE_PROFILE_URL', site_url('/profile/'));
}
if (!defined('EMPLOYER_PROFILE_URL')) {
    define('EMPLOYER_PROFILE_URL', site_url('/profile/'));
}

use EcJobHunting\Front\SiteSettings;
use EcJobHunting\ThemeInit;

// basic functional
$themeInit = ThemeInit::getInstance();

// global site settings
global $ec_site;
$ec_site = new SiteSettings();

//// HELPERS ////

/**
 * Returns nice formatted date difference
 *
 * @param $date
 *
 * @return string
 */
function nicetime($date)
{
    if (empty($date)) {
        return "No date provided";
    }

    $periods = ["second", "minute", "hour", "day", "week", "month", "year", "decade"];
    $lengths = ["60", "60", "24", "7", "4.35", "12", "10"];

    $now = time();
    $unix_date = strtotime($date);

    // check validity of date
    if (empty($unix_date)) {
        return "Bad date";
    }

    // is it future date or past date
    if ($now > $unix_date) {
        $difference = $now - $unix_date;
        $tense = "ago";
    } else {
        $difference = $unix_date - $now;
        $tense = "from now";
    }

    for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
        $difference /= $lengths[$j];
    }

    $difference = round($difference);

    if ($difference != 1) {
        $periods[$j] .= "s";
    }

    return "$difference $periods[$j] {$tense}";
}

function dateDiff($posted)
{
    try {
        $earlier = new DateTime($posted);
        $today = new DateTime('now');
        $diff = $today->diff($earlier)->format("%a");

        return $diff;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

/**
 * Returns nice formatted date period
 *
 * @param array $period = ['from'=>'', 'to'=>'']
 *
 * @return string
 */
function getDatePeriod($period)
{
    return sprintf(
        '%1$s - %2$s',
        date(
            'F Y',
            strtotime($period['from'])
        ),
        ($period['to'] ?
            date(
                'F Y',
                strtotime($period['to'])
            ) : 'Current')
    );
}

function getEnvelopIcon()
{
    return "<img src='" . IMG_URI . "icons/envelope.png' alt='Envelop Icon' />";
}

function getPhoneIcon()
{
    return "<img src='" . IMG_URI . "icons/mobile.png' alt='Phone Icon' />";
}

function getTwitterIcon()
{
    return "<img src='" . IMG_URI . "icons/twitter.png' alt='twitter Icon' />";
}

function getLinkedinIcon()
{
    return "<img src='" . IMG_URI . "icons/instagram.png' alt='Linkedin Icon' />";
}

function getFacebookIcon()
{
    return "<img src='" . IMG_URI . "icons/facebook.png' alt='facebook Icon' />";
}

function getLikeIcon()
{
    return "<img src='" . IMG_URI . "icons/rate-plus.png' alt='facebook Icon' />";
}

function getDislikeIcon()
{
    return "<img src='" . IMG_URI . "icons/rate-minus.png' alt='dislike Icon' />";
}

function getNotSureIcon()
{
    return "<img src='" . IMG_URI . "icons/rate-null.png' alt='not sure Icon' />";
}

function getActivateProfileIcon()
{
    return "<img src='" . IMG_URI . "icons/active.png' alt='activate Icon' />";
}

/**
 * @param int $id   Candidate ID
 * @param array $ratedCandidates    Employer rated candidates list
 *
 * @return string
 */
function renderRateButtons(int $id, array $ratedCandidates): void
{
    $rate = false;

    if (array_key_exists($id, $ratedCandidates)) {
        $rate = $ratedCandidates[$id];
    }

    ob_start();
    ?>
    <div
        class="rate-buttons"
        data-user="<?php echo $id; ?>"
        data-nonce="<?php echo wp_create_nonce('rate_user') ?>"
    >
        <button class="rate-button <?php echo $rate === 'like' ? 'active' : ''; ?>" data-rate="like">
            <?php echo getLikeIcon(); ?>
        </button>
        <button class="rate-button <?php echo $rate === 'normal' ? 'active' : ''; ?>" data-rate="normal">
            <?php echo getNotSureIcon(); ?>
        </button>
        <button class="rate-button <?php echo $rate === 'dislike' ? 'active' : ''; ?>" data-rate="dislike">
            <?php echo getDislikeIcon(); ?>
        </button>
    </div>
    <?php
    echo ob_get_clean();
}

function add_custom_recaptcha_forms($forms)
{
    $forms['ecj_login_form'] = ["form_name" => "Custom Login Form"];
    $forms['ecj_register_candidate_form'] = ["form_name" => "Candidate Sign Up Form"];
    $forms['ecj_register_employer_form'] = ["form_name" => "Employer Sign Up Form"];
    $forms['ecj_lost_password_form'] = ["form_name" => "Forgot Password Form"];
    return $forms;
}

add_filter('gglcptch_add_custom_form', 'add_custom_recaptcha_forms');
