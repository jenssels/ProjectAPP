<script>
    function haalDeelnemersOp (id) {
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
    }
    
    $(document).ready(function(){
    
        $('overzicht').click(funtion(){
            var id = this.data('id');
            haalDeelnemersOp(id);
            $('#modalInschrijvingen').modal(show);
        });
    });
</script>
<div class="row">
    <div class="col-md-12">
        <?php
            //Jens Sels - 4 buttons aanmaken
            echo anchor('Admin/?', 'Personeelsfeest aanmaken');
            echo anchor('Admin/?', 'Fotoalbums beheren');
            echo anchor('Admin/?', 'Locaties beheren');
            echo anchor('Admin/?', 'Mail sturen');
        ?>
    </div>
    <div class="col-md-12">
        <table>
        <?php
            //Jens Sels - Overzicht van feesten in tabel tonen
            foreach($personeelsFeesten as $feest){
                echo "<tr><td>" + $feest->naam + "</td><td>" + $feest->datum + "</td><td> <a href=#! class='overzicht' data-id='" + $feest->id + "'>Overzicht inschrijvingen</a></td><td>" + anchor('Admin/?', 'edit') + "</td><td>" + anchor('Admin/?', 'verwijder') + "</td></tr>"; 
            }
        ?>
        </table>
    </div>
    <div class="col-md-12">
        <?php
            //Jens Sels - button organisator toevoegen
            echo anchor('Admin/?', 'Organisator toevoegen');
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


