<?php/**
 * @file taakShiften.php
 * 
 * Pagina waar je een overzicht van de shiften bij deze taak kan zien
 * 
 */?> <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<script>
    $(document).ready(function () {
        <?php
        $phpvar = base_url('index.php/organisator/verwijderShift/');
        echo "var _href = '{$phpvar}'; \n";
        ?>
        $('.verwijderShift').click(function (e) {
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
        echo "Gelieve een tijd in te voeren tussen " . $taak->dagindeling->beginuur . " en " . $taak->dagindeling->einduur;
            //Thomas Vansprengel - Overzicht van taken
            foreach($shiften as $shift){
                echo "<tr><td>" .  $shift->naam . "</td>"
                        . "<td>" .  $shift->beginuur . "</td>"
                        . "<td>" .  $shift->einduur . "</td>"
                        . "<td>" .  $shift->maxAantal . "</td>"
                        . "<td>" . anchor("#!",'<i class="far fa-trash-alt grow"></i>', 'class="verwijderShift" data-id="' . $shift->id . '"') . "</td>"
                        . "<td>" . anchor("organisator/editShift/".$shift->id,'<i class="fas fa-pencil-alt grow"></i>') . "</td></tr>"; 
                
            }
            
            echo "<tr><td>" . anchor("organisator/shiftToevoegen/".$taakid,"Shift Toevoegen"). "</tr></td>";
            echo "<tr><td>" . anchor("organisator/personeelsFeestOverzicht/","Terug naar overzicht"). "</tr></td>";
       
           
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
                Ben je zeker dat je deze shift wilt verwijderen?
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-secondary" id="verwijderen">Doorgaan</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
            </div>
        </div>
    </div>
</div>

