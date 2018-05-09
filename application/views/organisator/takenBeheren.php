<?php/**
 * @file takenBeheren.php
 * 
 * Pagina waar je alle taken in kan beheren
 * 
 */?>
<div class="row">
    <div class="col-md-8">
        <table class="table">
        <?php
            //Thomas Vansprengel - Overzicht van taken
            foreach($taken as $taak){
                echo "<tr><td>" .  $taak->naam . "</td>"
                        . "<td>" .  $taak->beschrijving . "</td>"
                        . "<td>" .  $taak->dagindeling->naam . "</td>"
                        . "<td>" .  $taak->locatie->naam . "</td>"
                        . "<td>" . anchor("organisator/verwijdertaak/".$taak->id,'<i class="far fa-trash-alt grow"></i>') . "</td>"
                        . "<td>" . anchor("organisator/edittaak/".$taak->id,'<i class="fas fa-pencil-alt grow"></i>') . "</td></tr>"; 
                
            }
            
            echo "<tr><td>" . anchor("organisator/taakToevoegen/","Taak toevoegen"). "</tr></td>";
            echo "<tr><td>" . anchor("organisator/personeelsFeestOverzicht/","Terug naar overzicht"). "</tr></td>";
        
            echo form_open();
            echo form_hidden("dagindelingid", $dagindelingid);
            echo form_close();
            
            
            
            
            ?>
        </table>
    </div>
</div>

