<?php/**
 * @file taakShiften.php
 * 
 * Pagina waar je een overzicht van de shiften bij deze taak kan zien
 * 
 */?> <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
    <?php

    
    ?>
	
    <?php
    $attributes = array('name' => 'mijnFormulier');
    echo form_open('organisator/pasShiftenaan', $attributes);
    
    
    
    foreach($shiften as $shift){
                echo '<table>';
                echo '<tr>';
                
                echo'<td>';
                echo form_label('Naam:', 'naam');
                echo'</td>';
                echo'<td>';
                $data = array('value' => $shift->naam,'name' => 'naam', 'id' => 'naam', 'size' => '10');
                echo form_input($data);
                echo'</td>';
                
                echo'<td>';
                echo form_label('Beginuur:', 'beginuur');
                echo'</td>';
                echo'<td>';
                $data = array('value' => $shift->beginuur,'name' => 'beginuur', 'id' => 'beginuur', 'size' => '10');
                echo form_input($data);
                echo'</td>';
                
                echo'<td>';
                echo form_label('Einduur:', 'einduur');
                echo'</td>';
                echo'<td>';
                $data = array('value' => $shift->einduur,'name' => 'einduur', 'id' => 'einduur', 'size' => '10');
                echo form_input($data);
                echo'</td>';
                
                echo'<td>';
                echo form_label('Maximum Aantal:', 'maxAantal');
                echo'</td>';
                echo'<td>';
                $data = array('value' => $shift->maxAantal,'name' => 'maxAantal', 'id' => 'maxAantal', 'size' => '10');
                echo form_input($data);
                echo'</td>';
                
                
                
                echo '</tr>';
                echo '</table>';
    }
    ?>
    
    <?php echo form_hidden('id', $shift->id);
    echo form_submit('knop', 'Submit'); 
    echo form_close(); 

    echo "<a href=\"javascript:history.go(-1)\">Terug</a>"; ?>
