<script>
    $(document).ready(function(){
//        console.log('ready');
//        var datumNu =  new Date()
//        console.log(datumNu);
//        $(".form_datetime").datepicker({ dateFormat: "dd-mm-yy" });
//        $("#datum").value(datumNu);
    });
    
</script>
<?php
    echo haalJavascriptOp("validator.js");
    $attributenFormulier = array('id' => 'myform',
        'data-toggle' => 'validator',
        'role' => 'form');
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
        </div>
        <div class="form-group">
            <?php
            echo form_labelpro('Datum', 'datum');
            ?>
            <div class="input-group-date" data-provide="datepicker" id="datum1" data-date-format="dd/mm/yyyy" data-date-language = "nl-BE">
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
                <div class='help-block with-errors'>
                    
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php
            echo form_labelpro('Deadline', 'deadline');
            ?>
            <div class="input-group-date" data-provide="datepicker" id="datum1" data-date-format="dd/mm/yyyy" data-date-language = "nl-BE">
            <?php
            echo form_input(array('name' => 'deadline',
                'id' => 'datum',
                'value' => zetomnaarDDMMYYYY($feest->inschrijfdeadline),
                'class' => 'form-control', 
                'placeholder' => '00/00/0000', 
                'required' => 'required'));
            ?>
            </div>
        </div>
        <?php
        echo form_submit('knop', 'Verzenden', "class='btn btn-primary'");
        echo form_close();
        ?>
    </div>
</div>
