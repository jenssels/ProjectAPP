<?php/**
 * @file takenBeheren.php
 * 
 * Pagina waar je alle taken in kan beheren
 * 
 */?>
<div class="row">
    <div class="col-md-12">
        <table>
        <?php
            //Thomas Vansprengel - Overzicht van taken
            foreach($taken as $taak){
                echo "<tr><td>" .  $taak->naam . "</td><td>" .  $taak->beschrijving . "</td><td>" .  $taak->dagindeling->naam . "</td><td>" .  $taak->locatie->naam . "</td><td>" . anchor("organisator/verwijdertaak/".$taak->id,"Verwijderen") . "</td><td>" . anchor("organisator/edittaak/".$taak->id,"Bewerk") . "</td><td>" . anchor("organisator/shifttaak/".$taak->id,"Shiften") . "</td></tr>"; 
            }
            
            
                        echo "<tr><td>" . anchor("organisator/taakToevoegen/","Taak toevoegen"). "</tr></td>";
            echo "<tr><td>" . anchor("organisator/personeelsFeestOverzicht/","Terug naar homepagina"). "</tr></td>";
        ?>
        </table>
    </div>
</div>

