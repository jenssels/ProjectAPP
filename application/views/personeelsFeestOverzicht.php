<script>
    function haalDeelnemersOp (id) {
        // Jens Sels - Ophalen personeelsleden en vrijwilligers en tonen in modal
        $.ajax({type : "GET",
                url : site_url + "/Organisator/ajaxHaalDeelnemersOp",
                data : { id: id },
                success : function(result){
                    $('#resultaat').html(result);
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
            $('#modalInschrijvingen').modal('show');
        });
    });
</script>
<div class="row">
    <div class="col-md-12">
        <table class="table">
            <tr>
                <th>Naam</th>
                <th>Datum</th>
                <th>Inschrijvingen</th>
                <th>Personeel toevoegen</th>
                <th>Bewerken</th>
                <th>Verwijderen</th>
                <th>Taken beheren</th>
                <th>Mail sturen</th>
            </tr>
        <?php
            //Jens Sels - 4 buttons aanmaken
            echo anchor('Organisator/personeelsFeestAanmakenForm/nieuw', 'Personeelsfeest aanmaken');
            echo anchor('Organisator/?', 'Fotoalbums beheren');
            echo anchor('Organisator/?', 'Locaties beheren');
            echo anchor('Organisator/?', 'Mail sturen');
            echo anchor('organisator/takenBeheren', 'Taak beheren');
        ?>
    </div>
    <div class="col-md-12">
        <table>
        <?php
            //Jens Sels - Overzicht van feesten in tabel tonen
            foreach($personeelsFeesten as $feest){
                echo "<tr>";
                echo "<td>" . $feest->naam .  "</td>"
                        . "<td>" . zetOmNaarDDMMYYYY($feest->datum) . "</td>"
                        . "<td class='text-center'> <a href=#! class='overzicht' data-id='" . $feest->id . "'><i class='fas fa-list-ul grow'></i></a></td>"
                        . "<td class='text-center'>" . anchor('Organisator/personeelsFeestUploadForm/' . $feest->id, '<i class="fas fa-user-plus grow"></i>') . "</td>"
                        . "<td class='text-center'>" . anchor('Organisator/personeelsFeestAanmakenForm/' . $feest->id, '<i class="fas fa-pencil-alt grow"></i>') . "</td>"
                        . "<td class='text-center'>" . anchor('Organisator/personeelsFeestVerwijderen/' . $feest->id, '<i class="far fa-trash-alt grow"></i>') . "</td>"
                        . "<td class='text-center'>" . anchor('organisator/taakbeheren', '<i class="fas fa-tasks grow"></i>') . "</td>"
                        . "<td class='text-center'>" . anchor('Organisator/mailSturen/' . $feest->id, '<i class="far fa-envelope grow"></i>') . "</td>";
                echo "</tr>"; 
            }
        ?>
        </table>
    </div>
    
    <div class="col-md-12">
        <div class="btn-group" role="group" aria-label="Basic example">
            <?php 
            echo anchor('organisator/personeelsFeestAanmakenForm/nieuw', 'Personeelsfeest aanmaken', array('role' => 'button' , 'class' => 'btn btn-primary'));
            echo anchor('organisator/?', 'Fotoalbums beheren', array('role' => 'button' , 'class' => 'btn btn-primary'));
            echo anchor('organisator/?', 'Locaties beheren', array('role' => 'button' , 'class' => 'btn btn-primary'));
            echo anchor('organisator/beheerOrganisatoren', 'Organisatoren beheren', array('role' => 'button' , 'class' => 'btn btn-primary'));
            ?>
        </div>
    </div>
</div>

<!-- Dialoogvenster -->
<div class="modal fade" id="modalInschrijvingen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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


