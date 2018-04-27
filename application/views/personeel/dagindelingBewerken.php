<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$optielijst = "";
$optielijst[0] = "--Select--";

foreach($opties as $optie){
    $optielijst[$optie->id] = $optie->naam;
}
?>

<div>
    <p>Welkom!</p>
    <p>Hier kan u uw gekozen dagindeling bewerken.</p>

    <?php
    $attributenFormulier = array('id' => 'mijnFormulier',
        'role' => 'form');
    echo form_open('personeel/bewerkIngevuldeDagindeling/'. $optieDeelnameId, $attributenFormulier);
    
    ?>

    <?php
    echo form_labelpro('U koos om de opties van ' . $dagindeling->naam . ' te bewerken', 'personeelsfeest');
    echo form_dropdown(array('name' => 'optie',
       'id' => 'optie',
       'class' => 'form-control',
       'options' => $optielijst,
       'selected' => '0',
       'required' => 'required'));
    ?>

    <div class="form-group">
        <?php echo form_submit('knop', 'Bevestigen', "class='btn btn-primary'") ?>
    </div>

    <?php echo form_close(); ?>
</div>
