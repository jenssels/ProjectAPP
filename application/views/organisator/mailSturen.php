<?php
/**
 * @file mailSturen.php
 * 
 * View waarin een organisator een (uitnodigings)mail kan sturen naar mensen in het systeem 
 * 
 */
?>

<?php echo haalJavascriptOp("validator.js"); ?>

<script type="text/javascript">
    function soortSelectFunctie() {
        var soortSelect = document.getElementById("soortSelect");
        var dagindelingSelect = document.getElementById("dagindelingSelect");
        var optieSelect = document.getElementById("optieSelect");

        if (soortSelect.value !== 'niks') {
            var soortId = soortSelect.value;
            if (soortId !== 'niks') {
                dagindelingSelect.disabled = false;
                optieSelect.disabled = false;
            }
        } else {
            dagindelingSelect.value = 'niks';
            dagindelingSelect.disabled = true;
            optieSelect.value = 'niks';
            optieSelect.disabled = true;
        }
    }

    function dagindelingSelectFunctie() {
        var dagindelingSelect = document.getElementById("dagindelingSelect");

        if (dagindelingSelect.value !== 'niks') {
            var dagindelingId = dagindelingSelect.value;
            if (dagindelingId === 'alles') {
                //Alle dagindelingen zijn geselecteerd
                var feestId = document.getElementById("feestId").value;
                $.ajax({type: "GET",
                    url: site_url + "/organisator/haalAjaxOp_SelectOptiesBijDagindeling",
                    data: {feestId: feestId, dagindelingId: dagindelingId},
                    success: function (result) {
                        $("#optieResultaat").html(result);
                    },
                    error: function (xhr, status, error) {
                        alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                    }
                });
            }
            var feestId = document.getElementById("feestId").value;
            $.ajax({type: "GET",
                url: site_url + "/organisator/haalAjaxOp_SelectOptiesBijDagindeling",
                data: {dagindelingId: dagindelingId, feestId: feestId},
                success: function (result) {
                    $("#optieResultaat").html(result);
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
            });
        } else {
            var optieSelect = document.getElementById("optieSelect");
            var optieId = optieSelect.value;
            if (optieId !== 'niks') {
                optieSelect.disabled = true;
                optieSelect.value = 'niks';
            } else {
                optieSelect.disabled = false;
            }
        }
    }

    function optieSelectFunctie() {

    }
</script>

<div class="container">
    <form>
        <?php
        //Verborgen veld om Id van personeelsfest me te kunnen geven
        echo '<input type="hidden" id="feestId" name="feestId" value="' . $feestId . '">';
        ?>
        <div class="row">
            <div class="col">
                <fieldset>
                    <div class="form-group">
                        <label for="soortSelect">Soort:</label>
                        <?php
                        //select voor soort
                        $options1 = array();
                        $options1['niks'] = "-- Kies het soort gebruiker --";
                        $options1['iedereen'] = "Iedereen";
                        $options1[3] = 'Personeelsleden';
                        $options1[2] = 'Vrijwilligers';
                        $attributes1 = array('id' => 'soortSelect',
                            'onchange' => 'soortSelectFunctie()',
                            'class' => 'form-control');
                        echo "<div class='form-group'>";
                        echo form_dropdown('soortSelect', $options1, '', $attributes1);
                        echo "</div>";
                        ?>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="form-group">
                        <label for="dagindelingSelect">Dagindeling:</label>
                        <?php
                        //select voor dagindeling
                        $options2 = array();
                        $options2['niks'] = "-- Kies een dagindeling --";
                        $options2['alles'] = "Alle dagindelingen";
                        foreach ($dagindelingen as $dagindeling) {
                            $options2[$dagindeling->id] = $dagindeling->naam;
                        }
                        $attributes2 = array('id' => 'dagindelingSelect',
                            'onchange' => 'dagindelingSelectFunctie()',
                            'class' => 'form-control',
                            'disabled' => 'true');
                        echo "<div class='form-group'>";
                        echo form_dropdown('dagindelingSelect', $options2, '', $attributes2);
                        echo "</div>";
                        ?>
                    </div>
                </fieldset>
                <div id="optieResultaat"></div>
            </div>
            <div class="col">
                <div id="lijstResultaat"></div>
                <div class="form-group">
                    <label for="ontvangers">Ontvangers:</label>
                    <select multiple="true" disabled="true" class="form-control" id="inputInhoud" aria-describedby="ontvangersHelp" size="9">
                        <option value="1">Joren</option>
                        <option>Jens</option>
                        <option>Stef</option>
                        <option>Jorne</option>
                        <option>Florian</option>
                        <option>Henk</option>
                        <option>Lise</option>
                        <option>Jolien</option>
                    </select>
                    <small id="ontvangersHelp" class="form-text text-muted">Een lijst van alle personen die de mail zullen ontvangen.</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="onderwerp">Onderwerp:</label>
                    <input type="text" class="form-control" id="inputOnderwerp" aria-describedby="onderwerpHelp" placeholder="Onderwerp">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="inhoud">Inhoud:</label>
                    <textarea class="form-control" rows="8" id="inputInhoud" aria-describedby="inhoudHelp" placeholder="Geef hier de inhoud van de mail op."></textarea>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" id="checkboxUitnodiging" name="checkboxUitnodiging" value="">Uitnodogingslink genereren.</label>
                </div>
            </div>
        </div>
    </form>

    <!-- Help Modal -->
    <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hulp bij mail sturen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Filteren</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo toonAfbeelding('../img/help1.png', 'width=100%'); ?>
                        </div>
                        <div class="col-md-6">
                            <p>Om te beginnen kunt u filteren op het soort gebruiker.</p>
                            <ul>
                                <li>Iedereen: u stuurt een mail naar zowel de personeelsleden als de vrijwilligers.</li>
                                <li>Personeelsleden: u stuurt een mail met enkel de personeelsleden als ontvangers.</li>
                                <li>Vrijwilligers: u stuurt een mail met enkel de vrijwilligers als ontvangers.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p>Als tweede kunt u filteren op dagindeling.</p>
                            <ul>
                                <li>Alle dagindelingen: u stuurt een mail naar alle personen die zijn ingeschreven zijn voor eender welke dagindeling.</li>
                                <li>U selecteerd een dagindeling: u stuurt een mail naar de personen die ingeschreven voor deze dagindeling.</li>
                            </ul>
                        </div>
                        <div class="col-md-6">                            
                            <?php echo toonAfbeelding('../img/help2.png', 'width=100%'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo toonAfbeelding('../img/help3.png', 'width=100%'); ?>
                        </div>
                        <div class="col-md-6">
                            <p>Als laatste kunt u filteren op optie.</p>
                            <ul>
                                <li>Alle opties: u stuurt een mail naar alle personen die ingeschreven zijn voor eender welke optie.</li>
                                <li>U selecteert een optie: u stuurt een mail naar de personen die ingeschreven zijn voor deze optie.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Lijst van ontvangers</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo toonAfbeelding('../img/help4.png', 'width=100%'); ?>
                        </div>
                        <div class="col-md-6">
                            <p>Dit is de lijst van alle ontvangers.</p>
                            <p>Deze lijst past zich automatisch aan wanneer u filtert. Op deze manier kunt u controleren of u de mail naar de juiste
                                personen stuurt.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Mailinhoud</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">                            
                            <?php echo toonAfbeelding('../img/help5.png', 'width=100%'); ?>
                        </div>
                        <div class="col-md-6">
                            <p>Bij onderwerp vult u het onderwerp van de mail in.</p>
                            <p>De inhoud kunt u zelf kiezen. Je kan hier bijvoorbeeld contactgegevens zetten. Daarnaast kan je ook een persoonlijke
                                boodschap aan de ontvangers meegeven.</p>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Uitnodigingslink</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">                            
                            <?php echo toonAfbeelding('../img/help6.png', 'width=100%'); ?>
                        </div>
                        <div class="col-md-6">
                            <p>Deze optie is optioneel. Wanneer u ze aanvinkt zal er op het einde van de mail een persoonlijke link
                                gegenereerd worden waarmee de gebruikers zich kunnen inschrijven. Deze link wordt automatisch door het systeem gegenereerd.</p>                           
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <?php
        echo '<div class="col-sm-4">';
        echo anchor('organisator/personeelsFeestOverzicht', 'Terug naar overzicht', array('role' => 'button', 'class' => 'btn btn-primary'));
        echo '</div>';

        echo '<div class="col-sm-4 text-center">';
        echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#helpModal">Help</button>';
        echo '</div>';

        echo '<div class="col-sm-4">';
        echo anchor('', 'Stuur mail!', array('role' => 'button', 'class' => 'btn btn-primary float-right'));
        echo '</div>';
        ?>
    </div>
</div>