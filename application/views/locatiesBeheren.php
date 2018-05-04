<?php/**
 * @file locatiesBeheren.php
 * 
 * Pagina waar je alle locaties kan beheren
 * 
 */?>
<div class="row">
    <div class="col-md-8">
        <table class="table">
            <tr>
                <th>Naam</th>
                <th>Adres</th>
                <th>Plaats</th>
            </tr>
        <?php
            //Thomas Vansprengel - Overzicht van taken
            foreach($locaties as $locatie){
                echo "<tr><td>" .  $locatie->naam . "</td><td>" .  $locatie->adres . "</td><td>" .  $locatie->plaats . "</td><td>" . anchor("organisator/verwijderlocatie/".$locatie->id,"<i class='far fa-trash-alt grow'></i>") . "</td><td>" . anchor("organisator/editlocatie/".$locatie->id,'<i class="fas fa-pencil-alt grow"></i>') . "</td></tr>"; 
            }
            
            
            echo "<tr><td class='text-center'>" . anchor("organisator/locatieToevoegen/","Locatie toevoegen"). "</tr></td>";
            echo "<tr><td class='text-center'>" . anchor("organisator/personeelsFeestOverzicht/","Terug naar homepagina"). "</tr></td>";
        ?>
        </table>
    </div>
</div>

