
<div class="col-md-12">
    <h2>Vrijwilligers</h2>
    <ul>
        <?php
            foreach ($vrijwilligers as $vrijwilliger){
                echo '<li>' . $vrijwilliger->voornaam . ' ' . $vrijwilliger->naam . '</li>';
            }
        ?>
    </ul>
</div>

<div class="col-md-12">
    <h2>Personeelsleden</h2>
    <ul>
        <?php
            foreach ($personeelsLeden as $personeelsLid){
                echo '<li>' . $personeelsLid->voornaam . ' ' . $personeelsLid->naam . '</li>';
            }
        ?>
    </ul>
</div>

<?php

?>
