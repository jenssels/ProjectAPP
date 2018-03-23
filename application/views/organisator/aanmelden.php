<?php
/**
 * @file inloggen.php
 * 
 * View waarin een organisator kan inloggen 
 *  - Gebruikt Bootstrap-formulier
 */
?>

<div class="page-header">
    <h1>Inloggen</h1>
</div>

<div>
    <p>Gelieve u aan te melden met uw gegevens</p>
</div>

<div id="aanmeldblok">
    <?php echo haalJavascriptOp("validator.js"); ?>

    <?php
    $attributenFormulier = array('id' => 'mijnFormulier',
        'role' => 'form');
    echo form_open('organisator/controleerAanmelden', $attributenFormulier)
    ?>

    <div class="form-group">
        <?php
        echo form_labelpro('Email', 'email');
        echo form_input(array('name' => 'email',
            'id' => 'email',
            'type' => 'email',
            'class' => 'form-control',
            'placeholder' => 'gebruiker@email.com',
            'required' => 'required'));
        ?>
    </div>

    <div class="form-group">
        <?php
        echo form_labelpro('Wachtwoord', 'wachtwoord');
        echo form_input(array('name' => 'wachtwoord',
            'id' => 'wachtwoord',
            'type' => 'password',
            'class' => 'form-control',
            'placeholder' => 'Wachtwoord',
            'required' => 'required'));
        ?>
    </div>

    <div class="form-group">
        <?php echo form_submit('knop', 'Aanmelden', "class='btn btn-primary'") ?>
        <?php echo form_submit('knop', 'Annuleren', "class='btn btn-primary'") ?>
    </div>

    <?php echo form_close(); ?>
</div>

