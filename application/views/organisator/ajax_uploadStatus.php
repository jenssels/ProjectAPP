
<?php

if (isset($errors)) {
    foreach($errors as $error){
        echo $error;
    }
} elseif (isset($personeel)) {
    echo $personeel;
}
?>

