<fieldset>
    <div class="form-group">
        <label for="optieSelect">Optie:</label>
        <?php
        //select voor opties
        $options3 = array();
        $options3['niks'] = "-- Kies een optie --";
        $options3['alles'] = "Alle opties";
        if ($dagindelingId == 'alles') {
            //alle dagindelingen zijn geselecteerd
            foreach ($dagindelingen as $dagindeling) {
                foreach ($dagindeling->opties as $optie) {
                    $options3[$optie->id] = $optie->naam;
                }
            }
        } else {
            //er is maar 1 dagindeling geselecteerd
            foreach ($dagindelingen as $dagindeling) {
                if ($dagindeling->id == $dagindelingId) {
                    foreach ($dagindeling->opties as $optie) {
                        $options3[$optie->id] = $optie->naam;
                    }
                }
            }
        }
        $attributes3 = array('id' => 'optieSelect',
            'onchange' => 'optieSelectFunctie()',
            'class' => 'form-control');
        echo "<div class='form-group'>";
        echo form_dropdown('optieSelect', $options3, '', $attributes3);
        echo "</div>";
        ?>
    </div>
</fieldset>
