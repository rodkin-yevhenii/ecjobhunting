<?php get_header(); ?>
    <form class="hero">
        <div class="container">
            <div class="row d-flex justify-content-xl-center">
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
        </div>
    </form>
    <section class="my-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>26,728+ Designer Jobs in New York</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-4 order-xl-1">
                    <button class="btn btn-outline-primary btn-lg d-xl-none mb-5" data-handler="filter">Filter</button>
                    <form class="filter" data-dropdown="filter">
                        <div class="ys-select" data-select><span data-select-value>Within 5 miles</span>
                            <ul>
                                <li class="active" data-select-item>Within 5 miles</li>
                                <li data-select-item>Within 51 miles</li>
                                <li data-select-item>Within 15 miles</li>
                            </ul>
                            <input class="d-none" type="text">
                        </div>
                        <div class="ys-select" data-select><span data-select-value>posted anytime</span>
                            <ul>
                                <li class="active" data-select-item>posted anytime</li>
                                <li data-select-item>Item 2</li>
                                <li data-select-item>Item 3</li>
                            </ul>
                            <input class="d-none" type="text">
                        </div>
                        <div class="ys-select" data-select><span data-select-value>$38 000+</span>
                            <ul>
                                <li class="active" data-select-item>$38 000+</li>
                                <li data-select-item>$19 000+</li>
                                <li data-select-item>$57 000+</li>
                            </ul>
                            <input class="d-none" type="text">
                        </div>
                        <div class="ys-select" data-select><span data-select-value>Full Time</span>
                            <ul>
                                <li class="active" data-select-item>Full Time</li>
                                <li data-select-item>Part Time</li>
                            </ul>
                            <input class="d-none" type="text">
                        </div>
                        <div class="ys-select" data-select><span data-select-value>All Titles</span>
                            <ul>
                                <li class="active" data-select-item>All Titles</li>
                                <li data-select-item>Item 2</li>
                                <li data-select-item>Item 3</li>
                            </ul>
                            <input class="d-none" type="text">
                        </div>
                        <div class="ys-select" data-select><span data-select-value>All Companies</span>
                            <ul>
                                <li class="active" data-select-item>All Companies</li>
                                <li data-select-item>Item 2</li>
                                <li data-select-item>Item 3</li>
                            </ul>
                            <input class="d-none" type="text">
                        </div>
                        <button class="btn btn-primary">Apply</button>
                    </form>
                </div>
                <div class="col-12 col-xl-8 order-xl-0">
                    <div class="vacancies">
                        <?php if (have_posts()): ?>
                            <?php while (have_posts()): the_post(); ?>
                                <?php get_template_part('template-parts/vacancy/card', 'default'); ?>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <?php get_template_part('content-none'); ?>
                        <?php endif; ?>
                    </div>
                    <button class="btn btn-outline-primary btn-lg mt-5">Load More Job Results</button>
                </div>
            </div>
        </div>
    </section>
<?php get_footer();
