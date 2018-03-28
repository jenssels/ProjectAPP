<script>
    /*function haalDeelnemersOp (id) {
        // Jens Sels - Ophalen personeelsleden en vrijwilligers en tonen in modal
        $.ajax({type : "GET",
                url : site_url + "/Admin/ajaxHaalDeelnemersOp",
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
    });*/
</script>
<div class="row">
    <div class="col-md-12">
        <p>Je bent uitgenodigd om te helpen op het personeelsfeest van dit jaar.</p>
        <p>Vul te taken aan die jij wilt uitvoeren.</p>
    </div>
    <div class="col-md-12">
        <form method="post" action="send">
            <table>
     M       <?php
                //Thomas Vansprengel
            echo "<tr><th>Taak</th><th>Shift</th><th>Tijd</th><th>Aantal inschrijvingen</th><th>Locatie</th><th>Ik wil helpen!</th></tr>";
                foreach($shiften as $shift){
                    echo "<tr><td>" . $shift->taak->naam .  "</td><td>" .  $shift->naam .  "</td><td>" .  $shift->beginuur . " - " .  $shift->einduur .  "</td><td>" . anchor("vrijwilliger/overzicht/".$shift->id, "x/" . $shift->maxAantal)  .  "</td><td>" .  $shift->taak->locatieId .  "</td><td>" . form_checkbox($shift->id) .  "</td></tr>"; 
                }
                echo "<tr><td>" . form_submit('verzenden', 'Bevestigen!') . "</td></tr>";
            ?>
            </table>
        </form>
    </div>
    <div class="col-md-12">
        <?php
            //Thomas Vansprengel
            echo anchor('Vrijwilliger/?', 'Naar albums');
        ?>
    </div>
</div>


