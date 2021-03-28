<?php
global $wp_query;
get_template_part('template-parts/vacancy/form', 'search'); ?>
<section class="my-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><? zzzzzzzzz ?></h1>
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
                <?php if (have_posts()): ?>
                    <div class="vacancies js-vacancies" data-total="<?php echo $wp_query->found_posts; ?>"
                         data-paged="1" data-posttype="vacancy" data-perpage="10" data-shown="<?php echo $wp_query->post_count; ?>">
                        <?php while (have_posts()): the_post();
                            get_template_part('template-parts/vacancy/card', 'default');
                        endwhile;
                        ?>
                    </div>
                    <?php if ($wp_query->post_count < $wp_query->found_posts): ?>
                        <button class="btn btn-outline-primary btn-lg mt-5 js-load-more">
                            Load More Job Results
                        </button>
                    <?php endif; ?>
                <?php else:
                    get_template_part('content', 'none');
                endif;
                ?>
            </div>
        </div>
    </div>
</section>
<?php
