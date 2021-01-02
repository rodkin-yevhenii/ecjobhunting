<?php
/**
 * Template Name: Candidate Profile
 */

use EcJobHunting\Service\User\UserService;

if (!UserService::isCandidate()) {
    wp_redirect(get_post_type_archive_link('cv'), 301);
}
$candidate = UserService::getUser(get_current_user_id());
get_header(); ?>
    <nav class="menu">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-md-3 d-xl-none"><span>Account menu:</span></div>
                <div class="col-12 col-md-6 col-xl-12">
                    <ul data-select>
                        <li><a href="<?php echo get_post_type_archive_link('vacancy')?>"><?php _e('Jobs', 'ecjobhunting'); ?></a></li>
                        <li><a href="#">Messages</a></li>
                        <li data-select-value><a>Profile</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row d-md-block d-xl-flex my-3 my-md-4 my-xl-5 clearfix">
            <div class="col-12 order-0 col-md-5 float-md-left col-xl-3">
                <div class="profile-item">
                    <div class="profile-header">
                        <button class="profile-edit-link" type="button" data-toggle="modal" data-target="#edit">Edit
                        </button>
                        <h2 class="no-decor"><?php _e('About Me', 'ecjobhunting'); ?></h2>
                    </div>
                    <form class="profile-photo">
                        <div class="profile-photo-image"><img src="<?php echo $candidate->getPhoto(); ?>" alt="photo"></div>
                        <input type="file" id="profile-photo">
                        <label for="profile-photo">+</label>
                    </form>
                    <div class="profile-name"><strong>Nicholas Coppola</strong><span>Nyack NY</span></div>
                </div>
                <div class="profile-item">
                    <div class="profile-header">
                        <button class="profile-edit-link">Edit</button>
                        <h2 class="no-decor">Contact Information</h2>
                    </div>
                    <ul>
                        <li>
                            <div class="profile-icon"><img src="images/icons/envelope.png" alt="icon"></div>
                            <span>yar-shabanov@yandex.ru</span><span class="color-red">Verify your email to receive application updates from employers.</span>
                            <button class="btn btn-primary">Resend Confirmation</button>
                        </li>
                        <li>
                            <div class="profile-icon"><img src="images/icons/mobile.png" alt="icon"></div>
                            <a href="#">Add Phone Number</a>
                        </li>
                    </ul>
                </div>
                <div class="profile-item">
                    <div class="profile-header">
                        <button class="profile-edit-link">Edit</button>
                        <h2 class="no-decor">Websites</h2>
                    </div>
                    <ul>
                        <li>
                            <div class="profile-icon"><img src="images/icons/envelope.png" alt="icon"></div>
                            <a href="#">Add Website</a>
                        </li>
                        <li>
                            <div class="profile-icon"><img src="images/icons/twitter.png" alt="icon"></div>
                            <a href="#">Add Twitter Profile</a>
                        </li>
                        <li>
                            <div class="profile-icon"><img src="images/icons/instagram.png" alt="icon"></div>
                            <a href="#">Add LinkedIn Profile</a>
                        </li>
                        <li>
                            <div class="profile-icon"><img src="images/icons/facebook.png" alt="icon"></div>
                            <a href="#">Add Facebook Profile</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 order-2 col-md-7 float-md-right col-xl-6 order-xl-1 mb-5">
                <div class="profile-activation">
                    <h3>Let Employers Find You</h3>
                    <div class="custom-handler">
                        <div></div>
                    </div>
                    <p>Private: Your profile is not publicly accessible. However, it is viewable as a part of your
                        applications.</p>
                </div>
                <div class="profile-header">
                    <h2 class="no-decor">Work Experience</h2>
                    <p><a href="#">Add Work Experience</a></p>
                </div>
                <div class="profile-item">
                    <div class="profile-subitem"><span>Aug 2019 - Current</span>
                        <h3>web designer</h3><strong>companyName</strong>
                        <button class="btn btn-outline-secondary">Edit</button>
                        <p>Enthusiastic and self-motivated web designer with 3+ years of experience. Eager to join
                            WebHouse to bring top-class frontend development, UX, and visual design skills. In previous
                            roles redesigned a SaaS website that reduced CAC by 50%, and implemented an SEO-optimized
                            design that boosted traffic by 300%.</p>
                    </div>
                    <div class="profile-subitem"><span>Aug 2016 - Aug 2017</span>
                        <h3>web designer</h3><strong>companyName</strong>
                        <button class="btn btn-outline-secondary">Edit</button>
                        <p>— Met and corresponded with clients to determine client needs for company sites</p>
                        <p>— Created corporate web sites, portals and large-scale web applications</p>
                        <p>— Developed and designed new web interfaces, layouts and site graphics</p>
                    </div>
                </div>
                <div class="profile-item">
                    <div class="profile-header">
                        <h2 class="no-decor">Education</h2>
                    </div>
                    <p><a href="#">Add Education</a></p>
                    <div class="profile-subitem"><span>2012 - 2016</span>
                        <h3>New York School</h3><strong>No Degree</strong><strong>Major or field of study</strong>
                        <button class="btn btn-outline-secondary">Edit</button>
                        <p>Description</p>
                    </div>
                </div>
                <div class="profile-item">
                    <div class="profile-header">
                        <h2 class="no-decor">References</h2>
                    </div>
                    <p>Hiring managers prefer candidates with references! Ask a former co-worker, manager, teacher or
                        friend to write a reference for you.</p>
                    <button class="btn btn-outline-secondary btn-full">Request References</button>
                </div>
                <div class="profile-item">
                    <p><a href="#">Add Executive Summary</a></p>
                    <p><a href="#">Add Objective</a></p>
                    <p><a href="#">Add Achievements</a></p>
                    <p><a href="#">Add Certificates and Licenses</a></p>
                    <p><a href="#">Add Associations</a></p>
                    <p><a href="#">Add Skills</a></p>
                </div>
                <div class="profile-item">
                    <h2 class="no-decor">More Information</h2>
                    <p><a href="#">Add Desired Salary</a></p>
                    <p><a href="#">Add Years of Experience</a></p>
                    <p><a href="#">Add Highest Degree Earned</a></p>
                    <p><a href="#">Add Industry</a></p>
                    <p><a href="#">Add Veteran Status</a></p>
                </div>
            </div>
            <div class="col-12 order-1 col-md-5 float-md-left col-xl-3 order-xl-2">
                <div class="profile-progress">
                    <div class="profile-progressbar"><span style="width: 37%;"></span></div>
                    <div class="profile-header">
                        <h2 class="no-decor">Your Profile is Incomplete</h2>
                    </div>
                    <p>Finish your profile to unlock better job matching and stand out to hiring managers!</p>
                    <ul>
                        <li>
                            <div class="icon-check active"></div>
                            <span>Register with EcJobHunting</span>
                        </li>
                        <li>
                            <div class="icon-check"></div>
                            <span>Add Resume</span>
                        </li>
                        <li>
                            <div class="icon-check"></div>
                            <span>Add Phone Number</span>
                        </li>
                        <li>
                            <div class="icon-check"></div>
                            <span>Add Skills</span>
                        </li>
                        <li>
                            <div class="icon-check"></div>
                            <span>Add Headline</span>
                        </li>
                        <li>
                            <div class="icon-check"></div>
                            <span>Receive a Reference</span>
                        </li>
                    </ul>
                    <a class="btn btn-primary btn-full mt-4" href="#">I got hired!</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content">
                <div class="modal-header">
                    <h2 class="no-decor">Lorem ipsum</h2>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="profile-photo">
                        <div class="profile-photo-image"><img src="<?php echo $candidate->getPhoto(); ?>" alt="photo"></div>
                        <input type="file" id="profile-photo-modal">
                        <label for="profile-photo-modal">Add Profile Photo</label>
                    </div>
                    <label class="field-label" for="edit-name">Full Name</label>
                    <input class="field-text" type="text" id="edit-name">
                    <label class="field-label" for="edit-headline">Headline (optional)</label>
                    <input class="field-text" type="text" id="edit-headline">
                    <label class="field-label" for="edit-location">Location</label>
                    <input class="field-text" type="text" id="edit-location">
                    <label class="field-label" for="edit-zip">ZIP / Postal Code</label>
                    <input class="field-text" type="text" id="edit-zip">
                    <fieldset>
                        <input type="checkbox" id="edit-checkbox">
                        <label for="edit-checkbox">I am willing to relocate</label>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-outline-primary" type="button" data-dismiss="modal" aria-label="Close">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php get_footer();
