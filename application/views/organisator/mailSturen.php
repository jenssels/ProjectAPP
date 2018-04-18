<?php
/**
 * @file mailSturen.php
 * 
 * View waarin een organisator een (uitnodigings)mail kan sturen naar mensen in het systeem 
 * 
 */
?>

<div>
    <?php echo haalJavascriptOp("validator.js"); ?>

    <?php
    echo form_open()
    ?>



    <div class="form-group">
        <?php echo form_submit('knop', 'Bevestigen', "class='btn btn-primary'") ?>
        <?php echo form_submit('knop', 'Annuleren', "class='btn btn-primary'") ?>
    </div>


    <?php echo form_close(); ?>
</div>