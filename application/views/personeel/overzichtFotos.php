<?php
/**
 * @file overzichtAlbums.php
 * 
 * View waarin een personeelslid/vrijwilliger het overzicht van de albums kan bekijken
 */
?>

<div class="page-header">
    <h1>Overzicht fotos</h1>
</div>

<div>
    <?php
        echo '<p>Op deze pagina vindt u alle afbeeldingen van het album: ';
        echo $album->naam;
        echo '</p>';
    ?>
</div>

<div>
    <?php
    //Stef Goor - Toon alle foto's van het huidige album
    echo '<div class="row">';
    foreach ($fotos as $foto) {
        echo '<div class="afbeeldingVeld col-sm">';
        echo toonAfbeelding($foto->naam, 'class="card-img-top img-thumbnail rounded img-fluid"');
        echo '</div>';
    }
    echo '</div>';
    echo anchor('personeel/overzichtAlbums', 'Terug naar overzicht albums')
    ?>
</div>