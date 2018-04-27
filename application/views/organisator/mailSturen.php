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
        }

        var optieSelect = document.getElementById("optieSelect");
        if (optieSelect.value !== 'niks') {
            var optieId = optieSelect.value;
            if (optieId !== 'niks') {
                optieSelect.disabled = false;
            }
        } else {
            optieSelect.value = 'niks';
            optieSelect.disabled = true;
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
                    <p>
                        <label>Soort:</label>
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
                    </p>
                </fieldset>
                <fieldset>
                    <p>
                        <label>Dagindeling:</label>
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
                    </p>
                </fieldset>
                <div id="optieResultaat"></div>
            </div>
            <div class="col">
                <div id="lijstResultaat"></div>

                <div class="form-group">
                    <label for="onderwerp">Onderwerp:</label>
                    <input type="text" class="form-control" id="inputOnderwerp" aria-describedby="onderwerpHelp" placeholder="Onderwerp">
                    <small id="onderwerpHelp" class="form-text text-muted">Vul hier het onderwerp van de mail in.</small>
                </div>
                <div class="form-group">
                    <label for="ontvangers">Ontvangers:</label>
                    <select multiple="true" disabled="true" class="form-control" id="inputInhoud" aria-describedby="ontvangersHelp" size="6">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                    </select>
                    <small id="ontvangersHelp" class="form-text text-muted">Een lijst van alle personen die de mail zullen ontvangen.</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="inhoud">Inhoud:</label>
                    <textarea class="form-control" rows="8" id="inputInhoud" aria-describedby="inhoudHelp" placeholder="Geef hier de inhoud van de mail op."></textarea>
                    <small id="inhoudHelp" class="form-text text-muted">Vul hier het onderwerp van de mail in.</small>
                </div>
            </div>
        </div>
    </form>
    <?php
    echo anchor('organisator/personeelsFeestOverzicht', 'Terug naar overzicht', array('role' => 'button', 'class' => 'btn btn-primary'));
    ?>
</div>