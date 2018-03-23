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
        <?php
            //Jens Sels - 4 buttons aanmaken
            echo anchor('Organisator/personeelsFeestAanmakenForm/nieuw', 'Personeelsfeest aanmaken');
            echo anchor('Organisator/?', 'Fotoalbums beheren');
            echo anchor('Organisator/?', 'Locaties beheren');
            echo anchor('Organisator/?', 'Mail sturen');
        ?>
    </div>
    <div class="col-md-12">
        <table>
        <?php
            //Jens Sels - Overzicht van feesten in tabel tonen
            foreach($personeelsFeesten as $feest){
                echo "<tr><td>" . $feest->naam .  "</td><td>" .  $feest->datum . "</td><td> <a href=#! class='overzicht' data-id='" . $feest->id . "'>Overzicht inschrijvingen</a></td><td>" . anchor('Organisator/personeelsFeestAanmakenForm/' . $feest->id, 'edit') . "</td><td>" . anchor('Organisator/personeelsFeestVerwijderen/' . $feest->id, 'verwijder') . "</td></tr>"; 
            }
        ?>
        </table>
    </div>
    <div class="col-md-12">
        <?php
            //Jens Sels - button organisator toevoegen
            echo anchor('Organisator/?', 'Organisator toevoegen');
        ?>
    </div>
</div>

<!-- Modal overzicht -->
<!-- Dialoogvenster -->
<div class="modal fade" id="modalInschrijvingen" role="dialog">
    <div class="modal-dialog">
 
        <!-- Inhoud dialoogvenster-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Overzicht inschrijvingen</h4>
            </div>
            <div class="modal-body">
                <p><div id="resultaat"></div></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sluit</button>
            </div>
        </div>
 
    </div>
</div>


