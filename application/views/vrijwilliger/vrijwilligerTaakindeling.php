<?php /**
 * @file vrijwilligerTaakindeling.php
 * 
 * View waaruit een vrijwilliger zijn dagindeling kan invullen
 * 
 */ ?>
<script>
    $(document).ready(function () {

        // Tonen van overlay
        $('#overlay').show();
        // Weghalen overlay bij click
        $('#overlay').click(function () {
            $('#overlay').fadeOut();
        });

        // Checken op volzet
        function ajaxCheckVolzet(id, max) {
            $.ajax({type: "GET",
                url: site_url + "/Organisator/ajaxCheckVolzet",
                data: {id: id},
                success: function (result) {
                    $('.check').each(function () {
                        if (id === $(this).data('id')) {
                            if (result === "true") {
                                $(this).parent().prev().prev().html(max + '/' + max);
                                $(this).prop('disabled', true);
                                $(this).prop('checked', false);
                                $(this).parent().next().children().html('Volzet');
                            } else {
                                $(this).prop('disabled', false);
                            }
                        }
                    });
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
            });
        }
        ;
        $('.check').change(function () {
            var max = $(this).data('max');
            var id = $(this).data('id');
            ajaxCheckVolzet(id, max);
        });
        $('.check').each(function () {
            var count = $(this).data('count');
            var max = $(this).data('max');
            if (count >= max && !$(this).checked) {
                $(this).prop('disabled', true);
            }
        });

    });
</script>
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
        ?>
        <table class="table">
            <tr>
                <th>Taak</th>
                <th>Shift</th>
                <th>Uur</th>
                <th>Locatie</th>
                <th>Inschrijvingen</th>
                <th>Ik wil helpen!</th>
            </tr>    
            <?php
            $teller = 0;
            
            foreach ($personeelsfeest->dagindelingen as $dagindeling) {
                foreach ($dagindeling->taken as $taak) {
                    foreach ($taak->shiften as $shift) {
                        $teller++;
                        echo "<tr><td>" . $taak->naam . "</td><td>" . $shift->naam . "</td>"
                        . "<td>" . substr($shift->beginuur, 0, 5) . "u - " . substr($shift->einduur, 0, 5) . "u</td>"
                        . "<td>" . $taak->locatie->naam. "</td>"
                        . "<td>" . $shift->deelnemers . '/' . $shift->maxAantal . "</td>"
                        . "<td>" . form_checkbox(array('name' => 'shift[]', 'class' => 'check', 'value' => $shift->id, 'id' => 'shift' . $shift->id, 'data-count' => $shift->deelnemers, 'data-max' => $shift->maxAantal, 'data-id' => $shift->id)) . "</td>"
                        . "<td><div class='volzet'></div></td></tr>";
                    }
                }
            }
            ?>
        </table>        

        <?php
        echo form_hidden("hashcode", $hashcode);
        echo form_submit('verzenden', 'Bevestigen', 'class="btn btn-primary"');
        ?>
    </div>
</div>


