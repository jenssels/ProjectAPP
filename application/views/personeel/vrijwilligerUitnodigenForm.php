<script>
$(document).ready(function () {
    function nodigVrijwilligerUit(voornaam, naam, mail) {
            $.ajax({type: "GET",
                url: site_url + "/Personeel/ajaxNodigVrijwilligerUit",
                data: {voornaam: voornaam, naam: naam, mail: mail},
                success: function (result) {
                    $('#result').html(result);
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
            });
        }
    $('#myform').submit(function(e){
        e.preventDefault();
        var voorNaam = $('#voorNaam').val();
        var naam = $('#naam').val();
        var mail = $('#mail').val();
        nodigVrijwilligerUit(voorNaam, naam, mail);
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

echo form_open('', $attributenFormulier);
?>

<div class="form-group row">
    <div class="col-md-2">
        <?php
        echo form_labelpro('Voornaam', 'voorNaam');
        ?>
    </div>
    <div class="col-md-9">
        <?php
        echo form_input(array('name' => 'voorNaam',
            'id' => 'voorNaam',
            'class' => 'form-control',
            'placeholder' => 'Voornaam',
            'required' => 'required'));
        ?>
        <div class='help-block with-errors'>

        </div>
    </div>
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
            'class' => 'form-control',
            'placeholder' => 'Naam',
            'required' => 'required'));
        ?>
        <div class='help-block with-errors'>

        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-2">
        <?php
        echo form_labelpro('Email', 'mail');
        ?>
    </div>
    <div class="col-md-9">
            <?php
            echo form_input(array('name' => 'mail',
                'id' => 'mail',
                'class' => 'form-control',
                'type' => 'email',
                'placeholder' => 'Mail',
                'required' => 'required'));
            ?>
        <div class='help-block with-errors'>

        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <?php echo form_submit('knop', 'Uitnodigen', "class='btn btn-primary'");?>
    </div>    
</div>
<?php
echo form_close();
?>
<div id="result">
</div>
