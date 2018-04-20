<?php/**
 * @file vrijwilligerOverzicht.php
 * 
 * Een overzicht van alle vrijwilligers
 * 
 */?>
<div class="row">
    <div class="col-md-12">
        <p>Overzicht vrijwilligers</p>
    </div>
    <div class="col-md-12">
        <form method="post" action="send">
            <table>
             <?php
                //Thomas Vansprengel
            echo "<tr><th>Voornaam</th><th>Naam</th><th>Email</th></tr>";
                foreach($deelnames as $deelname){
                    echo "<tr><td>" . $deelname->persoon->voornaam .  "</td><td>" . $deelname->persoon->naam .  "</td><td>" . $deelname->persoon->email .  "</td></tr>"; 
                }
            ?>
            </table>
        </form>
    </div>
    <div class="col-md-12">
        <?php
            //Thomas Vansprengel
            echo anchor('vrijwilliger/taakindeling', 'Ga terug');
        ?>
    </div>
</div>


