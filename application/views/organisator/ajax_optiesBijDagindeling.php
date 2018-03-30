<table class="table">
    <tr>
        <th>Naam</th>
        <th>Beschrijving</th>
        <th>Max. deelnemers</th>
        <th>Min. deelnemers</th>
    </tr>
    <?php
    foreach ($opties as $optie) {
        echo "<tr><td>" . $optie->naam . "</td><td>" . $optie->beschrijving . "</td><td>" . $optie->maxAantal . "</td><td>" . $optie->minAantal . "</td></tr>";
    }
    ?>
</table>

