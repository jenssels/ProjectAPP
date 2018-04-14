<?php
/**
 * @file beheerOrganisatoren.php
 * 
 * View waarin de organisatoren worden getoond. 
 * Van hieruit kan je de organistoren beheren.
 * 
 */
?>

<div class="row">
    <div class="page-header col-sm-12 pb-2">
        <h1><?php echo $titel; ?></h1>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <table class="table">
            <tr>
                <th>Naam voornaam</th>
                <th>Email</th>
                <th></th>
            </tr>
            <?php
            foreach ($organisatoren as $organisator) {
                echo "<tr>";
                echo "<td>" . $organisator->voornaam . " " . $organisator->naam . "</td>";
                echo "<td>" . $organisator->email . "</td>";
                echo "<td>" . anchor('#', 'Verwijderen') . "</td>";
                echo "</tr>";
            }
            ?>
            <td><?php echo anchor('organisator/maakNieuweOrganisator', 'Toevoegen') ?></td>
            <td></td>
            <td></td>
        </table>
    </div>
</div>
