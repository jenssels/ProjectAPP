<?php
/**
 * @file overzichtFotos.php
 * 
 * View waarin een organisator de foto's in een album kan verwijderen of toevoegen
 */
?>
<script>
    function verwijderFoto(fotoId){
         $.ajax({type: "GET",
            url: site_url + "/organisator/verwijderAjaxFoto",
            data: {fotoId: fotoId},
            success: function (result) {
                
                $("#resultaat").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }
    
    $(document).ready(function () {
        var fotoId = ''; // globale variabele om later te kunnen gebruiken bij verwijderen
        $('.verwijderen').on('click', function() {
          fotoId = $(this).data('id');
          // modal wordt automatisch opgeroepen door data-toggle in knop
        });

        $('#knopVerwijder').click(function() {
          verwijderFoto(fotoId); 
          //location.reload();
        });

    });
</script>

<div id="resultaat">
    <div>
    <?php
    if ($titel == 'Album bekijken'){
        $bewerken = false;
        echo '<p>Op deze pagina vindt u alle afbeeldingen van het album: ';
        echo $album->naam;
        echo '</p>';
    } else {
        $bewerken = true;
        echo '<p>Op deze pagina kunt alle afbeeldingen bewerken van het album: ';
        echo $album->naam;
        echo '</p>';
        $attributenFormulier = array('id' => 'mijnFormulier',
        'role' => 'form');
        echo form_open_multipart('organisator/uploadFeestFotos', $attributenFormulier);
    
        echo '<div class="form-group">';
        echo form_hidden(array('albumId' => $albumId));
        echo form_labelpro("Foto's toevoegen aan album: ", 'fotos[]');
        echo form_input(array('name' => 'fotos[]',
            'id' => 'fotos[]',
            'type' => 'file',
            'multiple' => 'multiple'));
        echo '</div>';
        echo '<div class="form-group">';
        echo form_submit('doorgaan', 'Doorgaan', "class='btn btn-primary'");
        echo'</div>';
    }
    ?>
    </div>

<div>
    <?php
    //Stef Goor - Toon alle foto's van het huidige album
    $teller = 0;
    if($fotos != null){
        echo '<div class="row">';
        foreach ($fotos as $foto) {
            if ($teller == 3){
                echo '</div>';
                echo '<div class="row">';
                $teller = 0;
            }
            echo '<div class="card col-sm-4">';
            echo toonAfbeelding($foto->naam, 'class="card-img-top"');
        
            // Jorne Lambrechts - als er bewerkt mag worden, verwijder link tonen
            if ($bewerken) {
                echo '<button type="button" class="btn verwijderen" data-id="' . $foto->id . '" data-toggle="modal" data-target="#bevestigVerwijderen"><i class="fas fa-times"></i></button>';
            }
   
        echo '</div>';
        $teller++;
    }
    echo '</div>';
    } else {
        echo "<p>Er zijn nog geen foto's toegevoegd aan dit album!</p>";
    }
    
    echo anchor('organisator/overzichtAlbums', 'Terug naar overzicht albums', array('role' => 'button' , 'class' => 'btn btn-primary'));
    ?>
    
        <!--Modal dialog om het verwijderen van een album te bevestigen-->
    <div class="modal fade" id="bevestigVerwijderen" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Foto verwijderen</h4>
                </div>
                <div class="modal-body">
                    <p>Bent u zeker dat u deze foto wilt verwijderen?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="button">Annuleer</button>
                    <button class="btn btn-danger" id="knopVerwijder" type="button">Verwijder</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>