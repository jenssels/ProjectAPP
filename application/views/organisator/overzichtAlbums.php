<?php
/**
 * @file overzichtAlbums.php
 * 
 * View waarin een organisator het overzicht van de albums kan bekijken
 */
?>

<script>
    /*var sURL = decodeURI(window.location.pathname);

    function refresh()
    {
        window.location.href = sURL;
    }*/
    
    function verwijderAlbum(albumId){
         $.ajax({type: "GET",
            url: site_url + "/organisator/verwijderAjaxAlbum",
            data: {albumId: albumId},
            success: function (result) {
                
                $("#resultaat").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }
    
    $(document).ready(function () {
        var albumId = ''; // globale variabele om later te kunnen gebruiken bij verwijderen
        $('.verwijderen').on('click', function() {
          albumId = $(this).data('id');
          // modal wordt automatisch opgeroepen door data-toggle in knop
        });

        $('#knopVerwijder').click(function(e) {
           //if (confirm("Ben je zeker dat je dit album wilt verwijderen")){
           verwijderAlbum(albumId); 
           /*}
           else {
               e.preventDefault();
           }
          
          //location.reload();*/
        });

    });

</script>
<div id="resultaat">
<!--<div class="page-header">
    <h1>Overzicht albums</h1>
</div>-->

<div>
    <p>Op deze pagina vindt u het overzicht van fotoalbums van de vorige personeelsfeesten. Zo kan u alvast eens de sfeer opsnuiven van de vorige jaren.</p>
</div>

<div>
    <?php
    //Stef Goor - Toon alle albums met hun foto
    if ($albums != null) {
        echo '<div class="row">';
        foreach ($albums as $album) {
            echo '<div class="col-sm">';
            echo '<div class="card" style="width: 18rem;">';
            //Als er geen fotos in het album zitten wordt er geen foto getoond
            if($album->eersteFoto != NULL){
                echo toonAfbeelding($album->eersteFoto, 'class="card-img-top"');
            }
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $album->naam . '</h5>';
            echo '<p class="card-text">Bekijk hier alle foto\'s van dit album!</p>';
            echo anchor('organisator/toonAlbum/' . $album->id, '<button type="button" class="btn btn-primary">Bekijk de foto\'s!</button>');
            echo '</div>';
            //Jorne Lambrechts - knoppen om album te bewerken of te verwijderen
            echo '<div class="text-center">';
            echo anchor('organisator/albumBewerken/' . $album->id,'<button type="button" class="btn btn-primary"><i class="fas fa-edit"></i></button>');
            echo "\t";
            echo '<button type="button" class="btn btn-primary verwijderen" data-id="' . $album->id . '" data-toggle="modal" data-target="#bevestigVerwijderen"><i class="fas fa-times"></i></button>';
        
            echo '</div>';
            echo'</div></div><br>';
        }
        echo '</div>';
    } else {
        echo '<p>Er zijn geen albums om weer te geven';
    }
   
    //Jorne Lambrechts - knop om naar het aanmaken van albums te gaan
    echo '<div>'. anchor ('organisator/maakAlbum', 'Album aanmaken', 'class="btn btn-primary"') . '</div>';
    ?>
    
    <!--Modal dialog om het verwijderen van een album te bevestigen-->
    <div class="modal fade" id="bevestigVerwijderen" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Album verwijderen</h4>
                </div>
                <div class="modal-body">
                    <p>Bent u zeker dat u dit Album wilt verwijderen?</p>
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