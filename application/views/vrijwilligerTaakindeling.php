<?php/**
 * @file vrijwilligerTaakindeling.php
 * 
 * View waaruit een vrijwilliger zijn dagindeling kan invullen
 * 
 */?>
<div class="row">
    <div class="col-md-12">
        <p>Je bent uitgenodigd om te helpen op het personeelsfeest van dit jaar.</p>
        <p>Vul te taken aan die jij wilt uitvoeren.</p>
    </div>
    <div class="col-md-12">
                     <?php
                $attributes = array('name' => 'formulierInschrijven');
            echo form_open('vrijwilliger/bevestigTaakindeling', $attributes);
            echo"<table>";
            echo "<tr><th>Taak</th><th>Shift</th><th>Tijd</th><th>Aantal inschrijvingen</th><th>Locatie</th><th>Ik wil helpen!</th></tr>";
            $teller = 0;
                foreach($shiften as $shift){     
                    $teller++;
                    echo "<tr><td>" . $shift->taak->naam .  "</td><td>" .  $shift->naam .  "</td>"
                            . "<td>" .  $shift->beginuur . " - " .  $shift->einduur .  "</td>"
                            . "<td>" . anchor("vrijwilliger/overzicht/".$shift->id, "x/" . $shift->maxAantal)  .  "</td>"
                            . "<td>" .  $shift->taak->locatie->naam .  "</td>"
                            . "<td>" . form_checkbox(array('name' => 'shift[]', 'value' => $shift->id)) .  "</td></tr>";                     
                }
                echo form_hidden("hashcode", $hashcode);
           echo "<tr><td>" . form_submit('verzenden', 'Bevestigen!') . "</td></tr>";
           echo" </table>";
                            ?>
    </div>
    <div class="col-md-12">
        <?php
            //Thomas Vansprengel
            echo anchor('Vrijwilliger/?', 'Naar albums');
        ?>
    </div>
</div>


