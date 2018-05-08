<?php
/**
 * @file error.php
 * @param $foutmelding Een string die de foutmelding bevat.
 * 
 * View waarin een foutmelding getoond wordt.
 * 
 */
?>
<div class="row">
    <div class="col-md12">
        <p><?php echo $foutmelding ?></p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a id="terug" class='btn btn-primary' href="javascript:history.go(-1);">Terug</a>
    </div>
</div>


