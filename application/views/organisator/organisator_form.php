<?php 
/**
 * @file organisator_form.php
 * 
 * View waarin je een nieuwe organisator kunt toevoegen * 
 *  - gebruikt Bootstrap-formulier
 */
?>

<div class="page-header">
  <h1>Organisator toevoegen</h1>
</div>

<?php echo haalJavascriptOp("validator.js"); ?>

<?php
$attributenFormulier = array('id' => 'mijnFormulier',
    'data-toggle' => 'validator',
    'role' => 'form');
echo form_open('organisator/registreerNieuweOrganisator', $attributenFormulier)
?>

<div class="form-group">
    <?php
    echo form_labelpro('Gebruikersnaam', 'gebruikersnaam');
    echo form_input(array('name' => 'gebruikersnaam',
        'id' => 'gebruikersnaam',  
        'class' => 'form-control', 
        'placeholder' => 'Gebruikersnaam', 
        'required' => 'required'));
    ?>
</div>

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
    echo form_input(array('email' => 'email',
        'id' => 'email',  
        'type' => 'email',
        'data-error' => 'Gelieve een geldig emailadres te gebruiken',
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
    <?php echo form_submit('knop', 'Bevestigen', "class='btn btn-primary'") ?>
    <?php echo form_submit('knop', 'Annuleren', "class='btn btn-primary'") ?>
</div>

<?php echo form_close(); ?>