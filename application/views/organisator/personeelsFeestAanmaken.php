<script>
    $(document).ready(function () {
        /**
         * Jens Sels - Formaat en taal toevoegen aan datepickers
         */
        
        // Default settings van datepicker aanpassen
        var datumNu = new Date(); 
        $.fn.datepicker.defaults.format = 'dd/mm/yyyy';
        $.fn.datepicker.defaults.language = 'nl-BE';
        $.fn.datepicker.defaults.autoclose = true;
        
        function CheckDate(){
          var datum = $('#datum').datepicker("getDate");
          var inschrijfDatum = $('#inschrijfdeadline').datepicker("getDate");
          if (datum < inschrijfDatum){
              $('#inschrijfdeadline').datepicker('update', datum);
          }
        };
        
        $(function(){
            $('#datum, #inschrijfdeadline').datepicker({
                startDate: datumNu
            }).on('changeDate', function(){
                CheckDate();
            });

        });
        $(function () {
            $('[data-toggle="popover"]').popover();
        });
        
        
    });


</script>
<?php
/**
 * Jens Sels - Inladen van validator
 */
echo haalJavascriptOp("validator.js");
$attributenFormulier = array('id' => 'myform',
    'data-toggle' => 'validator',
    'role' => 'form');
/**
 * Jens Sels - Formulier voor personeelsfeesten te bewerken/aanmaken
 */
echo form_open('organisator/personeelsFeestAanmaken', $attributenFormulier);
?>

<?php
$tooltipNaamTitel = "Hulp bij naam";
$tooltipNaamInhoud = "Vul een duidelijke naam in. Dit kan bijvoorbeeld 'Personeelsfeest 2019' zijn.";
$tooltipBeschrijvingTitel = "Hulp bij beschrijving";
$tooltipBeschrijvingInhoud = "Geef een beschrijving van het personeelsfeest. Dit kan bijvoorbeeld zijn waar het plaatsvindt en om welke reden.";
$tooltipDatumTitel = "Hulp bij datum";
$tooltipDatumInhoud = "Dit is de datum waarop het personeelsfeest zal plaatsvinden.";
$tooltipDeadlineTitel = "Hulp bij inschrijfdeadline";
$tooltipDeadlineInhoud = "Dit is de datum waarop de inschrijvingen zullen sluiten.";
?>

<div class="form-group row">
    <?php
    echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $feest->id));
    ?>
</div>



<div class="form-group row">
    <div class="col-md-2">
        <?php
        echo form_labelpro('Naam', 'naam');
        ?>
    </div>
    <div class="col-md-9">
        <?php
        echo form_input(array('name' => 'naam',
            'id' => 'naam',
            'value' => $feest->naam,
            'class' => 'form-control',
            'placeholder' => 'Naam',
            'required' => 'required'));
        ?>
        <div class='help-block with-errors'>

        </div>
    </div>
    <div class="col-md-1">
        <button type="button" class="btn " data-toggle="popover" title="<?php echo $tooltipNaamTitel; ?>" data-content="<?php echo $tooltipNaamInhoud; ?>"><i class="fas fa-question"></i></button>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-2">
        <?php
        echo form_labelpro('Beschrijving', 'beschrijving');
        ?>
    </div>
    <div class="col-md-9">
        <?php
        echo form_textarea(array('name' => 'beschrijving',
            'id' => 'beschrijving',
            'value' => $feest->beschrijving,
            'class' => 'form-control',
            'placeholder' => 'Beschrijving'));
        ?>
        <div class='help-block with-errors'>

        </div>
    </div>
    <div class="col-md-1">
        <button type="button" class="btn " data-toggle="popover" title="<?php echo $tooltipBeschrijvingTitel; ?>" data-content="<?php echo $tooltipBeschrijvingInhoud; ?>"><i class="fas fa-question"></i></button>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-2">
        <?php
        echo form_labelpro('Datum', 'datum');
        ?>
    </div>
    <div class="col-md-9">
        <div class="input-group date">
            <?php
            echo form_input(array('name' => 'datum',
                'id' => 'datum',
                'value' => zetomnaarDDMMYYYY($feest->datum),
                'class' => 'form-control',
                'placeholder' => '00/00/0000',
                'required' => 'required'));
            ?>
            <div class="input-group-addon">
            </div>

        </div>
        <div class='help-block with-errors'>

        </div>
    </div>
    <div class="col-md-1">
<button type="button" class="btn " data-toggle="popover" title="<?php echo $tooltipDatumTitel; ?>" data-content="<?php echo $tooltipDatumInhoud; ?>"><i class="fas fa-question"></i></button>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-2">
        <?php
        echo form_labelpro('Inschrijf deadline', 'inschrijfdeadline');
        ?>
    </div>
    <div class="col-md-9">
        <div class="input-group date">
            <?php
            echo form_input(array('name' => 'inschrijfdeadline',
                'id' => 'inschrijfdeadline',
                'value' => zetomnaarDDMMYYYY($feest->inschrijfdeadline),
                'class' => 'form-control',
                'placeholder' => '00/00/0000',
                'required' => 'required'));
            ?>
            <div class="input-group-addon">
            </div>
            <div class='help-block with-errors'>

            </div>
        </div>
    </div>
    <div class="col-md-1">
<button type="button" class="btn " data-toggle="popover" title="<?php echo $tooltipDeadlineTitel; ?>" data-content="<?php echo $tooltipDeadlineInhoud; ?>"><i class="fas fa-question"></i></button>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <?php echo form_submit('knop', 'Verzenden', "class='btn btn-primary'");
        echo anchor('Organisator/personeelsFeestOverzicht', 'Annuleer', "class='btn btn-primary'"); ?>
    </div>    
</div>
<?php

echo form_close();

?>
