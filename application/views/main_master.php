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

        <script type="text/javascript">
            var site_url = '<?php echo site_url(); ?>';
            var base_url = '<?php echo base_url(); ?>';
        </script>
    </head>
    <body>
        <?php echo $main_header; ?>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consequat dapibus feugiat. Pellentesque dignissim in nisl et faucibus. Nulla eget tincidunt erat, at dapibus felis. Maecenas ullamcorper nec diam tincidunt iaculis. Proin justo diam, fermentum euismod venenatis et, pharetra non eros. Donec sed leo quis dolor volutpat blandit a ut mauris. Proin ac aliquet magna. Aliquam rhoncus a libero sit amet ultricies. Quisque malesuada enim at malesuada rhoncus. Praesent quis euismod orci, nec faucibus nisl. Etiam sed nulla sed massa sagittis vulputate non blandit nunc. Proin vel malesuada urna. Maecenas interdum auctor dolor eget elementum. Aenean sed dapibus metus. Fusce non feugiat sapien.
        </p>
        <p>
            Etiam porta at felis vitae consectetur. Morbi vitae arcu eget elit aliquam facilisis quis at nibh. In id porta neque, nec elementum orci. Integer rhoncus ullamcorper nisl et sagittis. Sed id felis urna. Sed dictum sem et diam finibus dapibus. Nulla at mi quis ante imperdiet hendrerit non non massa. In scelerisque est sed malesuada tempor. Aliquam erat volutpat. Pellentesque auctor nunc lectus. Curabitur eleifend quam non ipsum aliquam rhoncus. Nulla bibendum efficitur neque nec commodo.
        </p>
        <p>
            Vestibulum viverra aliquam ante, sed vestibulum risus. Nunc bibendum tincidunt ipsum, in consequat nunc ullamcorper at. Suspendisse quam orci, auctor sed lectus eget, bibendum ullamcorper ex. Aenean eget nisl odio. Phasellus risus diam, vehicula sit amet augue sit amet, feugiat finibus libero. Donec nec urna vitae lacus sollicitudin blandit ac ut mi. Sed at gravida turpis, sed vulputate magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut auctor nisi eu maximus iaculis. Aliquam mollis erat quis felis vulputate interdum. Suspendisse a libero faucibus, porttitor odio a, malesuada mi. Sed nec metus eu erat pretium dictum.
        </p>
        <p>
            Sed mattis tempor aliquam. Ut tempor cursus est, a consectetur ex blandit eu. Proin luctus sit amet lacus sit amet molestie. Curabitur fringilla, turpis vel egestas tempor, nulla felis aliquet dolor, in egestas metus turpis quis ante. Praesent vitae vestibulum purus, non aliquet nulla. Integer vitae cursus velit, sed tincidunt ipsum. Nulla lacus urna, elementum id velit vel, blandit semper sem. Morbi eget justo odio. Nam augue turpis, imperdiet eu dignissim at, volutpat a mi. Pellentesque scelerisque leo sit amet lorem pulvinar posuere. Nulla pharetra mauris nec quam dapibus, sed condimentum ex lobortis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempor urna ut arcu mattis varius. Vestibulum lobortis, turpis non tempor fermentum, sem libero sollicitudin ex, quis ultricies mi dui sit amet eros. Pellentesque eget quam sed leo vestibulum ultrices.
        </p>
        <p>
            Ut et tortor gravida, ornare tellus in, feugiat magna. Aenean ornare justo at volutpat efficitur. Curabitur dui nunc, luctus in nisi tempor, rutrum tincidunt orci. Duis accumsan ante id placerat tincidunt. Integer efficitur justo eget lacus vulputate molestie. In fermentum nunc et eleifend pellentesque. Donec et ligula in turpis condimentum facilisis. Suspendisse quis nibh ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent tempus ipsum nec purus consequat, quis iaculis neque laoreet. Duis aliquam quam in leo egestas ullamcorper. Curabitur quis pharetra arcu. Pellentesque efficitur lorem sed elementum porta. Vivamus sit amet volutpat orci, at interdum nulla. In varius consequat tincidunt.
        </p>
        <p>
            Nullam eu nunc laoreet, faucibus lacus eget, aliquam nunc. Nulla dapibus interdum massa. Phasellus eu placerat justo. Phasellus faucibus id libero condimentum tincidunt. Vestibulum consequat turpis metus, id pellentesque nibh eleifend id. Nulla pulvinar viverra rhoncus. Nunc vel felis eu dolor eleifend ultrices at eget arcu. Suspendisse lobortis felis id odio placerat, ut blandit mauris feugiat. Integer sodales massa ut turpis suscipit facilisis. Mauris feugiat interdum finibus. Etiam sagittis non justo ut tristique. Sed sit amet accumsan orci. Aliquam quis mollis mauris.
        </p>
        <p>
            Phasellus ut sapien et mauris lacinia condimentum. Sed porta nunc fermentum nunc ullamcorper, in suscipit ex hendrerit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Pellentesque congue turpis nulla, sed pretium elit hendrerit eu. In ullamcorper sapien quis felis feugiat consectetur. Maecenas pretium sit amet nibh sit amet aliquam. Morbi est ex, ornare et eros sed, eleifend faucibus orci. Vivamus quis felis mi. Phasellus congue nisi massa, in fringilla ex rhoncus sodales. Aliquam non libero pharetra, ullamcorper tellus eu, egestas massa.
        </p>
        <p>
            Vestibulum sed erat ex. Nam lobortis non enim sed venenatis. Suspendisse finibus tristique nunc. Nulla facilisi. Suspendisse bibendum odio a leo pellentesque, vel ullamcorper ante vulputate. Suspendisse at condimentum ligula, vel sagittis quam. Praesent luctus mi in fermentum volutpat. Maecenas in fermentum magna, vitae efficitur erat. Sed mattis placerat felis, ut efficitur justo malesuada vitae. Sed ornare cursus ante, at ultricies neque semper eu. Nam lobortis ipsum risus, sed vehicula ex finibus eu. Suspendisse vitae luctus est. Aenean vitae malesuada massa.
        </p>
        <p>
            Mauris sed fermentum turpis, a congue est. Phasellus id feugiat elit. Sed tempus ante sed leo auctor dignissim. Morbi tristique eros luctus felis sollicitudin, in malesuada urna sodales. In sed ligula eget lacus tincidunt mattis non ut massa. Etiam id nunc in tellus volutpat vulputate. Integer non semper tortor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt maximus lectus, in egestas elit varius in. Sed lobortis mollis tellus ac imperdiet. Vivamus tellus magna, finibus ut tellus vel, hendrerit sollicitudin leo. Integer massa nulla, pharetra suscipit erat sed, fermentum feugiat ante.
        </p>
        <p>
            Quisque congue nec ligula sit amet bibendum. Donec consectetur dui auctor purus auctor, non bibendum elit ornare. Maecenas dapibus lacus et erat consequat convallis. Nullam eget lacinia augue, a finibus tortor. Praesent in pharetra eros. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras malesuada ornare odio et blandit. Nunc hendrerit mi et massa hendrerit, vel lacinia nisi pharetra. Vestibulum tristique quam eu velit vestibulum rutrum.
        </p>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consequat dapibus feugiat. Pellentesque dignissim in nisl et faucibus. Nulla eget tincidunt erat, at dapibus felis. Maecenas ullamcorper nec diam tincidunt iaculis. Proin justo diam, fermentum euismod venenatis et, pharetra non eros. Donec sed leo quis dolor volutpat blandit a ut mauris. Proin ac aliquet magna. Aliquam rhoncus a libero sit amet ultricies. Quisque malesuada enim at malesuada rhoncus. Praesent quis euismod orci, nec faucibus nisl. Etiam sed nulla sed massa sagittis vulputate non blandit nunc. Proin vel malesuada urna. Maecenas interdum auctor dolor eget elementum. Aenean sed dapibus metus. Fusce non feugiat sapien.
        </p>
        <?php echo $main_footer; ?>
    </body>
</html>
