<table class="table">
    <?php
    if ($opties == null) {
        echo "niks";
    } else {
        echo "<tr>";
        echo "<th>Naam</th>";
        echo "<th>Beschrijving</th>";
        echo "<th>Max. deelnemers</th>";
        echo "<th>Min. deelnemers</th>";
        echo "</tr>";
        foreach ($opties as $optie) {
            echo "<tr><td>" . $optie->naam . "</td><td>" . $optie->beschrijving . "</td><td>" . $optie->maxAantal . "</td><td>" . $optie->minAantal . "</td></tr>";
        }
    }
    ?>
</table>

<!-- Roep dialoogvenster op via de knop -->
<button type="button" class="btn btn-primary" data-toggle="modal" id="knopVoegOptieToe" data-target="#exampleModal" data-id="<?php echo $dagindeling->id ?>">
  Toevoegen
</button>
