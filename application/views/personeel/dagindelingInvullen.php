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
    foreach ($dagindelingenMetOpties as $dagindeling) {
        echo "<h2>" . $dagindeling->naam . "</h2>";
        $options = array();
        foreach ($dagindeling->opties as $optie) {
            $options[] = $optie->naam;
        }
        echo form_dropdown($dagindeling->id, $options);
    }
    ?>
</div>
