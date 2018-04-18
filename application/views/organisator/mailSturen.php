<?php
/**
 * @file mailSturen.php
 * 
 * View waarin een organisator een (uitnodigings)mail kan sturen naar mensen in het systeem 
 * 
 */
?>

<div>
    <?php echo haalJavascriptOp("validator.js"); ?>
    <form>
        <fieldset>
            <legend>Kies het juiste personeelsfeest</legend>
            <p>
                <label>Personeelsfeest:</label>

                <?php
                //select voor personeelsfeest
                $options1 = array();
                $options1[] = "-- Kies een personeelsfeest --";
                foreach ($personeelsfeesten as $personeelsfeest) {
                    $options1[$personeelsfeest->id] = $personeelsfeest->naam;
                }
                $attributes1 = array('id' => 'personeelsfeestSelect',
                    'class' => 'form-control');
                $js1 = 'onChange="some_function();"';
                echo "<div class='form-group'>";
                echo form_dropdown('personeelsfeestSelect', $options1, '', $attributes1, $js1);
                echo "</div>";
                
                //select voor soort
                $options2 = array();
                $options2[] = "-- Kies het soort gebruiker --";
                $options2[3] = 'Personeelsleden';
                $options2[2] = 'Vrijwilligers';
                $attributes2 = array('id' => 'soortSelect',
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