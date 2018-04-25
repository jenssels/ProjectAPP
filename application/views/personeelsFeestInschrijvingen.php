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
        };
        
        $('.toon').click(function(e){
            e.preventDefault();
            $id = $(this).data('id');
            $type = $(this).data('type');
            ajaxToonDeelnemers($id, $type);
            
        });
        
    });
</script>


<?php
$opties = "";
$taken = "";
    foreach($personeelsfeest->dagindelingen as $dagindeling){
        foreach($dagindeling->opties as $optie){
            $opties .= '<tr><td>' . $optie->naam .  '</td><td>' . $dagindeling->beginuur . ' - ' . $dagindeling->einduur . '</td><td><a href="#!" class="toon" data-type="optie" data-id="' . $optie->id . '">' . $optie->deelnemers . '/' . $optie->maxAantal . '</a></td><td>'. $optie->minAantal .'</td></tr>';
        }
    }
    foreach($personeelsfeest->dagindelingen as $dagindeling){
        foreach($dagindeling->taken as $taak){
            foreach($taak->shiften as $shift){
                $taken .= '<tr><td>' . $taak->naam . '</td><td>' . $shift->naam . '</td><td>' . $shift->beginuur . ' - ' . $shift->einduur .'</td><td><a href="#!" class="toon" data-type="shift" data-id="' . $shift->id . '">' . $shift->deelnemers . '/' . $shift->maxAantal . '</a></td></tr>';
            }
        }
    }
?>

<table cellpadding="10">
    <th></th>
    <th>Aantal</th>
    <tr><td>Totaal inschrijvingen <br/> (deelnemers + helpers)</td><td><?php echo $personeelsfeest->inschrijvingen['helpers'] + $personeelsfeest->inschrijvingen['deelnemers'] ?></td></tr>
    <tr><td>Totaal deelnemers</td><td><?php echo $personeelsfeest->inschrijvingen['deelnemers'] ?></td></tr>
    <tr><td>Totaal helpers</td><td><?php echo $personeelsfeest->inschrijvingen['helpers'] ?></td></tr>
</table>
<table cellpadding="10">
    <th>Optie</th>
    <th>Tijd</th>
    <th>Aantal inschrijvingen</th>
    <th>Minimum aantal</th>
    <?php
        echo $opties;
    ?>
</table>
<table cellpadding="10">
    <th>Taak</th>
    <th>Shift</th>
    <th>Tijd</th>
    <th>Aantal inschrijvingen</th>
    <?php
        echo $taken;
    ?>
</table>

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