<?php
        echo '<table class="table table-sm">';
        foreach($deelnemers as $deelnemer){
            echo '<tr><td>' . $deelnemer->naam . ' ' . $deelnemer->voornaam . '</td><td>' . $deelnemer->email . '</td></tr>';
        }
        echo '</table>';


?>