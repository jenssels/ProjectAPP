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
                <select id = "personeelsfeest">
                    <?php
                    foreach ($personeelsfeesten as $personeelsfeest) {
                        echo '<option value = "' + $personeelsfeest->id + '">' + $personeelsfeest->naam + '</option>';
                    }
                    ?>
                </select>
            </p>
        </fieldset>
    </form>
</div>