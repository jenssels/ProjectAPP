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
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas faucibus ante in accumsan aliquam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent imperdiet viverra nibh, dignissim accumsan mauris. Etiam mattis est quis tortor placerat, quis tincidunt lorem consequat. Sed nulla ligula, feugiat in rutrum et, bibendum eget nibh. Nullam sed luctus elit. Quisque convallis, turpis vitae lacinia viverra, tortor nisl sodales tellus, vel commodo nisl libero eget tortor. Etiam laoreet, lacus ut rhoncus gravida, metus erat tempor orci, id congue ante quam eget massa. Aliquam non est at massa varius imperdiet. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porttitor fermentum nisi, ut facilisis felis sagittis in.
            </p>
            <p>
                Vestibulum vehicula nisi magna, in congue dolor hendrerit nec. Integer in risus lacinia, ultrices elit a, mattis dui. Vivamus non est et elit consectetur congue. Nunc vel justo eu elit dapibus tincidunt. Nulla suscipit urna eu blandit pulvinar. Praesent maximus a velit vitae posuere. Suspendisse lacinia lorem non ligula ultrices malesuada.
            </p>
            <p>
                Proin congue consequat nisl sagittis viverra. Aenean malesuada interdum justo. Nulla risus lacus, eleifend condimentum commodo sit amet, eleifend ac ipsum. Praesent auctor malesuada arcu sit amet dignissim. Fusce sed mattis libero. Curabitur fringilla viverra vestibulum. Phasellus egestas felis ante. Curabitur ligula felis, placerat ornare laoreet ut, mollis at nulla. Proin ullamcorper orci non lorem suscipit tempus. Suspendisse sollicitudin, velit ut vulputate convallis, tortor velit iaculis tortor, eget luctus elit mi nec tellus.
            </p>
            <p>
                Maecenas tempus non enim vel bibendum. Nulla id odio est. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse mi tortor, bibendum et elit et, rutrum fringilla dolor. Praesent ante dolor, bibendum a velit nec, porta ullamcorper est. Quisque vitae nibh ipsum. Nunc auctor turpis vitae velit egestas eleifend. Vivamus ipsum enim, porttitor id dolor quis, maximus pharetra augue. In ante ligula, convallis sed diam ut, malesuada sodales nulla. Nulla elit diam, ultricies vulputate erat vitae, efficitur tempus nisi.
            </p>
            <p>
                Suspendisse eleifend et eros sit amet tristique. Suspendisse a lectus vel dui placerat gravida in sit amet elit. Nunc a dictum lorem. Donec imperdiet imperdiet iaculis. Suspendisse consectetur porttitor eros eget rhoncus. Donec aliquam rutrum mauris, ut condimentum mauris maximus sed. Morbi eu bibendum turpis. Sed scelerisque, arcu non ornare luctus, purus tellus vehicula leo, ut facilisis quam sem in sapien. Nunc laoreet elementum venenatis. Pellentesque hendrerit at quam non venenatis.
            </p>

        </div>
        <!-- Voetnoot -->
        <?php echo $voetnoot; ?>
    </body>
</html>
