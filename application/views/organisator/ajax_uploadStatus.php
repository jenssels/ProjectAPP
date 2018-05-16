<?php
/**
 * @file ajax_uploadStatus.php
 * Jens Sels - Ajax pagina die lijstje toont van toegevoegde personeelsleden
 */
if (isset($errors)) {
    foreach($errors as $error){
        echo $error;
    }
} elseif (isset($personeel)) {
    echo $personeel;
}
?>

