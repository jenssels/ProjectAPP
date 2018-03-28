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
    echo form_open('organisator/registreerNieuweOrganisator', $attributenFormulier)
    ?>

    <?php
    foreach ($dagindelingenMetOpties as $dagindeling) {
        echo "<h2>" . $dagindeling->naam . "</h2>";
        $options = array();
        foreach ($dagindeling->opties as $optie) {
            $options[] = $optie->naam;
        }
        $attributes = array('name' => '',
            'id' => '',
            'class' => 'form-control');
        echo "<div class='form-group'>";
        echo form_dropdown($dagindeling->id, $options, '', $attributes);
        echo "</div>";
    }
    ?>
    
    <?php echo form_close(); ?>
</div>
