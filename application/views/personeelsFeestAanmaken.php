<script>
    $(document).ready(function(){
        /**
         * Jens Sels - Formaat en taal toevoegen aan datepickers
         */
        $( ".date" ).datepicker({
            format: 'dd/mm/yyyy',
            language: 'nl-BE'
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
<div class="row">
    <div class="col-md-12">
        
        <div class="form-group">
            <?php 
            echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $feest->id));
            ?>
        </div>
        <div class="form-group">
            <?php
                echo form_labelpro('Naam', 'naam');
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
        <div class="form-group">
            <?php
                echo form_labelpro('Beschrijving', 'beschrijving');
                echo form_textarea(array('name' => 'beschrijving',
                    'id' => 'beschrijving', 
                    'value' => $feest->beschrijving, 
                    'class' => 'form-control', 
                    'placeholder' => 'Beschrijving', 
                    'required' => 'required'));
            ?>
            <div class='help-block with-errors'>
                    
            </div>
        </div>
        <div class="form-group">
            <?php
            echo form_labelpro('Datum', 'datum');
            ?>
            <div class="input-group date" data-provide="datepicker">
            <?php
            echo form_input(array('name' => 'datum',
                'id' => 'datum',
                'value' => zetomnaarDDMMYYYY($feest->datum),
                'class' => 'form-control', 
                'placeholder' => '00/00/0000', 
                'required' => 'required'));
            ?>
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calander"></span>
                </div>

            </div>
                <div class='help-block with-errors'>
                    
                </div>
        </div>
        <div class="form-group">
            <?php
            echo form_labelpro('Inschrijf deadline', 'inschrijfdeadline');
            ?>
            <div class="input-group date" data-provide="datepicker">
            <?php
            echo form_input(array('name' => 'inschrijfdeadline',
                'id' => 'inschrijfdeadline',
                'value' => zetomnaarDDMMYYYY($feest->inschrijfdeadline),
                'class' => 'form-control', 
                'placeholder' => '00/00/0000', 
                'required' => 'required'));
            ?>
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calander"></span>
                </div>
            </div>
            <div class='help-block with-errors'>
                    
            </div>
        </div>
        <?php
        echo form_submit('knop', 'Verzenden', "class='btn btn-primary'");
        echo form_close();
        echo anchor('Organisator/personeelsFeestOverzicht', 'Annuleer',"class='btn btn-primary'");
        ?>
    </div>
</div>
