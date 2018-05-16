<?php
/**
 * @file overzichtFotos.php
 * 
 * View waarin een personeelslid het overzicht van de fotos kan bekijken
 */
?>

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
    $teller = 0;
    echo '<div class="row">';
    foreach ($fotos as $foto) {
        if ($teller == 3){
            echo '</div>';
            echo '<div class="row">';
            $teller = 0;
        }
        echo '<div class="afbeeldingVeld col-sm-4">';
        echo toonAfbeelding($foto->naam, 'class="card-img-top img-thumbnail rounded img-fluid"');
        echo '</div>';
        $teller++;
    }
    echo '</div>';
    echo anchor('personeel/overzichtAlbums', 'Terug naar overzicht albums', array('role' => 'button' , 'class' => 'btn btn-primary'));
    ?>
</div>