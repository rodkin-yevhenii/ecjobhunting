<?php

use EcJobHunting\Entity\Vacancy;
use EcJobHunting\Service\Job\JobService;
use EcJobHunting\Service\User\UserService;

if (!empty($args['vacancyId'])) {
    $vacancy = new Vacancy($args['vacancyId']);
} else {
    $vacancy = new Vacancy();
}
$employer = UserService::getUser();
$jobService = new JobService();
$employmentTypes = get_terms(['taxonomy' => 'type', 'hide_empty' => false,]);
$benefits = get_field_object('field_5fecd57ec26b9')['choices']; // benefits option
$benefitsCount = count($benefits);
if ($benefitsCount % 2 == 0) {
    $pos = $benefitsCount / 2;
} else {
    $pos = $benefitsCount / 2 + 0.5;
}
$benefits_1 = array_slice($benefits, 0, $pos);
$benefits_2 = array_slice($benefits, $pos);
$currencies = get_field_object('field_compensation_currency')['choices']; // field_compensation_currency option
$period = get_field_object('field_compensation_period')['choices']; // field_compensation_period option
$agreements = get_field_object('field_5fecd839c41cf')['choices']; // agreements option
?>
<form
    id="publish-job-form"
    class="container-fluid p-0 publish-job-form"
    data-author="<?php echo get_current_user_id();?>"
