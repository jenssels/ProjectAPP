<?php
/**
 * @file beheerOrganisatoren.php
 * 
 * View waarin de organisatoren worden getoond. 
 * Van hieruit kan je de organistoren beheren.
 * 
 */
?>

<script>
    $(document).ready(function () {
        <?php
            $phpvar = base_url('index.php/organisator/verwijderOrganisator/');
            echo "var _href = '{$phpvar}'; \n";
        ?>
        $('.verwijderOrganisator').click(function (e) {
            var hashcode = $(this).data('hashcode');
            $('#verwijderen').attr('href', _href + hashcode);
            var aantalOrganisatoren = $('.verwijderOrganisator').length;
            if (aantalOrganisatoren <= 1) {
                e.preventDefault();
                $('#modalFout').modal('show');
            } else {
                $('#modalBevestig').modal('show');
                e.preventDefault();
            }
        });
    });
</script>

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
                echo "<td>" . anchor('#!', '<i class="far fa-trash-alt grow"></i>', 'class="verwijderOrganisator" data-hashcode="' . $organisator->hashcode . '"') . "</td>";
                echo "</tr>";
            }
            ?>
            <td><?php echo anchor('organisator/maakNieuweOrganisator', 'Toevoegen') ?></td>
            <td></td>
            <td></td>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalFout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Fout!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Dit is de laatste organisator. Je kan deze niet verwijderen.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalBevestig" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Wil je doorgaan?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Ben je zeker dat je deze organisator wilt verwijderen?
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-secondary" id="verwijderen">Doorgaan</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
            </div>
        </div>
    </div>
</div>
