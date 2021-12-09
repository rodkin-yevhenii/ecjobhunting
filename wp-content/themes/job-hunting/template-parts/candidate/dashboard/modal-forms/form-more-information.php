<?php

/**
 * @var $candidate \EcJobHunting\Entity\Candidate
 */

use EcJobHunting\Service\Helpers\Helpers;

$candidate = $args['candidate'] ?? null;

if (!$candidate) {
    return;
}
?>
<form class="modal-content" id="more-information">
    <?php get_template_part(
        'template-parts/candidate/dashboard/modal-forms/form-header',
        null,
        ['heading' => __('More Information', 'ecjobhunting')]
    ); ?>
    <div class="modal-body">
        <label class="field-label" for="desired_salary">
            <?php _e('Desired Salary', 'ecjobhunting'); ?>
        </label>
        <select id="desired_salary" class="field-text">
            <?php
            for ($i = 0; $i <= 200000; $i += 5000) :
                ?>
                <option
                    value="<?php echo $i; ?>"
                    <?php echo $i === $candidate->getSalaryExpectation() ? 'selected' : ''; ?>
                >
                    <?php echo $i === 0
                        ? '-- Select option --'
                        : number_format($i, 0, '.', ',') . '$ / year';
                    ?>
                </option>
                <?php
            endfor;
            ?>
        </select>

        <label class="field-label" for="years_of_experience">
            <?php _e('Years of Experience', 'ecjobhunting'); ?>
        </label>
        <select id="years_of_experience" class="field-text">
            <option
                value=""
                <?php echo '' === $candidate->getYearsOfExperience() ? 'selected' : ''; ?>
            >
                -- Select option --
            </option>
            <option
                value="Intern"
                <?php echo 'Intern' === $candidate->getYearsOfExperience() ? 'selected' : ''; ?>
            >
                Intern
            </option>
            <option
                value="Entry Level (0-2 years)"
                <?php echo 'Entry Level (0-2 years)' === $candidate->getYearsOfExperience() ? 'selected' : ''; ?>
            >
                Entry Level (0-2 years)
            </option>
            <option
                value="Mid Level (3-6 years)"
                <?php echo 'Mid Level (3-6 years)' === $candidate->getYearsOfExperience() ? 'selected' : ''; ?>
            >
                Mid Level (3-6 years)
            </option>
            <option
                value="Senior Level (7+ years)"
                <?php echo 'Senior Level (7+ years)' === $candidate->getYearsOfExperience() ? 'selected' : ''; ?>
            >
                Senior Level (7+ years)
            </option>
            <option
                value="Director"
                <?php echo 'Director' === $candidate->getYearsOfExperience() ? 'selected' : ''; ?>
            >
                Director
            </option>
            <option
                value="Executive"
                <?php echo 'Executive' === $candidate->getYearsOfExperience() ? 'selected' : ''; ?>
            >
                Executive
            </option>
        </select>

        <label class="field-label" for="highest_degree_earned">
            <?php _e('Highest Degree Earned', 'ecjobhunting'); ?>
        </label>
        <select id="highest_degree_earned" class="field-text">
            <?php
            $fieldObj = get_field_object('degree_earned', $candidate->getCvId());

            foreach ($fieldObj['choices'] as $key => $val) :
                ?>
                <option
                    value="<?php echo $key; ?>"
                    <?php selected($candidate->getHighestDegreeEarned(), $val); ?>
                >
                    <?php echo $val; ?>
                </option>
                <?php
            endforeach;
            ?>
        </select>

        <label class="field-label" for="category">
            <?php _e('Industry', 'ecjobhunting'); ?>
        </label>
        <select id="category" class="field-text">
            <option
                value=""
                <?php echo '' === $candidate->getCategory() ? 'selected' : ''; ?>
            >
                -- Select option --
            </option>
            <?php foreach (Helpers::getCategories() as $id => $name) : ?>
                <option
                    value="<?php echo $name; ?>"
                    <?php echo $name === $candidate->getCategory() ? 'selected' : ''; ?>
                >
                    <?php echo $name; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label class="field-label" for="veteran_status">
            <?php _e('Veteran Status', 'ecjobhunting'); ?>
        </label>
        <select id="veteran_status" class="field-text">
            <option
                value=""
                <?php echo '' === $candidate->getVeteranStatus() ? 'selected' : ''; ?>
            >
                -- Select option --
            </option>
            <option
                value="I am a Veteran"
                <?php echo 'I am a Veteran' === $candidate->getVeteranStatus() ? 'selected' : ''; ?>
            >
                I am a Veteran
            </option>
            <option
                value="I do not wish to specify at this time"
                <?php echo 'I do not wish to specify at this time' === $candidate->getVeteranStatus()
                    ? 'selected' : ''; ?>
            >
                I do not wish to specify at this time
            </option>
        </select>
    </div>
    <?php get_template_part('template-parts/candidate/dashboard/modal-forms/form-footer'); ?>
</form>
