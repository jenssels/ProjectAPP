<?php
/**
 * @file ajax_toonDeelnemers.php
 * Jens Sels - Ajax pagina die de deelnemers van een bepaalde shift of optie toont
 */
        echo '<table class="table table-sm">';
        foreach($deelnemers as $deelnemer){
            echo '<tr><td>' . $deelnemer->naam . ' ' . $deelnemer->voornaam . '</td><td>' . $deelnemer->email . '</td></tr>';
        }
        echo '</table>';


?>