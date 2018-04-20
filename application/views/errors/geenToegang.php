<?php
/**
 * @file geenToeging.php
 * 
 * View waarin getoond wordt dat de gebruiker geen toegang heeft en zich eerst moet aanmelden.
 * 
 */
?>
<div>
    <p>Je bent niet aangemeld als organisator!</p>
    <p><?php echo anchor('home/aanmelden', 'Aanmelden'); ?></p>
</div>

