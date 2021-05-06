<?php

$heading = $args['heading'] ?? null;
?>
<div class="modal-header">
    <h2 class="no-decor js-header-text"><?php echo $heading; ?></h2>
    <button class="close js-close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="notification js-notification p-3 text-center d-none"></div>
