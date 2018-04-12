<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="page-header">
    <h1><?php echo $titel ?></h1>
</div>

<div>
    <p>Hieronder de opties die jij gekozen hebt.</p>
    <?php
    foreach ($optiedeelnames as $optiedeelname) {
            echo $optiedeelname->optie->naam;
    }
    ?>
</div>
