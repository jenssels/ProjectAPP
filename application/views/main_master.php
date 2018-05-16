<?php
/**
 * @file main_master.php
 * View waarin alle deelviews worden geladen
 * Wordt opgevuld met data via methodes en functies
 */
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo $titel; ?></title>
        <?php echo '<link rel="shortcut icon" href="' . base_url("assets/img/favicon.ico") . '"/>' ?>

        <!-- Load bootstrap css -->

        <?php echo pasStylesheetAan("bootstrap.css"); ?>
        <?php echo pasStylesheetAan("buttons.css"); ?>

        <!-- Load own css -->
        <?php echo pasStylesheetAan("ownStylesheet.css"); ?>

        <!-- Load js -->
        <?php echo haalJavascriptOp("jquery-3.1.0.min.js"); ?>
        <?php echo haalJavascriptOp("bootstrap.js"); ?>
        <?php echo haalJavascriptOp("bootstrap.bundle.min.js"); ?>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.css"/>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.nl-BE.min.js"></script>

        <!-- Load FA icons -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

        <script type="text/javascript">
            var site_url = '<?php echo site_url(); ?>';
            var base_url = '<?php echo base_url(); ?>';
        </script>
    </head>
    <body>
        <!-- Hoofding -->
        <?php echo $hoofding . "\n"; ?>
        <!-- Inhoud -->
        <div class="container">  
        <div class="page-header">
            <h1><?php echo $titel ?></h1>
            <hr>
        </div>
            <?php echo $inhoud ?>
        </div>
        <!-- Voetnoot -->
        <?php echo $voetnoot; ?>
    </body>
</html>
