<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $titel; ?></title>

        <!-- Load bootstrap css -->
        <?php echo pasStylesheetAan("bootstrap.css"); ?>
        <?php echo pasStylesheetAan("buttons.css"); ?>

        <!-- Load own css -->
        <?php echo pasStylesheetAan("ownStylesheet.css"); ?>

        <!-- Load js -->
        <?php echo haalJavascriptOp("jquery-3.1.0.min.js"); ?>
        <?php echo haalJavascriptOp("bootstrap.js"); ?>

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
            <?php echo $inhoud ?>
        </div>
        <!-- Voetnoot -->
        <?php echo $voetnoot; ?>
    </body>
</html>
