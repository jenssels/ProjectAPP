
<div class="row">
    <div class="col-md-12">
        <table>
            <tr>
                <th>Naam</th>
                <th>Adres</th>
                <th>Plaats</th>
            </tr>
        <?php
            //Thomas Vansprengel - Overzicht van taken
            foreach($locaties as $locatie){
                echo "<tr><td>" .  $locatie->naam . "</td><td>" .  $locatie->adres . "</td><td>" .  $locatie->plaats . "</td><td>" . anchor("organisator/verwijderlocatie/".$locatie->id,"Verwijderen") . "</td><td>" . anchor("organisator/editlocatie/".$locatie->id,"Bewerk") . "</td></tr>"; 
            }
            
            
            echo "<tr><td>" . anchor("organisator/locatieToevoegen/","Locatie toevoegen"). "</tr></td>";
            echo "<tr><td>" . anchor("organisator/personeelsFeestOverzicht/","Terug naar homepagina"). "</tr></td>";
        ?>
        </table>
    </div>
</div>

