<?php

$heading = $args['heading'] ?? null;
?>
<div class="modal-header">
    <h2 class="no-decor js-header-text"><?php echo $heading; ?></h2>
    <button class="close js-close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div id="form-error" class="alert alert-dismissible" style="display: none" role="alert">
    <span class="content"></span>
    <button type="button" class="close" aria-label="Close" >
        <span aria-hidden="true">&times;</span>
    </button>
</div>
