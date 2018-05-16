<?php
/**
 * @file overzichtIngevuldeDagindeling.php
 *
 * View waarin een personeelslid zijn / haar ingevulde dagindeling kan bekijken
 * Van hieruit kan hij / zij ook naar een pagina gaan om deze te bewerken of een vrijwilliger uitnodigen
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
    
    echo anchor('personeel/vrijwilligerUitnodigenForm', 'Nodig een vrijwilliger uit', array('role' => 'button', 'class' => 'btn btn-primary'));
    ?>
</div>
