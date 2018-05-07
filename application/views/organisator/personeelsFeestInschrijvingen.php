<script>
    $(document).ready(function () {
        function ajaxToonDeelnemers(id, type) {
            $.ajax({type: "GET",
                url: site_url + "/Organisator/ajaxToonDeelnemers",
                data: {id: id, type: type},
                success: function (result) {
                    $('#resultaat').html(result);
                    $('#modalDeelnemers').modal('show');
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
            });
        }
        ;

        $('.toon').click(function (e) {
            e.preventDefault();
            $id = $(this).data('id');
            $type = $(this).data('type');
            ajaxToonDeelnemers($id, $type);

        });

        $('#myTab a').on('click', function (e) {
            e.preventDefault()
            $(this).tab('show')
        })
    });
</script>


<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-totaal-tab" data-toggle="tab" href="#nav-totaal" role="tab" aria-controls="nav-totaal" aria-selected="true">Totaal</a>
        <a class="nav-item nav-link" id="nav-deelnemers-tab" data-toggle="tab" href="#nav-deelnemers" role="tab" aria-controls="nav-deelnemers" aria-selected="false">Deelnemers</a>
        <a class="nav-item nav-link" id="nav-vrijwilligers-tab" data-toggle="tab" href="#nav-vrijwilligers" role="tab" aria-controls="nav-vrijwilligers" aria-selected="false">Vrijwilligers</a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-totaal" role="tabpanel" aria-labelledby="nav-totaal-tab">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <th>Totaal aantal inschrijvingen</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>Deelnemers en vrijwilligers</td>
                        <td><?php echo $personeelsfeest->inschrijvingen['helpers'] + $personeelsfeest->inschrijvingen['deelnemers']; ?></td>
                    </tr>
                    <tr>
                        <td>Deelnemers</td>
                        <td><?php echo $personeelsfeest->inschrijvingen['deelnemers']; ?></td>
                    </tr>
                    <tr>
                        <td>Vrijwilligers</td>
                        <td><?php echo $personeelsfeest->inschrijvingen['helpers']; ?></td>
                    </tr>
                </table>
            </div>
        </div> 
    </div>
    <div class="tab-pane fade" id="nav-deelnemers" role="tabpanel" aria-labelledby="nav-deelnemers-tab">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <th>Optie</th>
                        <th>Uur</th>
                        <th>Aantal inschrijvingen</th>
                        <th>Minimumaantal nodig</th>
                    </tr>
                    <?php
                    foreach ($personeelsfeest->dagindelingen as $dagindeling) {
                        foreach ($dagindeling->opties as $optie) {
                            if ($optie->minAantal == 0) {
                                $minimumaantal = 'N.v.t.';
                            } else {
                                $minimumaantal = $optie->minAantal . ' deelnemers';
                            }
                            
                            echo "<tr>";
                            echo "<td>" . $optie->naam . "</td>";
                            echo "<td>" . substr($dagindeling->beginuur, 0, 5) . "u - " . substr($dagindeling->einduur, 0, 5) . "u</td>";
                            echo "<td>" . anchor('#!', $optie->deelnemers . "/" . $optie->maxAantal . " deelnemers", 'class="toon" data-type="optie" data-id="' . $optie->id . '"') . "</td>";
                            echo "<td>" . $minimumaantal . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-vrijwilligers" role="tabpanel" aria-labelledby="nav-vrijwilligers-tab">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <th>Taak</th>
                        <th>Shift</th>
                        <th>Tijd</th>
                        <th>Aantal inschrijvingen</th>
                    </tr>
                    <?php
                    foreach ($personeelsfeest->dagindelingen as $dagindeling) {
                        foreach ($dagindeling->taken as $taak) {
                            foreach ($taak->shiften as $shift) {
                                echo "<tr>";
                                echo "<td>" . $taak->naam . "</td>";
                                echo "<td>" . $shift->naam . "</td>";
                                echo "<td>" . $shift->beginuur . " - " . $shift->einduur . "</td>";
                                echo "<td>" . anchor('#!', $shift->deelnemers . "/" . $shift->maxAantal, 'class="toon" data-type="taak" data-id="' . $shift->id . '"') . "</td>";
                                echo "</tr>";
                            }
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Dialoogvenster -->
<div class="modal fade" id="modalDeelnemers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Overizcht van de inschrijvingen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="resultaat"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
            </div>
        </div>
    </div>
</div>