<script>
    function haalDeelnemersOp (id) {
        // Jens Sels - Ophalen personeelsleden en vrijwilligers en tonen in modal
        $.ajax({type : "GET",
                url : site_url + "/Organisator/ajaxHaalDeelnemersOp",
                data : { id: id },
                success : function(result){
                    $('#resultaat').html(result);
                    $('#modalInschrijvingen').modal('show');
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
        });
    };
    
    $(document).ready(function(){
    
        $('.overzicht').click(function(){
            console.log('klik');
            var id = $(this).data('id');
            haalDeelnemersOp(id);
        });

        <?php
        $phpvar = base_url('index.php/organisator/personeelsFeestVerwijderen/');
        echo "var _href = '{$phpvar}'; \n";
        ?>
        $('.verwijderPersoneelsfeest').click(function (e) {
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
                <th>Datum</th>
                <th>Uitgenodigden</th>
                <th>Inschrijvingen</th>
                <th>Personeel toevoegen</th>
                <th>Beheer dagindeling</th>
                <th>Bewerken</th>
                <th>Verwijderen</th>
                <th>Mail sturen</th>
            </tr>
        <?php
            $vandaag = date('Y-m-d');
            echo $vandaag;
            //Jens Sels - Overzicht van feesten in tabel tonen
            foreach($personeelsFeesten as $feest){
                $feestDatum = $feest->datum;
                echo "<tr>";
                //if ($feestDatum > $vandaag) {
                    echo "<td>" . $feest->naam .  "</td>"
                        . "<td>" . zetOmNaarDDMMYYYY($feest->datum) . "</td>"

                        . "<td class='text-center'> <a href=#! class='overzicht' data-id='" . $feest->id . "'><i class='fas fa-list-ul grow'></i></a></td>"
                        . "<td class='text-center'>" . anchor('Organisator/personeelsFeestInschrijvingen/' . $feest->id, '<i class="fas fa-list-ul grow"></i>') . "</td>"
                        . "<td class='text-center'>" . anchor('Organisator/personeelsFeestUploadForm/' . $feest->id, '<i class="fas fa-user-plus grow"></i>') . "</td>"
                        . "<td class='text-center'>" . anchor('Organisator/beheerDagindeling/' . $feest->id, '<i class="fas fa-pencil-alt grow"></i>') . "</td>"
                        . "<td class='text-center'>" . anchor('Organisator/personeelsFeestAanmakenForm/' . $feest->id, '<i class="fas fa-pencil-alt grow"></i>') . "</td>"
                        . "<td class='text-center'>" . anchor('#!', '<i class="far fa-trash-alt grow"></i>', 'class="verwijderPersoneelsfeest" data-id="' . $feest->id . '"') . "</td>"
                        . "<td class='text-center'>" . anchor('Organisator/mailSturen/' . $feest->id, '<i class="far fa-envelope grow"></i>') . "</td>";
                /*} else {
                    echo "<td>" . $feest->naam .  "</td>"
                        . "<td>" . zetOmNaarDDMMYYYY($feest->datum) . "</td>"

                        . "<td class='text-center'> <a href=#! class='overzicht' data-id='" . $feest->id . "'><i class='fas fa-list-ul grow'></i></a></td>"
                        . "<td class='text-center'>" . anchor('Organisator/personeelsFeestInschrijvingen/' . $feest->id, '<i class="fas fa-list-ul grow"></i>') . "</td>"
                        . "<td class='text-center'>" . anchor('Organisator/personeelsFeestUploadForm/' . $feest->id, '<i class="fas fa-user-plus grow"></i>') . "</td>"
                        . "<td class='text-center'> </td>"
                        . "<td class='text-center'>" . anchor('Organisator/personeelsFeestAanmakenForm/' . $feest->id, '<i class="fas fa-pencil-alt grow"></i>') . "</td>"
                        . "<td class='text-center'>" . anchor('Organisator/personeelsFeestVerwijderen/' . $feest->id, '<i class="far fa-trash-alt grow"></i>') . "</td>"
                        . "<td class='text-center'>" . anchor('Organisator/mailSturen/' . $feest->id, '<i class="far fa-envelope grow"></i>') . "</td>";
                }*/
                

                echo "</tr>"; 
            }
        ?>
        </table>
    </div>
    
    <div class="col-md-12">
        <div class="btn-group" role="group" aria-label="Basic example">
            <?php 
            echo anchor('organisator/personeelsFeestAanmakenForm/nieuw', 'Personeelsfeest aanmaken', array('role' => 'button' , 'class' => 'btn btn-primary'));
            echo anchor('organisator/overzichtAlbums', 'Fotoalbums beheren', array('role' => 'button' , 'class' => 'btn btn-primary'));
            echo anchor('organisator/locatiesBeheren', 'Locaties beheren', array('role' => 'button' , 'class' => 'btn btn-primary'));
            echo anchor('organisator/beheerOrganisatoren', 'Organisatoren beheren', array('role' => 'button' , 'class' => 'btn btn-primary'));
            ?>
        </div>
    </div>
</div>

<!-- Dialoogvenster -->
<div class="modal fade moda-lg" id="modalInschrijvingen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Overizcht van de inschrijvingen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div id="resultaat" class="row">
          </div>          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
      </div>
    </div>
  </div>
</div>

<!-- Bevestigdialoogvenster -->
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
                Ben je zeker dat je <span id="personeelsfeestNaam"></span> wilt verwijderen?
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-secondary" id="verwijderen">Doorgaan</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
            </div>
        </div>
    </div>
</div>


