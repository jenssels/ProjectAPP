<?php/**
 * @file taakBewerken.php
 * 
 * Pagina waar je een huidige taak kan bewerken
 * 
 */?> <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $titel; ?></title>
    </head>

	
    <?php
    $attributes = array('name' => 'mijnFormulier', 'class' => "table");
    echo form_open('organisator/pasShiftAan', $attributes);
    ?>
    <table>
        <tr>
            <td><?php echo form_label('Naam:', 'naam'); ?></td>
            <td><?php
            $data = array('class' => 'form-control','value' => $shift->naam,'name' => 'naam', 'id' => 'naam', 'size' => '30');
            echo form_input($data);
            ?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('Beginuur:', 'beginuur'); ?></td>
            <td><?php echo form_input(array('class' => 'form-control','value' => $shift->beginuur,'name' => 'beginuur', 'id' => 'beginuur', 'size' => '50')); ?></td>
        </tr>
        <tr>
            <td><?php echo form_label('Einduur:', 'einduur'); ?></td>
            <td><?php echo form_input(array('class' => 'form-control','value' => $shift->einduur,'name' => 'einduur', 'id' => 'einduur', 'size' => '50')); ?></td>
        </tr>
        <tr>
            <td><?php echo form_label('Maxaantal:', 'maxAantal'); ?></td>
            <td><?php echo form_input(array('class' => 'form-control','value' => $shift->maxAantal,'name' => 'maxAantal', 'id' => 'maxAantal', 'size' => '50')); ?></td>
        </tr>
        <tr>
            <td><?php echo form_hidden('id', $shift->id); ?></td>
<td><?php echo form_submit('knop', 'Submit',"class='btn btn-primary'"); ?>
<?php echo "<a class='btn btn-primary' href=\"javascript:history.go(-1)\">Terug</a>"; ?></td>
        </tr>
    </table>

    <?php echo form_close(); ?>


</body>
</html>