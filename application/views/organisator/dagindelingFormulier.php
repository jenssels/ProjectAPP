<?php
/**
 * @file toevoegenDagindeling.php
 * 
 * View waarin een formulier getoond wordt om een dagindeling toe te voegen. 
 * 
 */
?>

<div>
    <?php echo haalJavascriptOp("validator.js"); ?>

    <?php
    $attributenFormulier = array('id' => 'mijnFormulier',
        'role' => 'form');
    echo form_open('organisator/registreerDagindeling', $attributenFormulier)
    ?>

    <div class="form-group row">
        <?php
        echo form_label('Naam', 'naam', array('class' => 'col-sm-2 col-form-label'));
        ?>
        <div class="col-sm-10">
            <?php
            echo form_input(array('name' => 'naam',
                'id' => 'naam',
                'value' => $dagindeling->naam,
                'class' => 'form-control',
                'placeholder' => 'Naam',
                'required' => 'required'));
            ?>
        </div>
    </div>

    <div class="form-group row">
        <?php
        echo form_label('Beginuur', 'beginuur', array('class' => 'col-sm-2 col-form-label'));
        ?>
        <div class="col-sm-10">
            <?php
            echo form_input(array('name' => 'beginuur',
                'id' => 'beginuur',
                'value' => $dagindeling->beginuur,
                'class' => 'form-control',
                'placeholder' => 'hh:mm',
                'required' => 'required'));
            ?>
        </div>
    </div>

    <div class="form-group row">
        <?php
        echo form_label('Einduur', 'einduur', array('class' => 'col-sm-2 col-form-label'));
        ?>
        <div class="col-sm-10">
            <?php
            echo form_input(array('name' => 'einduur',
                'id' => 'einduur',
                'value' => $dagindeling->einduur,
                'class' => 'form-control',
                'placeholder' => 'hh:mm',
                'required' => 'required'));
            ?>
        </div>
    </div>

    <div class="form-group row">
        <?php
        echo form_label('Beschrijving', 'beschrijving', array('class' => 'col-sm-2 col-form-label'));
        ?>
        <div class="col-sm-10">
            <?php
            echo form_textarea(array('name' => 'beschrijving',
                'id' => 'beschrijving',
                'value' => $dagindeling->beschrijving,
                'class' => 'form-control'));
            ?>
        </div>
    </div>

    <fieldset class="form-group" id="voorVrijwilliger" name="voorVrijwilliger">
        <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Voor vrijwilliger</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="voorVrijwilliger" id="ja" value="1" checked>
                    <label class="form-check-label" for="ja">
                        Ja
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="voorVrijwilliger" id="nee" value="0">
                    <label class="form-check-label" for="nee">
                        Nee
                    </label>
                </div>
            </div>
        </div>
    </fieldset>

    <?php
    echo form_hidden('personeelsfeestId', $personeelsfeest->id);
    ?>

    <?php
    echo form_hidden('dagindelingId', $dagindeling->id);
    ?>

    <div class="form-group">
        <?php echo form_submit('knop', 'Bevestigen', "class='btn btn-primary'") ?>
        <?php echo form_submit('knop', 'Annuleren', "class='btn btn-primary'") ?>
    </div>


    <?php echo form_close(); ?>
</div>