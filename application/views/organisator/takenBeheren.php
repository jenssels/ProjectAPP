<?php/**
 * @file takenBeheren.php
 * 
 * Pagina waar je alle taken in kan beheren
 * 
 */?>
<script>
    $(document).ready(function () {
        <?php
        $phpvar = base_url('index.php/organisator/verwijdertaak/');
        echo "var _href = '{$phpvar}'; \n";
        ?>
        $('.verwijderTaak').click(function (e) {
            var id = $(this).data('id');
            $('#verwijderen').attr('href', _href + id);
            $('#modalBevestig').modal('show');
            e.preventDefault();
        });
    });
</script>
<div class="row">
    <div class="col-md-8">
        <table class="table">
        <?php
            //Thomas Vansprengel - Overzicht van taken
            foreach($taken as $taak){
                echo "<tr><td>" .  $taak->naam . "</td>"
                        . "<td>" .  $taak->beschrijving . "</td>"
                        . "<td>" .  $taak->dagindeling->naam . "</td>"
                        . "<td>" .  $taak->locatie->naam . "</td>"
                        . "<td>" . anchor("#!",'<i class="far fa-trash-alt grow"></i>', 'class="verwijderTaak" data-id="' . $taak->id . '"') . "</td>"
                        . "<td>" . anchor("organisator/edittaak/".$taak->id,'<i class="fas fa-pencil-alt grow"></i>') . "</td></tr>"; 
                
            }
            
            echo "<tr><td>" . anchor("organisator/taakToevoegen/","Taak toevoegen"). "</tr></td>";
            echo "<tr><td>" . anchor("organisator/personeelsFeestOverzicht/","Terug naar overzicht"). "</tr></td>";
        
            echo form_open();
            echo form_hidden("dagindelingid", $dagindelingid);
            echo form_close();
            
            
            
            
            ?>
        </table>
    </div>
</div>

<!-- Bevstigdialoogvenster -->
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
                Ben je zeker dat je deze taak wilt verwijderen?
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-secondary" id="verwijderen">Doorgaan</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
            </div>
        </div>
    </div>
</div>

