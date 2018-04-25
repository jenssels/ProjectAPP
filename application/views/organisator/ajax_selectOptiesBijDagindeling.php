<fieldset>
    <p>
        <label>Optie:</label>
        <?php
        //select voor opties
        $options3 = array();
        $options3['niks'] = "-- Kies een optie --";
        $options3['alles'] = "Alle opties";
        foreach ($opties as $optie) {
            $options3[$optie->id] = $optie->naam;
        }
        $attributes3 = array('id' => 'optieSelect',
            'onchange' => 'optieSelectFunctie()',
            'class' => 'form-control');
        echo "<div class='form-group'>";
        echo form_dropdown('optieSelect', $options3, '', $attributes3);
        echo "</div>";
        ?>
    </p>
</fieldset>
