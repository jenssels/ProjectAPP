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
    function personeelsfeestSelectFunctie() {
        var e = document.getElementById("soortSelect");
        if (e.selectedIndex !== 0) {
                alert("yo");
        }
    }
    
    function soortSelectFunctie() {
        var e = document.getElementById("soortSelect");
        if (e.selectedIndex !== 0) {
                var id = e.selectedIndex;
                alert(id);
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
                $options2 = array();
                $options2[] = "-- Kies het soort gebruiker --";
                $options2[3] = 'Personeelsleden';
                $options2[2] = 'Vrijwilligers';
                $attributes2 = array('id' => 'soortSelect',
                    'onchange' => 'soortSelectFunctie()',
                    'class' => 'form-control');
                $js2 = 'onChange="some_function();"';
                echo "<div class='form-group'>";
                echo form_dropdown('soortSelect', $options2, '', $attributes2, $js2);
                echo "</div>";
                ?>
            </p>
        </fieldset>
    </form>
</div>