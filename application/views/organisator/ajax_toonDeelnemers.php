<?php
if($deelnemers != null){
   foreach($deelnemers as $deelnemer){
    echo $deelnemer->naam . ' ' . $deelnemer->voornaam . ' - ' . $deelnemer->email . '</br>';
}
}
else{
    echo "Geen deelnemers";
}

?>