<script>
    $(document).ready(function () {
        $('.voegOptieToeLink').click(function (e) {
            e.preventDefault();
        });

        <?php
        $phpvar = base_url('index.php/organisator/verwijderOptie/');
        echo "var _href = '{$phpvar}'; \n";
        ?>
        $('.verwijderOptie').click(function (e) {
            var id = $(this).data('id');
            $('#verwijderen').attr('href', _href + id);
            $('#modalBevestig1').modal('show');
            e.preventDefault();
        });
    });
</script>

<div class="row">
    <div class="page-header col-sm-12 pb-2">
        <h5>Opties bij "<?php echo strtolower($dagindeling->naam); ?>"</h5>
    </div>
</div>
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
        echo "<td>" . anchor('?', '<i class="fas fa-pencil-alt grow"></i>') . "</td>";
        echo "<td>" . anchor('#!', '<i class="far fa-trash-alt grow"></i>', 'class="verwijderOptie" data-id="' . $optie->id . '"') . "</td>";
        echo "</tr>";
    }
    echo "<tr>";
    echo "<td>" . anchor('#!', 'Optie toevoegen', 'class="btn btn-primary voegOptieToeLink"') . "</td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "</tr>";
    echo "</table>";
} else {
    echo "<p>Er zijn nog geen opties bij deze dagindeling.</p>";
    echo anchor('#!', 'Optie toevoegen', 'class="btn btn-primary voegOptieToeLink"');
}
?>

<!-- Bevestigdialoogvenster -->
<div class="modal fade" id="modalBevestig1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Wil je doorgaan?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Ben je zeker dat je deze optie wilt verwijderen?
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-secondary" id="verwijderen">Doorgaan</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
            </div>
        </div>
    </div>
</div>
