<?php
/**
 * @file overzichtAlbums.php
 * 
 * View waarin een personeelslid het overzicht van de albums kan bekijken
 */
?>

<div>
    <p>Op deze pagina vindt u het overzicht van fotoalbums van de vorige personeelsfeesten. Zo kan u alvast eens de sfeer opsnuiven van de vorige jaren.</p>
</div>

<div>
    <?php    
    //Stef Goor - Toon alle albums met hun foto
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
        echo '<p class="card-text">Bekijk hier alle fotos van dit album!</p>';
        echo '<a href="'. base_url() . 'index.php/personeel/toonAlbum/' . $album->id .'" class="btn btn-primary">Bekijk de fotos!</a>';
        echo '</div></div></div><br>';
    }
    echo '</div>';
    
    $hashcode = $this->session->userdata('gebruikerHashcode'); 
    echo anchor('personeel/controleerDagindelingIsIngevuld/' . $hashcode, 'Terug', array('role' => 'button', 'class' => 'btn btn-primary'));
    ?>
</div>

<div>
    
</div>