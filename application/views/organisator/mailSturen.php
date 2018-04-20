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
        if (soortSelect.value !== 'niks') {
            var soortId = soortSelect.selectedIndex;
            if (soortId !== 'niks') {
                dagindelingSelect.disabled = false;
            }
        } else {
            dagindelingSelect.value = 'niks';
            dagindelingSelect.disabled = true;
        }
    }

    function dagindelingSelectFunctie() {
        var dagindelingSelect = document.getElementById("dagindelingSelect");
        if (dagindelingSelect.value !== 'niks') {
            var dagindelingId = dagindelingSelect.selectedIndex;
            if (dagindelingId === 'alles') {
                //Alle dagindelingen zijn geselecteerd
            }
            $.ajax({type: "GET",
                url: site_url + "/organisator/haalAjaxOp_SelectOptiesBijDagindeling",
                data: {dagindelingId: dagindelingId},
                success: function (result) {
                    $("#optieResultaat").html(result);
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
            });
        }
    }
</script>

<div>
    <form>
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
    </form>
    <?php
    echo anchor('organisator/personeelsFeestOverzicht', 'Terug naar overzicht', array('role' => 'button', 'class' => 'btn btn-primary'));
    ?>
</div>