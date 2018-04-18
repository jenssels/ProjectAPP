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
        var e = document.getElementById("soortSelect");
        if (e.selectedIndex !== 0) {
            var soortId = e.selectedIndex;
            alert(soortId);
        }
    }

    function dagindelingSelectFunctie() {
        var e = document.getElementById("dagindelingSelect");
        if (e.selectedIndex !== 0) {
            var dagindelingId = e.selectedIndex;
            if (dagindelingId === 1){
                alert(Alle dagindelingen worden doorgegeven!);
            }
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
                    'class' => 'form-control');
                echo "<div class='form-group'>";
                echo form_dropdown('dagindelingSelect', $options2, '', $attributes2);
                echo "</div>";
                ?>
            </p>
        </fieldset>
    </form>
    <?php
    echo anchor('organisator/personeelsFeestOverzicht', 'Terug naar overzicht', array('role' => 'button' , 'class' => 'btn btn-primary'));
    ?>
</div>