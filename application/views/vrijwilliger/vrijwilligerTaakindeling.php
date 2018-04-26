<script>
    $(document).ready(function () {
        // Tonen van overlay
        $('#overlay').show();
        // Weghalen overlay bij click
        $('#overlay').click(function () {
            $('#overlay').fadeOut();
        });

    });
</script>

<?php /**
 * @file vrijwilligerTaakindeling.php
 * 
 * View waaruit een vrijwilliger zijn dagindeling kan invullen
 * 
 */ ?>
<!-- Overlay gemaakt door Joren Synaeve -->
<div id="overlay">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h3>Beste vrijwilliger</h3>
            </div> 
            <div class="col-md-12">
                <p>Je bent uigenodigd om te komen helpen op het personeelsfeest. <br>
                Je krijgt zometeen een overzicht te zien van de taken die jij kan doen.</p>
                <p>Het is de bedoeling dat je taken aanduidt die je graag wilt doen, en die je ook zeker kan. Het is niet de bedoeling van je in te schrijven om dan niet te komen opdagen.
                Wie inschrijft verwachten we ook effectief op de dag zelf om te komen helpen.</p>
                <p>Als je op 'aantal inschrijvingen' klikt, kan je bekijken wie er al heeft ingeschreven. Zo kan je afspreken met je vrienden om samen te werken.</p>
                <p>De organisatie bedankt je alvast voor je inzet!</p>
                <p>Klik ergens op de pagina om door te gaan.</p>
            </div> 
        </div>
    </div>    
</div>



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
        foreach ($shiften as $shift) {
            $teller++;
            echo "<tr><td>" . $shift->taak->naam . "</td><td>" . $shift->naam . "</td>"
            . "<td>" . $shift->beginuur . " - " . $shift->einduur . "</td>"
            . "<td>" . anchor("vrijwilliger/overzicht/" . $shift->id, "x/" . $shift->maxAantal) . "</td>"
            . "<td>" . $shift->taak->locatie->naam . "</td>"
            . "<td>" . form_checkbox(array('name' => 'shift[]', 'value' => $shift->id)) . "</td></tr>";
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


