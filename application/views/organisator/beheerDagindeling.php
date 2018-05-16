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
                $('.voegOptieToeLink').show();
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    function voegOptieToe(dagindelingID, naam, beschrijving, minAantal, maxAantal, locatieID){
        $.ajax({
            type: "GET",
            url: site_url + "/organisator/ajax_voegOptieToe",
            data: {dagindelingID: dagindelingID,
            naam: naam,
            beschrijving: beschrijving,
            minAantal: minAantal,
            maxAantal: maxAantal,
            locatieID: locatieID},
            success: function (result) {
                $('#voegOptieToe').modal('hide');
                haalOptiesBijDagindelingOp(dagindelingID);
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
            $('#bevestigVoegToe').attr('data-id', id);
            haalOptiesBijDagindelingOp(id);
        });

        $('.voegOptieToeLink').hide();

        $('#bevestigVoegToe').click(function(e) {
            var id = $(this).data('id');
            e.preventDefault();
            var dagindelingID = id;
            var naam = $('#inputNaam').val();
            var beschrijving = $('#inputBeschrijving').val();
            var minAantal = $('#inputMin').val();
            var maxAantal = $('#inputMax').val();
            var locatieID = $('#inputLocatie').val();
            voegOptieToe(dagindelingID, naam, beschrijving, minAantal, maxAantal, locatieID);
        })
    });

</script>

<div class="row">
    <div class="page-header col-sm-12 pb-2">
        <h5>Dagindelingen van <?php echo strtolower($personeelsfeest->naam); ?></h5>
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
                <td><?php echo anchor('organisator/maakNieuweDagindeling/' . $personeelsfeest->id, 'Dagindeling toevoegen', 'class="btn btn-primary"'); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="col-sm-12" id="resultaat">
        <h5>Klik op een dagindeling om de opties te bekijken.</h5>
    </div>
    <div class="col-sm-12">
        <?php echo anchor('#!', 'Optie toevoegen', 'class="btn btn-primary voegOptieToeLink"'); ?>
    </div>
</div>

<!-- Bevestigdialoogvenster -->
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


<!-- Optie toevoegen dialoogvenster -->
<div class="modal fade" id="voegOptieToe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Optie toevoegen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            $attributenFormulier = array('id' => 'mijnFormulier',
                'role' => 'form');
            echo form_open('', $attributenFormulier)
            ?>
            <div class="modal-body">
                <div class="form-group row">
                    <?php echo form_label('Naam', 'inputNaam', 'class="col-sm-3 col-form-label"') ?>
                    <div class="col-sm-9">
                        <?php echo form_input('inputNaam', '', 'class="form-control" id="inputNaam"') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <?php echo form_label('Beschrijving', 'inputBeschrijving', 'class="col-sm-3 col-form-label"') ?>
                    <div class="col-sm-9">
                        <?php echo form_textarea('inputBeschrijving', '', 'class="form-control" id="inputBeschrijving"') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <?php echo form_label('Min aantal', 'inputMin', 'class="col-sm-3 col-form-label"') ?>
                    <div class="col-sm-9">
                        <?php echo form_input('inputMin', '', 'class="form-control" id="inputMin"') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <?php echo form_label('Max aantal', 'inputMax', 'class="col-sm-3 col-form-label"') ?>
                    <div class="col-sm-9">
                        <?php echo form_input('inputMax', '', 'class="form-control" id="inputMax"') ?>
                    </div>
                </div>
                <?php
                $options = array();
                $options[] = "-- Kies een locatie --";
                foreach ($locaties as $locatie){
                    $options[$locatie->id] = $locatie->naam;
                }
                ?>

                <div class="form-group row">
                    <?php echo form_label('Locatie', 'inputLocatie', 'class="col-sm-3 col-form-label"') ?>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('inputLocatie', $options, '', 'class="form-control" id="inputLocatie"') ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php echo form_submit('knop', 'Toevoegen', 'class="btn btn-primary" id="bevestigVoegToe"') ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
