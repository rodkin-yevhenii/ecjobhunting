<?php

/**
 * @var $candidate \EcJobHunting\Entity\Candidate
 */
$candidate = $args['candidate'] ?? null;

if (!$candidate) {
    return;
}
?>
<form class="modal-content" id="skills">
    <?php get_template_part(
        'template-parts/candidate/dashboard/modal-forms/form-header',
        null,
        ['heading' => __('Skills', 'ecjobhunting')]
    ); ?>
    <div class="modal-body">
        <div class="d-flex flex-nowrap mb-3">
            <input
                type="text"
                class="field-text mr-3 js-auto-complete js-add-skill-field"
                autocomplete="off"
            />
            <a href="#" class="btn btn-primary js-add-skill-btn">
                <?php _e('Add', 'ecjobhunting'); ?>
            </a>
        </div>
        <div class="candidate-skills">
            <ul class="candidate-skills__container js-skills-container">
                <?php foreach ($candidate->getSkills() as $id => $name) : ?>
                    <li
                        class="candidate-skills__item js-skill"
                        data-id="<?php echo $id; ?>"
                        data-name="<?php echo $name; ?>"
                    >
                        <?php echo $name; ?>
                        <a href="#" class="delete js-delete-skill-btn">x</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php get_template_part('template-parts/candidate/dashboard/modal-forms/form-footer'); ?>
</form>
