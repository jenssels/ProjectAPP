<fieldset>
    <div class="form-group">
        <label for="optieSelect">Optie:</label>
        <?php
        //select voor opties
        $options = array();
        $options['niks'] = "-- Kies een optie --";
        $options['alles'] = "Alle opties";
        if (isset($dagindelingen)) {
            foreach ($dagindelingen as $dagindeling) {
                foreach ($dagindeling->opties as $optie) {
                    $options[$optie->id] = $optie->naam;
                }
            }
        }
        
//        if ($dagindelingId == 'alles') {
//            //alle dagindelingen zijn geselecteerd
//            foreach ($dagindelingen as $dagindeling) {
//                foreach ($dagindeling->opties as $optie) {
//                    $options[$optie->id] = $optie->naam;
//                }
//            }
//        } else {
//            //er is maar 1 dagindeling geselecteerd
//            foreach ($dagindelingen as $dagindeling) {
//                if ($dagindeling->id == $dagindelingId) {
//                    foreach ($dagindeling->opties as $optie) {
//                        $options[$optie->id] = $optie->naam;
//                    }
//                }
//            }
//        }
        $attributes = array('id' => 'optieSelect',
            'onchange' => 'optieSelectFunctie()',
            'class' => 'form-control');
        echo "<div class='form-group'>";
        echo form_dropdown('optieSelect', $options, '', $attributes);
        echo "</div>";
        ?>
    </div>
</fieldset>
