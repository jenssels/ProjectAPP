<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?></title>
        
        <!-- Load bootstrap css -->
        <?php echo pasStylesheetAan("bootstrap.css"); ?>
        <?php echo pasStylesheetAan("buttons.css"); ?>
        
        <!-- Load own css -->
        <?php echo pasStylesheetAan("stijl.css"); ?>
        
        <?php echo haalJavascriptOp("jquery-3.1.0.min.js"); ?>
        <?php echo haalJavascriptOp("bootstrap.js"); ?>
        
        <script type="text/javascript">
           var site_url = '<?php echo site_url(); ?>';
           var base_url = '<?php echo base_url(); ?>';
        </script>
    </head>
    <body>
        <?php echo $main_header; ?>
        <?php echo $content; ?>
        <?php echo $main_footer; ?>
    </body>
</html>
