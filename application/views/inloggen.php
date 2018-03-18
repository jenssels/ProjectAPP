<div>
    <p>Welkom bij de applicatie.<br/>
        Gelieve u aan te melden met uw gegevens</p>
</div>

<div>
    <?php
        //$attributen = array('name' => 'inlogformulier');
        echo form_open('inlogformulier');
        echo "<div>".form_label('Email', 'email')."<br/>";
        
        $data = array('name' => 'email', 'id' => 'email');
        echo form_input($data)."</div>";
        
        echo "<div>".form_label('Paswoord', 'paswoord')."<br/>";
        
        $data = array('name' => 'paswoord', 'id' => 'paswoord');
        echo form_input($data)."</div>";
    ?>
</div>

