<?php/**
 * @file taakToevoegen.php
 * 
 * Pagina waar je een taak kan toevoegen
 * 
 */?> <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <?php
    $locatieOpties = "";
    foreach ($locaties as $locatie) {
        $locatieOpties[$locatie->id] = $locatie->naam;
    }
    
    $dagindelingOpties = "";
    foreach ($dagindelingen as $dagindeling) {
        $dagindelingOpties[$dagindeling->id] = ($dagindeling->naam . ' ' . $dagindeling->beginuur . ' ' . $dagindeling->einduur);
    }
    
    
    ?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $titel; ?></title>
    </head>

	
    <?php
    $attributes = array('name' => 'mijnFormulier', 'class' => "table");
    echo form_open('organisator/voegTaakToe', $attributes);
    ?>
    <table>
        <tr>
            <td><?php echo form_label('Naam:', 'naam'); ?></td>
            <td><?php
            $data = array('class' => 'form-control','name' => 'naam', 'id' => 'naam', 'size' => '30');
            echo form_input($data);
            ?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('Beschrijving:', 'beschrijving'); ?></td>
            <td><?php echo form_input(array('class' => 'form-control','name' => 'beschrijving', 'id' => 'beschrijving', 'size' => '50')); ?></td>
        </tr>
        <tr>
            <td><?php echo form_label('Locatie:', 'locatie'); ?></td>
            <td><?php
                echo form_dropdown('locatie', $locatieOpties, $locatie->id);
                ?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('Dagindeling:', 'dagindeling'); ?></td>
            <td><?php
                echo form_dropdown('dagindeling', $dagindelingOpties, $dagindeling->id);
                ?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_submit('knop', 'Submit',"class='btn btn-primary'"); ?>
<?php echo "<a class='btn btn-primary' href=\"javascript:history.go(-1)\">Terug</a>"; ?></td>
        </tr>
    </table>

    <?php echo form_close(); ?>

</body>
</html>