<?php
$ontvangers = array();
foreach ($personen as $persoon) {
    $ontvangers[$persoon->id] = $persoon->naam . ' - ' . $persoon->email;
}
$attributes = array('id' => 'selectOntvangers',
    'class' => 'form-control',
    'disabled' => 'true',
    'multiple' => 'true',
    'aria-describedby' => 'ontvangersHelp',
    'size' => '9');
echo "<div class='form-group'>";
echo form_dropdown('selectOntvangers', $ontvangers, '', $attributes);
echo '<small id="ontvangersHelp" class="form-text text-muted">Een lijst van alle personen die de mail zullen ontvangen.</small>';
echo "</div>";
?>