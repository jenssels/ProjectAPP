<script>
    $(document).ready(function () {
        $('.voegOptieToeLink').click(function (e) {
            e.preventDefault();
        });
    });
</script>

<h5>
    Opties bij "<?php echo strtolower($dagindeling->naam); ?>"
</h5>
<?php
if (count($opties) > 0) {
    echo "<table class='table'>";
    echo "<tr>";
    echo "<th>Naam</th><th>Beschrijving</th><th>Maximum aantal</th><th>Minimum aantal</th><th>Locatie</th><th></th><th></th>";
    echo "</tr>";
    foreach ($opties as $optie) {
        if ($optie->maxAantal != null) {
            $maxAantal = $optie->maxAantal;
        } else {
            $maxAantal = "N.v.t.";
        }
        if ($optie->minAantal != null) {
            $minAantal = $optie->minAantal;
        } else {
            $minAantal = "N.v.t.";
        }

        echo "<tr>";
        echo "<td>" . $optie->naam . "</td>";
        echo "<td>" . $optie->beschrijving . "</td>";
        echo "<td>" . $maxAantal . "</td>";
        echo "<td>" . $minAantal . "</td>";
        echo "<td>" . $optie->locatie->naam . "</td>";
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
