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

    function haalOptiesBijDagindelingOp ( dagindelingId ) {
        $.ajax({type : "GET",
                url : site_url + "/organisator/haalAjaxOp_OptiesBijDagindeling",
                data : { dagindelingId : dagindelingId },
                success : function(result){
                    $("#resultaat").html(result);
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
        });
    }
   
    $(document).ready(function(){

        $( ".dagindelingLink" ).click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            haalOptiesBijDagindelingOp ( id );
        });
        
        $('#knopVoegOptieToe').on('click', function() {
            console.log("Test");
        });
        
        
    });

</script>

<div class="row">
    <div class="page-header col-sm-12 pb-2">
        <h1><?php echo $titel; ?> - <?php echo $personeelsfeest->naam ?></h1>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
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

                echo "<tr><td>" . divanchor('', $dagindeling->naam, array('data-id' => $dagindeling->id, 'class' => 'dagindelingLink')) . "</td><td>" . $dagindeling->beginuur . " - " . $dagindeling->einduur .
                "</td><td>" . $voorVrijwilliger . "</td><td>" . anchor('organisator/wijzigDagindeling/' . $personeelsfeest->id . '/' . $dagindeling->id, 'Bewerken') . "</td><td>" . anchor('organisator/verwijderDagindeling/' . $personeelsfeest->id . '/' . $dagindeling->id, 'Verwijder') . "</td></tr>";
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
