<?php
$searchPageUrl = get_field('search_page_url', 'option');
$s = $_GET['s'] ?? '';
$location = $_GET['location'] ?? '';
?>
<form class="hero" method="get" action="<?php echo $searchPageUrl; ?>">
    <div class="container">
        <div class="row d-flex justify-content-xl-center">
            <div class="col-12 col-md-5 col-xl-4">
                <label class="my-2">
                    <input
                        class="field-text"
                        type="text"
                        name="s"
                        placeholder="<?php _e('Job Title', 'ecjobhunting'); ?>"
                        value="<?php echo $s; ?>"
                    />
                </label>
            </div>
            <div class="col-12 col-md-5 col-xl-4">
                <label class="my-2">
                    <input
                            class="field-text"
                            type="text"
                            name="location"
                            placeholder="<?php _e('Location', 'ecjobhunting'); ?>"
                            value="<?php echo $location; ?>"
                    />
                </label>
            </div>
            <div class="col-12 col-md-2">
                <button class="btn btn-primary my-2" type="submit">
                    <?php _e('Search', 'ecjobhunting'); ?>
                </button>
            </div>
        </div>
    </div>
</form>