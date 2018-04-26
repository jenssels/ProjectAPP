<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div>
    <p>Hieronder de opties die jij gekozen hebt.</p>
    <?php
    $opties = [];
    $i = 0;
    foreach ($dagindelingen as $dagindeling) {
        echo "<h5>" . $dagindeling->naam . "</h5>";
        foreach ($optiedeelnames as $optiedeelname) {
            if ($optiedeelname->optie->dagindeling->naam == $dagindeling->naam) {
                if ($optiedeelname->optie->naam == "") {
                    echo "Nee";
                }
                echo "<p>" . $optiedeelname->optie->naam .
                        anchor('personeel/bewerkDagindeling/'. $optiedeelname->id, '<button type="button" class="btn"><i class="fas fa-edit"></i></button>');"</p>"; 
            } 
        }
    }
    ?>
</div>
