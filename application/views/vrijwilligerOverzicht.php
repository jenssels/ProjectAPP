
<div class="row">
    <div class="col-md-12">
        <p>Overzicht vrijwilligers</p>
    </div>
    <div class="col-md-12">
        <form method="post" action="send">
            <table>
            <?php
                //Thomas Vansprengel
            echo "<tr><th>Taak</th><th>Shift</th><th>Tijd</th><th>Aantal inschrijvingen</th><th>Locatie</th><th>Ik wil helpen!</th></tr>";
                foreach($shiften as $shift){
                    echo "<tr><td>" . $shift->taak->naam .  "</td><td>" .  $shift->naam .  "</td><td>" .  $shift->beginuur . " - " .  $shift->einduur .  "</td><td>" . anchor("vrijwilliger/".$shift->id, "x/" . $shift->maxAantal)  .  "</td><td>" .  $shift->taak->locatieId .  "</td><td>" . form_checkbox($shift->id) .  "</td></tr>"; 
                }
                echo "<tr><td>" . form_submit('verzenden', 'Bevestigen!') . "</td></tr>";
            ?>
            </table>
        </form>
    </div>
    <div class="col-md-12">
        <?php
            //Thomas Vansprengel
            echo anchor('Vrijwilliger/?', 'Naar albums');
        ?>
    </div>
</div>


