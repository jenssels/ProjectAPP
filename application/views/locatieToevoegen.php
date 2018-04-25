<?php/**
 * @file locatieToevoegen.php
 * 
 * Pagina waar je een nieuwe locatie kan toevoegen
 * 
 */?> <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $titel; ?></title>
    </head>

	
    <?php
    $attributes = array('name' => 'mijnFormulier');
    echo form_open('organisator/voegLocatieToe', $attributes);
    ?>
    <table>
        <tr>
            <td><?php echo form_label('Naam:', 'naam'); ?></td>
            <td><?php echo form_input(array('name' => 'naam', 'id' => 'naam', 'size' => '50')); ?></td>
        </tr>
                <tr>
            <td><?php echo form_label('Adres:', 'adres'); ?></td>
            <td><?php echo form_input(array('name' => 'adres', 'id' => 'adres', 'size' => '50')); ?></td>
        </tr>
        <tr>
            <td><?php echo form_label('Plaats:', 'plaats'); ?></td>
            <td><?php echo form_input(array('name' => 'plaats', 'id' => 'plaats', 'size' => '50')); ?></td>
            <td><?php echo form_hidden('id'); ?></td>
        </tr>
        <tr>
            <td><?php echo form_submit('knop', 'Submit'); ?></td>
        </tr>
    </table>

    <?php echo form_close(); ?>

        <?php echo "<a href=\"javascript:history.go(-1)\">Terug</a>"; ?>

</body>
</html>