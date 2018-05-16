<?php
    /**
     * @file personeelsFeestUploaForm.php
     * Jens Sels - Pagina waarmee je personeelsleden kan toevoegen aan een personeelsfeest
     * - 1 ajax functie waarmee je een personeelslid kan toevoegen via een formulier en een andere ajax functie waarmee je een .xls bestand kan uploaden om meerdere personeelsleden toe te voegen
     * - gebruikt bootstrap en eigen css
     * - krijgt een personeelsfeest Id binnen
     */
?>
<script>
    $(document).ready(function () {
        function addPersoon(voornaam, naam, email) {
            $.ajax({type: "GET",
                url: site_url + "/Organisator/ajaxAddPersoon",
                data: {voornaam: voornaam, naam: naam, email: email},
                success: function (result) {
                    $('#uploadMessage').html(result);
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
            });
        }
        ;
        $('#uploadPersoon').submit(function (e) {
            e.preventDefault();
            var voornaam = $('#voornaam').val();
            var naam = $('#naam').val();
            var email = $('#email').val();
            addPersoon(voornaam, naam, email);
        });
        $('#uploadFile').submit(function (e) {
            var data = new FormData(this);
            e.preventDefault();
            $.ajax({
                url: site_url + '/organisator/ajaxUploadFile',
                method: "POST",
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (result) {
                    $('#uploadMessage').html(result);
                },
            });
            return false;
        });
    });
</script>


<div class="row">
    <div class="col-md-6">
        <p>Hier kan je een personeelslijst uit Excel importeren</p>

        <?php
        $attributenFormulier = array('id' => 'uploadFile',
            'role' => 'form');
        echo form_open('', $attributenFormulier);
        echo form_labelpro('Upload excel (.xls):', 'excel');
        ?>
        <div class="form-group">
            <?php
            echo form_input(array('name' => 'excel',
                'id' => 'excel',
                'type' => 'file',
                'required' => 'required'));
            ?>                    
        </div>
        <div class="form-group">
            <?php
            echo form_submit('knop', 'Upload', "class='btn btn-primary'");
            echo form_close();
            ?>

        </div>
    </div>
    <div class="col-md-6">
            <p>Zorg ervoor dat uw excel deze 3 kolommen heeft: Voornaam, Naam, Email</p>
            <p>Download hier een voorbeeld excel: </p>
            <p> <?php echo anchor('home/downloadBestand/Voorbeeld.xls', 'Download', "class='btn btn-primary'") ?></p>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6">
        <p>Manueel een personeelslid toevoegen</p>
        <?php
        $attributenFormulier2 = array('id' => 'uploadPersoon',
            'role' => 'form');
        echo form_open('', $attributenFormulier2);
        ?>
        <div class="form-group">
            <?php
            echo form_labelpro('Voornaam', 'voornaam');
            echo form_input(array('voornaam' => 'voornaam',
                'id' => 'voornaam',
                'class' => 'form-control',
                'placeholder' => 'Naam',
                'required' => 'required'));
            ?>
            <div class='help-block with-errors'>

            </div>
        </div>
        <div class="form-group">
            <?php
            echo form_labelpro('Naam', 'naam');
            echo form_input(array('name' => 'naam',
                'id' => 'naam',
                'class' => 'form-control',
                'placeholder' => 'Naam',
                'required' => 'required'));
            ?>
            <div class='help-block with-errors'>

            </div>
        </div>
        <div class="form-group">
            <?php
            echo form_labelpro('Email', 'email');
            echo form_input(array('email' => 'email',
                'id' => 'email',
                'type' => 'email',
                'class' => 'form-control',
                'placeholder' => 'Beschrijving',
                'required' => 'required'));
            ?>
            <div class='help-block with-errors'>

            </div>
        </div>
        <div class="form-group">
            <?php
            echo form_submit('knop', 'Voeg toe', 'class="btn btn-primary"');
            echo form_close();
            ?>
        </div>
        <p>
            <?php
            echo anchor('/organisator/personeelsFeestOverzicht', 'Terug naar overzicht');
            ?>
        </p>

    </div>
    <div id="uploadMessage" class="col-md-6">
        
    </div>
</div>

