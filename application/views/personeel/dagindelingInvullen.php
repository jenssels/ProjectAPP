<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div>
    <p>Welkom!</p>
    <p>De organisator heeft gekozen voor onderstaande dagindeling. Aan jou om de activiteiten te kiezen.</p>

    <?php
    $attributenFormulier = array('id' => 'mijnFormulier',
        'role' => 'form');
    echo form_open('personeel/bevestigIngevuldeDagindeling/' . $deelnemer->hashcode, $attributenFormulier)
    ?>

    <?php
    $teller = 0;
    foreach ($dagindelingenMetOpties as $dagindeling) {
        if (count($dagindeling->opties) !== 0) {
            $teller++;
            echo "<h5>" . $dagindeling->naam . "</h5>";
            $options = array();
            $options[] = "-- Kies een optie --";
            foreach ($dagindeling->opties as $optie) {
                $options[$optie->id] = $optie->naam;
            }
            $attributes = array('id' => '',
                'class' => 'form-control');
            echo "<div class='form-group'>";
            echo form_dropdown($teller, $options, '', $attributes);
            echo "</div>";
            
        }
    }
    ?>

    <?php
    echo form_input(array('type' => 'hidden',
        'name' => 'aantalSelects',
        'id' => 'aantalSelects',
        'value' => $teller));
    ?>

    <div class="form-group">
        <?php echo form_submit('knop', 'Bevestigen', "class='btn btn-primary'") ?>
    </div>

    <?php echo form_close(); ?>
</div>