>
    <div class="row mt-md-4">
        <div class="col-12 col-md-5 col-xl-3">
            <label class="field-label mb-2 mb-md-0 mt-md-3" for="post-company-logo">Company logo
                <span class="color-primary">*</span></label>
        </div>
        <div class="col-12 col-md-7 js-file-input-container">
            <input
                class="file"
                type="file"
                name="logo"
                id="post-company-logo"
                accept=".jpg,.png"
                required
            />
        </div>
    </div>
    <div class="row mt-md-4">
        <div class="col-12 col-md-5 col-xl-3">
            <label class="field-label mb-2 mb-md-0 mt-md-3" for="post-job-title"><?php echo $vacancy->getTitle(); ?>
                <span class="color-primary">*</span></label>
        </div>
        <div class="col-12 col-md-7">
            <input class="field-text" type="text" id="post-job-title" required>
        </div>
    </div>
    <div class="row mt-3 mt-md-4">
        <div class="col-12 col-md-5 col-xl-3">
            <label class="field-label mb-2 mb-md-0 mt-md-3" for="post-job-location">Job Location <span
                        class="color-primary">*</span></label>
        </div>
        <div class="col-12 col-md-7">
            <input
                class="field-text js-auto-complete"
                type="text"
                id="post-job-location"
                name="location"
                autocomplete="off"
                required
            >
        </div>
    </div>
    <div class="row mt-3 mt-md-4">
        <div class="col-12 col-md-5 col-xl-3">
            <label class="field-label mb-2 mb-md-0 mt-md-3" for="post-job-category">Job Category<span
                    class="color-primary">*</span></label>
        </div>
        <div class="col-12 col-md-7">
            <input
                class="field-text js-auto-complete"
                type="text"
                id="post-job-category"
                name="job-category"
                autocomplete="off"
                required
            >
        </div>
    </div>
    <div class="row mt-3 mt-md-4">
        <div class="col-12 col-md-5 col-xl-3">
            <div class="field-label mb-2 mb-md-0 mt-md-3">Employment Type <span class="color-primary">*</span></div>
        </div>
        <?php if (!empty($employmentTypes)) : ?>
            <div class="col-12 col-md-7">
                <div class="ys-select ys-select-bordered js-employment-type" data-select><span
                            data-select-value>Select employment type</span>
                    <ul>
                        <?php foreach ($employmentTypes as $type) : ?>
                            <li data-select-item data-key="<?php echo $type->name; ?>"><?php echo $type->name; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <input class="d-none" type="text" id="employment-type">
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="row mt-3 mt-md-4">
        <div class="col-12 col-md-5 col-xl-3">
            <label class="field-label mb-2 mb-md-0 mt-md-3" for="post-job-description">Job Description <span
                        class="color-primary">*</span></label>
        </div>
        <div class="col-12 col-md-7">
            <textarea class="field-textarea" id="post-job-description"></textarea>
        </div>
    </div>
    <?php if (!empty($benefits)) : ?>
        <div class="row mt-3 mt-md-5">
        <div class="col-12 col-md-5 col-xl-3">
                <div class="field-label mb-2 mb-md-0">Benefits</div>
        </div>
        <?php if (!empty($benefits_1)) : ?>
            <div class="col-12 col-md-4">
                <?php foreach ($benefits_1 as $id => $item) : ?>
                    <fieldset>
                        <input type="checkbox" name="post-job-benefits[]" id="<?php echo $id; ?>">
                        <label for="<?php echo $id; ?>"><?php echo $item; ?></label>
                    </fieldset>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($benefits_2)) : ?>
            <div class="col-12 col-md-3">
                <?php foreach ($benefits_2 as $id => $item) : ?>
                    <fieldset>
                        <input type="checkbox" name="post-job-benefits[]" id="<?php echo $id; ?>">
                        <label for="<?php echo $id; ?>"><?php echo $item; ?></label>
                    </fieldset>
                <?php endforeach; ?>
            </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="row mt-3 mt-md-5">
        <div class="col-12 col-md-5 col-xl-3">
            <div class="field-label mb-2 mb-md-0 mt-md-3">Compensation Range <span class="color-primary">*</span></div>
            <p>Job postings with compensation data receive maximum visibility.</p>
        </div>
        <div class="col-12 col-md-7">
            <div class="field-prices">
                <label><span>$</span>
                    <input class="field-text" type="text" id="compensation_from">
                </label><span>to</span>
                <label><span>$</span>
                    <input class="field-text" type="text" id="compensation_to">
                </label>
            </div>
            <div class="d-md-flex justify-content-md-between mt-3 mt-md-4 align-items-start flex-wrap">
                <?php if (!empty($currencies)) : ?>
                    <div class="ys-select ys-select-bordered mt-3 mt-md-0 mr-md-4 js-currency" data-select>
                        <span data-select-value>USD</span>
                        <ul>
                            <?php foreach ($currencies as $key => $item) : ?>
                                <li data-select-item data-key="<?php echo $key; ?>"><?php echo $item; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <input class="d-none" type="text" id="currency">
                    </div>
                <?php endif; ?>
                <?php if (!empty($period)) : ?>
                    <div class="ys-select ys-select-bordered mt-3 mt-md-0 flex-md-grow-1 mr-lg-4 js-period" data-select>
                        <span data-select-value>Annualy</span>
                        <ul>
                            <?php foreach ($period as $key => $item) : ?>
                                <li data-select-item data-key="<?php echo $key; ?>"><?php echo $item; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <input class="d-none" type="text" id="period">
                    </div>
                <?php endif; ?>
                <div class="mt-3 mt-md-4 mt-lg-3">
                    <input type="checkbox" name="post-job-commission" id="post-job-commission">
                    <label for="post-job-commission">Plus commission</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3 mt-md-5">
        <div class="col-12 col-md-5 col-xl-3">
            <label class="field-label m-0 mt-md-3" for="post-job-address">Street Address <span
                        class="color-primary">*</span></label>
            <p>Some job boards allow users to search with a map. Enter your full street address for better
                visibility.</p>
        </div>
        <div class="col-12 col-md-7">
            <input class="field-text" type="text" id="post-job-address" required>
        </div>
    </div>
    <div class="row mt-3 mt-md-5">
        <div class="col-12 col-md-5 col-xl-3">
            <div class="field-label mb-2 mb-md-0 mt-md-2">Skills <span class="color-primary">*</span></div>
            <p>Target the exact job seekers you need by adding skill keywords below.</p>
        </div>
        <div class="col-12 col-md-7 js-custom-list-component">
            <ul class="custom-list__items js-custom-list-items js-skills-list mb-md-4">
            </ul>
            <div class="field-skills-panel d-flex flex-column flex-md-row">
                <label class="d-block mb-0 mt-3 mt-md-0 flex-md-grow-1 mr-md-4">
                    <input
                        class="field-text js-auto-complete js-custom-list-input"
                        type="text"
                        id="post-skill"
                        name="skill"
                        autocomplete="off"
                    />
                </label>
                <button class="btn btn-primary mt-3 m-md-0 px-md-4 js-custom-list-add-button" type="button">Add</button>
            </div>
        </div>
    </div>
    <div class="row mt-3 mt-md-5">
        <div class="col-12 col-md-5 col-xl-3">
            <label class="field-label mb-2 mb-md-0 mt-md-3" for="post-job-company">
                Hiring Company
                <span class="color-primary">*</span>
            </label>
        </div>
        <div class="col-12 col-md-7">
            <input
                class="field-text js-auto-complete"
                type="text"
                id="post-job-company"
                name="company"
                autocomplete="off"
                required
            >
        </div>
    </div>
    <div class="row mt-3 mt-md-4">
        <div class="col-12 col-md-5 col-xl-3">
            <label class="field-label mb-2 mb-md-0 mt-md-3" for="post-job-why">Why Work at This Company</label>
        </div>
        <div class="col-12 col-md-7">
            <textarea class="field-textarea" id="post-job-why"></textarea>
        </div>
    </div>
    <div class="row mt-3 mt-md-4">
        <div class="col-12 col-md-5 col-xl-3">
            <label class="field-label mb-2 mb-md-0 mt-md-3" for="post-job-company-description">Hiring Company
                Description</label>
            <p>Please note: editing this description will affect all jobs at this hiring company.</p>
        </div>
        <div class="col-12 col-md-7">
            <textarea class="field-textarea" id="post-job-company-description"></textarea>
        </div>
    </div>
    <div class="row mt-3 mt-md-5">
        <div class="col-12 col-md-5 col-xl-3">
            <label class="field-label mb-2 mb-md-0" for="post-job-company-description">Send New Candidates To <span
                        class="color-primary">*</span></label>
            <p>Alert emails with new candidates will be sent to</p>
        </div>
        <div class="col-12 col-md-7 custom-list js-custom-list-component">
            <fieldset>
                <input type="checkbox" name="post-job-send" id="post-job-send">
                <label for="post-job-send"><?php echo $employer->getName(); ?> (You!)</label>
            </fieldset>
            <ul
                class="mb-md-4 custom-list__items custom-list__items--vertical js-custom-list-items js-emails-list"
            ></ul>
            <div class="mt-md-2 d-flex flex-column flex-md-row">
                <label class="d-block m-0 mr-md-4 flex-grow-1">
                    <input class="field-text js-custom-list-input" type="email" id="post-job-send-email">
                </label>
                <button class="btn btn-primary mt-3 m-md-0 js-custom-list-add-button" type="button">Add Email</button>
            </div>
            <?php if (!empty($agreements)) :
                $firstKey = array_key_first($agreements);
                foreach ($agreements as $id => $item) :
                    $classNames = '';
                    if ($id === $firstKey) :
                        $classNames = " mt-3 mt-md-5";
                    endif; ?>
                    <div class="d-flex<?php echo $classNames; ?>">
                        <input type="checkbox" name="post-job-send[]" id="<?php echo $id; ?>">
                        <label for="<?php echo $id; ?>"><?php echo $item; ?></label>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="row field-footer mt-3 pt-3 mt-md-5 pt-md-5">
        <div class="col-12 col-md-5 col-xl-3">
            <p class="my-md-0">By clicking Save & Post Now, I agree that EcJobHunting may publish and/or distribute my
                job advertisement on its site and through its distribution partners.</p>
        </div>
        <div class="col-12 col-md-7 d-md-flex align-items-md-start">
            <?php if (UserService::isEmployer()) :
                if ($employer->isActivated()) : ?>
                    <button class="btn btn-primary mr-md-4" type="submit" data-status="publish">Save & Post Now</button>
                <?php endif; ?>
                <button class="btn btn-outline-primary" type="submit" data-status="draft">Save Draft</button>
            <?php endif; ?>
        </div>
    </div>
</form>
