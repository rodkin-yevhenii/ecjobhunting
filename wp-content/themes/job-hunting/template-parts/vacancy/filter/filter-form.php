<?php

use EcJobHunting\Entity\Vacancy;

$fields = get_fields();
$publishDates = $fields['posted_dates'] ?? [];
$compensation = $fields['minimum_salary'] ?? [];
$employmentTypes = get_terms(['taxonomy' => 'type', 'hide_empty' => false,]);
$categories = get_terms(['taxonomy' => 'job-category', 'hide_empty' => false,]);
$companies = [];
$vacancies = get_posts(
    [
        'post_type' => 'vacancy',
        'post_status' => 'publish',
        'number' => -1,
        'meta_query' => [
            'key' => 'hiring_company',
            'compare' => 'EXISTS'
        ],
        'fields' => 'ids',
    ]
);

foreach ($vacancies as $id) {
    $vacancy = new Vacancy($id);

    if (!$vacancy) {
        continue;
    }

    $companies[] = $vacancy->getCompanyName();
}

$companies = array_unique($companies);

if (! is_array($employmentTypes)) {
    $employmentTypes = [];
}

if (! is_array($categories)) {
    $categories = [];
}
?>
<form class="filter" data-dropdown="filter" action="<?php the_permalink() ?>;" method="get">
    <?php if (!empty($_GET['s'])) : ?>
        <input type="hidden" name="s" id="s" value="<?php echo $_GET['s']; ?>">
    <?php endif;

    if (!empty($_GET['location'])) : ?>
        <input type="hidden" name="location" id="location" value="<?php echo $_GET['location']; ?>">
    <?php endif;

    if ($publishDates) : ?>
        <div class="ys-select" data-select><span data-select-value><?php _e('Posted anytime', 'ecjobhunting'); ?></span>
            <ul>
                <li <?php echo empty($_GET['publish-date']) ? 'class="active"' : ''; ?> data-select-item data-select-item-value="">
                    <?php _e('Posted anytime', 'ecjobhunting'); ?>
                </li>
                <?php foreach ($publishDates as $item) : ?>
                    <li
                        <?php echo !empty($_GET['publish-date']) && $_GET['publish-date'] == date("Y-m-d", strtotime($item['key']))
                            ? 'class="active"' : ''; ?>
                        data-select-item
                        data-select-item-value="<?php echo date("Y-m-d", strtotime($item['key'])); ?>"
                    >
                        <?php echo $item['label']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <input class="d-none" name="publish-date" id="publish-date" type="text">
        </div>
    <?php endif;

    if ($compensation) : ?>
        <div class="ys-select" data-select><span data-select-value><?php _e('Any Compensation', 'ecjobhunting'); ?></span>
            <ul>
                <li <?php echo empty($_GET['compensation']) ? 'class="active"' : ''; ?> data-select-item data-select-item-value=""><?php _e('Any Compensation', 'ecjobhunting'); ?></li>
                <?php foreach ($compensation as $item) : ?>
                    <li
                        <?php echo !empty($_GET['compensation']) && $_GET['compensation'] == $item['key'] ? 'class="active"' : ''; ?>
                        data-select-item
                        data-select-item-value="<?php echo $item['key']; ?>"
                    >
                        <?php echo $item['label']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <input class="d-none" name="compensation" id="compensation" type="text">
        </div>
    <?php endif;

    if ($employmentTypes) : ?>
        <div class="ys-select" data-select>
            <span data-select-value><?php _e('Any employment type', 'ecjobhunting'); ?></span>
            <ul>
                <li <?php echo empty($_GET['employment-type']) ? 'class="active"' : ''; ?> data-select-item  data-select-item-value="">
                    <?php _e('Any employment type', 'ecjobhunting'); ?>
                </li>
                <?php foreach ($employmentTypes as $type) : ?>
                    <li
                        <?php echo !empty($_GET['employment-type']) && $_GET['employment-type'] == $type->term_id
                            ? 'class="active"' : ''; ?>
                        data-select-item
                        data-select-item-value="<?php echo $type->term_id; ?>"
                    >
                        <?php echo $type->name; ?>
                    </li>
                <?php
                endforeach; ?>
            </ul>
            <input class="d-none" name="employment-type" id="employment-type" type="text">
        </div>
    <?php
    endif;

    if ($categories) : ?>
        <div class="ys-select" data-select>
            <span data-select-value>
                <?php _e('All Titles', 'ecjobhunting'); ?>
            </span>
            <ul>
                <li <?php echo empty($_GET['category']) ? 'class="active"' : ''; ?> data-select-item data-select-item-value="">
                    <?php _e('All Titles', 'ecjobhunting'); ?>
                </li>
                <?php foreach ($categories as $category) : ?>
                    <li
                        <?php echo !empty($_GET['category']) && $_GET['category'] == $category->term_id
                            ? 'class="active"' : ''; ?>
                        data-select-item
                        data-select-item-value="<?php echo $category->term_id; ?>"
                    >
                        <?php echo $category->name; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <input class="d-none" name="category" id="category" type="text">
        </div>
    <?php endif;

    if ($companies) : ?>
        <div class="ys-select" data-select>
            <span data-select-value>
                <?php _e('All Companies', 'ecjobhunting'); ?>
            </span>
            <ul>
                <li <?php echo empty($_GET['company']) ? 'class="active"' : ''; ?> data-select-item data-select-item-value="">
                    <?php _e('All Companies', 'ecjobhunting'); ?>
                </li>
                <?php foreach ($companies as $company) : ?>
                    <li
                        <?php echo !empty($_GET['company']) && $_GET['company'] == $company
                            ? 'class="active"' : ''; ?>
                        data-select-item
                        data-select-item-value="<?php echo $company; ?>"
                    >
                        <?php echo $company; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <input class="d-none" name="company" id="company" type="text">
        </div>
    <?php endif; ?>
    <button class="btn btn-primary"><?php _e('Apply', 'ecjobhunting'); ?></button>
</form>
