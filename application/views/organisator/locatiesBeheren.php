<?php /**
 * @file locatiesBeheren.php
 *
 * Pagina waar je alle locaties kan beheren
 *
 */ ?>
<script>
    $(document).ready(function () {
        <?php
        $phpvar = base_url('index.php/organisator/verwijderLocatie/');
        echo "var _href = '{$phpvar}'; \n";
        ?>
        $('.verwijderLocatie').click(function (e) {
            var id = $(this).data('id');
            $('#verwijderen').attr('href', _href + id);
            $('#modalBevestig').modal('show');
            e.preventDefault();
        });
    });
</script>

<div class="row">
    <div class="col-md-12">
        <table class="table">
            <tr>
                <th>Naam</th>
                <th>Adres</th>
                <th>Plaats</th>
                <th></th>
                <th></th>
            </tr>
            <?php
            //Thomas Vansprengel - Overzicht van taken
            foreach ($locaties as $locatie) {
                echo "<tr>
                <td>" . $locatie->naam . "</td>
                <td>" . $locatie->adres . "</td>
                <td>" . $locatie->plaats . "</td>
                <td>" . anchor("#!", "<i class='far fa-trash-alt grow'></i>", "class='verwijderLocatie' data-id='" . $locatie->id . "'") . "</td>
                <td>" . anchor("organisator/editlocatie/" . $locatie->id, '<i class="fas fa-pencil-alt grow"></i>') . "</td>
                </tr>";
            }
            echo "<tr><td>" . anchor("organisator/locatieToevoegen/", "Locatie toevoegen") . "</td><td></td><td></td><td></td><td></td></tr>";
            ?>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a id="terug" class='btn btn-primary' href="javascript:history.go(-1);">Terug</a>
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
                Ben je zeker dat je deze locatie wilt verwijderen?
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-secondary" id="verwijderen">Doorgaan</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
            </div>
        </div>
    </div>
</div>

