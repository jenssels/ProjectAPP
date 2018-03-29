<?php
/**
 * @file beheerDagindeling.php
 * 
 * View waarin de dagindeling van een bepaald personeelsfeest getoond. 
 * Je kan van hieruit de dagindeling bewerken.
 * 
 */
?>

<div class="page-header">
    <h1><?php echo $titel; ?></h1>
</div>

<div>
    <p>Dit is de dagindeling van <?php echo $personeelsfeest->naam ?></p>
    <table class="table">
        <tr>
            <th>Naam</th>
            <th>Uur</th>
            <th>Voor vrijwilliger</th>
            <th></th>
            <th></th>
        </tr>
        <?php
        foreach ($dagindelingenBijFeest as $dagindeling) {
            if ($dagindeling->voorVrijwilliger == 0) {
                $voorVrijwilliger = 'Nee';
            } else {
                $voorVrijwilliger = 'Ja';
            }
            
            echo "<tr><td>" . $dagindeling->naam  . "</td><td>" . $dagindeling->beginuur . " - " .$dagindeling->einduur . 
                    "</td><td>" . $voorVrijwilliger . "</td><td>" . anchor('?', 'Bewerken') . "</td><td>" . anchor('organisator/verwijderDagindeling/' .$personeelsfeest->id . '/' .$dagindeling->id, 'Verwijderen') . "</td></tr>";
        }
        ?>
        <tr>
            <td><?php echo anchor('organisator/toevoegenDagindeling/' . $personeelsfeest->id, 'Toevoegen') ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>