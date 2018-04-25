<?php
/**
 * @file albumAanmaken.php
 * 
 * View waarin een organisator albums kan aanmaken 
 *  - Gebruikt Bootstrap-formulier
 */

$personeelsfeestLijst = "";
$personeelsfeestLijst[0] = "--Select--";

foreach($personeelsfeesten as $personeelsfeest){
    $personeelsfeestLijst[$personeelsfeest->id] = $personeelsfeest->naam;
}
?>
<div id="formulier">
    <?php echo haalJavascriptOp("validator.js"); ?>

    <?php
    $attributenFormulier = array('id' => 'mijnFormulier',
        'role' => 'form');
    echo form_open('organisator/registreerAlbum', $attributenFormulier)
    ?>

    <div class="form-group">
        <?php
        echo form_labelpro('Naam: ', 'naam');
        echo form_input(array('name' => 'naam',
            'id' => 'naam',
            'class' => 'form-control',
            'placeholder' => 'Album naam',
            'required' => 'required'));
        ?>
    </div>

    <div class="form-group">
        <?php
        echo form_labelpro('Personeelsfeest: ', 'personeelsfeest');
        echo form_dropdown(array('name' => 'personeelsfeest',
            'id' => 'personeelsfeest',
            'class' => 'form-control',
            'options' => $personeelsfeestLijst,
            'selected' => '0',
            'required' => 'required'));
        ?>
    </div>

    <div class="form-group">
        <?php echo form_submit('knop', 'Aanmaken', "class='btn btn-primary'") ?>
        <?php echo form_submit('knop', 'Annuleren', "class='btn btn-primary'") ?>
    </div>

    <?php echo form_close(); ?>
</div>

