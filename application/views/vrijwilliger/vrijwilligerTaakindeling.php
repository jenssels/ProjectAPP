<?php/**
 * @file vrijwilligerTaakindeling.php
 * 
 * View waaruit een vrijwilliger zijn dagindeling kan invullen
 * 
 */?>
<script>
    $(document).ready(function () {
        
                // Tonen van overlay
        $('#overlay').show();
        // Weghalen overlay bij click
        $('#overlay').click(function () {
            $('#overlay').fadeOut();
        });
        
        var response;
        function ajaxCheckVolzet(id) {
            $.ajax({type: "GET",
                url: site_url + "/Organisator/ajaxCheckVolzet",
                data: {id: id},
                success: function (result) {
                    result;
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
            });
            return response;
            console.log(response);
        };
        $('.check').change(function(){
            $('.check').each(function(){
                var max = $(this).data('max');
                var id = $(this).data('id');
                var check = ajaxCheckVolzet(id);
                if (check === "true"){
                    $(this).prev().prev().val(max + '/' + max);
                    $(this).prop('disabled', true);
                    $(this).next().children().html('Volzet');
                }
                else{
                    $(this).prop('disabled', false); 
                }
            });
        });
        $('.check').each(function(){
            var count = $(this).data('count');
            var max = $(this).data('max');
            if (count >= max && !$(this).checked){
                $(this).prop('disabled', true);            }
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
            echo"<table>";
            echo "<tr><th>Taak</th><th>Shift</th><th>Tijd</th><th>Aantal inschrijvingen</th><th>Locatie</th><th>Ik wil helpen!</th></tr>";
            $teller = 0;
                foreach($shiften as $shift){     
                    $teller++;
                    echo "<tr><td>" . $shift->taak->naam .  "</td><td>" .  $shift->naam .  "</td>"
                            . "<td>" .  $shift->beginuur . " - " .  $shift->einduur .  "</td>"
                            . "<td>" .  $shift->deelnemers . '/' . $shift->maxAantal . "</td>"
                            . "<td>" .  $shift->taak->locatie->naam .  "</td>"
                            . "<td>" . form_checkbox(array('name' => 'shift[]', 'class' => 'check' , 'value' => $shift->id, 'data-count' => $shift->deelnemers, 'data-max' => $shift->maxAantal, 'data-id' => $shift->id)) .  "</td></tr>"
                            . "<td><div class='volzet'></div></td>";                     
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


