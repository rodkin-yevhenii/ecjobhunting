<?php

$jobCategories = get_terms(
    ['taxonomy' => 'job-category', 'hide_empty' => false, 'orderby' => 'name', 'order' => 'ASC']
);

get_header(); ?>
    <form class="hero">
        <div class="container">
            <div class="row d-flex justify-content-xl-center">
                <div class="col-12">
                    <h1><?php the_title(); ?></h1>
                </div>
                <div class="col-12 col-md-5 col-xl-4">
                    <label class="my-2">
                        <input class="field-text" type="text" placeholder="Job Title">
                    </label>
                </div>
                <div class="col-12 col-md-5 col-xl-4">
                    <label class="my-2">
                        <input class="field-text" type="text" placeholder="Location">
                    </label>
                </div>
                <div class="col-12 col-md-2">
                    <button class="btn btn-primary my-2" type="submit">Search</button>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-md-3 hero-numbers"><strong>6890</strong><span>Jobs</span></div>
                <div class="col-6 col-md-3 hero-numbers"><strong>2773</strong><span>Members</span></div>
                <div class="col-6 col-md-3 hero-numbers"><strong>1200</strong><span>Resumes</span></div>
                <div class="col-6 col-md-3 hero-numbers"><strong>1300</strong><span>Companies</span></div>
            </div>
        </div>
    </form>
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="align-center">Popular Job Categories</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-xl-12">
                    <?php if ($jobCategories): ?>
                        <ul>
                            <?php foreach ($jobCategories as $term): ?>
                                <li><a href="<?php echo get_term_link($term->term_id); ?>"
                                       class="btn btn-outline-secondary" data-abc="true"><?php echo $term->name; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>
    <section class="results">
        <div class="container">
            <div class="row">
                <div class="col-12" data-tab>
                    <h2 class="align-center">We have founds 16 available jobs for you</h2>
                    <ul class="results-header">
                        <li class="d-md-none" data-tab-value><span>Jobs</span></li>
                        <li class="active" data-tab-item="jobs">Jobs</li>
                        <li data-tab-item="resumes">Latest Resumes</li>
                        <li data-tab-item="companies">Latest Companies</li>
                    </ul>
                    <ul class="results-content">
                        <li class="active" data-tab-content="jobs">
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/jobs-image-1.png"
                                                                            alt="image">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-10 col-xl-9"><small>5 years ago</small>
                                            <h4 class="color-primary">Computer and Information Tech</h4>
                                            <ul>
                                                <li><span class="color-secondary">Full-Time</span></li>
                                                <li><span class="color-secondary">London, United Kingdom</span></li>
                                            </ul>
                                            <p>Schweitzer Engineering Laboratories (SEL) seeks a professional,
                                                innovative and detailed individual for our Mechanical Designer
                                                position.
                                                If you are looking for an opportunity to practice World Class
                                                ...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/jobs-image-2.png"
                                                                            alt="image">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-10 col-xl-9"><small>5 years ago</small>
                                            <h4 class="color-primary">Graduate Inside Sales Representatives</h4>
                                            <ul>
                                                <li><span class="color-secondary">Full-Time</span></li>
                                                <li><span class="color-secondary">London, United Kingdom</span></li>
                                            </ul>
                                            <p>Schweitzer Engineering Laboratories (SEL) seeks a professional,
                                                innovative and detailed individual for our Mechanical Designer
                                                position.
                                                If you are looking for an opportunity to practice World Class
                                                ...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/jobs-image-3.png"
                                                                            alt="image">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-10 col-xl-9"><small>5 years ago</small>
                                            <h4 class="color-primary">Java Developer Scala Spring Linux Java
                                                Dev</h4>
                                            <ul>
                                                <li><span class="color-secondary">Full-Time</span></li>
                                                <li><span class="color-secondary">London, United Kingdom</span></li>
                                            </ul>
                                            <p>Schweitzer Engineering Laboratories (SEL) seeks a professional,
                                                innovative and detailed individual for our Mechanical Designer
                                                position.
                                                If you are looking for an opportunity to practice World Class
                                                ...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/jobs-image-4.png"
                                                                            alt="image">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-10 col-xl-9"><small>5 years ago</small>
                                            <h4 class="color-primary">Graduate Inside Sales Executive Job</h4>
                                            <ul>
                                                <li><span class="color-secondary">Full-Time</span></li>
                                                <li><span class="color-secondary">London, United Kingdom</span></li>
                                            </ul>
                                            <p>Schweitzer Engineering Laboratories (SEL) seeks a professional,
                                                innovative and detailed individual for our Mechanical Designer
                                                position.
                                                If you are looking for an opportunity to practice World Class
                                                ...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/jobs-image-5.png"
                                                                            alt="image">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-10 col-xl-9"><small>5 years ago</small>
                                            <h4 class="color-primary">Senior Rolling Stock Technician Required</h4>
                                            <ul>
                                                <li><span class="color-secondary">Full-Time</span></li>
                                                <li><span class="color-secondary">London, United Kingdom</span></li>
                                            </ul>
                                            <p>Schweitzer Engineering Laboratories (SEL) seeks a professional,
                                                innovative and detailed individual for our Mechanical Designer
                                                position.
                                                If you are looking for an opportunity to practice World Class
                                                ...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li data-tab-content="resumes">
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/customer-photo-1.jpg"
                                                                            alt="photo"></div>
                                        </div>
                                        <div class="col-12 col-md-10 col-xl-9 d-flex flex-wrap">
                                            <h4 class="color-primary">Ann Fuller</h4><span
                                                    class="results-country color-secondary">London</span>
                                            <ul>
                                                <li><span class="color-secondary">$50000 p.a minimum</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/customer-photo-2.jpg"
                                                                            alt="photo"></div>
                                        </div>
                                        <div class="col-12 col-md-10 col-xl-9 d-flex flex-wrap">
                                            <h4 class="color-primary">Annasmith</h4>
                                            <ul>
                                                <li><span class="color-secondary">Last Activity 12 months ago</span>
                                                </li>
                                                <li><span class="color-secondary">Automotive</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/customer-photo-3.jpg"
                                                                            alt="photo"></div>
                                        </div>
                                        <div class="col-12 col-md-10 col-xl-9 d-flex flex-wrap">
                                            <h4 class="color-primary">Annette Cox</h4><span
                                                    class="results-country color-secondary">Greenford</span>
                                            <ul>
                                                <li><span class="color-secondary">$50000 p.a minimum</span></li>
                                                <li><span class="color-secondaryLast">Activity 4 years ago</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/customer-photo-4.jpg"
                                                                            alt="photo"></div>
                                        </div>
                                        <div class="col-12 col-md-10 col-xl-9 d-flex flex-wrap">
                                            <h4 class="color-primary">Barry Burns</h4><span
                                                    class="results-country color-secondary">London</span>
                                            <ul>
                                                <li><span class="color-secondary">$50000 p.a minimum</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/customer-photo-5.jpg"
                                                                            alt="photo"></div>
                                        </div>
                                        <div class="col-12 col-md-10 col-xl-9 d-flex flex-wrap">
                                            <h4 class="color-primary">Betty Stanley</h4><span
                                                    class="results-country color-secondary">London</span>
                                            <ul>
                                                <li><span class="color-secondary">$50000 p.a minimum</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/customer-photo-6.jpg"
                                                                            alt="photo"></div>
                                        </div>
                                        <div class="col-12 col-md-10 col-xl-9 d-flex flex-wrap">
                                            <h4 class="color-primary">Billy Reed</h4><span
                                                    class="results-country color-secondary">London</span>
                                            <ul>
                                                <li><span class="color-secondary">$50000 p.a minimum</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/customer-photo-1.jpg"
                                                                            alt="photo"></div>
                                        </div>
                                        <div class="col-12 col-md-10 col-xl-9 d-flex flex-wrap">
                                            <h4 class="color-primary">Annasmith</h4>
                                            <ul>
                                                <li><span class="color-secondary">Last Activity 12 months ago</span>
                                                </li>
                                                <li><span class="color-secondary">Automotive</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/customer-photo-2.jpg"
                                                                            alt="photo"></div>
                                        </div>
                                        <div class="col-12 col-md-10 col-xl-9 d-flex flex-wrap">
                                            <h4 class="color-primary">Annette Cox</h4><span
                                                    class="results-country color-secondary">Greenford</span>
                                            <ul>
                                                <li><span class="color-secondary">$50000 p.a minimum</span></li>
                                                <li><span class="color-secondary">Last Activity 4 years ago</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li data-tab-content="companies">
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center align-items-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/companies-image-1.png"
                                                                            alt="logo"></div>
                                        </div>
                                        <div class="col-12 col-md-7 col-xl-7 d-flex flex-wrap">
                                            <h4 class="color-primary">Altes Bank</h4><span
                                                    class="results-country color-secondary">United Kingdom</span>
                                            <ul>
                                                <li><span class="color-secondary">Retail</span></li>
                                            </ul>
                                        </div>
                                        <div class="col d-none d-md-block col-md-3 col-xl-2"><span
                                                    class="color-secondary">0 vacancies</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center align-items-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/companies-image-2.png"
                                                                            alt="logo"></div>
                                        </div>
                                        <div class="col-12 col-md-7 col-xl-7 d-flex flex-wrap">
                                            <h4 class="color-primary">Altes Bank</h4>
                                            <ul>
                                                <li><span class="color-secondary">London, United Kingdom</span></li>
                                            </ul>
                                        </div>
                                        <div class="col d-none d-md-block col-md-3 col-xl-2"><span
                                                    class="color-primary">103 vacancies</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center align-items-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/companies-image-3.png"
                                                                            alt="logo"></div>
                                        </div>
                                        <div class="col-12 col-md-7 col-xl-7 d-flex flex-wrap">
                                            <h4 class="color-primary">Altes Bank</h4>
                                            <ul>
                                                <li><span class="color-secondary">London, United Kingdom</span></li>
                                            </ul>
                                        </div>
                                        <div class="col d-none d-md-block col-md-3 col-xl-2"><span
                                                    class="color-primary">15 vacancies</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center align-items-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/companies-image-4.png"
                                                                            alt="logo"></div>
                                        </div>
                                        <div class="col-12 col-md-7 col-xl-7 d-flex flex-wrap">
                                            <h4 class="color-primary">Altes Bank</h4>
                                            <ul>
                                                <li><span class="color-secondary">United Kingdom</span></li>
                                            </ul>
                                        </div>
                                        <div class="col d-none d-md-block col-md-3 col-xl-2"><span
                                                    class="color-primary">7 vacancies</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center align-items-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/companies-image-5.png"
                                                                            alt="logo"></div>
                                        </div>
                                        <div class="col-12 col-md-7 col-xl-7 d-flex flex-wrap">
                                            <h4 class="color-primary">Altes Bank</h4>
                                            <ul>
                                                <li><span class="color-secondary">United Kingdom</span></li>
                                            </ul>
                                        </div>
                                        <div class="col d-none d-md-block col-md-3 col-xl-2"><span
                                                    class="color-primary">12 vacancies</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="results-item">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-xl-center align-items-center">
                                        <div class="col d-none d-md-block col-md-2 col-xl-1">
                                            <div class="results-image"><img src="images/companies-image-6.png"
                                                                            alt="logo"></div>
                                        </div>
                                        <div class="col-12 col-md-7 col-xl-7 d-flex flex-wrap">
                                            <h4 class="color-primary">Altes Bank</h4>
                                            <ul>
                                                <li><span class="color-secondary">London, United Kingdom</span></li>
                                            </ul>
                                        </div>
                                        <div class="col d-none d-md-block col-md-3 col-xl-2"><span
                                                    class="color-primary">5 vacancies</span></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<?php if (have_posts()): the_post(); ?>
    <?php the_content(); ?>
<?php endif; ?>
    <section class="register">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 register-item">
                    <div class="register-item-icon d-none d-md-flex"><img src="images/icons/register-icon-1.png"
                                                                          alt="icon"></div>
                    <h3>Employer Account</h3>
                    <p>We are a group of entrepreneurs brought together to provide a differentiated approach to the
                        recruiting industry.</p><a class="btn btn-outline-secondary" href="#">Register Account</a>
                </div>
                <div class="col-12 col-md-6 register-item">
                    <div class="register-item-icon d-none d-md-flex"><img src="images/icons/register-icon-2.png"
                                                                          alt="icon"></div>
                    <h3>Candidates Account</h3>
                    <p>We are a group of entrepreneurs brought together to provide differentiated approach. We are a
                        group of entrepreneurs</p><a class="btn btn-outline-secondary" href="#">Register Account</a>
                </div>
            </div>
        </div>
    </section>
<?php get_footer();
