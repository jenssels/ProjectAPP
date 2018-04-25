<?php
/**
 * @file uploadFotos.php
 * 
 * View waarin een organisator foto's in albums kan uploaden 
 *  - Gebruikt Bootstrap-formulier
 */
?>
<div id="formulier">
    <?php echo haalJavascriptOp("validator.js"); ?>

    <p>Hier kan u foto's uploaden om in uw album te zetten.</p>
    
    <?php
    $attributenFormulier = array('id' => 'mijnFormulier',
        'role' => 'form');
    echo form_open_multipart('organisator/uploadFeestFotos', $attributenFormulier);
    ?>
    
    <div class="form-group">
        <?php
        echo form_hidden(array('albumId' => $albumId));
        echo form_labelpro("Importeer foto's: ", 'fotos[]');
        echo form_input(array('name' => 'fotos[]',
            'id' => 'fotos[]',
            'type' => 'file',
            'multiple' => 'multiple'));
        ?>
    </div>

    <div class="form-group">
        <?php echo form_submit('doorgaan', 'Doorgaan', "class='btn btn-primary'") ?>
    </div>

    <?php echo form_close(); ?>
</div>

