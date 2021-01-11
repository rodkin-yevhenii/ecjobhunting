<?php

/***
 * Vacancy Template
 */

use EcJobHunting\Entity\Vacancy;

$vacancy = new Vacancy(get_the_ID());
get_header(); ?>
    <main>
        <?php if (have_posts() && $vacancy): the_post();
        $benefits = $vacancy->getBenefits();
        ?>
            <section class="mt-3 my-md-5">
                <div class="container">
                    <div class="row justify-content-xl-between">
                        <div class="col-12 col-xl-8">
                            <h1 class="mb-md-3 mb-xl-5"><?php echo $vacancy->getTitle(); ?></h1>
                            <div class="vacancy-header"><strong class="my-3">
                                    <?php
                                    if ($vacancy->getCompensationFrom() && $vacancy->getCompensationTo()):
                                        echo sprintf(
                                            __('%s to %s', 'ecjobhunting'),
                                            $vacancy->getCompensationFrom(),
                                            $vacancy->getCompensationTo()
                                        );
                                    else:
                                        echo $vacancy->getCompensationFrom() ? : $vacancy->getCompensationTo();
                                    endif;

                                    echo ' ' . $vacancy->getCompensationPeriodName();
                                    ?></strong>
                                <span class="color-secondary"><?php echo $vacancy->getEmploymentType(); ?></span>
                                <span class="color-secondary"><?php echo $vacancy->getLocation(); ?></span>
                                <?php if ($benefits) : ?>
                                    <strong class="mt-4 mb-2">Benefits Offered</strong>
                                    <ul>
                                        <?php foreach ($benefits as $benefit): ?>
                                            <li><?php echo $benefit; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <article class="mt-5">
                                <h4>Why Work at This Company?</h4>
                                <p class="mb-4">Inc 500 fastest growing companies</p>
                                <p class="mb-4">The Penso Agency is looking to hire a select few business partners for
                                    the fastest growing financial services sales organization in the United States. We
                                    are looking for like-minded people who are coachable and have a proven track record
                                    of integrity and willingness to think outside the box. Insurance industry experience
                                    is not required but you must be willing to think and act like a business owner.</p>
                                <h4>About The Penso Agency:</h4>
                                <p class="mb-4">INNOVATION: We are a people and tech company developing a new model in a
                                    world of traditional insurance sales. With an ever changing market and the
                                    proliferation of social media our business model is more lucrative than ever
                                    before.</p>
                                <p class="mb-4">FINANCIAL INDEPENDENCE: We are passionate about creating an
                                    entrepreneurial platform for both personal producers who desire an active six figure
                                    income and builders who want to create a passive income stream where the sky is the
                                    limit.</p>
                                <p class="mb-4">LEADERSHIP: Our mission is to serve our agents by providing access to
                                    warm leads and a simple, yet, sophisticated selling system coupled with unparalleled
                                    support and leadership. We build leaders!</p>
                                <p class="mb-4">PRODUCT PORTFOLIO: Our carriers and their products are selected from the
                                    BEST in the industry and serve our primary markets of Mortgage Protection, Final
                                    Expense, Annuities and Index Universal Life. Our top rated carriers include
                                    Foresters, United Home Life, and American Amicable.</p>
                            </article>
                            <div class="vacancy-footer"><a class="btn btn-primary btn-lg" href="#">Apply Now</a><a
                                        class="btn btn-outline-primary btn-lg" href="#">Am I Qualified?</a></div>
                        </div>
                        <div class="col-12 col-xl-3 my-5 d-md-flex d-xl-block">
                            <div class="vacancy-image"><img src="images/penso.png" alt="vacancy"></div>
                            <div class="vacancy-info">
                                <h2 class="vacancy-company no-decor">The Penso Agency</h2><span class="color-secondary">Posted date: 2 days ago</span>
                                <div class="social mt-4"><span>Share this job:</span>
                                    <ul>
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                        <li><a href="#"><i class="fa fa-envelope-o"></i></a></li>
                                        <li><a href="#"><i class="fa fa-chain"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php else: ?>
            <?php get_template_part('content-none'); endif; ?>
    </main>
<?php get_footer();
