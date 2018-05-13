<script>
    $(document).ready(function () {
        $('.voegOptieToeLink').click(function (e) {
            e.preventDefault();
        });
    });
</script>

<h5>
    Opties
</h5>
<?php
if (count($opties) > 0) {
    echo "<table class='table'>";
    echo "<tr>";
    echo "<th>Naam</th><th>Beschrijving</th><th>Maximum aantal</th><th>Minimum aantal</th><th>Locatie</th><th></th><th></th>";
    echo "</tr>";
    foreach ($opties as $optie) {
        echo "<tr>";
        echo "<td>" . $optie->naam . "</td>";
        echo "<td>" . $optie->beschrijving . "</td>";
        echo "<td>" . $optie->maxAantal . "</td>";
        echo "<td>" . $optie->minAantal . "</td>";
        echo "<td>" . $optie->locatieId . "</td>";
        echo "<td>" . anchor('', 'bewerken') . "</td>";
        echo "<td>" . anchor('', 'verwijderen') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Er zijn nog geen opties bij deze dagindeling.</p>";
}
echo anchor('#!', 'Optie toevoegen', 'class="btn btn-primary voegOptieToeLink"');
?>
