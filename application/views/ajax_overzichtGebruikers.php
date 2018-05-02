
<div class="col-md-12">
    <h2>Vrijwilligers</h2>
    <table class="table table-sm">
        <?php
        foreach ($vrijwilligers as $vrijwilliger) {
            echo '<tr><td>' . $vrijwilliger->voornaam . ' ' . $vrijwilliger->naam . '</td><td>' . $vrijwilliger->email . '</td></tr>';
        }
        ?>
    </table>
</div>

<div class="col-md-12">
    <h2>Personeelsleden</h2>
    <table class="table table-sm">
        <?php
        foreach ($personeelsLeden as $personeelslid) {
            echo '<tr><td>' . $personeelslid->voornaam . ' ' . $personeelslid->naam . '</td><td>' . $personeelslid->email . '</td></tr>';
        }
        ?>
    </table>
</div>
