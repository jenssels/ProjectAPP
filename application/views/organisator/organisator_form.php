<?php 
/**
 * @file organisator_form.php
 * 
 * View waarin je een nieuwe organisator kunt toevoegen 
 *  - Gebruikt Bootstrap-formulier
 */
?>

<?php echo haalJavascriptOp("validator.js"); ?>

<?php
$attributenFormulier = array('id' => 'mijnFormulier',
    'role' => 'form');
echo form_open('organisator/registreerNieuweOrganisator', $attributenFormulier)
?>

<div class="form-group">
    <?php
    echo form_labelpro('Voornaam', 'voornaam');
    echo form_input(array('name' => 'voornaam',
        'id' => 'voornaam',  
        'class' => 'form-control', 
        'placeholder' => 'Voornaam', 
        'required' => 'required'));
    ?>
</div>

<div class="form-group">
    <?php
    echo form_labelpro('Naam', 'naam');
    echo form_input(array('name' => 'naam',
        'id' => 'naam',  
        'class' => 'form-control', 
        'placeholder' => 'Naam', 
        'required' => 'required'));
    ?>
</div>

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
    <?php
    echo form_labelpro('Bevestig wachtwoord', 'bevestigWachtwoord');
    echo form_input(array('name' => 'bevestigWachtwoord',
        'id' => 'bevestigWachtwoord',
        'type' => 'password',
        'data-match' => '#wachtwoord',
        'data-match-error' => 'Wachtwoorden komen niet overeen',
        'class' => 'form-control', 
        'placeholder' => 'Wachtwoord', 
        'required' => 'required'));
    ?>
</div>

<div class="form-group">
    <?php echo form_submit('knop', 'Bevestigen', "class='btn btn-primary'"); ?>
    <a id="terug" class='btn btn-primary' href="javascript:history.go(-1);">Annuleren</a>
</div>

<?php echo form_close(); ?>