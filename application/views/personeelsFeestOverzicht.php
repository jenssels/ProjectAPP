
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
                echo "<tr><td>" + $feest->naam + "</td><td>" + $feest->datum + "</td><td> <a href=#! id='overzicht' data-id='" + $feest->id + "'>Overzicht inschrijvingen</a></td><td>" + anchor('Admin/?', 'edit') + "</td><td>" + anchor('Admin/?', 'verwijder') + "</td></tr>"; 
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

