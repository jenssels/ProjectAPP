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
    $attributes = array('name' => 'mijnFormulier', 'class' => 'table');
    echo form_open('organisator/voegLocatieToe', $attributes);
    ?>
    <table>
        <tr>
            <td><?php echo form_labelpro('Naam:', 'naam'); ?></td>
            <td><?php echo form_input(array('class' => 'form-control','name' => 'naam', 'id' => 'naam', 'size' => '50')); ?></td>
        </tr>
                <tr>
            <td><?php echo form_labelpro('Adres:', 'adres'); ?></td>
            <td><?php echo form_input(array('class' => 'form-control','name' => 'adres', 'id' => 'adres', 'size' => '50')); ?></td>
        </tr>
        <tr>
            <td><?php echo form_labelpro('Plaats:', 'plaats'); ?></td>
            <td><?php echo form_input(array('class' => 'form-control','name' => 'plaats', 'id' => 'plaats', 'size' => '50')); ?></td>
            <td><?php echo form_hidden('id'); ?></td>
        </tr>
        <tr>
           <td><?php echo form_submit('knop', 'Submit',"class='btn btn-primary'"); ?>
<?php echo "<a class='btn btn-primary' href=\"javascript:history.go(-1)\">Terug</a>"; ?></td>
        </tr>
    </table>

    <?php echo form_close(); ?>
</body>
</html>