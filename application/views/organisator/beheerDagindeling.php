<?php
/**
 * @file beheerDagindeling.php
 *
 * View waarin de dagindeling van een bepaald personeelsfeest getoond.
 * Je kan van hieruit de dagindeling bewerken.
 *
 */
?>

<script>

    function haalOptiesBijDagindelingOp(dagindelingId) {
        $.ajax({
            type: "GET",
            url: site_url + "/organisator/haalAjaxOp_OptiesBijDagindeling",
            data: {dagindelingId: dagindelingId},
            success: function (result) {
                $("#resultaat").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        <?php
        $phpvar = base_url('index.php/organisator/verwijderDagindeling/' . $personeelsfeest->id . '/');
        echo "var _href = '{$phpvar}'; \n";
        ?>
        $('.verwijderDagindeling').click(function (e) {
            console.log("Test");
            var id = $(this).data('id');
            $('#verwijderen').attr('href', _href + id);
            $('#modalBevestig').modal('show');
            e.preventDefault();
        });

        $(".dagindelingLink").click(function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            haalOptiesBijDagindelingOp(id);
        });

        $('#knopVoegOptieToe').on('click', function () {

        });
    });

</script>

<div class="row">
    <div class="page-header col-sm-12 pb-2">
        <h5>Dagindeling van <?php echo $personeelsfeest->naam ?></h5>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
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

                $beginuur = substr($dagindeling->beginuur, 0, 5);
                $einduur = substr($dagindeling->einduur, 0, 5);

                echo "<tr><td>" . divanchor('', $dagindeling->naam, array('data-id' => $dagindeling->id, 'class' => 'dagindelingLink')) . "</td>"
                    . "<td>" . $beginuur . "u - " . $einduur . "u</td>"
                    . "<td>" . $voorVrijwilliger . "</td>"
                    . "<td>" . anchor('organisator/taakBeheren/' . $dagindeling->id, 'Beheer taken') . "</td>"
                    . "<td>" . anchor('organisator/wijzigDagindeling/' . $personeelsfeest->id . '/' . $dagindeling->id, '<i class="fas fa-pencil-alt grow"></i>') . "</td>"
                    . "<td>" . anchor('#!', '<i class="far fa-trash-alt grow"></i>', 'class="verwijderDagindeling" data-id="' . $dagindeling->id . '"') . "</td></tr>";
            }
            ?>
            <tr>
                <td><?php echo anchor('organisator/maakNieuweDagindeling/' . $personeelsfeest->id, 'Toevoegen') ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="col-sm-12" id="resultaat">

    </div>
</div>

<!-- Dialoogvenster -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalBevestig" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                Ben je zeker dat je deze dagindeling wilt verwijderen?
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-secondary" id="verwijderen">Doorgaan</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
            </div>
        </div>
    </div>
</div>
