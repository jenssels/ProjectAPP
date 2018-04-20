<?php
$opties = "";
$taken = "";
    foreach($personeelsfeest->dagindelingen as $dagindeling){
        foreach($dagindeling->opties as $optie){
            $opties .= '<tr><td>' . $optie->naam .  '</td><td>' . $dagindeling->beginuur . ' - ' . $dagindeling->einduur . '</td><td>' . $optie->deelnemers . '/' . $optie->maxAantal . '</td><td>'. $optie->minAantal .'</td></tr>';
        }
    }
    foreach($personeelsfeest->dagindelingen as $dagindeling){
        foreach($dagindeling->taken as $taak){
            foreach($taak->shiften as $shift){
                $taken .= '<tr><td>' . $taak->naam . '</td><td>' . $shift->naam . '</td><td>' . $shift->beginuur . ' - ' . $shift->einduur .'</td><td>' . $shift->deelnemers . '/' . $shift->maxAantal . '</td></tr>';
            }
        }
    }
?>

<table cellpadding="10">
    <th></th>
    <th>Aantal</th>
    <tr><td>Totaal inschrijvingen <br/> (deelnemers + helpers)</td><td><?php echo $personeelsfeest->inschrijvingen['helpers'] + $personeelsfeest->inschrijvingen['deelnemers'] ?></td></tr>
    <tr><td>Totaal deelnemers</td><td><?php echo $personeelsfeest->inschrijvingen['deelnemers'] ?></td></tr>
    <tr><td>Totaal helpers</td><td><?php echo $personeelsfeest->inschrijvingen['helpers'] ?></td></tr>
</table>
<table cellpadding="10">
    <th>Optie</th>
    <th>Tijd</th>
    <th>Aantal inschrijvingen</th>
    <th>Minimum aantal</th>
    <?php
        echo $opties;
    ?>
</table>
<table cellpadding="10">
    <th>Taak</th>
    <th>Shift</th>
    <th>Tijd</th>
    <th>Aantal inschrijvingen</th>
    <?php
        echo $taken;
    ?>
</table>