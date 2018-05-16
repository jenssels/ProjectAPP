<?php
    /**
     * @file ajax_overzichtGebruikers.php
     * Jens Sels - Ajax pagina die alle personeelsleden en vrijwilliger toont die uitgenodigd zijn voor een personeelsfeest
     */
?>

<div class="col-md-12">
    <h2>Vrijwilligers</h2>

    <?php
    if (count($vrijwilligers) > 0) {
        echo '<table class="table table-sm">';
        foreach ($vrijwilligers as $vrijwilliger) {
            echo '<tr><td>' . $vrijwilliger->voornaam . ' ' . $vrijwilliger->naam . '</td><td>' . $vrijwilliger->email . '</td></tr>';
        }
        echo '</table>';
    } else {
        echo "<p>Nog geen vrijwilligers uitgenodigd.</p>";
    }
    ?>
</div>

<div class="col-md-12">
    <h2>Personeelsleden</h2>
    <table class="table table-sm">
        <?php
        if (count($personeelsLeden) > 0) {
            echo '<table class="table table-sm">';
            foreach ($personeelsLeden as $personeelslid) {
                echo '<tr><td>' . $personeelslid->voornaam . ' ' . $personeelslid->naam . '</td><td>' . $personeelslid->email . '</td></tr>';
            }
            echo "</table>";
        } else {
            echo "<p>Nog geen personeelsleden uitgenodigd.</p>";
        }
        ?>
    </table>
</div>
