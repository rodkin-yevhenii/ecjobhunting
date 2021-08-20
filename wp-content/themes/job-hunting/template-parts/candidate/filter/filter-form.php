<?php

use EcJobHunting\Entity\Company;
use EcJobHunting\Entity\Vacancy;

$company = new Company(get_user_by('ID', get_current_user_id()));
$activeVacancies = $company->getActiveVacancies();
$locations = get_terms(
    [
        'taxonomy' => 'location',
        'hide_empty' => false,
        'hierarchical' => false,
        'fields' => 'id=>name'
    ]
);
$categories = get_terms(
    [
        'taxonomy' => 'job-category',
        'hide_empty' => false,
        'hierarchical' => false,
        'fields' => 'id=>name'
    ]
);
?>
<button class="filter-database-handler btn btn-outline-primary px-5 mb-3 d-md-none">Filter</button>
<form class="filter-database" data-nonce="<?php echo wp_create_nonce('get-filtered-cvs'); ?>">
    <?php
    // Vacancies
    if (!empty($activeVacancies)) :
        ?>
        <fieldset>
            <div class="field-label mb-2">Your Active Jobs:</div>
            <div class="ys-select ys-select-bordered" data-select>
                <span data-select-value>Show all candidates</span>
                <ul>
                    <li data-select-item data-id>Show all candidates</li>
                    <?php
                    foreach ($activeVacancies as $id) :
                        $vacancy = new Vacancy($id);
                        ?>
                        <li
                            data-select-item
                            data-select-item-value="<?php echo $id; ?>"
                        >
                            <?php echo $vacancy->getTitle(); ?>
                        </li>
                        <?php
                    endforeach;
                    ?>
                </ul>
                <input id="vacancy-id" name="vacancy-id" class="d-none" type="text"/>
            </div>
        </fieldset>
        <?php
    endif;
    ?>
    <fieldset class="field-skills mt-4 js-custom-list-component">
        <div class="field-label mb-2">Keywords:</div>
        <ul class="field-skills-list custom-list__items js-skills-list js-custom-list-items"></ul>
        <div class="field-skills-panel mt-2">
            <label class="d-block">
                <input
                    name="skill"
                    class="field-text js-auto-complete js-custom-list-input"
                    type="text"
                    placeholder="Skills"
                />
            </label>
            <button class="btn btn-primary js-custom-list-add-button" type="button">Add</button>
        </div>
    </fieldset>
    <?php
    if (!empty($locations)) :
        ?>
        <fieldset class="mt-4">
            <div class="field-label mb-2">Location:</div>
            <div class="ys-select ys-select-bordered" data-select>
                <span data-select-value>City, state or zip code</span>
                <ul>
                    <li data-select-item data-term-id>Any location</li>
                    <?php
                    foreach ($locations as $id => $name) :
                        ?>
                        <li
                            data-select-item
                            data-select-item-value="<?php echo $name; ?>"
                        >
                            <?php echo $name; ?>
                        </li>
                        <?php
                    endforeach;
                    ?>
                </ul>
                <input id="location" name="location" class="d-none" type="text">
            </div>
        </fieldset>
        <?php
    endif;
    ?>
<!--    TODO: Hide radius range-->
<!--    <fieldset class="mt-4">-->
<!--        <div class="field-label mb-3">-->
<!--            Radius: within <span data-noui-value="miles">0</span> miles-->
<!--        </div>-->
<!--        <div-->
<!--            data-noui-slider="miles"-->
<!--            data-noui-step="1"-->
<!--            data-noui-start="0"-->
<!--            data-noui-end="50"-->
<!--        ></div>-->
<!--    </fieldset>-->
    <fieldset class="mt-4">
        <label class="field-label mb-2" for="resumes-job">Job Title:</label>
        <input
            class="field-text"
            type="text"
            id="resumes-job"
            placeholder="Past or present job titles"
        />
    </fieldset>
    <fieldset class="mt-4">
        <label class="field-label mb-2" for="resumes-company">
            Previous Companies:
        </label>
        <input
            class="field-text"
            type="text"
            id="resumes-company"
            placeholder="Past or current employers"
        />
    </fieldset>
    <fieldset class="mt-4">
        <div id="resume-days-ago" class="field-label mb-3">
            Freshness: posted <span data-noui-value="posted">0</span> days ago
        </div>
        <div
            data-noui-slider="posted"
            data-noui-step="1"
            data-noui-start="0"
            data-noui-end="30"
        ></div>
    </fieldset>
    <fieldset class="mt-4">
        <div class="field-label">Minimum Education:</div>
        <div class="mt-2">
            <input type="radio" name="resume-education" id="resume-education-1" value="any" checked>
            <label for="resume-education-1">Any</label>
        </div>
        <div class="mt-2">
            <input type="radio" name="resume-education" id="resume-education-2" value="high_school">
            <label for="resume-education-2">High School</label>
        </div>
        <div class="mt-2">
            <input type="radio" name="resume-education" id="resume-education-3" value="college">
            <label for="resume-education-3">Some College</label>
        </div>
        <div class="mt-2">
            <input type="radio" name="resume-education" id="resume-education-4" value="bachelors">
            <label for="resume-education-4">Bachelors Degree</label>
        </div>
        <div class="mt-2">
            <input type="radio" name="resume-education" id="resume-education-5" value="master">
            <label for="resume-education-5">Masters Degree</label>
        </div>
        <div class="mt-2">
            <input type="radio" name="resume-education" id="resume-education-6" value="doctorate">
            <label for="resume-education-6">Doctorate or Higher</label>
        </div>
    </fieldset>
    <?php
    if (!empty($categories)) :
        $counter = 1;
        ?>
        <fieldset class="mt-4">
            <div class="field-label mb-2">Industry:</div>
            <div class="ys-select ys-select-bordered" data-select>
                <span data-select-value>Jobs categories</span>
                <ul>
                    <li
                        data-select-item
                        data-select-item-value
                    >
                        Any category
                    </li>
                    <?php
                    foreach ($categories as $id => $name) :
                        ?>
                        <li
                            data-select-item
                            data-select-item-value="<?php echo $name; ?>"
                        >
                            <?php echo $name; ?>
                        </li>
                        <?php
                    endforeach;
                    ?>
                </ul>
                <input id="resume-category" name="job-category" class="d-none" type="text">
            </div>
        </fieldset>
        <?php
    endif;
    ?>
    <fieldset class="mt-4">
        <div class="field-label mb-2">Veteran Status:</div>
        <input name="veteran-status" type="checkbox" id="resume-veteran">
        <label for="resume-veteran">Self-identified as Veteran</label>
    </fieldset>
    <button class="btn btn-primary btn-full mt-4" type="submit">Apply</button>
</form>
