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
            console.log( id );
            haalOptiesBijDagindelingOp ( id );
        });
        
    });

</script>

<div class="row">
    <div class="page-header col-sm-12 pb-2">
        <h1><?php echo $titel; ?> - <?php echo $personeelsfeest->naam ?></h1>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
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
                "</td><td>" . $voorVrijwilliger . "</td><td>" . anchor('?', '<i class="fas fa-edit"></i>') . "</td><td>" . anchor('organisator/verwijderDagindeling/' . $personeelsfeest->id . '/' . $dagindeling->id, '<i class="fas fa-trash-alt"></i>') . "</td></tr>";
            }
            ?>
            <tr>
                <td><?php echo anchor('organisator/toevoegenDagindeling/' . $personeelsfeest->id, 'Toevoegen') ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="col-sm-6" id="resultaat">
        
    </div>
</div>
